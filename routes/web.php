<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;

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
Auth::routes();

Route::get('/', [PageController::class, 'index']);
Route::get('/home', [PageController::class, 'index']);
Route::get('/dashboard', [PageController::class, 'dashboardPage']);
Route::get('/manageform', [PageController::class, 'manageFormPage']);
Route::get('/addform', [PageController::class, 'addFormPage']);
Route::get('/editform/{id}', [PageController::class, 'editFormPage']);
Route::get('/inputdata', [PageController::class, 'inputDataPage']);
Route::get('/profile', [PageController::class, 'profilePage']);

Route::post('add-form', [FormController::class, 'insertForm']);
Route::post('update-form/{id}', [FormController::class, 'updateForm']);
Route::delete('delete-form/{id}', [FormController::class, 'deleteForm']);
