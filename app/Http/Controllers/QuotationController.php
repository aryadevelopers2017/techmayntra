<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\QuotationServiceProvider;
use Illuminate\Http\Request;

class QuotationController extends Controller
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
    
    public static function index($id)
    {
    	$data=QuotationServiceProvider::quotation_list($id);

        return view('quotation_list')->with('quotation_list', $data['data']);
    }

    public static function get_customer_item_list()
    {
        $data=QuotationServiceProvider::get_customer_item_list();

        return view('quotation_add')->with('details_array', $data['data']);
    }

    public static function add_quotation(Request $request)
    {
        $data=QuotationServiceProvider::add_quotation($request);

        if($data['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$data['message'];
        
        return redirect('/quotation/0')->with($status, $message);
    }

    public static function quotation_edit($id)
    {
        $data=QuotationServiceProvider::quotation_edit($id);
        
        return view('quotation_add')->with('details_array', $data['data']);
    }

    public static function update_quotation(Request $request)
    {
        $data=QuotationServiceProvider::update_quotation($request);

        if($data['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$data['message'];

        return redirect('/quotation/0')->with($status, $message);
    }

    public static function invoice($id)
    {
        $data=QuotationServiceProvider::invoice($id);
        
        return view('invoice')->with('data', $data['data']);
    }

    public static function delete_quotation($id)
    {
        $data=QuotationServiceProvider::delete_quotation($id);
        
        if($data['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$data['message'];

        return redirect('/quotation/0')->with($status, $message);
    }

    public static function quotation_approve($id)
    {
        $data=QuotationServiceProvider::quotation_approve($id);

        if($data['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$data['message'];
        
        return redirect('/quotation/0')->with($status, $message);
    }

    public static function quotation_cancel($id)
    {
        $data=QuotationServiceProvider::quotation_cancel($id);

        if($data['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$data['message'];

        return redirect('/quotation/0')->with($status, $message);
    }
}
