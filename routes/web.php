<?php

use Illuminate\Support\Facades\Route ;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AuthController as AuthController;
use App\Http\Controllers\HomeController as HomeController;
use App\Http\Controllers\TaskController as TaskController;
use App\Http\Controllers\Api\RoleController as ApiRoleController;
use App\Http\Controllers\Api\TaskController as ApiTaskController;
use App\Http\Controllers\Api\UserController as ApiUserController;
use App\Http\Controllers\ProjectController  as ProjectController;
use App\Http\Controllers\Api\CommentController as ApiCommentController;
use App\Http\Controllers\Api\ProjectController as ApiProjectController;
use App\Http\Controllers\UserController as UserController;

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

route::view('editor','welcome');

Route::controller(AuthController::class)->middleware('guest')->group(function () {
    Route::get("login", "loginPage")->name("login.page");
    Route::post("login", "login")->name("login");
    Route::post("forget_password", "forget_password")->name("forget_password");
});

Route::middleware("auth")->group(function () {


    Route::post("update-password", [AuthController::class, "updatePassword"])->name("update-password");
    Route::post("logout", [AuthController::class, "logout"])->name("logout");

    Route::get("/", [HomeController::class, "index"])->name("index");

    Route::get("projects", [ProjectController::class, "index"])->name("projects.index");
    Route::get('projects/document/{project}', [ProjectController::class, 'projectDocument'])->name('projects.document');


    Route::get("tasks", [TaskController::class, "index"])->name("tasks.index");
    Route::get("tasks/{task}/edit", [TaskController::class, "edit"])->name("tasks.edit");
    Route::post("tasks/updateStatus/{task}",[TaskController::class, "updateStatus"])->name("tasks.updateStatus");


    Route::get("users/", [UserController::class, "index"])->name("users.index");

});





Route::middleware("auth")->group(function () {

    Route::prefix("projects")->name("projects.")->controller(ApiProjectController::class)->group(function () {
        // Route::get("/", "index")->name("index");
        Route::post("/", "store")->name("store");
        Route::put("/{project}", "update")->name("update");
        Route::delete("/{project}", "destroy")->name("destroy");
        Route::get("/{project}", "show")->name("show");
    });


    Route::prefix("tasks")->name("tasks.")->controller(ApiTaskController::class)->group(function () {
        // Route::get("/", "index")->name("api.index");
        Route::post("/", "store")->name("store");
        Route::put("/{task}", "update")->name("update");
        Route::delete("/{task}", "destroy")->name("destroy");
        Route::get("/{task}", "show")->name("show");
    });



    Route::prefix("comments")->name("comments.")->controller(ApiCommentController::class)->group(function () {
        // Route::get("/", "index")->name("index");
        Route::post("/", "store")->name("store");
        Route::put("/{comment}", "update")->name("update");
        Route::delete("/{comment}", "destroy")->name("update");
        Route::get("/{comment}", "show")->name("show");
    });



    Route::resource('roles', ApiRoleController::class);




    Route::prefix("users")->name("users.")->controller(ApiUserController::class)->group(function () {
        Route::post("/", "store")->name("store");
        Route::put("/{user}", "update")->name("update");
        Route::get("/{user}", "show")->name("show");
        Route::delete("/{user}", "destroy")->name("destroy");
    });


    Route::prefix("documents")->controller(DocumentController::class)->name("documents.")->group(function () {
            Route::get("/","index")->name("index");
            Route::get("/create","create")->name("create");
            Route::post("/","store")->name("store");
            Route::get("/{document}/edit","edit")->name("edit");
            Route::put("/{document}","update")->name("update");
            Route::delete("/{document}","destroy")->name("destroy");
            Route::get("/{document}","show")->name("show");


    });
    Route::delete("document/file/{file}", [DocumentController::class, "destroyFile"])->name("documents.destroyFile");
});
