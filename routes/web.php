<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// ===== AUTH =====
Route::get('/login', [TaskController::class, 'login_form'])->name('task.login_form');
Route::post('/login', [TaskController::class, 'login'])->name('task.login');
Route::get('/signup', [TaskController::class, 'signup_form'])->name('task.signup_form');
Route::post('/signup', [TaskController::class, 'signup'])->name('task.signup');
Route::post('/logout', [TaskController::class, 'logout'])->name('task.logout');

// ===== PROFILE =====
Route::get('/profile', [TaskController::class, 'profile'])->name('task.profile');
Route::post('/profile', [TaskController::class, 'profile_update'])->name('task.profile_update');

// ===== TASKS =====
Route::get('/', [TaskController::class, 'index'])->name('task.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('task.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('task.store');
Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('task.show');
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('task.edit');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('task.update');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('task.delete');
Route::post('/tasks/{task}/toggle', [TaskController::class, 'toggleStatus'])->name('task.toggle');
Route::get('/tasks/{task}/download', [TaskController::class, 'downloadAttachment'])->name('task.download');
Route::get('/tasks/{task}/view-attachment', [TaskController::class, 'viewAttachment'])->name('task.view_attachment');
Route::get('/tasks/completed/list', [TaskController::class, 'completed'])->name('task.completed');


