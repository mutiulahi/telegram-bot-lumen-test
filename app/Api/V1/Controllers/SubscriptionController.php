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


    public function subscribeToBot(Request $request)
    {
        
        $chatId = $this->chat_id;
        $botToken = $this->bot_token;

        $telegram = new TelegramBot($botToken);

        $message = "You have successfully subscribed to this bot!";
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $message,
        ]);

        $messageId = $telegram->getMessageId();
        // TODO: Store the subscription in the database

        return APIResponse::success($message, $messageId);
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
         $webhookData = $request->all();
 
         $telegram = new TelegramBot(env('TELEGRAM_BOT_TOKEN'));
         $telegram->commandsHandler(true);

         return response()->json(['message' => 'Webhook received']);
     }
    

}
