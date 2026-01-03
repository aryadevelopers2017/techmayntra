<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quotation_item extends Model
{
    use HasFactory;

    protected $table = 'quotation_item';

    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'company_name', 'address', 'email', 'mobile', 'city', 'state'];

    public static function customer_list()
    {
    	$data=quotation_item::select('name', 'company_name', 'address', 'city', 'state', 'email', 'mobile')->orderBy('id', 'DESC')->get();
    	return $data;
    }

    public static function add($request)
    {
        foreach ($request->item as $key => $value)
        {
            $field='item_price_'.$value;
            $description='item_desc_'.$value;
            $qty='item_qty_'.$value;
            $qty_id='item_qty_id_'.$value;
            $price=$request->$field;
            $rate=ROUND(($price / $request->$qty),2);

            $discount=$request->discount;

            $discount_price_amount=ROUND(($price*$discount)/100,2);
            $discount_rate_amount=ROUND(($rate*$discount)/100,2);

            $result = new quotation_item();
            $result->c_id=$request->c_id;
            $result->quotation_id=$request->invoice_id;
            $result->item_id=$value;
            $result->rate=$rate;
            $result->description=$request->$description;
            $result->price=$price;
            $result->qty=$request->$qty;
            $result->qty_id=$request->$qty_id;
            $result->net_price=ROUND($price-$discount_price_amount,2);
            $result->net_rate=ROUND($rate-$discount_rate_amount,2);

            $result->save();
        }

        return $result;
    }

    public static function update_quotation_item($request)
    {
        $item_id_arr=$request->item;
        $result=quotation_item::where(['quotation_id'=>$request->invoice_id])->whereIn('item_id', $item_id_arr)->delete();

        foreach ($request->item as $key => $value)
        {
            $field='item_price_'.$value;
            $description='item_desc_'.$value;
            $qty='item_qty_'.$value;
            $qty_id='item_qty_id_'.$value;
            $price=$request->$field;
            $rate=ROUND($request->$field/$request->$qty,2);
            $discount=$request->discount;

            $discount_price_amount=ROUND(($price*$discount)/100,2);
            $discount_rate_amount=ROUND(($rate*$discount)/100,2);

            $result=quotation_item::where(['quotation_id'=>$request->invoice_id, 'item_id'=>$value])->get();
            if(!isset(($result[0]->id)))
            {
                $result = new quotation_item();
                $result->c_id=$request->c_id;
                $result->quotation_id=$request->invoice_id;
                $result->item_id=$value;
                $result->description=$request->$description;
                $result->price=$price;
                $result->rate=$rate;
                $result->qty=$request->$qty;
                $result->qty_id=$request->$qty_id;
                $result->net_price=ROUND($price-$discount_price_amount,2);
                $result->net_rate=ROUND($rate-$discount_rate_amount,2);
                $result->save();
            }
            else
            {
                $result =quotation_item::find($result[0]->id);
                $result->c_id=$request->c_id;
                $result->item_id=$value;
                $result->description=$request->$description;
                $result->price=$price;
                $result->rate=$rate;
                $result->qty=$request->$qty;
                $result->qty_id=$request->$qty_id;
                $result->net_price=ROUND($price-$discount_price_amount,2);
                $result->net_rate=ROUND($rate-$discount_rate_amount,2);
                $result->update();
            }
        }

        return $result;
    }

    public function delete_quotation_item($id)
    {
        quotation_item::where('id',$id)->delete();
    }
}
