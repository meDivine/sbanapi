<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/profile', ['middleware' => 'auth', function (Request $request) {
   return response()->json(Auth::user());
}]);

$router->post('/auth', 'AuthController@index');

$router->get('/cache', function () {
   return Cache::flush();
});

$router->get('/user',  'AuthController@test');
