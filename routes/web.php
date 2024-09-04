<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobAplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\MyJobAplicationController;
use App\Http\Controllers\MyJobController;
use Illuminate\Support\Facades\Route;

Route::get('', function () {
    return redirect()->route('jobs.index');
});
Route::resource('jobs', JobController::class)->only(['index', 'show']);

Route::get('login', fn() => to_route('auth.create'))->name('login');
Route::resource('auth', AuthController::class)->only(['create', 'store']);

// cikis islemleri
Route::delete('logout', fn() => to_route('auth.create'))->name('logout');
Route::delete('auth', [AuthController::class, 'destroy'])->name('auth.destroy');

// jobaplication with auth
Route::middleware('auth')->group(function () {


    Route::resource('jobs.aplication', JobAplicationController::class)->only(['create', 'store', 'destroy']);

    Route::resource('my-job-applications', MyJobAplicationController::class)->only(['index', 'destroy']);

    Route::resource('employer', EmployerController::class)->only(['create', 'store']);

    Route::middleware('employer')->resource('my-jobs',MyJobController::class);
});
