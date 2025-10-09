<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Authentication (temporary)
Route::get('/login', [TaskController::class, 'loginForm'])->name('login.form');
Route::post('/login', [TaskController::class, 'login'])->name('login');
Route::get('/signup', [TaskController::class, 'signupForm'])->name('signup.form');
Route::post('/signup', [TaskController::class, 'signup'])->name('signup');
Route::get('/logout', [TaskController::class, 'logout'])->name('task.logout');

Route::get('/', [TaskController::class, 'index'])->name('task.index');
Route::get('/add', [TaskController::class, 'create'])->name('task.create');
Route::post('/add', [TaskController::class, 'store'])->name('task.store');
Route::get('/edit/{index}', [TaskController::class, 'edit'])->name('task.edit');
Route::post('/update/{index}', [TaskController::class, 'update'])->name('task.update');
Route::get('/delete/{index}', [TaskController::class, 'delete'])->name('task.delete');
Route::get('/complete/{index}', [TaskController::class, 'complete'])->name('task.complete');
Route::get('/view/{index}', [TaskController::class, 'view'])->name('task.view');
Route::get('/search', [TaskController::class, 'search'])->name('task.search');
Route::get('/completed', [TaskController::class, 'completedTasks'])->name('task.completed');
Route::get('/completed', [TaskController::class, 'completedTasks'])->name('task.completed');


