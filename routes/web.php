<?php

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'rabbitmq'], function ($router) {
    $router->get('/queue-stats', 'RabbitmqController@queueStats');
    $router->post('/consume-message', 'RabbitmqController@consumeMessage');
    $router->post('/create-producer', 'RabbitmqController@createProducer');
});