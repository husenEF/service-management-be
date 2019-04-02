<?php

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
$router->get("/key", function () {
    return str_random(32);
});

//api routing
$router->group(["prefix" => "api"], function () use ($router) {

    // $router->get("/register", "AuthController@registerForm");
    //register login
    $router->post("/register", "AuthController@register");
    $router->post("/login", "AuthController@login");

    //user
    $router->group(['prefix' => 'user'], function () use ($router) {
        //post
        $router->post("/create", "UserController@create");
        //puth
        $router->put("/update/{id}", "UserController@update");
        //get
        $router->get("/detail/{id}", "UserController@show");
        //delete
        $router->delete("/delete/{id}", "UserController@delete");
    });

    //vehicle
    $router->group(["prefix" => "vehicle"], function () use ($router) {
        $router->get("/list", "VehicleController@index");
    });

    //tire
    $router->group(["prefix" => "tire"], function () use ($router) {
        $router->get("/list", "TireController@index");
    });
});
