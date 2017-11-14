<?php

namespace Ahelos\Http\Controllers;

use Ahelos\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AddPrinterController extends Controller
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
     * @return Response
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);

        return view('add_printer', compact('user'));
    }
}
