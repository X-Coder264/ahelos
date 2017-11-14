<?php

namespace Ahelos\Http\Controllers;

use Ahelos\Order;
use Illuminate\Http\Response;

class AdminCPController extends Controller
{
    /**
     * @return Response
     */
    public function index()
    {
        $orders = Order::all();
        
        return view('admin.index', compact('orders'));
    }
}
