<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\quotation;

class proforma_invoice extends Model
{
    use HasFactory;

    protected $table = 'proforma_invoice';

    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'entrydate', 'title', 'quotation_id', 'c_id', 'max_invoice_no', 'invoice_no', 'item_ids', 'price', 'discount', 'discount_amount', 'paid_amount', 'amount', 'gst_per', 'gst_amount', 'total_amount', 'bank_details', 'status'];

    public static function add($request)
    {
        $max_invoice_no=0;
        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d h:i:s");
        $invoice_date = date("Y");
        $month_date = date("Y-01-01 00:00:00");

		$result=proforma_invoice::where('entrydate','>',$month_date)->orderBy('id','DESC')->take(1)->get();
        if(isset($result[0]->max_invoice_no))
        {
            $max_invoice_no=$result[0]->max_invoice_no;
        }
        $max_invoice_no=$max_invoice_no+1;

        $invoice_no='PRO-TMI-'.$invoice_date.'/'.str_pad($max_invoice_no,4,"0",STR_PAD_LEFT);

        $quotation=quotation::find($request->id);

    	$data=new proforma_invoice();
    	
    	$data->entrydate=$date;
    	$data->title=$request->title;
    	$data->c_id=$request->c_id;
        $data->currency_id=$request->currency_id;
    	$data->invoice_no=$invoice_no;
    	$data->max_invoice_no=$max_invoice_no;
    	$data->quotation_id=$request->id;
    	$data->item_ids=$request->quotation_item_id;
    	$data->price=$request->price;
    	$data->discount=$request->discount;
    	$data->discount_amount=$request->discount_amount;
    	$data->amount=$request->amount;
    	$data->gst_per=$request->gst_per;
    	$data->gst_amount=$request->gst_amount;
    	$data->total_amount=$request->total_amount;
    	$data->bank_details=$request->bank_details;
        $data->technology=$request->technology;
        $data->paid_amount=0;
    	$data->status=0;
        $data->gst_no=$quotation->gst_no;
        $data->igst=$quotation->igst;
        $data->company_address_id=$quotation->company_address_id;
    	$data->save();
    	return $data;
    }

    public static function proforma_invoicelist()
    {
        $data=proforma_invoice::select('proforma_invoice.id', 'proforma_invoice.entrydate', 'proforma_invoice.title', 'proforma_invoice.invoice_no', 'proforma_invoice.total_amount', 'proforma_invoice.paid_amount', 'proforma_invoice.status', 'customer.name', 'customer.company_name', 'currency.code', 'currency.symbol')
            ->join('customer', 'customer.id', 'proforma_invoice.c_id')
            ->join('currency', 'currency.id', '=', 'proforma_invoice.currency_id')
            // ->where('proforma_invoice.gst_per', '>', '0')
            ->orderBy('proforma_invoice.id', 'DESC')
            ->get();

        return $data;
    }

    public static function find_proforma_invoice($id)
    {
        $data=proforma_invoice::select('proforma_invoice.id', 'proforma_invoice.entrydate', 'proforma_invoice.title', 'proforma_invoice.invoice_no', 'proforma_invoice.amount', 'proforma_invoice.paid_amount', 'proforma_invoice.gst_per', 'proforma_invoice.total_amount', 'proforma_invoice.status', 'customer.name', 'customer.company_name', 'currency.code', 'currency.symbol', 'proforma_invoice.currency_id')
            ->join('customer', 'customer.id', 'proforma_invoice.c_id')
            ->join('currency', 'currency.id', '=', 'proforma_invoice.currency_id')
            // ->where('proforma_invoice.gst_per', '>', '0')
            ->where('proforma_invoice.id', '=', $id)
            ->get();

        return $data;
    }

    public static function change_status($request)
    {
        $data=proforma_invoice::find($request['id']);
        $data->status=$request['status'];
        $data->save();

        return $data;
    }    

    public static function update_paid_amount($request)
    {
        $data=proforma_invoice::find($request->proforma_invoice_id);
            
        $paid_amount=ROUND($data->paid_amount+$request->total_amount,2);
        $data->paid_amount=$paid_amount;

        if($paid_amount>=$data->total_amount)
        {
            $data->status=1;
        }

        $data->save();
        return $data;
    }

    public static function get_proformaByquotationId($id)
    {
        $data=proforma_invoice::where(['quotation_id' => $id])->get();

        return $data;
    }    
}
