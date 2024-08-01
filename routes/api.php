<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::prefix("projects")->name("projects.")->controller(ProjectController::class)->group(function () {
    Route::get("/", "index")->name("index");
    Route::post("/", "store")->name("store");
    Route::put("/{project}", "update")->name("update");
    Route::delete("/{project}", "destroy")->name("destroy");
    Route::get("/{project}", "show")->name("show");
});



Route::prefix("tasks")->name("tasks.")->controller(TaskController::class)->group(function () {
    Route::get("/", "index")->name("index");
    Route::post("/", "store")->name("store");
    Route::put("/{task}", "update")->name("update");
    Route::delete("/{task}", "destroy")->name("update");
});
