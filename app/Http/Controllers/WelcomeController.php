<?php

namespace Ahelos\Http\Controllers;

use Illuminate\Http\Request;
use Ahelos\ContactMessage;
use ReCaptcha\ReCaptcha;
use Illuminate\Support\Facades\Validator;

use Ahelos\Http\Requests;

class WelcomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }
}
