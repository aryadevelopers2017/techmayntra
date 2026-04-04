<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\VendorServiceprovider;
use App\Models\Customer;
use App\Models\item_master;
use App\Models\proforma_invoice;
use App\Models\company_module_master;

use App\Models\CountryPhoneCode;
use App\Models\vendor_master;
use DB ;


use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function index()
    {
    	$data=VendorServiceprovider::get_list();

        $company_data = company_module_master::first();

        $currency_data = DB::table('currency')->where('id', $company_data->currency_id)->first();

        // dd($currency_data->symbol);

        return view('vendor_list')->with('data', $data['data'])->with('currency_data', $currency_data);
    }

    public static function vendor_add()
    {
        $data=[];
           $data['country_data'] = Customer::getCountry();

           $data['services'] =  item_master::item_list();

              $data['country_phone_code']=CountryPhoneCode::get();


        $data['state_data']=Customer::getState();
        return view('vendor_add')->with('data', $data);
    }

	public static function add_vendor(Request $request)
    {

        // dd($request->all());

    	$data=VendorServiceprovider::add_vendor($request);

        if($data['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$data['message'];

    	return redirect('/vendor_list')->with($status, $message);
    }

     public static function vendor_info($id)
    {
        $data=VendorServiceprovider::get_vendor_info($id);

// dd($data);
        return view('vendor_info')->with('data', $data['data']);
    }

    public static function vendor_edit($id) {
          $data=[];

          $vendor_data = VendorServiceprovider::get_vendor_info($id);
            $data['vendor_data'] = $vendor_data['data'];

                $data['country_data'] = Customer::getCountry();
                $data['state_data']=Customer::getState();
                $data['services'] =  item_master::item_list();
                $data['country_phone_code']=CountryPhoneCode::get();

                // dd($data);

            return view('vendor_edit')->with('data', $data);
    }

        public static function update_vendor(Request $request, $id)
    {
        $data=VendorServiceprovider::update_vendor($request, $id);
        if($data['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }
        $message=$data['message'];
          	return redirect('/vendor_list')->with($status, $message);

    }


     public static function vendor_delete($id)
{
    try {
        // Find the service by id and delete
        $vendor_master = vendor_master::find($id);
        if ($vendor_master) {
            $vendor_master->delete();
            return redirect('/vendor_list')->with('success', 'vendor deleted successfully');
        } else {
            return redirect('/vendor_list')->with('fail', 'vendor not found');
        }
    } catch (\Exception $e) {
        \Log::error([
            'method' => __METHOD__,
            'error' => [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'message' => $e->getMessage()
            ],
            'created_at' => now()
        ]);
        return redirect('/vendor_list')->with('fail', 'Something went wrong');
    }
}

    public function getVendorDetails(Request $request)
    {
        $vendor = vendor_master::where('id', $request->vendor_id)->first();

        $country = DB::table('country')->where('name', $vendor->country)->first();
        $state   = DB::table('states')->where('name', $vendor->state)->first();
        $city    = DB::table('city')->where('name', $vendor->city)->first();

        //  STEP 1: Get invoice items total (PAID invoices only)
        $invoice_ids = DB::table('proforma_invoice')
            ->where('status', 1)
            ->pluck('id');

        $invoice_total = DB::table('proforma_invoice_item as pii')
            ->join('item_master as im', 'im.id', '=', 'pii.item_id')
            ->whereIn('pii.proforma_invoice_id', $invoice_ids)
            ->where('im.vendor_id', $request->vendor_id)
            ->sum(DB::raw('im.admin_cost * pii.qty'));

        //  DEBUG LOG
        // \Log::info('Vendor Invoice Total', [
        //     'vendor_id' => $request->vendor_id,
        //     'invoice_total' => $invoice_total
        // ]);

        //  STEP 2: Vendor paid amount
        $vendor_paid = DB::table('vendor_accounts')
            ->where('vendor_id', $request->vendor_id)
            ->where('status', 1)
            ->sum('total_amount');   // OR sub_total_amount (based on your DB)

        //  DEBUG LOG
        // \Log::info('Vendor Paid Amount', [
        //     'vendor_id' => $request->vendor_id,
        //     'vendor_paid' => $vendor_paid
        // ]);

        //  STEP 3: FINAL PENDING
        $pending_amount = $invoice_total - $vendor_paid;
        $pending_amount = $pending_amount ?? 0;

        //  FINAL DEBUG
        // \Log::info('Vendor Final Pending', [
        //     'vendor_id' => $request->vendor_id,
        //     'pending_amount' => $pending_amount
        // ]);

        return response()->json([
            'company_name' => $vendor->company_name,
            'address'      => $vendor->address,

            'country'      => $vendor->country,
            'state'        => $vendor->state,
            'city'         => $vendor->city,

            'country_id'   => $country ? $country->id : '',
            'state_id'     => $state ? $state->id : '',
            'city_id'      => $city ? $city->id : '',

            'pending_amount' => $pending_amount
        ]);
    }


}
