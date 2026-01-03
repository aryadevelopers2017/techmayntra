<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';

    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'company_name', 'address', 'email', 'mobile', 'city', 'state', 'status'];

    public static function customer_list()
    {
    	$data=Customer::select('id', 'name', 'company_name', 'address', 'city', 'state', 'email', 'mobile')->where('status', 0)->orderBy('id', 'DESC')->get();
    	return $data;
    }

    public static function checkemail($request)
    {
    	$data=Customer::where(['email'=>strtolower($request->email)])->get();
    	return $data;
    }

    public static function get_CustomerByid($id)
    {
        $data=Customer::find($id);
        return $data;
    }

    public static function remove_customer($id)
    {
        $data=Customer::find($id);
        $data->status=1;

        $data->update();
        
        return $data;
    }
    
    public static function add_customer($request)
    {
        $customer =new Customer();

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
	public static function getCountry()
    {
        $country = DB::table('country')->where(['status' => 0])->get();
        return $country;
    }

    public static function getState()
    {
        $state = DB::table('states')->where(['country_id' => 101])->get();
        return $state;
    }

    public static function getCity()
    {
        $state = DB::table('city')->where(['country_id' => 101])->get();
        return $state;
    }

    public static function getCityBystateId($id)
    {
        $state = DB::table('city')->where(['state_id' => $id])->get();
        return $state;
    }
	public static function getStateBycountryId($id)
    {
        $state = DB::table('states')->where(['country_id' => $id])->get();
        return $state;
    }

    public static function getStateName($id)
    {
        $state = DB::table('states')->where(['id' => $id])->get();
        return $state;
    }

    public static function getCityName($id)
    {
        $state = DB::table('city')->where(['id' => $id])->get();
        return $state;
    }

    public static function getStatedata($name)
    {
        $state = DB::table('states')->where(['name' => $name])->get();
        return $state;
    }
}