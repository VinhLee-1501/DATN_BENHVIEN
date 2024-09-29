<?php

use Illuminate\Support\Facades\Route;

//HomeController
Route::get('/', function () {
   
    return view('client.index');
})->name('home');
Route::get('/gioi-thieu', function () {
    return view('client.introduce');
})->name('introduce');
Route::get('/chuan-doan-benh', function () {
    return view('client.diagnosis');
})->name('diagnosis');

Route::get('/phuong-phap-dieu-tri', function () {
    return view('client.treatment-method');
})->name('treatment-method');

Route::get('/tin-tuc', function () {
    return view('client.news');
})->name('news');

Route::get('/lien-he', function () {
    return view('client.contact');
})->name('contact');
Route::get('/ho-so', function () {
    return view('client.profile');
})->name('profile');
