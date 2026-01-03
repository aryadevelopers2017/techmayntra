<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\ClientServiceProvider;
use App\Providers\LeadServiceProvider;
use App\Providers\CustomerServiceProvider;
use Illuminate\Http\Request;

class LeadController extends Controller
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
    	$data=LeadServiceProvider::lead_list();
        
        return view('lead_list')->with('lead_lists', $data['data']);
    }

    public static function lead_add()
    {
    	$data=LeadServiceProvider::lead_add();
		
		return view('lead_add')->with('data', $data['data']);
    }

    public static function add_leads(Request $request)
    {
        $item=LeadServiceProvider::add_leads($request);

        return redirect('/lead_list');
    }
    
    public static function lead_edit($id)
    {
        $lead=LeadServiceProvider::get_lead_data($id);
        
        return view('lead_add')->with('data', $lead['data']);
    }

    public static function lead_delete($id)
    {
        LeadServiceProvider::lead_delete($id);

        return redirect('/lead_list');
    }

    public static function update_lead(Request $request)
    {
        $data=LeadServiceProvider::update_lead($request);

        return redirect('/lead_list');
    }

    public static function lead_cancel($id)
    {
        $status=2;
        $data=LeadServiceProvider::update_lead_status($id, $status);
        
        return redirect('/lead_list');
    }
    
    public static function lead_approve($id)
    {
        $status=1;
        $data=LeadServiceProvider::update_lead_status($id, $status);

        return view('customer_add')->with('data', $data['data']);
    }
}
