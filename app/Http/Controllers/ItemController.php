<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\ItemMasterServiceProvider;
use Illuminate\Http\Request;
use DB;
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
        $data['vendors'] = DB::table('vendor_master')->where('status', 0)->get();
        $data['categories'] = DB::table('service_categories')->where('status', 1)->get();

        $data['subcategories'] = []; // empty for add form
        return view('item_master_add')->with('data', $data);
    }

    public static function add_item_master(Request $request)
    {
        // dd($request->all());
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

        return redirect('/service')->with($status, $message);
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

        return redirect('/service')->with($status, $message);
    }

    public static function item_master_edit($id)
{
    $item = ItemMasterServiceProvider::item_master_edit($id);

    $data = null;
    $data = $item['data']; // item record
    $data['vendors'] = DB::table('vendor_master')->get();
    $data['categories'] = DB::table('service_categories')->where('status', 1)->get();

    // preload subcategories for edit
    $data['subcategories'] = DB::table('services')
        ->where('category_id', $item['data']->category_id)

        ->get();


        // dd($data['subcategories']);

    return view('item_master_add', compact('data'));
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

        return redirect('/service')->with($status, $message);
    }

       public static function service_subcategories(Request $request)
    {
        return DB::table('services')
        ->where('category_id', $request->category_id)
        ->where('status', 1)
        ->get();
    }

}
