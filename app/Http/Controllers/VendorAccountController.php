<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\VendorServiceprovider;
use Carbon\Carbon;
use App\Models\vendor_master;
use App\Models\company_module_master;

use App\Models\VendorAccount;

use DB;


use Illuminate\Http\Request;

class VendorAccountController extends Controller
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


    private function generateOrderNumber()
    {
        $year = Carbon::now()->year;

        // Get last record of current year
        $last = VendorAccount::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        if ($last && $last->order_no) {
            // Extract last number
            preg_match('/(\d+)$/', $last->order_no, $matches);
            $number = isset($matches[1]) ? (int)$matches[1] : 0;
            $number++;
        } else {
            $number = 1;
        }

        // Format: VA-2026/0001
        return 'VA-' . $year . '/' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public static function vendor_account_list()
    {

        $data = VendorAccount::get();

        return view('vendor_account_list')->with('data', $data);
    }

    public static function create()
    {

        $vendor_list = vendor_master::vendor_list();

        $country_data = DB::table('country')->get();

        $state_data = DB::table('states')->get();

        $city_data = DB::table('city')->get();

        return view('vendor_account_add')->with('vendor_list', $vendor_list)->with('country_data', $country_data)->with('state_data', $state_data)->with('city_data', $city_data);
    }
    public function edit($id)
    {

        $data = VendorAccount::findOrFail($id);

        $vendor_list = vendor_master::vendor_list();
        $country_data = DB::table('country')->get();
        $state_data = DB::table('states')->get();
        $city_data = DB::table('city')->get();

        return view('vendor_account_add', compact(
            'data',
            'vendor_list',
            'country_data',
            'state_data',
            'city_data'
        ));
    }


    public function store(Request $request)
    {
        //  Validation
        $request->validate([
            'vendor_id'         => 'required',
            'date'              => 'required|date',
            'company_name'      => 'nullable',
            'address'           => 'nullable',
            'total_amount'  => 'required|numeric|min:0',
            'status'            => 'required',
        ]);

        //  OPTIONAL: Validate pending amount (IMPORTANT SECURITY)
        // $max_pending = 10000; // later calculate from DB

        // if ($request->total_amount > $max_pending) {
        //     return back()->with('error', 'Amount exceeds pending amount');
        // }

        //  Save data
        $data = new VendorAccount();

        $data->order_no        = $this->generateOrderNumber();
        $data->vendor_id       = $request->vendor_id;
        $data->date            = $request->date;
        $data->company_name    = $request->company_name;
        $data->description     = $request->description;
        $data->status          = $request->status;

        $data->address         = $request->address;
        $data->country_id      = $request->country_id;
        $data->state_id        = $request->state_id;
        $data->city_id         = $request->city_id;

        $data->total_amount     = $request->total_amount;
        $data->payment_mode     = $request->payment_mode;

        $data->save();

        return redirect()->route('vendor.account.list')->with('success', 'Vendor Account Added Successfully');
    }

    public function update(Request $request)
    {
        // Validation
        $request->validate([
            'id'                => 'required|exists:vendor_accounts,id',
            'vendor_id'         => 'required',
            'date'              => 'required|date',
            'total_amount'  => 'required|numeric|min:0',
            'status'            => 'required',
        ]);

        $data = VendorAccount::findOrFail($request->id);

        // keep existing order_no

        $data->vendor_id        = $request->vendor_id;
        $data->date             = $request->date;
        $data->company_name     = $request->company_name;
        $data->description      = $request->description;
        $data->status           = $request->status;

        $data->address          = $request->address;
        $data->country_id       = $request->country_id;
        $data->state_id         = $request->state_id;
        $data->city_id          = $request->city_id;

        $data->total_amount     = $request->total_amount;
        $data->payment_mode     = $request->payment_mode;

        $data->save();

        return redirect()->route('vendor.account.list')
            ->with('success', 'Vendor Account Updated Successfully');
    }

    public function vendor_accounts_generate_invoice($id)
    {
        $data = VendorAccount::findOrFail($id);

        $Vendor = vendor_master::find($data->vendor_id);

        $city = DB::table('city')->where('id', $data->city_id)->first();
        $state = DB::table('states')->where('id', $data->state_id)->first();
        $country = DB::table('country')->where('id', $data->country_id)->first();


        $company_data = company_module_master::first();

        $currency_data = DB::table('currency')->where('id', $company_data->currency_id)->first();

        return view('vendor_accounts_generate_invoice')->with('data', $data)->with('company_data', $company_data)->with('vendor_data', $Vendor)->with('city', $city)->with('state', $state)->with('country', $country)->with('currency_data', $currency_data);


    }
}
