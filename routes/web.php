<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('welcome');
});

// route::get('/books', function () {
//     return view('books.index');
// });

Route::get('/books', [App\Http\Controllers\BookController::class, 'index']);
route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index']);
route::get('/members', [App\Http\Controllers\MemberController::class, 'index']);