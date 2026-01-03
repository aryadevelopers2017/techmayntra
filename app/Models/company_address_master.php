<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class company_address_master extends Model
{
    use HasFactory;

    protected $table = 'company_address_master';

    protected $dates = ['deleted_at'];
    
    protected $fillable = ['company_id', 'address', 'city', 'state'];

    public static function companyaddress_list()
    {
    	return company_address_master::all();
    }

    public static function company_address_data()
    {
        $result=company_address_master::select('company_address_master.id', 'company_address_master.address', 'company_address_master.city', 'company_address_master.state', 'company_address_master.mobile', 'company_address_master.email')
            ->join('company_module_master', 'company_module_master.id', 'company_address_master.company_id')
            ->where('status', 0)
            ->orderBy('company_address_master.id', 'DESC')->get();
        return $result;
    }

    public static function update_status_address($id)
    {
    	$data=company_address_master::find($id);

    	if($data->status==0)
    	{
    		$data->status=1;
    	}
    	else
    	{
    		$data->status=0;
    	}

    	$data->update();

    	return $data;
    	
    }

    public static function add_companyadrress($request)
    {
        $data=new company_address_master();

        $data->company_id=$request->company_id;
        $data->address=$request->address;
        $data->city=$request->city;
        $data->state=$request->state;
        $data->email=$request->company_email;
        $data->mobile=$request->company_mobile;
        $data->signature=$request->company_signature;
        $data->save();

        return $data;
    }

    public static function update_companyadrress($request)
    {
        $data=company_address_master::find($request->id);

        $data->company_id=$request->company_id;
        $data->address=$request->address;
        $data->city=$request->city;
        $data->state=$request->state;
        $data->update();
        return $data;
    }
}