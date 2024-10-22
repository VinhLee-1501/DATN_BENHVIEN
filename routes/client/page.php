<?php

use App\Http\Controllers\Admin\BlogController;
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
Route::get('/meeting', function () {
    return view('client.meeting');
})->name('meeting');

Route::get('/tin-tuc', [BlogController::class, 'blogviewclient'])->name('news');
Route::get('/tin-tuc/{slug}', [BlogController::class, 'detailblog'])->name('detailnews');
Route::get('/lien-he', function () {
    return view('client.contact');
})->name('contact');
Route::get('/ho-so', function () {
    return view('client.profile');
})->name('profile');
