<?php

namespace Ahelos\Http\Controllers;

use Ahelos\Order;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *
     * @return Response
     */
    public function index()
    {
        return view('home');
    }
    
    public function orders_data()
    {
        $orders = Order::where('user_id', '=', Auth::user()->id)->get();

        return DataTables::of($orders)
            ->editColumn('created_at', function(Order $order) {
                Carbon::setLocale('hr');
                return $order->created_at->format('d.m.Y. H:i:s') . " (" . $order->created_at->diffForHumans() . ")";
            })->editColumn('updated_at', function(Order $order) {
                Carbon::setLocale('hr');
                return $order->updated_at->format('d.m.Y. H:i:s') . " (" . $order->updated_at->diffForHumans() . ")";
            })
            ->addColumn('actions', function(Order $order) {
                $actions = '<a href='. route('user.order.show', ['order' => $order]) .'><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428bca" title="Pregledaj narudžbu"></i></a>';
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
