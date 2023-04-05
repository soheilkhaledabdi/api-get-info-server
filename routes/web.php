<?php

/** @var \Laravel\Lumen\Routing\Router $router */



$router->get('/uptime' ,'monitoringController@uptime');
$router->get('/info' ,'monitoringController@getServerInfo');
$router->get('/diskUsage' ,'monitoringController@diskUsage');
$router->get('/cpuAndRam' ,'monitoringController@cpuAndRam');
$router->get('/onlineUser' ,'monitoringController@onlineUser');

$router->post('/users/create' ,'UserController@create');
$router->post('/users/disable' ,'UserController@disable');
$router->post('/users/enable' ,'UserController@enable');
