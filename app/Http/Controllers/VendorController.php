<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\VendorServiceprovider;
use App\Models\Customer;
use Illuminate\Http\Request;

class VendorController extends Controller
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
    	$data=VendorServiceprovider::get_list();
        
        return view('vendor_list')->with('data', $data['data']);
    }

    public static function vendor_add()
    {
        $data=[];
        $data['state_data']=Customer::getState();
        return view('vendor_add')->with('data', $data);
    }

	public static function add_vendor(Request $request)
    {
    	$data=VendorServiceprovider::add_vendor($request);

        if($data['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$data['message'];
    	
    	return redirect('/vendor_list')->with($status, $message);
    }    
}
