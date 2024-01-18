<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\KPIController;
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
//Auth::routes();

Route::get('/login', [PageController::class, 'loginPage'])->name('login');
Route::post('/login', [UserController::class, 'storeSession']);
Route::post('/logout', [UserController::class, 'destroySession']);

Route::get('/', [PageController::class, 'index'])->middleware('auth');
Route::get('/home', [PageController::class, 'index'])->middleware('auth');
Route::get('/dashboard', [PageController::class, 'dashboardPage'])->middleware('auth');
Route::get('/managerole', [PageController::class, 'manageRolePage'])->middleware('auth');
Route::get('/addrole', [PageController::class, 'addRolePage'])->name('addrole')->middleware('auth');
Route::get('/editrole/{id}', [PageController::class, 'editRolePage'])->name('editrole')->middleware('auth');
Route::get('/manageuser', [PageController::class, 'manageUserPage'])->middleware('auth');
Route::get('/adduser', [PageController::class, 'addUserPage'])->middleware('auth');
Route::get('/edituser/{id}', [PageController::class, 'editUserPage'])->middleware('auth');
Route::get('/manageform', [PageController::class, 'manageFormPage'])->middleware('auth');
Route::get('/addform', [PageController::class, 'addFormPage'])->middleware('auth');
Route::get('/editform/{id}', [PageController::class, 'editFormPage'])->middleware('auth');
Route::get('/inputdata', [PageController::class, 'inputDataPage'])->middleware('auth');
Route::get('/approvedata', [PageController::class, 'approveDataPage'])->middleware('auth');
Route::get('/getform/{id}', [PageController::class, 'inputDataFormPage'])->middleware('auth');
Route::get('/profile', [PageController::class, 'profilePage'])->middleware('auth');
Route::get('/personaldata', [UserController::class, 'personalDataPage'])->name('profile.personaldata')->middleware('auth');
Route::get('/updatepassword', [UserController::class, 'updatePasswordPage'])->name('profile.updatepassword')->middleware('auth');

Route::get('/getFormsByDate/{period}', [FormController::class, 'getFormsByDate'])->middleware('auth');
Route::get('/getReport/{period}', [KPIController::class, 'getReport'])->middleware('auth');
Route::get('/getChildReport/{period}/{userId}', [KPIController::class, 'getChildReport'])->middleware('auth');
Route::get('/getKpiByYear/{year}/{user}', [KPIController::class, 'getKpiByYear']);
Route::get('/getChildrenKpiByDate/{date}', [KPIController::class, 'getChildrenKpiByDate']);
Route::get('/getApprovalDetail/{id}', [KPIController::class, 'getApprovalDetail'])->middleware('auth');

Route::post('/add-role', [RoleController::class, 'insertRole']);
Route::post('/update-role/{id}', [RoleController::class, 'updateRole']);
Route::delete('/delete-role/{id}', [RoleController::class, 'deleteRole']);

Route::post('/add-user', [UserController::class, 'insertUser']);
Route::post('/update-user/{id}', [UserController::class, 'updateUser']);
Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser']);

Route::post('/add-form', [FormController::class, 'insertForm']);
Route::post('/update-form/{id}', [FormController::class, 'updateForm']);
Route::delete('/delete-form/{id}', [FormController::class, 'deleteForm']);

Route::post('/savekpi', [KPIController::class, 'saveKpi']);
Route::post('/approve/{id}', [KPIController::class, 'approve']);

Route::post('/update-personaldata', [UserController::class, 'updatePersonalData']);
Route::post('/update-password', [UserController::class, 'updatePassword']);
Route::post('/reset-password', [UserController::class, 'resetPassword']);
