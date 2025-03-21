<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index'); // Show all tasks
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store'); // Add new task
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit'); // Show edit page
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update'); // Update task
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy'); // Delete task


    Route::get('/dashboard', function () {
        $tasks = auth()->user()->tasks; // Fetch tasks for logged-in user
        return view('dashboard', compact('tasks'));
    })->name('dashboard');

    Route::resource('tasks', TaskController::class);
    // AJAX route for toggling task status
    Route::patch('/tasks/{task}/toggle-status', [TaskController::class, 'toggleStatus'])->name('tasks.toggleStatus');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
});




require __DIR__.'/auth.php';
