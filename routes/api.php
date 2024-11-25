<?php

use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;

Route::post('/login',[UsuariosController::class,'login'])->name('login');
Route::post('/index',[UsuariosController::class,'index'])->name('index');
Route::post('/store',[UsuariosController::class,'store'])->name('store');
Route::post('/show/{id}',[UsuariosController::class,'show'])->name('show');
Route::post('/update/{id}',[UsuariosController::class,'update'])->name('update');
Route::post('/destroy/{id}',[UsuariosController::class,'destroy'])->name('destroy');
