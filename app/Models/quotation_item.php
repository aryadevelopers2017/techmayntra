<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quotation_item extends Model
{
    use HasFactory;

    protected $table = 'quotation_item';

    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'company_name', 'address', 'email', 'mobile', 'city', 'state', 'passenger_type',
    'service_type' ];

    public static function customer_list()
    {
    	$data=quotation_item::select('name', 'company_name', 'address', 'city', 'state', 'email', 'mobile')->orderBy('id', 'DESC')->get();
    	return $data;
    }

   public static function add($request)
{
    $items = json_decode($request->services_item, true);

    if (!is_array($items)) {
        throw new \Exception('Invalid services_item data');
    }

    foreach ($items as $item) {

        $qty   = (float) $item['qty'];
        $price = (float) $item['price'];
        $rate  = $qty > 0 ? round($price / $qty, 2) : 0;

        $discount = (float) $request->discount;

        $discount_price_amount = round(($price * $discount) / 100, 2);
        $discount_rate_amount  = round(($rate * $discount) / 100, 2);

        $result = new quotation_item();
        $result->c_id          = $request->c_id;
        $result->quotation_id  = $request->invoice_id;
        $result->item_id       = $item['item_id'];
        $result->description   = $item['description'];
        $result->qty           = $qty;
        $result->price         = $price;
        $result->rate          = $rate;
        $result->net_price     = round($price - $discount_price_amount, 2);
        $result->net_rate      = round($rate - $discount_rate_amount, 2);

           $result->original_price = $item['original_price'] ?? null;

        $result->passenger_type = $item['passenger_type'] ?? null;
        $result->service_type   = $item['service_type'] ?? null;

        $result->save();
    }

    return true;
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

    public static function update_items($request)
{
    $items = json_decode($request->services_item, true);

    if (!is_array($items)) {
        throw new \Exception('Invalid services_item data');
    }

    // delete old items
    quotation_item::where('quotation_id', $request->invoice_id)->delete();

    foreach ($items as $item) {

        $qty   = (float) $item['qty'];
        $price = (float) $item['price'];
        $rate  = $qty > 0 ? round($price / $qty, 2) : 0;

        $discount = (float) $request->discount;

        $discount_price_amount = round(($price * $discount) / 100, 2);
        $discount_rate_amount  = round(($rate * $discount) / 100, 2);

        $row = new quotation_item();
        $row->c_id         = $request->c_id;
        $row->quotation_id = $request->invoice_id;
        $row->item_id      = $item['item_id'];
        $row->description  = $item['description'];
        $row->qty          = $qty;
        $row->price        = $price;
        $row->rate         = $rate;
        $row->net_price    = round($price - $discount_price_amount, 2);
        $row->net_rate     = round($rate - $discount_rate_amount, 2);


        $row->passenger_type = $item['passenger_type'] ?? null;
        $row->service_type   = $item['service_type'] ?? null;


        $row->save();
    }

    return true;
}


    public function delete_quotation_item($id)
    {
        quotation_item::where('id',$id)->delete();
    }
}
