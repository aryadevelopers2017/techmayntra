<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Lead_master extends Model
{
    use HasFactory;

    protected $table = 'lead_master';

    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'name', 'company_name', 'contact', 'client_id', 'follow_up_date', 'remarks', 'status','state','city','country'];

    public static function lead_list()
    {
    	$data=Lead_master::orderBy('id', 'DESC')->get();
    	return $data;
    }

    public static function add_lead_master($request)
    {
		 
		\DB::enableQueryLog();
        $data =new Lead_master();

        $data->name=$request->name;
        $data->contact=$request->contact;
        $data->client_id=isset($request->client_id) ? $request->client_id : null;
       // $data->lead=implode(',', $request->lead);
        $data->follow_up_date=$request->follow_up_date;
        $data->status=0;
        $data->remarks=$request->remarks;
        $data->mobile=$request->mobile;
        $data->email=$request->email;
        $data->address=$request->address;
        $data->city=$request->city;
        $data->state=$request->state;
		$data->country=$request->country;
        $data->pincode=$request->pincode;

        $data->save();
		dd(\DB::getQueryLog());

        return $data;
    }

    public static function get_lead_dataByID($id)
    {
        $data=Lead_master::find($id);
        return $data;
    }

    public static function delete_lead($id)
    {
        $data=Lead_master::where('id', $id)->delete();
    }

    public static function update_lead_master($request)
    {
        $data =Lead_master::find($request->id);

        $data->name=$request->name;
        $data->contact=$request->contact;
        $data->client_id=isset($request->client_id) ? $request->client_id : '';
       // $data->lead=implode(',', $request->lead);
        $data->follow_up_date=$request->follow_up_date;
        $data->remarks=$request->remarks;
        $data->status=0;
        $data->mobile=$request->mobile;
        $data->email=$request->email;
        $data->address=$request->address;
        $data->city=$request->city;
        $data->state=$request->state;
		$data->country=$request->country;
        $data->pincode=$request->pincode;

        $data->save();

        return $data;
    }

    public static function update_lead_status($id, $status)
    {
        $data =Lead_master::find($id);
        $data->status=$status;
        
        $data->save();

        return $data;
    }
}

