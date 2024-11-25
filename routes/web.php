<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


Route::post('login',function(Request $request){
    return "nihao";
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
],function($router){
    //Route::post('/login',[UsuariosController::class,'login'])->name('login');
});

