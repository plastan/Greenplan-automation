<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;

class CommandController extends Controller
{
    public function run(Request $request)
    {
        // Example: run a custom Artisan command
        Artisan::call('app:assign-daily-meals');

        // You can also get the output like:
        $output = Artisan::output();

        return back()->with('status', 'Command executed successfully!');
    }   //
}
