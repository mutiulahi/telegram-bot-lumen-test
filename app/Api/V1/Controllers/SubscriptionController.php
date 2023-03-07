<?php

namespace  App\Api\V1\Controllers;

use Illuminate\Http\Request;
use  App\Api\V1\Controllers\APIResponse;
use Telegram\Bot\Api as TelegramBot;

class SubscriptionController extends Controller
{
    /**
     * Subscribe to a bot
     */

    private $chat_id;
    private $bot_token;

    public function __construct()
    {
        $this->chat_id = env('TELEGRAM_CHAT_ID');
        $this->bot_token = env('TELEGRAM_BOT_TOKEN');
    }
    /**
     * @OA\Post(
     *     path="/api/v1/subscribe-to-bot",
     *     tags={"Subscription"},
     *     summary="Subscribe to a bot",
     *     operationId="subscribeToBot",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *     )
     * )
     */

    public function subscribeToBot(Request $request)
    {

        $chatId = $this->chat_id;
        $botToken = $this->bot_token;

        $telegram = new TelegramBot($botToken);

        $message = "You have successfully subscribed to this bot!";

        $messageId = $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $message,
        ])->getMessageId();
        // TODO: Store the subscription in the database

        return APIResponse::success($message, $messageId);
    } 


    /**
     * Subscribe to a channel
     */

    /**
     * @OA\Post(
     *    path="/api/v1/subscribe-to-channel",
     *   tags={"Subscription"},
     *  summary="Subscribe to a channel",
     *  operationId="subscribeToChannel",
     * @OA\Response(
     *        response=200,
     *      description="Success",
     *  )
     * )
     */
    public function subscribeToChannel(Request $request)
    {
        $userId = $request->header('User-Id');

        $chatId = $this->chat_id;
        $botToken = $this->bot_token;

        $telegram = new TelegramBot($botToken);

        $message = "You have successfully subscribed to this channel!";

        $messageId = $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $message,
        ])->getMessageId();

        return APIResponse::success($message, $messageId);
    }

    /**
     * send messages to subscribers
     */
/**
     * @OA\Post(
     *     path="/api/v1/message-to-subscriber",
     *     summary="Send message to subscribers",
     *     description="Send a message to all subscribers of a Telegram bot or channel",
     *     @OA\Parameter(
     *         name="message",
     *         in="query",
     *         description="The message to send to subscribers",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success"
     *     )
     * )
     */
    public function sendMessageToSubscribers(Request $request)
    {
        
        $this->validate($request, [
            'message' => 'required|string',
        ]);

        $chatId = $this->chat_id;
        $botToken = $this->bot_token;
        $message = $request->input('message');

        $telegram = new TelegramBot($botToken);

        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $message,
        ]);

        return APIResponse::success($message, [
            'chat_id' => $chatId,
            'bot_token' => $botToken,
        ]);
    }

    /**
 * Webhooks to receive responses from messenger API
 *
 * @OA\Post(
 *     path="/subscribe/webhook",
 *     summary="Webhooks to receive responses from messenger API",
 *     tags={"Subscription"},
 *     @OA\RequestBody(
 *         description="Webhook data",
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="update_id", type="integer"),
 *             @OA\Property(property="message", type="object"),
 *             @OA\Property(property="edited_message", type="object"),
 *             @OA\Property(property="channel_post", type="object"),
 *             @OA\Property(property="edited_channel_post", type="object"),
 *             @OA\Property(property="inline_query", type="object"),
 *             @OA\Property(property="chosen_inline_result", type="object"),
 *             @OA\Property(property="callback_query", type="object"),
 *             @OA\Property(property="shipping_query", type="object"),
 *             @OA\Property(property="pre_checkout_query", type="object"),
 *             @OA\Property(property="poll", type="object"),
 *             @OA\Property(property="poll_answer", type="object"),
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Webhook received",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Webhook received")
 *         )
 *     )
 * )
 */
public function handleWebhook(Request $request)
{
   // validate the request
    $this->validate($request, [
        'update_id' => 'required|integer',
        'message' => 'nullable|object',
        'edited_message' => 'nullable|object',
        'channel_post' => 'nullable|object',
        'edited_channel_post' => 'nullable|object',
        'inline_query' => 'nullable|object',
        'chosen_inline_result' => 'nullable|object',
        'callback_query' => 'nullable|object',
        'shipping_query' => 'nullable|object',
        'pre_checkout_query' => 'nullable|object',
        'poll' => 'nullable|object',
        'poll_answer' => 'nullable|object',
    ]);



    $webhookData = $request->all();

    $telegram = new TelegramBot(env('TELEGRAM_BOT_TOKEN'));
    $telegram->commandsHandler(true);

    return response()->json(['message' => 'Webhook received']);
}

}
