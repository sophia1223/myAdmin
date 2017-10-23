<?php

use Illuminate\Routing\Router;

Route::get('/', function () {
    return view('welcome');
});