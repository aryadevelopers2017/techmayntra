<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\ClientServiceProvider;
use Illuminate\Http\Request;

class ClientController extends Controller
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
    
    public static function index()
    {
    	$data=ClientServiceProvider::client_list();
    	
    	return view('client_list')->with('client_lists', $data['data']);
    }

    public static function client_add(Request $request)
    {
        return view('client_add');
    }

    public static function add_client(Request $request)
    {
        $data=ClientServiceProvider::add_clients($request);
        
        return redirect('/lead_list');
    }

}
