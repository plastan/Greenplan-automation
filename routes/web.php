<?php

use App\Services\CustomerService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HeatmapController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/run-command', [App\Http\Controllers\CommandController::class, 'run'])->name('run.command');

Route::post('/chef_charts', [App\Http\Controllers\ChefChartController::class, 'run'])->name('run.command');

// Route::get('/api/heatmap-data', function () {
//     $service = app(CustomerService::class);
//     return response()->json($service->get_monthly_data(1));
// });
//

Route::get('/heatmap', [HeatmapController::class, 'index']);
