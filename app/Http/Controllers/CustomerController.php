<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\CustomerServiceProvider;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
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
    	$data=CustomerServiceProvider::customer_list();

    	return view('customer_list')->with('customer', $data['data']);
    }

    public static function customer_add()
    {
        $data=[];
        $data['state_data']=Customer::getState();
    	return view('customer_add')->with('data', $data);
    }

    public static function customer_checkemail(Request $request)
    {
        $data=CustomerServiceProvider::checkemail($request);
        if(count($data['data'])<=0)
        {
            return 'success';
        }
        return 'fail';
    }

    public static function add_customer(Request $request)
    {
        $customer=CustomerServiceProvider::add_customer($request);

        if($customer['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }
        $message=$customer['message'];
        
        return redirect('/customer')->with($status, $message);
    }

    public static function customer_info($id)
    {
        $data=CustomerServiceProvider::get_customer_info($id);
        
        return view('customer_info')->with('data', $data['data']);
    }

    public static function delete_customer($id)
    {
        $data=CustomerServiceProvider::delete_customer($id);
        
        return redirect('/customer');
    }

    public static function getCityBystateId(Request $request)
    {
        $data=CustomerServiceProvider::getCityBystateId($request->state_id);

        return response()->json(array('city'=> $data), 200);
    }
	public static function getStateBycountryId(Request $request)
    { 
        $data=CustomerServiceProvider::getStateBycountryId($request->country_id);

        return response()->json(array('state'=>  $data), 200);
    }
	
	
}