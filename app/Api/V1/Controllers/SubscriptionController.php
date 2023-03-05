<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\APIResponse;
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


    public function subscribeToBot(Request $request)
    {
        $userId = $request->header('User-Id');

        $chatId = $this->chat_id;
        $botToken = $this->bot_token;

        $telegram = new TelegramBot($botToken);

        $message = "You have successfully subscribed to this bot!";
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $message,
        ]);
        
        // TODO: Store the subscription in the database


        return APIResponse::success($message, [
            'chat_id' => $chatId,
            'bot_token' => $botToken,
        ]);
    }

    /**
     * subscribe users to channel or chat
     */

    public function subscribeToChannel(Request $request)
    {
        $userId = $request->header('User-Id');

        $chatId = $this->chat_id;
        $botToken = $this->bot_token;

        $telegram = new TelegramBot($botToken);

        $message = "You have successfully subscribed to this channel!";
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
     * send messages to subscribers
     */

    public function sendMessageToSubscribers(Request $request)
    {
        $userId = $request->header('User-Id');

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
     */

     public function webhook(Request $request)
     {
         // Get webhook data from request body
         $webhookData = $request->all();
 
         // Process webhook data
         $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
         $telegram->commandsHandler(true);
 
         // Return response
         return response()->json(['message' => 'Webhook received']);
     }
    

}