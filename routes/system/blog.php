<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogController;


Route::prefix('blogs')->middleware('check_login_admin')
->group(function () {
    Route::get('/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('/upload', [BlogController::class, 'store'])->name('blogs.store');
    Route::post('/uploadfile', [BlogController::class, 'uploadfile']);
    Route::delete('/revertfile', [BlogController::class, 'revertfile']);
    Route::get('/', [BlogController::class, 'index'])->name('blog');
    // Route::post('/search', [BlogController::class, 'index'])->name('blog.search');
    Route::delete('/multipledelete', [BlogController::class, 'index'])->name('blog.multipledelete');
    Route::get('/resetsearch', [BlogController::class, 'resetSearch'])->name('blog.resetsearch');
    Route::get('/perpage', [BlogController::class, 'index'])->name('blog.perpage');
    Route::get('/edit/{slug}', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::patch('/update/{id}', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/delete/{id}', [BlogController::class, 'delete'])->name('blogs.delete');
});
