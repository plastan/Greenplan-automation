<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/run-command', [App\Http\Controllers\CommandController::class, 'run'])->name('run.command');

Route::post('/chef_charts', [App\Http\Controllers\ChefChartController::class, 'run'])->name('run.command');
