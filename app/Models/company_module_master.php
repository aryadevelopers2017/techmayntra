<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class company_module_master extends Model
{
    use HasFactory;

    protected $table = 'company_module_master';

    protected $dates = ['deleted_at'];

    protected $fillable = ['milestone', 'terms_conditions', 'payment_terms_conditions', 'bank_details', 'personal_bank_details', 'company_name', 'company_logo', 'address', 'city', 'state','milestone_label','technology_label'];

    public static function module_data()
    {
        return company_module_master::all();
    }

    public static function module_list()
    {
    	return company_module_master::all();
    }

    public static function update_module($request)
    {
        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d h:i:s");
        $data=company_module_master::find($request->id);
        $data->milestone=$request->milestone;
		$data->milestone_label=$request->milestone_label;
		$data->technology_label=$request->technology_label;
        $data->terms_conditions=$request->terms_conditions;
        $data->payment_terms_conditions=$request->payment_terms_conditions;
        $data->bank_details=$request->bank_details;

        $data->company_name=$request->company_name;
        $data->address=$request->address;
        $data->city=$request->city;
        $data->state=$request->state;
        $data->mobile=$request->company_mobile;
        $data->email=$request->company_email;
        $data->currency_id=$request->currency_id;

        $data->gst_no=$request->gst_no;
		$data->vat_no=$request->vat_no;

		$data->trn_no=$request->trn_no;


        $data->pan_no=$request->pan_no;
        $data->personal_bank_details=$request->personal_bank_details;
        $data->technology=$request->technology;

        if(isset($request->company_logo))
        {
            $file = $request->file('company_logo');
            $extension=pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $company_logo='logo_'.strtotime($date).'.'.$extension;
            move_uploaded_file($_FILES['company_logo']['tmp_name'], public_path('/asset/images/').$company_logo);
            $data->company_logo=$company_logo;
        }

        if(isset($request->company_sign))
        {
            $file = $request->file('company_sign');
            $extension=pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $company_sign='asset/images/'.'sign_'.strtotime($date).'.'.$extension;
            move_uploaded_file($_FILES['company_sign']['tmp_name'], $company_sign);
            $data->company_signature=$company_sign;
        }

        $data->save();

        return $data;
    }

    public static function add_module($request)
    {
        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d h:i:s");
        $data=new company_module_master();
        $data->milestone=$request->milestone;
        $data->terms_conditions=$request->terms_conditions;
        $data->payment_terms_conditions=$request->payment_terms_conditions;
        $data->bank_details=$request->bank_details;
        $data->currency_id=$request->currency_id;

        $data->company_name=$request->company_name;
        $data->address=$request->address;
        $data->city=$request->city;
        $data->state=$request->state;
        $data->mobile=$request->company_mobile;
        $data->email=$request->company_email;
        $data->gst_no=$request->gst_no;
		$data->trn_no=$request->trn_no;
        $data->pan_no=$request->pan_no;
        $data->personal_bank_details=$request->personal_bank_details;
        $data->technology=$request->technology;

        if(isset($request->company_logo))
        {
            $file = $request->file('company_logo');
            $extension=pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $company_logo='logo_'.strtotime($date).'.'.$extension;
            move_uploaded_file($_FILES['company_logo']['tmp_name'], public_path('/asset/images/').$company_logo);
            $data->company_logo=$company_logo;
        }

        if(isset($request->company_sign))
        {
            $file = $request->file('company_sign');
            $extension=pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $company_sign='asset/images/'.'sign_'.strtotime($date).'.'.$extension;
            move_uploaded_file($_FILES['company_sign']['tmp_name'], $company_logo);
            $data->company_signature=$company_sign;
        }

        $data->save();

        return $data;
    }
}
