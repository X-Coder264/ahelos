<?php

namespace Ahelos\Http\Controllers;

use Ahelos\Order;
use Ahelos\Printer;
use Ahelos\PrinterOrder;
use Ahelos\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
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
        $user = User::with('printers')->find(Auth::user()->id);
        
        return view('order', compact('user'));
    }

    /**
     * Show order details.
     * @param Order $order
     * @return Response|RedirectResponse
     */
    public function show(Order $order)
    {
        if (Auth::user()->isAdmin() || Auth::user()->id === $order->user_id) {
            return view('order_details', compact('order'));
        }
        return back();
    }

    public function order_data(Order $order)
    {
        $printers_order = PrinterOrder::with(['ink.printer' => function($query)
        {
            $query->withTrashed();
        }])->where('order_id', '=', $order->id)->get();

        return DataTables::of($printers_order)
            ->make(true);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $orders = $request->except('_token');

        $validator = Validator::make($orders, [
            'order.*.printer_id' => [
                'required', 'integer', 'min:1',
                Rule::exists('printers', 'id')->where(function ($query) {
                    $query->where('user_id', Auth::user()->id);
                }),
            ],
            'order.*.ink_id' => [
                'required', 'integer', 'min:1',
                Rule::exists('printer_inks', 'id'),
            ],
            'order.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->getMessageBag()->toArray()]);
        } else {
            if($request->has('remark') && $request->input('remark') != '') {
                $remark = $request->input('remark');
            } else {
                $remark = "";
            }
            
            $saved_order = Order::create([
                'user_id' => Auth::user()->id,
                'remark' => $remark
            ]);

            foreach ($orders['order'] as $order) {
                PrinterOrder::create([
                    'order_id' => $saved_order->id,
                    'ink_id' => $order['ink_id'],
                    'quantity' => $order['quantity'],
                ]);
            }

            Cache::forget('unopened_order_count');

            return response()->json(['status' => 'success']);
        }
    }

    /**
     * @param Request $request
     * @param Order $order
     * @return Response
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->except('_token');

        $printers_order = PrinterOrder::where('order_id', '=', $order->id)->get();

        $count = count($printers_order);

        for($i = 0; $i < $count; $i++) {
            $printers_order[$i]->ink_id = $data['inks'][$i];
            $printers_order[$i]->quantity = $data['quantity'][$i];
            $printers_order[$i]->save();
        }

        $order->status = $data['status'];
        $order->save();

        return back()->with('success', 'Narudžba je uspješno ažurirana.');

    }
    
    public function getAllOrders()
    {
        $orders = Order::with('user')->get();

        return DataTables::of($orders)
            ->editColumn('created_at', function(Order $order) {
                Carbon::setLocale('hr');
                return $order->created_at->format('d.m.Y. H:i:s') . " (" . $order->created_at->diffForHumans() . ")";
            })
            ->addColumn('actions', function(Order $order) {
                $actions = '<a href='. route('admin.user.order.show', ['order' => $order]) .'><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428bca" title="Pregledaj narudžbu"></i></a>';
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * @param Order $order
     * @return Response
     */
    public function order_details(Order $order)
    {
        if (!$order->read_by_admin) {
            $order->timestamps = false;
            $order->read_by_admin = true;
            $order->save();
            Cache::forget('unopened_order_count');
        }

        $printers_order = PrinterOrder::with(['ink.printer' => function($query) {
            /* if the admin wants to have as an option to edit even the printers
               that the user has already (soft) deleted you should uncomment the next line */
            //$query->withTrashed();
        }])->where('order_id', '=', $order->id)->get();

        $user = User::select('name', 'surname', 'company', 'post', 'place', 'address', 'email', 'phone')->find($order->user_id);
        $printers = Printer::where('user_id', '=', $order->user_id)->get();

        return view('admin.order_details', compact('order', 'printers_order', 'user' ,'printers'));
    }
}
