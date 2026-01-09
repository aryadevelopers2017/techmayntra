<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\VendorServiceprovider;
use App\Models\Customer;
use App\Models\item_master;
use App\Models\vendor_master;


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
           $data['country_data'] = Customer::getCountry();

           $data['services'] =  item_master::item_list();;

        $data['state_data']=Customer::getState();
        return view('vendor_add')->with('data', $data);
    }

	public static function add_vendor(Request $request)
    {

        // dd($request->all());

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

     public static function vendor_info($id)
    {
        $data=VendorServiceprovider::get_vendor_info($id);

        return view('vendor_info')->with('data', $data['data']);
    }


     public static function vendor_delete($id)
{
    try {
        // Find the service by id and delete
        $vendor_master = vendor_master::find($id);
        if ($vendor_master) {
            $vendor_master->delete();
            return redirect('/vendor_list')->with('success', 'vendor deleted successfully');
        } else {
            return redirect('/vendor_list')->with('fail', 'vendor not found');
        }
    } catch (\Exception $e) {
        \Log::error([
            'method' => __METHOD__,
            'error' => [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'message' => $e->getMessage()
            ],
            'created_at' => now()
        ]);
        return redirect('/vendor_list')->with('fail', 'Something went wrong');
    }
}

}
