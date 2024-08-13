<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ProjectController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(AuthController::class)->prefix("auth")->group(function () {
    Route::post("/login", "login");
    Route::post("/register", "register")->name("register");
    Route::post("/logout", "logout")->middleware("auth:sanctum");
});


Route::middleware("auth")->group(function () {

    Route::prefix("projects")->name("projects.")->controller(ProjectController::class)->group(function () {
        Route::get("/", "index")->name("index");
        Route::post("/", "store")->name("store");
        Route::put("/{project}", "update")->name("update");
        Route::delete("/{project}", "destroy")->name("destroy");
        Route::get("/{project}", "show")->name("show");
    });


    Route::prefix("tasks")->name("tasks.")->controller(TaskController::class)->group(function () {
        Route::get("/", "index")->name("api.index");
        Route::post("/", "store")->name("store");
        Route::put("/{task}", "update")->name("update");
        Route::delete("/{task}", "destroy")->name("update");
        Route::get("/{task}", "show")->name("show");
    });



    Route::prefix("comments")->name("comments.")->controller(CommentController::class)->group(function () {
        Route::get("/", "index")->name("index");
        Route::post("/", "store")->name("store");
        Route::put("/{comment}", "update")->name("update");
        Route::delete("/{comment}", "destroy")->name("update");
        Route::get("/{comment}", "show")->name("show");
    });



    Route::resource('roles', RoleController::class);




    Route::prefix("users")->name("users.")->controller(UserController::class)->group(function () {
        Route::post("/", "store")->name("store");
        Route::put("/{user}", "update")->name("update");
        Route::get("/{user}", "show")->name("show");
        Route::delete("/{user}", "destroy")->name("destroy");
    });
});
