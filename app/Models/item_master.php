<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class item_master extends Model
{
    use HasFactory;

    protected $table = 'item_master';

    protected $dates = ['deleted_at'];
   protected $fillable = [
    'item_name',
    'description',
    'vendor_id',
    'admin_cost',
    'category_id',
    'subcategory_id',

    'tax_type',
    'tax_value',

    'status'
];


    public static function item_list()
    {
    	$data=item_master::where('status',0)->orderBy('id', 'DESC')->get();
    	return $data;
    }

    public static function getItemByid($id)
    {
        $data=item_master::find($id);
        return $data;
    }

    public static function add_item($request)
    {
        $item_master = new item_master();

        $item_master->item_name = $request->item_name;
        $item_master->description = $request->description;

        $item_master->vendor_id = $request->vendor_id ?? null;
        $item_master->admin_cost = $request->admin_cost ?? 0;

        $item_master->tax_type = $request->tax_type ?? null;
        $item_master->tax_value = $request->tax_value ?? null;

        $item_master->category_id = $request->category_id ?? null;
        $item_master->subcategory_id = $request->subcategory_id ?? null;

        $item_master->status = 0;
        $item_master->save();

        return $item_master;
    }


    public static function cancel_item($id)
    {
        $item_master =item_master::find($id);

        $item_master->status=1;

        $item_master->update();
        return $item_master;
    }

   public static function update_item($request)
{
    $item_master = item_master::find($request->id);

    $item_master->item_name = $request->item_name;
    $item_master->description = $request->description;

    $item_master->vendor_id = $request->vendor_id;
    $item_master->admin_cost = $request->admin_cost;

     $item_master->tax_type = $request->tax_type ?? null;
        $item_master->tax_value = $request->tax_value ?? null;

    $item_master->category_id = $request->category_id;
    $item_master->subcategory_id = $request->subcategory_id;

    $item_master->update();

    return $item_master;
}


    public static function quotation_item_check($id, $item_id)
    {
        $data=item_master::select('item_master.id', 'item_master.category_id','item_master.tax_value','item_master.tax_type' ,'item_master.admin_cost' ,'item_master.item_name', DB::raw('(CASE WHEN quotation_item.item_id IS NULL THEN item_master.description ELSE quotation_item.description END) as description'), 'item_master.description', 'quotation_item.item_id AS item_id', 'quotation_item.description  AS desc', 'quotation_item.price', 'quotation_item.rate', 'quotation_item.qty', 'quotation_item.qty_id','quotation_item.passenger_type','quotation_item.service_type','quotation_item.original_price','quotation_item.taxtype','quotation_item.taxvalue' )
            ->orderBy('item_master.id', 'DESC')
            ->leftJoin("quotation_item", function($join)use($id,$item_id){
                $join->on('item_master.id', '=', 'quotation_item.item_id')
                ->whereIn('quotation_item.item_id', explode(',',$item_id))
                ->where('quotation_item.quotation_id', '=', $id);

            })
            ->get();

        return $data;
    }

    public static function invoice_item($id, $item_id)
    {
        $data=item_master::select('item_master.id', 'item_master.item_name', 'quotation_item.description', 'quotation_item.price', 'quotation_item.rate', 'quotation_item.qty')
            ->join("quotation_item", 'item_master.id', '=', 'quotation_item.item_id')
            ->whereIn('quotation_item.item_id', explode(',',$item_id))
            ->where('quotation_item.quotation_id', '=', $id)
            ->orderBy('quotation_item.id', 'ASC')
            ->get();

        return $data;
    }

    public static function proforma_invoice_item($id, $item_id)
    {
        $data=item_master::select('item_master.id', 'item_master.item_name', 'proforma_invoice_item.description', 'proforma_invoice_item.price', 'proforma_invoice_item.rate', 'proforma_invoice_item.net_price', 'proforma_invoice_item.net_rate', 'proforma_invoice_item.qty')
            ->join("proforma_invoice_item", 'item_master.id', '=', 'proforma_invoice_item.item_id')
            ->whereIn('proforma_invoice_item.item_id', explode(',',$item_id))
            ->where('proforma_invoice_item.proforma_invoice_id', '=', $id)
            ->orderBy('proforma_invoice_item.id', 'ASC')
            ->get();

        return $data;
    }

    public static function final_invoice_item($id, $item_id)
    {
        $data=item_master::select('item_master.id', 'item_master.item_name', 'invoice_item_master.description', 'invoice_item_master.price', 'invoice_item_master.rate', 'invoice_item_master.net_price', 'invoice_item_master.net_rate', 'invoice_item_master.qty')
            ->join("invoice_item_master", 'item_master.id', '=', 'invoice_item_master.item_id')
            ->whereIn('invoice_item_master.item_id', explode(',',$item_id))
            ->where('invoice_item_master.invoice_id', '=', $id)
            ->orderBy('invoice_item_master.id', 'ASC')
            ->get();

        return $data;
    }

    public function vendor()
{
    return $this->belongsTo(\App\Models\vendor_master::class, 'vendor_id');
}

public function category()
{
    return $this->belongsTo(\App\Models\ServiceCategory::class, 'category_id');
}

public function subcategory()
{
    return $this->belongsTo(\App\Models\Service::class, 'subcategory_id');
}

}
