<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class vendor_master extends Model
{
    use HasFactory;

    protected $table = 'vendor_master';

    protected $dates = ['deleted_at'];
    // protected $fillable = ['id', 'name', 'company_name', 'address', 'email', 'mobile', 'city', 'state', 'status'];

    protected $fillable = [
    'id',
    'name',
    'company_name',
    'address',
    'email',
    'mobile',
    'country_code',
    'city',
    'state',
    'country',
    'service_id',
    'rate_option',
    'bank_name',
    'account_holder_name',
    'account_number',
    'ifsc_code',
    'branch_name',
    'gst_no',
    'status'
];


    public static function vendor_list()
    {
        $customer =vendor_master::where('status', 0)->orderBy('id', 'DESC')->get();

        return $customer;
    }

    public static function get_vendorById($id)
    {
           $data = vendor_master::with('service')->find($id);

        //  Convert country name → ID
        $country = DB::table('country')
            ->where('name', $data->country)
            ->first();

        $state = DB::table('states')
            ->where('name', $data->state)
            ->first();

        $city = DB::table('city')
            ->where('name', $data->city)
            ->first();

        $data->country_id = $country->id ?? null;
        $data->state_id   = $state->id ?? null;
        $data->city_id    = $city->id ?? null;



        return $data;
    }

    public static function add_vendor($request)
    {
        $customer =new vendor_master();

        $customer->name=$request->name;
        $customer->company_name=$request->company_name;
        $customer->email=$request->email;
        $customer->mobile=$request->mobile;
        $customer->address=isset($request->address) ? $request->address : '';
        $customer->country=isset($request->country) ? $request->country : '';
        $customer->city=isset($request->city) ? $request->city : '';
        $customer->state=isset($request->state) ? $request->state : '';
        $customer->gst_no=isset($request->gst_no) ? $request->gst_no : '';

        $customer->country_code=isset($request->country_code) ? $request->country_code : '';

          // Service & Rate
        $customer->service_id = $request->service_id ?? null;
        $customer->rate_option = $request->rate_option ?? null;

        // Bank Details
        $customer->bank_name = $request->bank_name ?? null;
        $customer->account_holder_name = $request->account_holder_name ?? null;
        $customer->account_number = $request->account_number ?? null;
        $customer->ifsc_code = $request->ifsc_code ?? null;
        $customer->branch_name = $request->branch_name ?? null;


        $customer->save();

        return $customer;
    }
    public static function update_vendor($request, $id)
{
    $vendor = vendor_master::find($id);

    if(!$vendor){
        return false; // vendor not found
    }

    $vendor->name = $request->name;
    $vendor->company_name = $request->company_name;
    $vendor->email = $request->email;
    $vendor->mobile = $request->mobile;

    $vendor->address = $request->address ?? '';
    $vendor->country = $request->country ?? '';
    $vendor->state = $request->state ?? '';
    $vendor->city = $request->city ?? '';

    $vendor->gst_no = $request->gst_no ?? '';
    $vendor->country_code = $request->country_code ?? '';

    // Service & Rate
    $vendor->service_id = $request->service_id ?? null;
    $vendor->rate_option = $request->rate_option ?? null;

    // Bank Details
    $vendor->bank_name = $request->bank_name ?? null;
    $vendor->account_holder_name = $request->account_holder_name ?? null;
    $vendor->account_number = $request->account_number ?? null;
    $vendor->ifsc_code = $request->ifsc_code ?? null;
    $vendor->branch_name = $request->branch_name ?? null;

    $vendor->save();

    return $vendor;
}


    public function service()
{
    return $this->belongsTo(item_master::class, 'service_id');
}

}
