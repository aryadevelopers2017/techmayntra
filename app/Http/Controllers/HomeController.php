<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\quotation_item;
use App\Models\quotation;
use App\Models\item_master;
use App\Models\qty_master;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\company_module_master;
use App\Models\proforma_invoice;
use App\Models\proforma_invoice_item;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

    $user = auth()->user();


        $data=[];


        // $customer_data=Customer::where(['status'=>0])->get();
        // $data['customer_data']=count($customer_data);


        if ($user->sub_admin == 1) {
    // Sub-admin: only assigned customers
    $data['customer_data'] = Customer::where('status', 0)
        ->where('assigned_staff', $user->id)
        ->count();
} else {
    // Admin: all customers
    $data['customer_data'] = Customer::where('status', 0)->count();
}






        // $paid_data = DB::table('invoice_master')
        //     ->select(DB::raw('IFNULL(SUM(total_amount),0) AS paid_amt'))
        //     // ->where('gst_per','>','0')
        //     ->get();
        // $paid_amount=$paid_data[0]->paid_amt;
        // $data['paid_amount']=$paid_amount;



        if ($user->sub_admin == 1) {
    // Sub-admin → only assigned customers
    $data['paid_amount'] = DB::table('invoice_master as im')
        ->join('quotation as q', 'im.quotation_id', '=', 'q.id')
        ->join('customer as c', 'q.c_id', '=', 'c.id')
        ->where('c.assigned_staff', $user->id)
        ->sum('im.total_amount');
} else {
    // Admin → all invoices
    $data['paid_amount'] = DB::table('invoice_master')
        ->sum('total_amount');
}

  $paid_amount=$data['paid_amount'] ?? 0;

// Safety fallback
$data['paid_amount'] = $data['paid_amount'] ?? 0;





        $approved_amount_data = DB::table('proforma_invoice')
            ->select(DB::raw('IFNULL(SUM(total_amount),0) AS approved_amt'))
            ->where('status','=','1')
            ->get();
        $approved_amount=$approved_amount_data[0]->approved_amt;



        // $data['approved_amount']=$approved_amount;

     if ($user->sub_admin == 1) {
    // Sub-admin → only assigned customers
    $data['approved_amount'] = DB::table('proforma_invoice as pi')
        ->join('customer as c', 'pi.c_id', '=', 'c.id')
        ->where('pi.status', 1)
        ->where('c.assigned_staff', $user->id)
        ->sum('pi.total_amount');
} else {
    // Admin → all data
    $data['approved_amount'] = DB::table('proforma_invoice')
        ->where('status', 1)
        ->sum('total_amount');
}

// Safety fallback (optional)
$data['approved_amount'] = $data['approved_amount'] ?? 0;


        // $actual_amount_data = DB::table('invoice_master')
        //     ->select(DB::raw('IFNULL(SUM(taxable_amount),0) AS actual_amount'))
        //     // ->where('gst_per','>','0')
        //     ->get();
        // $data['actual_amount']=$actual_amount_data[0]->actual_amount;


        if ($user->sub_admin == 1) {
    // Sub-admin → only assigned customers
    $data['actual_amount'] = DB::table('invoice_master as im')
        ->join('quotation as q', 'im.quotation_id', '=', 'q.id')
        ->join('customer as c', 'q.c_id', '=', 'c.id')
        ->where('c.assigned_staff', $user->id)
        ->sum('im.taxable_amount');
} else {
    // Admin → all invoices
    $data['actual_amount'] = DB::table('invoice_master')
        ->sum('taxable_amount');
}

// Safety fallback
$data['actual_amount'] = $data['actual_amount'] ?? 0;



        $data['pending_amount']=$approved_amount-$paid_amount;

        // $without_gst_total_data = DB::table('proforma_invoice')
        //     ->select(DB::raw('IFNULL(SUM(total_amount),0) AS without_total_gst_amt'))
        //     ->where('gst_per','=','0')
        //     ->where('status','=','1')
        //     ->get();
        // $data['without_total_gst_amt']=$without_gst_total_data[0]->without_total_gst_amt;



        if ($user->sub_admin == 1) {
    // Sub-admin → only assigned customers
    $data['without_total_gst_amt'] = DB::table('proforma_invoice as pi')
        ->join('customer as c', 'pi.c_id', '=', 'c.id')
        ->where('pi.status', 1)
        ->where('pi.gst_per', 0)
        ->where('c.assigned_staff', $user->id)
        ->sum('pi.total_amount');
} else {
    // Admin → all data
    $data['without_total_gst_amt'] = DB::table('proforma_invoice')
        ->where('status', 1)
        ->where('gst_per', 0)
        ->sum('total_amount');
}

