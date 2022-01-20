<?php

use Illuminate\Support\Facades\Route;


Route::view('/', 'welcome')->name("mainPage");


Route::view('/login', 'login')->name("login");
Route::post("/login/post","RequestController@postLogin");

Route::view('/register', 'register')->name("register");
Route::post("/register/post","RequestController@postRegister");

Route::get('/forgot/password', "RequestController@forgotPassword")->name("resetPassword");
Route::post("/forgot/password/reset","RequestController@postForgotPassword");

Route::get('/reset/password/link/{link}', "RequestController@resetPasswordWithLink");
Route::post("/reset/password/link/change","RequestController@postResetPasswordWithLink");