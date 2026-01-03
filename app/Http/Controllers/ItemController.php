<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\ItemMasterServiceProvider;
use Illuminate\Http\Request;

class ItemController extends Controller
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
    	$data=ItemMasterServiceProvider::item_list();

    	return view('item_master_list')->with('item_list', $data['data']);
    }

    public static function item_master_add()
    {
        return view('item_master_add');
    }

    public static function add_item_master(Request $request)
    {
        $data=ItemMasterServiceProvider::add_item_master($request);

        if($data['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$data['message'];
        
        return redirect('/item')->with($status, $message);
    }

    public static function edit_item_master(Request $request)
    {
        $data=ItemMasterServiceProvider::edit_item_master($request);
        
        if($data['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$data['message'];

        return redirect('/item')->with($status, $message);
    }

    public static function item_master_edit($id)
    {
        $item=ItemMasterServiceProvider::item_master_edit($id);
        
        return view('item_master_add')->with('data', $item['data']);
    }

    public static function item_cancel($id)
    {
        $data=ItemMasterServiceProvider::item_cancel($id);

        if($data['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$data['message'];

        return redirect('/item')->with($status, $message);
    }
}
