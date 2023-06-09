<?php

/** @var \Laravel\Lumen\Routing\Router $router */




$router->get('/api-key' , function () {
   return view('api');
});

$router->get('/uptime' ,'monitoringController@uptime');
$router->get('/info' ,'monitoringController@getServerInfo');
$router->get('/diskUsage' ,'monitoringController@diskUsage');
$router->get('/cpuAndRam' ,'monitoringController@cpuAndRam');
$router->get('/onlineUser' ,'monitoringController@onlineUser');
$router->get('/getAllUsers' ,'monitoringController@getAllUsers');
$router->get('/reboot' ,'monitoringController@onlineUser');
$router->get('/update' ,'monitoringController@onlineUser');

$router->post('/api-keys', 'ApiKeyController@store');


$router->group(['prefix' => 'users'] , function () use ($router){
    $router->post('/create' ,'UserController@create');
    $router->post('/disable' ,'UserController@disable');
    $router->post('/enable' ,'UserController@enable');
    $router->post('/delete' ,'UserController@delete');
    $router->post('/check' ,'UserController@check_user_exsit');
    $router->post('/active' ,'UserController@is_user_active');
    $router->get('/online' ,'UserController@online');
});

