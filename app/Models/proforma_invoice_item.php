<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\quotation;
use App\Models\quotation_item;

class proforma_invoice_item extends Model
{
    use HasFactory;

    protected $table = 'proforma_invoice_item';

    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'c_id', 'proforma_invoice_id', 'item_id', 'description', 'price', 'rate', 'qty', 'qty_id'];

    public static function add($request)
    {
        $result=quotation_item::whereIn('item_id', explode(",", $request->item_ids))
            ->where('quotation_id', '=', $request->quotation_id)
            ->get();

        foreach ($result as $value)
        {
            $data=new proforma_invoice_item();
        
            $data->c_id=$request->c_id;
            $data->proforma_invoice_id=$request->id;
            $data->item_id=$value->item_id;
            $data->description=$value->description;
            $data->price=$value->price;
            $data->rate=$value->rate;
            $data->qty=$value->qty;
            $data->qty_id=isset($value->qty_id)??'0';
            $data->net_price=$value->net_price;
            $data->net_rate=$value->net_rate;

            $data->save();
        }

        return $data;
    }
}
