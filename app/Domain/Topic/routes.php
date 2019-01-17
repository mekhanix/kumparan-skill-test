<?php
$router->group(['prefix' => 'v1/topics'], function () use ($router) {
    $router->get('/', 'TopicController@list');
    $router->get('/{id:[0-9]+}', 'TopicController@show');
    $router->patch('/{id:[0-9]+}', 'TopicController@update');
    $router->post('/', 'TopicController@add');
    $router->delete('/{id:[0-9]+}', 'TopicController@remove');
});