<?php

namespace MyDesigner\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|designer|manager|user');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
		if ( $request->user()->hasRole('admin')) {
			return view('admin/dashboard');
		}
		else if ( $request->user()->hasRole('designer')) {
			return view('designer/dashboard');
		}
        else if ( $request->user()->hasRole('manager')) {
            return view('manager/dashboard');
        }
		else {
			return view('user/dashboard');
		}

    }
    
}
