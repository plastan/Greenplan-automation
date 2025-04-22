<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;

class ChefChartController extends Controller
{

    public function run(Request $request)
    {
        Artisan::call('app:assign-daily-meals');

        return back()->with('status', 'Command executed successfully!');
    }
}
