<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Customer;
use App\Models\vendor_master;

class Project extends Model
{
    use HasFactory;
    protected $table = 'project';

    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'quotation_id', 'quotation_title', 'quotation_price', 'customer_id', 'vendor_id', 'vendor_price', 'start_date', 'due_date', 'remarks', 'status', 'created_at', 'updated_at'];


    public static function get_project_list()
    {
        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d");

        $data=Project::select('project.id', 'project.quotation_title', 'project.quotation_price', 'project.vendor_price', 'project.start_date', 'project.due_date', 'project.status', 'customer.name as customer_name', 'vendor_master.name as vendor_name', DB::raw("DATEDIFF(due_date, start_date) AS remaining_days"), DB::raw("DATEDIFF(due_date, '$date') AS extradays") )
        ->join('customer', 'customer.id','=', 'project.customer_id')
        ->join('vendor_master', 'vendor_master.id','=', 'project.vendor_id')
        ->orderBy('project.id', 'DESC')
        ->get();
        return $data;
    }

    public static function add($request)
    {
        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d h:i:s");
        
        $data=new Project();

        $data->quotation_id=$request->quotation_id;
        $data->quotation_title=$request->quotation_title;
        $data->quotation_price=$request->quotation_price;
        $data->customer_id=$request->customer_id;
        $data->vendor_id=$request->vendor_id;
        $data->vendor_price=$request->vendor_price;
        $data->start_date=$request->start_date;
        $data->due_date=$request->due_date;
        $data->remarks=$request->remarks;

        $data->save();
        return $data;
    }

    public static function get_projectByvendor_id($id)
    {
        $data=Project::where(['vendor_id' => $id])->get();
        return $data;
    }

    public static function get_projectById($id)
    {
        $data=Project::find($id);
        return $data;
    }

    public static function project_approve($id)
    {
        $data=Project::find($id);

        $data->status=1;
        $data->update();
        return $data;
    }

    public static function project_cancel($id)
    {
        $data=Project::find($id);

        $data->status=2;
        $data->update();
    }
}
