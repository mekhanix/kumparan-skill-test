<?php
$router->group(['prefix' => 'v1/news'], function () use ($router) {
    $router->get('/', 'NewsController@list');
    $router->post('add', 'NewsController@add');
    $router->delete('remove/{id}', 'NewsController@remove');
});