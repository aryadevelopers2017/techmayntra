<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\proforma_invoice_item;
use App\Models\invoice_master;


class invoice_item_master extends Model
{
    use HasFactory;
    protected $table = 'invoice_item_master';

    protected $dates = ['deleted_at'];

    protected $fillable = ['id', 'c_id', 'invoice_id', 'item_id', 'description', 'price', 'rate', 'qty'];

    public static function add($request)
    {
    	$result=proforma_invoice_item::whereIn('item_id', explode(",",$request->item_ids))
            ->where('proforma_invoice_id', '=', $request->proforma_invoice_id)
    		->get();

    	foreach ($result as $itemdata)
    	{
    		$data=new invoice_item_master();

    		$data->c_id=$request->c_id;
    		$data->invoice_id=$request->id;
    		$data->item_id=$itemdata->item_id;
    		$data->description=$itemdata->description;
    		$data->qty=$itemdata->qty;
    		$data->price=ROUND(($itemdata->price*$request->payment_per)/100,2);
    		$data->rate=ROUND(($itemdata->rate*$request->payment_per)/100,2);
            $data->net_price=ROUND(($itemdata->net_price*$request->payment_per)/100,2);
            $data->net_rate=ROUND(($itemdata->net_rate*$request->payment_per)/100,2);

    		$data->save();
    	}
    	return $data;
    }
}
