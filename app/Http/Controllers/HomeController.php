<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::user()->user_type == 'end_user') {
            return view('dashboards.end_user.index');
        } else {
            return view('dashboards.admin.index');
        }
    }
}
