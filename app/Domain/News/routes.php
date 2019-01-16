<?php
$router->group(['prefix' => 'v1/news'], function () use ($router) {
    $router->get('/', 'NewsController@list');
    $router->get('/{id:[0-9]+}', 'NewsController@show');
    $router->post('/', 'NewsController@add');
    $router->delete('/{id:[0-9]+}', 'NewsController@remove');
});