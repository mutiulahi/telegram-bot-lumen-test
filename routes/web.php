<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Api\V1\Controllers\SubscriptionController;


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/



// Subscription routes for bots and channels or chats 
$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->post('subscribe-to-bot', 'SubscriptionController@subscribeToBot');
    $router->post('subscribe-to-channel', 'SubscriptionController@subscribeToChannel');
    $router->post('message-to-subscriber', 'SubscriptionController@sendMessageToSubscribers');
    $router->post('/webhook', 'WebhookController@handleWebhook');
});
