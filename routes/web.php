<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckPermissions;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/users');
Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('auth');
Route::get('/users/register', [UserController::class, 'create'])->name('users.create')->middleware('auth');
Route::get('/users/login', [UserController::class, 'login'])->name('login')->middleware('guest');
Route::post('/users/login/process', [UserController::class, 'process'])->name('users.process');
Route::post('/users/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/users/edit/{id}', [UserController::class, 'show'])->name('users.edit');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::put('/users/{user}/update', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}/destroy', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles')->middleware('auth');
Route::get('/admin/roles/edit/{id}', [RoleController::class, 'show'])->name('admin.roles.edit');
Route::view('/admin/roles/create', 'admin.role.create')->name('admin.roles.create')->middleware('auth');
Route::post('/admin/roles/store', [RoleController::class, 'store'])->name('admin.roles.store');
Route::put('/admin/roles/{role}/update', [RoleController::class, 'update'])->name('admin.roles.update');
Route::delete('/admin/roles/{role}/destroy', [RoleController::class, 'destroy'])->name('admin.roles.destroy');

Route::get('/admin/departments', [DepartmentController::class, 'index'])->name('admin.departments')->middleware('auth');
Route::get('/admin/departments/edit/{id}', [DepartmentController::class, 'show'])->name('admin.departments.edit');
Route::view('/admin/departments/create', 'admin.department.create')->name('admin.departments.create')->middleware('auth');
Route::post('/admin/departments/store', [DepartmentController::class, 'store'])->name('admin.departments.store');
Route::put('/admin/departments/{department}/update', [DepartmentController::class, 'update'])->name('admin.departments.update');
Route::delete('/admin/departments/{department}/destroy', [DepartmentController::class, 'destroy'])->name('admin.departments.destroy');

Route::get('/admin/tasks', [TaskController::class, 'index'])->name('admin.tasks')->middleware('auth');
Route::get('/admin/tasks/create', [TaskController::class, 'create'])->name('admin.tasks.create')->middleware('auth');
Route::get('/admin/tasks/edit/{id}', [TaskController::class, 'show'])->name('admin.tasks.edit');
Route::post('/admin/tasks/store', [TaskController::class, 'store'])->name('admin.tasks.store');
Route::put('/admin/tasks/{task}/update', [TaskController::class, 'update'])->name('admin.tasks.update');
Route::delete('/admin/tasks/{task}/destroy', [TaskController::class, 'destroy'])->name('admin.tasks.destroy');

Route::get('/admin/activity/log', [ActivityLogController::class, 'index'])->name('admin.activity.log');