<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function dashboard()
    {
        $data['customer'] = Customer::all()->count();
        return view('dashboard.index',compact('data'));
    }
}
