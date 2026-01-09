<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\userServiceprovider;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\User;
use App\Models\invoice_master;


use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Providers\ProformaInvoiceServiceProvider;


class userController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function index()
    {
        $data=userServiceprovider::user_list();

        return view('user_list')->with('users',  $data['data']);
    }

    public static function user_add()
    {
        return view('user_add');
    }

    public static function changePassword()
    {
        return view('change_password');
    }

    public static function add_user(Request $request)
    {
    	$user=userServiceprovider::add_user($request);

    	if($user['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$user['message'];
	    return redirect('/staff_list')->with($status, $message);
    // 	return redirect('/staff_list/'.Auth::user()->company_id.'')->with($status, $message);
    }

    public static function updatePassword(Request $request)
    {
        $user=userServiceprovider::UpdatePassword($request);
        if($user['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$user['message'];

        return redirect('/changepassword')->with($status, $message);
    }



    public static function user_checkemail(Request $request)
    {

        if (!$request->filled('email')) {
            return 'fail';
        }

        $data = userServiceprovider::checkemail($request);

        if ($data['data'] === true) {
            return 'fail';
        }

        return 'success';
    }


    public function assignCustomers($id)
{
    $user = User::findOrFail($id);

    $customers = Customer::where('assigned_staff', $id)->get();

    $allCustomers = Customer::whereNull('assigned_staff')->get();

    return view(
        'staff_assign_customers',
        compact('user', 'customers', 'allCustomers')
    );
}


    public function unassign($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->assigned_staff = null;
        $customer->save();

        return back()->with('success', 'Customer unassigned successfully.');
    }

public function assign(Request $request)
{
    $request->validate([
        'staff_id' => 'required',
        'customer_id' => 'required',
    ]);

    $customer = Customer::findOrFail($request->customer_id);
    $customer->assigned_staff = $request->staff_id;
    $customer->save();

    return back()->with('success', 'Customer assigned successfully.');
}



public function report(Request $request, $id)
{
    $user = User::findOrFail($id);

    $month = $request->month ?? Carbon::now()->month;
    $year  = $request->year  ?? Carbon::now()->year;

    $invoiceResponse = ProformaInvoiceServiceProvider::staff_invoice_list_data(
        $id, $month, $year
    );

    $totalResponse = ProformaInvoiceServiceProvider::staff_invoice_totals(
        $id, $month, $year
    );

    $monthTotals = invoice_master::get_staff_month_total_by_currency($id, $month, $year);
$yearTotals  = invoice_master::get_staff_year_total_by_currency($id, $year);

    return view('staff-report', [
        'user'        => $user,
        'list_data'   => $invoiceResponse['data'],
        'month'       => $month,
        'year'        => $year,
         'monthTotals'  => $monthTotals,
    'yearTotals'   => $yearTotals,
    ]);
}

}
