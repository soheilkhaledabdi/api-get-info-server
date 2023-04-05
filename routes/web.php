<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\monitoringController;

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


$router->get('/uptime' ,'monitoringController@uptime');
$router->get('/info' ,'monitoringController@getServerInfo');
$router->get('/diskUsage' ,'monitoringController@diskUsage');
$router->get('/cpuAndRam' ,'monitoringController@cpuAndRam');
$router->get('/onlineUser' ,'monitoringController@onlineUser');

$router->post('/users/create' ,'UserController@create');
