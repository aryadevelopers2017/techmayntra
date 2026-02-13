<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\company_address_master;
use DB;

class purchase_order extends Model
{
    use HasFactory;

    protected $table = 'purchase_order';

    protected $dates = ['deleted_at'];

    protected $fillable = ['id', 'purchase_date', 'order_no', 'max_invoice_no', 'company_name', 'company_id', 'vender_id', 'project_id', 'subject', 'product_name', 'description', 'address', 'city', 'state', 'pincode', 'gst', 'igst', 'gst_per', 'taxable_amount', 'gst_amount', 'total_amount', 'payment_mode', 'due_date', 'status', 'created_at'];

    public static function get_list()
    {
        $data=purchase_order::select('purchase_order.id', 'purchase_order.purchase_date', 'purchase_order.order_no', 'purchase_order.company_name', 'purchase_order.vender_id', 'purchase_order.subject', 'purchase_order.product_name', 'purchase_order.total_amount', 'purchase_order.payment_mode','purchase_order.status', 'vendor_master.name as vendor_name', 'project.quotation_title as subject_title')
        ->leftjoin('vendor_master', 'vendor_master.id','=', 'purchase_order.vender_id')
        ->leftjoin("project",function($join){
            $join->on("project.id","=","purchase_order.project_id")
            ->on("project.vendor_id","=","vendor_master.id");
        })
        ->orderBy('purchase_order.id', 'DESC')
        ->get();

        return $data;
    }

    public static function get_purchaseorderByProject_Id($id)
    {
        $data=purchase_order::select('purchase_order.id', 'purchase_order.purchase_date', 'purchase_order.order_no', 'purchase_order.company_name', 'purchase_order.vender_id', 'purchase_order.subject', 'purchase_order.product_name', 'purchase_order.total_amount', 'purchase_order.payment_mode', 'vendor_master.name as vendor_name', 'project.quotation_title as subject_title')
        ->leftjoin('vendor_master', 'vendor_master.id','=', 'purchase_order.vender_id')
        ->leftjoin("project",function($join){
            $join->on("project.id","=","purchase_order.project_id")
            ->on("project.vendor_id","=","vendor_master.id");
        })
        ->where('purchase_order.project_id', $id)
        ->orderBy('purchase_order.id', 'DESC')
        ->get();

        return $data;
    }

    public static function generate_invoice_qry($id)
    {
        $data=purchase_order::find($id);
        return $data;
    }

    public static function add($request)
    {
        $max_invoice_no=0;

        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d h:i:s");

        $invoice_date = date("Y");
        $month_date = date("Y-m-01 00:00:00");

        $result=purchase_order::where('created_at','>',$month_date)->orderBy('id','DESC')->take(1)->get();

        if(isset($result[0]->max_invoice_no))
        {
            $max_invoice_no=$result[0]->max_invoice_no;
        }

        $company_id_data=company_address_master::orderBy('id','DESC')->take(1)->get();
        $company_id=$company_id_data[0]->id;

        $max_invoice_no=$max_invoice_no+1;


        $invoice_no='PO-'.$invoice_date.'/'.str_pad($max_invoice_no,4,"0",STR_PAD_LEFT);

        $data=new purchase_order();
        $data->purchase_date=$request->purchase_date;
        $vender_id=$request->vender_id;
        $data->vender_id=$vender_id;
        $data->order_no=$invoice_no;
        $data->max_invoice_no=$max_invoice_no;

        $data->project_id=($vender_id!='other') ? $request->project_id : null ;
        $data->subject=($vender_id=='other') ? $request->subject : null ;

        $data->amount=$request->amount;
        $data->company_name=$request->company_name;
        $data->company_id=$company_id;

        $data->product_name=$request->product_name;
        $data->description=$request->description;
        $data->address=$request->address;
        $data->city=$request->city;
        $data->state=$request->state;
        $data->pincode=$request->pincode;
        $data->due_date=date('Y-m-d', strtotime($date.' + 7 day'));

        $amount=$request->amount;

        $data->gst=isset($request->gst) ?? '0';
        $data->igst=isset($request->gst) ? isset($request->igst) : '0';
        $data->gst_per=isset($request->gst) ? $request->gst_per : '0';
        $gst_amount=ROUND(($amount*$request->gst_per)/100,2);

        $data->gst_amount=$gst_amount;

        $total_amount=$amount + $gst_amount;

        $data->total_amount=$total_amount;
        $data->payment_mode=$request->payment_mode;

        $data->status=isset($request->status) ? $request->status : 0;

        $data->save();

        return $data;
    }

    public static function get_find_DataById($id)
    {
        $data=purchase_order::find($id);

    //        if($data){

    //        $state   = DB::table('states')->where('name', $vendor->state)->first();

    //     $data->country_id = $state ? $state->country_id : null;

    //  $data->country = DB::table('country')->where('name', $data->country_id)->first();

    // }

        return $data;
    }

    public static function update_order($request)
    {
        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d h:i:s");

        $data=purchase_order::find($request->id);

        $data->purchase_date=$request->purchase_date;

        $vender_id=$request->vender_id;
        $data->vender_id=$vender_id;

        $data->project_id=($vender_id!='other') ? $request->project_id : null ;
        $data->subject=($vender_id=='other') ? $request->subject : null ;

        $data->amount=$request->amount;
        $data->company_name=$request->company_name;
        $data->product_name=$request->product_name;
        $data->description=$request->description;
        $data->address=$request->address;
        $data->city=$request->city;
        $data->state=$request->state;
        $data->pincode=$request->pincode;
        $data->due_date=date('Y-m-d', strtotime($date.' + 7 day'));

        $amount=$request->amount;

        $data->gst=isset($request->gst) ?? '0';
        $data->igst=isset($request->gst) ? isset($request->igst) : '0';
        $data->gst_per=isset($request->gst) ? $request->gst_per : '0';
        $gst_amount=ROUND(($amount*$request->gst_per)/100,2);

        $data->gst_amount=$gst_amount;

        $total_amount=$amount + $gst_amount;

        $data->total_amount=$total_amount;

        $data->status=isset($request->status) ? $request->status : 0;
        $data->payment_mode=$request->payment_mode;

        $data->update();

        return $data;
    }

    public static function get_purchaseByProject_id($id)
    {
        $data=purchase_order::where(['project_id' => $id])->get();

        return $data;
    }
















}
