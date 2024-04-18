<?php

namespace App\Http\Controllers;

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

Route::middleware("auth:sanctum")->get("/user", function (Request $request) {
    return $request->user();
});

Route::group(["prefix" => "api/v1", "as" => "api.v1."], function () {
    Route::post("register", [AuthController::class, "register"])->name(
        "register"
    );
    Route::post("login", [AuthController::class, "login"])->name("login");

    Route::group(
        ["prefix" => "page-content", "as" => "page-content."],
        function () {
            Route::get("/", [PageContentController::class, "index"])->name(
                "index"
            );
            Route::get("/{pageContent}", [
                PageContentController::class,
                "show",
            ])->name("show");
            Route::post("/", [PageContentController::class, "create"])->name(
                "create"
            );
            Route::put("/{pageContent}", [
                PageContentController::class,
                "update",
            ])->name("update");

            Route::delete("/{pageContent}", [
                PageContentController::class,
                "destroy",
            ])->name("destroy");
        }
    );
});
