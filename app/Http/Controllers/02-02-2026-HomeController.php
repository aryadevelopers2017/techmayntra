<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\quotation_item;
use App\Models\quotation;
use App\Models\item_master;
use App\Models\qty_master;
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
        $data=[];
        // $customer_data=Customer::all();
        $customer_data=Customer::where(['status'=>0])->get();
        $data['customer_data']=count($customer_data);

        $paid_data = DB::table('invoice_master')
            ->select(DB::raw('IFNULL(SUM(total_amount),0) AS paid_amt'))
            // ->where('gst_per','>','0')
            ->get();
        $paid_amount=$paid_data[0]->paid_amt;
        $data['paid_amount']=$paid_amount;
        $approved_amount_data = DB::table('proforma_invoice')
            ->select(DB::raw('IFNULL(SUM(total_amount),0) AS approved_amt'))
            ->where('status','=','1')
            ->get();
        $approved_amount=$approved_amount_data[0]->approved_amt;
        $data['approved_amount']=$approved_amount;

        $actual_amount_data = DB::table('invoice_master')
            ->select(DB::raw('IFNULL(SUM(taxable_amount),0) AS actual_amount'))
            // ->where('gst_per','>','0')
            ->get();
        $data['actual_amount']=$actual_amount_data[0]->actual_amount;

        $data['pending_amount']=$approved_amount-$paid_amount;

        $without_gst_total_data = DB::table('proforma_invoice')
            ->select(DB::raw('IFNULL(SUM(total_amount),0) AS without_total_gst_amt'))
            ->where('gst_per','=','0')
            ->where('status','=','1')
            ->get();
        $data['without_total_gst_amt']=$without_gst_total_data[0]->without_total_gst_amt;

        $total_gst_amount_data = DB::table('invoice_master')
            ->select(DB::raw('IFNULL(SUM(gst_amount),0) AS gst_amt'))
            ->where('gst_per','>','0')
            ->get();

        $data['gst_amt']=$total_gst_amount_data[0]->gst_amt;

        $total_quotation_count_data = DB::table('quotation')
            ->select(DB::raw('IFNULL(count(id),0) AS total_quotation_count'))
            ->get();

        $data['total_quotation_count']=$total_quotation_count_data[0]->total_quotation_count;

        $total_proforma_count_data = DB::table('proforma_invoice')
            ->select(DB::raw('IFNULL(count(id),0) AS total_proforma_count'))
            ->get();

        $data['total_proforma_count']=$total_proforma_count_data[0]->total_proforma_count;


        $total_invoice_count_data = DB::table('invoice_master')
            ->select(DB::raw('IFNULL(count(id),0) AS total_invoice_count'))
            ->get();

        $data['total_invoice_count']=$total_invoice_count_data[0]->total_invoice_count;



        return view('home')->with('data', $data);
    }
}
