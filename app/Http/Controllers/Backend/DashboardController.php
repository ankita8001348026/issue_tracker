<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Issue;
use App\Models\Order;
use App\Models\Package;
use App\Models\Product;
use App\Models\QuoteRequest;
use App\Models\QuoteRequestProduct;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct() {}


    public function dashboard()
    {
        $data['issue'] = Issue::count();
        $data['user'] = User::type(2)->count();
        $data['employee'] = User::type(1)->count();
        $data['complate'] = Issue::where('status', 2)->count();
        return view('backend.dashboard.dashboard', compact('data'));
    }
}
