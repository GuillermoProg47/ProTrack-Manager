<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\App;

// Auth routes (demo session-based)
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register');

// Home route (HomeController will redirect to login if session user is missing)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Admin routes
Route::middleware(['role:admin'])->group(function () {
    Route::get('admin', [AdminController::class, 'index'])->name('admin.dashboard');
    // Admin user management
    Route::get('admin/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
    Route::get('admin/users/create', [AdminController::class, 'create'])->name('admin.users.create');
    Route::post('admin/users', [AdminController::class, 'store'])->name('admin.users.store');
    Route::post('admin/users/{user}/toggle-active', [AdminController::class, 'toggleActive'])->name('admin.users.toggleActive');
    Route::post('admin/users/{user}/reset-password', [AdminController::class, 'resetPassword'])->name('admin.users.resetPassword');
    Route::put('admin/users/{user}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    // Task CRUD for admin
    Route::get('admin/tasks', [TaskController::class, 'index'])->name('admin.tasks.index');
    Route::get('admin/tasks/create', [TaskController::class, 'create'])->name('admin.tasks.create');
    Route::post('admin/tasks', [TaskController::class, 'store'])->name('admin.tasks.store');
    Route::get('admin/tasks/{task}/edit', [TaskController::class, 'edit'])->name('admin.tasks.edit');
    Route::put('admin/tasks/{task}', [TaskController::class, 'update'])->name('admin.tasks.update');
    Route::delete('admin/tasks/{task}', [TaskController::class, 'destroy'])->name('admin.tasks.destroy');
    // Project CRUD for admin
    Route::get('admin/projects', [\App\Http\Controllers\ProjectController::class, 'index'])->name('admin.projects.index');
    Route::get('admin/projects/create', [\App\Http\Controllers\ProjectController::class, 'create'])->name('admin.projects.create');
    Route::post('admin/projects', [\App\Http\Controllers\ProjectController::class, 'store'])->name('admin.projects.store');
    Route::get('admin/projects/{project}/edit', [\App\Http\Controllers\ProjectController::class, 'edit'])->name('admin.projects.edit');
    Route::put('admin/projects/{project}', [\App\Http\Controllers\ProjectController::class, 'update'])->name('admin.projects.update');
    Route::delete('admin/projects/{project}', [\App\Http\Controllers\ProjectController::class, 'destroy'])->name('admin.projects.destroy');
});

// Ruta simple para cambiar idioma (persistir en sesión). En una app real, mover a middleware/proveedor.
Route::get('lang/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'es'])) {
        session(['app_locale' => $lang]);
        App::setLocale($lang);
    }
    return redirect()->back();
})->name('lang.switch');

// Worker routes (tasks)
Route::middleware(['web'])->group(function () {
    Route::get('tasks/my', [TaskController::class, 'myTasks'])->name('tasks.my');
    Route::post('tasks/{task}/complete', [TaskController::class, 'markComplete'])->name('tasks.markComplete');
});

// Small developer helpers: only enabled when APP_DEBUG=true
if (config('app.debug')) {
    Route::get('whoami', function () {
        return response()->json(session('user'));
    })->name('dev.whoami');

    // Impersonate a user by email (development only). Sets session('user') to that user.
    Route::get('dev/impersonate/{email}', function ($email) {
        $u = App\Models\User::where('email', $email)->first();
        if (! $u) {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }
        session(['user' => [
            'id' => $u->id,
            'email' => $u->email,
            'name' => $u->name,
            'role' => $u->role ?? 'user'
        ]]);
        return redirect()->route('admin.dashboard')->with('success', 'Impersonando ' . $u->email);
    })->name('dev.impersonate');
}
