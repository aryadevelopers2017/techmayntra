<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Providers\ProformaInvoiceServiceProvider;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Providers\QuotationServiceProvider;
use App\Models\proforma_invoice;
use Illuminate\Support\Facades\Log;


class ProformaInvoiceController extends Controller
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
    	$data=ProformaInvoiceServiceProvider::proforma_invoice_list();

        return view('proforma_invoice_list')->with('proforma_invoice_list', $data['data']);
    }

       public static function add_new()
    {
        $data=QuotationServiceProvider::get_customer_item_list();

        return view('add_invoice')->with('details_array', value: $data['data']);
    }

    public static function save_invoice(Request $request){
    	  $Quotation=QuotationServiceProvider::add_quotation($request);
         $quotation_approve = QuotationServiceProvider::quotation_approve($Quotation['data']['id']);
        return redirect()->route('proforma_invoice.list');
    }

    // public static function proforma_invoice_generate($id)
    // {
    //     $data=ProformaInvoiceServiceProvider::proforma_invoice_generate($id);

    //     return view('proforma_invoice')->with('data', $data['data']);
    // }

     public static function proforma_invoice_generate(Request $request)
    {
        $id = $request->invoice_no;
        // dd($id);

     $invoice_number = proforma_invoice::where('invoice_no', $id)->first();



        $data=ProformaInvoiceServiceProvider::proforma_invoice_generate($invoice_number->id);


         if (ob_get_level() > 0) {
        ob_end_clean();
    }
    ob_start();

         $pdf = Pdf::loadView('pdf.proforma-invoice', [
            'data' => $data['data']
        ])->setPaper('a4', 'portrait');


        return $pdf->stream($data['data']['invoice_no'] . '.pdf');
    }

    public static function proforma_invoice_payment($id)
    {
        $data=ProformaInvoiceServiceProvider::proformainvoice_payment($id);



        return view('proforma_invoice_payment_add')->with('data', $data['data'])->with('currency', $data['currency']);
    }

    public static function add_proforma_invoice_payment(Request $request)
    {
        $data=ProformaInvoiceServiceProvider::add_proformainvoice_payment($request);

        if($data['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$data['message'];

        return redirect('/proforma_invoice')->with($status, $message);
    }

    public static function invoice_details($id)
    {
        $data=ProformaInvoiceServiceProvider::invoice_payment_details($id);

        return view('/proforma_invoice_details_list')->with('proforma_invoice_details', $data['data']);
    }

   public function final_invoice($id)
    {
        $data = ProformaInvoiceServiceProvider::final_invoice_data($id);

    if (ob_get_level() > 0) {
        ob_end_clean();
    }
    ob_start();

        // dd($data['data']['original_quotation_data']->vat);

        $pdf = Pdf::loadView('pdf.final-invoice', [
            'data' => $data['data']
        ])->setPaper('a4', 'portrait');

        return $pdf->stream($data['data']['invoice_no'] . '.pdf');
    }

    public static function invoice_list($id)
    {
        $data=ProformaInvoiceServiceProvider::invoice_list_data($id);

        return view('invoice_list')->with('list_data', $data['data']);
    }

    public static function proforma_invoice_approve(Request $request,$id)
    {


    // dd($request->all());

    $due_date = $request->due_date;

        $data=ProformaInvoiceServiceProvider::proforma_invoice_approve($id,$due_date);

        if($data['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$data['message'];

        return redirect('/proforma_invoice')->with($status, $message);
    }

    public static function proforma_invoice_cancel($id)
    {
        $data=ProformaInvoiceServiceProvider::proforma_invoice_cancel($id);

        if($data['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$data['message'];

        return redirect('/proforma_invoice')->with($status, $message);
    }
}