// Safety fallback
$data['without_total_gst_amt'] = $data['without_total_gst_amt'] ?? 0;





        // $total_gst_amount_data = DB::table('invoice_master')
        //     ->select(DB::raw('IFNULL(SUM(gst_amount),0) AS gst_amt'))
        //     ->where('gst_per','>','0')
        //     ->get();

        // $data['gst_amt']=$total_gst_amount_data[0]->gst_amt;


//         $gst_amt = DB::table('invoice_master as im')
//     ->join('quotation as q', 'im.quotation_id', '=', 'q.id')
//     ->where('q.gst', 1)
//     ->where('im.gst_per', '>', 0)
//     ->sum('im.gst_amount');

// $data['gst_amt'] = $gst_amt ?? 0;


if ($user->sub_admin == 1) {
    // Sub-admin → only assigned customers
    $data['gst_amt'] = DB::table('invoice_master as im')
        ->join('quotation as q', 'im.quotation_id', '=', 'q.id')
        ->join('customer as c', 'q.c_id', '=', 'c.id')
        ->where('q.gst', 1)
        ->where('im.gst_per', '>', 0)
        ->where('c.assigned_staff', $user->id)
        ->sum('im.gst_amount');
} else {
    // Admin → all invoices
    $data['gst_amt'] = DB::table('invoice_master as im')
        ->join('quotation as q', 'im.quotation_id', '=', 'q.id')
        ->where('q.gst', 1)
        ->where('im.gst_per', '>', 0)
        ->sum('im.gst_amount');
}

// Safety fallback
$data['gst_amt'] = $data['gst_amt'] ?? 0;




if ($user->sub_admin == 1) {
    // Sub-admin → only assigned customers
    $data['vat_amt'] = DB::table('invoice_master as im')
        ->join('quotation as q', 'im.quotation_id', '=', 'q.id')
        ->join('customer as c', 'q.c_id', '=', 'c.id')
        ->where('q.vat', 1)
        ->where('im.gst_per', '>', 0)
        ->where('c.assigned_staff', $user->id)
        ->sum('im.gst_amount');
} else {
    // Admin → all invoices
    $data['vat_amt'] = DB::table('invoice_master as im')
        ->join('quotation as q', 'im.quotation_id', '=', 'q.id')
        ->where('q.vat', 1)
        ->where('im.gst_per', '>', 0)
        ->sum('im.gst_amount');
}

// Safety fallback
$data['vat_amt'] = $data['vat_amt'] ?? 0;


// $vat_amt = DB::table('invoice_master as im')
//     ->join('quotation as q', 'im.quotation_id', '=', 'q.id')
//     ->where('q.vat', 1)
//     ->where('im.gst_per', '>', 0)
//     ->sum('im.gst_amount');

// $data['vat_amt'] = $vat_amt ?? 0;



        // $total_quotation_count_data = DB::table('quotation')
        //     ->select(DB::raw('IFNULL(count(id),0) AS total_quotation_count'))
        //     ->get();

        // $data['total_quotation_count']=$total_quotation_count_data[0]->total_quotation_count;

        if ($user->sub_admin == 1) {
    $data['total_quotation_count'] = DB::table('quotation as q')
        ->join('customer as c', 'q.c_id', '=', 'c.id')
        ->where('c.assigned_staff', $user->id)
        ->count();
} else {
    $data['total_quotation_count'] = DB::table('quotation')->count();
}




        // $total_proforma_count_data = DB::table('proforma_invoice')
        //     ->select(DB::raw('IFNULL(count(id),0) AS total_proforma_count'))
        //     ->get();

        // $data['total_proforma_count']=$total_proforma_count_data[0]->total_proforma_count;

        if ($user->sub_admin == 1) {
    $data['total_proforma_count'] = DB::table('proforma_invoice as pi')
        ->join('customer as c', 'pi.c_id', '=', 'c.id')
        ->where('c.assigned_staff', $user->id)
        ->count();
} else {
    $data['total_proforma_count'] = DB::table('proforma_invoice')->count();
}




        // $total_invoice_count_data = DB::table('invoice_master')
        //     ->select(DB::raw('IFNULL(count(id),0) AS total_invoice_count'))
        //     ->get();

        // $data['total_invoice_count']=$total_invoice_count_data[0]->total_invoice_count;


        if ($user->sub_admin == 1) {
    $data['total_invoice_count'] = DB::table('invoice_master as im')
        ->join('quotation as q', 'im.quotation_id', '=', 'q.id')
        ->join('customer as c', 'q.c_id', '=', 'c.id')
        ->where('c.assigned_staff', $user->id)
        ->count();
} else {
    $data['total_invoice_count'] = DB::table('invoice_master')->count();
}



        $company_module_master = company_module_master::first();

        $currency_data = Currency::getByID($company_module_master->currency_id);

        $data['company_module_master']= $company_module_master ;

        $data['currency_data']= $currency_data ;

        // dd($currency_data);

        return view('home')->with('data', $data);
    }
}
