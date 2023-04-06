<?php

/** @var \Laravel\Lumen\Routing\Router $router */



$router->get('/uptime' ,'monitoringController@uptime');
$router->get('/info' ,'monitoringController@getServerInfo');
$router->get('/diskUsage' ,'monitoringController@diskUsage');
$router->get('/cpuAndRam' ,'monitoringController@cpuAndRam');
$router->get('/onlineUser' ,'monitoringController@onlineUser');
$router->get('/reboot' ,'monitoringController@onlineUser');
$router->get('/update' ,'monitoringController@onlineUser');


$router->group(['prefix' => 'users'] , function () use ($router){
    $router->post('/create' ,'UserController@create');
    $router->post('/disable' ,'UserController@disable');
    $router->post('/enable' ,'UserController@enable');
    $router->post('/delete' ,'UserController@enable');
    $router->post('/check' ,'UserController@check_user_exsit');
    $router->post('/active' ,'UserController@is_user_active');
    $router->get('/online' ,'UserController@online');

});

