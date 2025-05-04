<?php

use App\Services\CustomerService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HeatmapController;
use App\Exports\MonthlyChartExport;
use Maatwebsite\Excel\Facades\Excel;

Route::redirect('/', '/admin');
Route::post('/run-command', [App\Http\Controllers\CommandController::class, 'run'])->name('run.command');
Route::post('/run-test_month',function (){
        $sheets = new MonthlyChartExport();
                        if ($sheets == []) { return; }
                        else {
                            return Excel::download($sheets, 'monthly' . now()->format('Yms') . '.xlsx');
                        }


    // return (new CustomerService)->get_monthly_data_all();

})->name('run.test_month');

// Route::post('/chef_charts', [App\Http\Controllers\ChefChartController::class, 'run'])->name('run.command');

// Route::get('/api/heatmap-data', function () {
//     $service = app(CustomerService::class);
//     return response()->json($service->get_monthly_data(1));
// });
//

// Route::get('/heatmap', [HeatmapController::class, 'index']);
