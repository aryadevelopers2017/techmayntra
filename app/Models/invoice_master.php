<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\proforma_invoice;
use App\Models\proforma_invoice_item;

class invoice_master extends Model
{
    use HasFactory;
    protected $table = 'invoice_master';

    protected $dates = ['deleted_at'];

    protected $fillable = ['id', 'entrydate', 'title', 'quotation_id', 'proforma_invoice_id', 'c_id', 'max_invoice_no', 'invoice_no', 'item_ids', 'price', 'remaining_amount', 'payment_per', 'taxable_amount', 'gst_per', 'gst_amount', 'total_amount', 'bank_details', 'status'];


    public static function add($request)
    {
        $per_data = DB::table('invoice_master')
            ->select(DB::raw('SUM(payment_per) AS per'))
            ->where('proforma_invoice_id', '=', $request->id)
            ->get();
        $per=0;
        if($per_data[0]->per)
        {
            $per=$per_data[0]->per;
        }
        
    	$result=proforma_invoice::find($request->id);
        $gst_per=$result->gst_per;
    	$max_invoice_no=0;
        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d h:i:s");
        $invoice_year = date("Y");
        $firstdate = date("Y-04-01 00:00:00");
        if($firstdate>$date)
        {
            $firstdate=date("Y-04-01 00:00:00", strtotime('-1 Year', strtotime($date)));
            $invoice_last_year=($invoice_year-1);
            $last_year=$invoice_year-2000;
            $invoice_date=$invoice_last_year.'-'.$last_year;
        }
        else
        {
            $invoice_next_year=($invoice_year+1)-2000;
            $invoice_date=$invoice_year.'-'.$invoice_next_year;
        }

        $proforma_invoice_data=proforma_invoice::find($request->id);
        $quotation_id=$proforma_invoice_data->quotation_id;
        

        if($gst_per>0)
        {
            $res1=invoice_master::where('entrydate','>=',$firstdate)->where('gst_per','>',0)->orderBy('id','DESC')->take(1)->get();
            
            if(isset($res1[0]->max_invoice_no))
            {
                $max_invoice_no=$res1[0]->max_invoice_no;
            }

            $max_invoice_no=$max_invoice_no+1;

            $invoice_no='TMSPL-'.$invoice_date.'/'.str_pad($max_invoice_no,4,"0",STR_PAD_LEFT);
        }
        else
        {
            $max_invoice_no=1000;

            $res1=invoice_master::where('entrydate','>=',$firstdate)->where('gst_per','=',0)->orderBy('id','DESC')->take(1)->get();
            if(isset($res1[0]->max_invoice_no))
            {
                $max_invoice_no=$res1[0]->max_invoice_no;
            }

            $max_invoice_no=$max_invoice_no+1;

            $invoice_no=$invoice_date.'/'.str_pad($max_invoice_no,4,"0",STR_PAD_LEFT);
        }

    	$data=new invoice_master();
    	
    	$data->entrydate=$date;
    	$data->title=$result->title;
    	$data->c_id=$result->c_id;
    	$data->invoice_no=$invoice_no;

    	$data->max_invoice_no=$max_invoice_no;
    	$data->proforma_invoice_id=$request->id;

        $data->currency_id=$request->currency_country_code;
        $data->currency_amount=$request->per_currency_amount;
        $data->payable_currency_amount=1;

        $data->quotation_id=$quotation_id;
    	$data->item_ids=$result->item_ids;
    	$total_amount=$result->total_amount;
    	$data->price=$total_amount;
    	$remaining_amount=$total_amount - $result->paid_amount;
    	$data->remaining_amount=$remaining_amount;
    	
        if($request->payment_per==100)
        {
            $request->payment_per=ROUND($request->payment_per-$per,2);
            $request->payment_amount=ROUND(($result->total_amount*$request->payment_per)/100,2);
        }
    	$data->payment_per=$request->payment_per;
    	$gst_per=$result->gst_per;
        $request->payment_amount;
    	$taxable_amount=ROUND(($request->payment_amount*100)/(100+$gst_per),2);
    	
    	$data->total_amount=$request->payment_amount;
    	$data->taxable_amount=$taxable_amount;
    	
    	$data->gst_per=$gst_per;
    	$data->gst_amount=ROUND($request->payment_amount-$taxable_amount,2);
    	
    	$data->bank_details=$result->bank_details;
        $data->gst_no=$result->gst_no;
        $data->status=0;
        $data->save();

    	return $data;
    }

    public static function get_invoice_details($id)
    {
        $data=invoice_master::select('invoice_master.id', 'invoice_master.entrydate', 'invoice_master.title', 'invoice_master.invoice_no', 'invoice_master.total_amount', 'customer.name', 'customer.company_name', 'currency.code', 'currency.symbol')
            ->join('customer', 'customer.id', 'invoice_master.c_id')
            ->join('currency', 'currency.id', '=', 'invoice_master.currency_id')
            ->where('proforma_invoice_id', '=', $id)->get();
        return $data;
    }

    public static function get_invoice_list($id)
    {
        $qry='!=';
        if($id!=0)
        {
            $qry='=';
        }

        $data=invoice_master::select('invoice_master.id', 'invoice_master.entrydate', 'invoice_master.title', 'invoice_master.invoice_no', 'invoice_master.total_amount', 'customer.name', 'customer.company_name', 'currency.code', 'currency.symbol')
            ->join('customer', 'customer.id', 'invoice_master.c_id')
            ->join('currency', 'currency.id', '=', 'invoice_master.currency_id')
            ->where('invoice_master.quotation_id', $qry, $id)
            ->orderBy('id', 'DESC')
            ->get();
        return $data;
    }

    public static function get_invoiceByquotation_id($id)
    {
        $data=invoice_master::where(['quotation_id' => $id])->get();

        return $data;
    }
}
