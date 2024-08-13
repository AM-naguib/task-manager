<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::controller(AuthController::class)->middleware('guest')->group(function () {
    Route::get("login", "loginPage")->name("login.page");
    Route::post("login", "login")->name("login");
    Route::post("forget_password", "forget_password")->name("forget_password");
});

Route::middleware("auth")->group(function () {
    Route::post("logout", [AuthController::class, "logout"])->name("logout");

    Route::get("/", [HomeController::class, "index"])->name("index");

    Route::get("projects", [ProjectController::class, "index"])->name("projects.index");



    Route::get("tasks", [TaskController::class, "index"])->name("tasks.index");
    Route::get("tasks/{task}/edit", [TaskController::class, "edit"])->name("tasks.edit");
});


