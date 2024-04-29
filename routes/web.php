<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('user.login');
});
Route::get('/register', function () {
    return view('user.register');
});

Route::get('/users', [UserController::class, 'index'])->name('users.index');
// Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/register', [UserController::class, 'create'])->name('users.create');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
// Route::put('/users/{user}/update', [UserController::class, 'update'])->name('users.update');
// Route::delete('/users/{user}/destroy', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles');
Route::get('/admin/role/{id}', [RoleController::class, 'show'])->name('admin.roles.show');
Route::view('/admin/roles/create', 'admin.role.create')->name('admin.roles.update');
Route::post('/admin/roles/store', [RoleController::class, 'store'])->name('admin.roles.store');
Route::put('/admin/role/{role}/update', [RoleController::class, 'update'])->name('admin.roles.update');
Route::delete('/admin/role/{role}/destroy', [RoleController::class, 'destroy'])->name('admin.roles.destroy');

Route::get('/admin/departments', [DepartmentController::class, 'index'])->name('admin.departments');
Route::get('/admin/department/{id}', [DepartmentController::class, 'show'])->name('admin.departments.show');
Route::view('/admin/departments/create', 'admin.department.create')->name('admin.departments.update');
Route::post('/admin/departments/store', [DepartmentController::class, 'store'])->name('admin.departments.store');
Route::put('/admin/department/{department}/update', [DepartmentController::class, 'update'])->name('admin.departments.update');
Route::delete('/admin/department/{department}/destroy', [DepartmentController::class, 'destroy'])->name('admin.departments.destroy');




// Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles');