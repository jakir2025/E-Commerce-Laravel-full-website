<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function adminDashboard()
    {
        $allOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $confirmedOrders = Order::where('status', 'confirmed')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        $returnedOrders = Order::where('status', 'returned')->count();
        // Logic for displaying the admin dashboard
        return view('backend.dashboard', compact('allOrders','pendingOrders','confirmedOrders','deliveredOrders','cancelledOrders','returnedOrders'));
    }   
}
