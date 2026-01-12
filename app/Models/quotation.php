<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class quotation extends Model
{
    use HasFactory;

    protected $table = 'quotation';

    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'entrydate', 'c_id', 'title', 'invoice_no', 'max_invoice_no', 'quotation_item_id', 'price', 'discount', 'discount_amount', 'amount', 'gst', 'igst', 'gst_per', 'gst_amount', 'total_amount', 'milestone', 'working_days', 'terms_conditions_flag', 'terms_conditions', 'payment_terms_conditions_flag', 'payment_terms_conditions', 'bank_details_flag', 'bank_details'];


    public static function accept_quotation_list()
    {
        $data=quotation::select('quotation.*', 'customer.name as customer_name')
            ->join('customer', 'customer.id', '=', 'quotation.c_id')
            ->where('quotation.quotation_status', 1)
            ->orderBy('quotation.id','DESC')
            ->get();
        return $data;
    }

    public static function add($request)
    {

        $items = json_decode($request->services_item, true);
$itemIds = collect($items)->pluck('item_id')->unique()->toArray();


        $max_invoice_no=0;
        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d h:i:s");
        $invoice_date = date("Y");
        $month_date = date("Y-01-01 00:00:00");
        $result=quotation::where('entrydate','>',$month_date)->orderBy('id','DESC')->take(1)->get();
        if(isset($result[0]->max_invoice_no))
        {
            $max_invoice_no=$result[0]->max_invoice_no;
        }
        $max_invoice_no=$max_invoice_no+1;
        $invoice_no='TMQ-'.$invoice_date.'/'.str_pad($max_invoice_no,4,"0",STR_PAD_LEFT);

        $customer=customer::find($request->c_id);

        $data=new quotation();
        $data->entrydate=$date;
        $data->c_id=$request->c_id;
        $data->invoice_no=$invoice_no;
        $data->currency_id=$request->currency_id;
        $data->max_invoice_no=$max_invoice_no;
        $data->title=$request->title;
       $data->quotation_item_id = implode(',', $itemIds);

        $data->price=$request->price;
        $data->discount=$request->discount;
        $discount_amount=ROUND(($request->price*$request->discount)/100,2);
        $amount=$request->price - $discount_amount;
        $data->discount_amount=$discount_amount;
        $data->amount=$amount;

        $data->gst=isset($request->gst) ?? '0';
        $data->igst=isset($request->gst) ? isset($request->igst) : '0';
        $data->gst_per=isset($request->gst) ? $request->gst_per : '0';

        $gst_amount=ROUND(($amount*$request->gst_per)/100,2);

        $data->gst_amount=$gst_amount;
        $total_amount=$amount + $gst_amount;
        $data->total_amount=$total_amount;
        $data->technology=$request->technology;
        $data->milestone=$request->milestone;
        $data->working_days=$request->working_days;

        $data->terms_conditions_flag=isset($request->terms_conditions_flag) ?? '0';

        $data->terms_conditions=$request->terms_conditions;

        $data->payment_terms_conditions_flag=isset($request->payment_terms_conditions_flag) ?? '0';

        $data->payment_terms_conditions=$request->payment_terms_conditions;

        $data->bank_details_flag=isset($request->bank_details_flag) ?? '0';
        $data->bank_details=$request->bank_details;

        if(!isset($request->gst))
        {
            $data->bank_details=$request->personal_bank_details;
        }

        $data->quotation_status=0;
        $data->gst_no=$customer->gst_no;
        $data->company_address_id=$request->company_address;
        $data->save();

        return $data;
    }

    public static function quotation_list($id)
    {
        $qry='!=';

        if($id!=0)
        {
            $qry='=';
        }
    	$data=quotation::select('quotation.id', 'quotation.title', 'quotation.entrydate', 'customer.name', 'customer.company_name', 'quotation.invoice_no', 'quotation.price', 'quotation.discount', 'quotation.discount_amount', 'quotation.igst', 'quotation.gst_per', 'quotation.gst_amount', 'quotation.total_amount', 'quotation.quotation_status', 'currency.code', 'currency.symbol')
    	->join('customer', 'customer.id','=', 'quotation.c_id')
        ->join('currency', 'currency.id', '=', 'quotation.currency_id')
        ->where('quotation.id', $qry, $id)

    	->orderBy('quotation.id', 'DESC')
    	->get();
    	return $data;
    }

    public static function update_quotation($request)
    {
        $data=quotation::find($request->id);
        $data->title=$request->title;
        $data->c_id=$request->c_id;
        $data->currency_id=$request->currency_id;
        $invoice_no=$data->invoice_no;
        if(strpos($data->invoice_no,'.V')!='')
        {
            $no=explode(".V",$invoice_no);
            $new_no=$no[1]+1;
            $data->invoice_no=$no[0].'.V'.$new_no;
        }
        else
        {
            $data->invoice_no=$invoice_no.'.V1';
        }

        $data->quotation_item_id=$request->item_id;
        $data->price=$request->price;
        $data->discount=$request->discount;
        $discount_amount=ROUND(($request->price*$request->discount)/100,2);
        $data->discount_amount=$discount_amount;
        $amount=$request->price - $discount_amount;
        $data->amount=$amount;

        $data->gst = $request->has('gst') ? 1 : 0;
        $data->igst = $request->has('gst') && $request->has('igst') ? 1 : 0;
        $data->gst_per = $request->has('gst') ? $request->gst_per : 0;

       $gst_amount = 0;

if ($request->has('gst')) {
    $gst_amount = round(($amount * $request->gst_per) / 100, 2);
}

        $data->gst_amount=$gst_amount;
        $total_amount=$amount + $gst_amount;
        $data->total_amount=$total_amount;
        $data->technology=$request->technology;
        $data->milestone=$request->milestone;
        $data->working_days=$request->working_days;

        $data->terms_conditions_flag=isset($request->terms_conditions_flag) ?? '0';

        $data->terms_conditions=$request->terms_conditions;

        $data->payment_terms_conditions_flag=isset($request->payment_terms_conditions_flag) ?? '0';

        $data->payment_terms_conditions=$request->payment_terms_conditions;

        $data->bank_details_flag=isset($request->bank_details_flag) ?? '0';

        $data->bank_details=$request->bank_details;

        if(!isset($request->gst))
        {
            $data->bank_details=$request->personal_bank_details;
        }

        $data->company_address_id=$request->company_address;

        $data->update();

        return $data;
    }

    public static function quotation_approve($id)
    {
        $data=quotation::find($id);

        $data->quotation_status=1;
        $data->update();
        return $data;
    }

    public static function quotation_cancel($id)
    {
        $data=quotation::find($id);

        $data->quotation_status=2;
        $data->update();
    }

    public static function get_quotationById($id)
    {
        $data=quotation::find($id);
        return $data;
    }
}
