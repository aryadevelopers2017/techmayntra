<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\PurchaseOrderServiceProvider;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
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
    	$data=PurchaseOrderServiceProvider::get_data();

        return view('purchase_order_list')->with('data', $data['data']);
    }

    public static function purchase_order_project_list($id)
    {
        $data=PurchaseOrderServiceProvider::purchaseorder_project_list($id);

        return view('purchase_order_list')->with('data', $data['data']);
    }

    public static function purchase_order_add()
    {
        $data=PurchaseOrderServiceProvider::get_vendordata();

    	return view('purchase_order_add')->with('data', $data['data']);
    }

    public static function add_purchase_order(Request $request)
    {
    	$data=PurchaseOrderServiceProvider::add_purchase_order($request);

        if($data['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$data['message'];

    	return redirect('/purchase_order_list')->with($status, $message);
    }

    public static function purchase_order_edit($id)
    {
        $data=PurchaseOrderServiceProvider::purchase_order_edit($id);

        return view('purchase_order_add')->with('data', $data['data']);
    }

    public static function update_purchase_order(Request $request)
    {
        $data=PurchaseOrderServiceProvider::update_purchase_order($request);

        if($data['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$data['message'];

        return redirect('/purchase_order_list')->with($status, $message);
    }

    public static function purchase_order_generate_invoice($id)
    {
        $data=PurchaseOrderServiceProvider::generate_invoice($id);

        return view('purchase_order_invoice')->with('data', $data['data']);
    }
}
