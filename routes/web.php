<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('welcome');
})->name('home');

Route::post('/role/redirect', [RoleController::class, 'redirect'])->name('role.redirect');

Route::get('/student', function () {
  return view('student');
})->name('student');

Route::get('/teacher', function () {
  return view('teacher');
})->name('teacher');

Route::get('/admin', function () {
  return view('admin');
})->name('admin');

Route::get('/developer', function () {
  return view('developer');
})->name('developer');