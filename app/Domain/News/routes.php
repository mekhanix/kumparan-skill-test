<?php
$router->group(['prefix' => 'v1/news'], function () use ($router) {
    $router->get('/', 'NewsController@list');
    $router->get('/{id}', 'NewsController@show');
    $router->post('/', 'NewsController@add');
    $router->delete('/{id}', 'NewsController@remove');
});