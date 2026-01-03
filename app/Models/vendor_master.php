<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class vendor_master extends Model
{
    use HasFactory;

    protected $table = 'vendor_master';

    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'name', 'company_name', 'address', 'email', 'mobile', 'city', 'state', 'status'];

    public static function vendor_list()
    {
        $customer =vendor_master::where('status', 0)->orderBy('id', 'DESC')->get();

        return $customer;
    }

    public static function get_vendorById($id)
    {
        $data=vendor_master::find($id);

        return $data;
    }

    public static function add_vendor($request)
    {
        $customer =new vendor_master();

        $customer->name=$request->name;
        $customer->company_name=$request->company_name;
        $customer->email=$request->email;
        $customer->mobile=$request->mobile;
        $customer->address=isset($request->address) ? $request->address : '';
        $customer->city=isset($request->city) ? $request->city : '';
        $customer->state=isset($request->state) ? $request->state : '';
        $customer->gst_no=isset($request->gst_no) ? $request->gst_no : '';
        $customer->save();

        return $customer;
    }
}
