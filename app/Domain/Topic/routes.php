<?php
$router->group(['prefix' => 'v1/topics'], function () use ($router) {
    $router->get('/', 'TopicController@list');
    $router->get('/{id}', 'TopicController@show');
    $router->post('/', 'TopicController@add');
    $router->delete('/{id}', 'TopicController@remove');
});