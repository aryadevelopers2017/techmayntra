<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use DB;
use Str;
use App\Models\Customer;
use App\Models\Currency;
use App\Models\proforma_invoice;
use App\Models\proforma_invoice_item;
use App\Models\invoice_master;
use App\Models\invoice_item_master;
use App\Models\item_master;
use App\Models\company_module_master;
use App\Models\company_address_master;

class ProformaInvoiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public static function proforma_invoice_list()
    {
        try
        {
            $data=proforma_invoice::proforma_invoicelist();

            return array('status_code' => 200, 'message' => 'Get Record Successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function proformainvoice_payment($id)
    {
        try
        {
            $data=proforma_invoice::find_proforma_invoice($id);
            $currency_data=Currency::getAll();

            return array('status_code' => 200, 'message' => 'Get Record Successfully', 'data' => $data, 'currency' => $currency_data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function add_proformainvoice_payment($request)
    {
        try
        {
            $data=[];
            $invoice=invoice_master::add($request);
            $data['invoice_data']=$invoice;

            proforma_invoice::update_paid_amount($invoice);

            $invoice_item_data=invoice_item_master::add($invoice);
            $data['invoice_item_data']=$invoice_item_data;

            return array('status_code' => 200, 'message' => 'Payment Successfully Save', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function invoice_payment_details($id)
    {
        try
        {
            $data=invoice_master::get_invoice_details($id);

            return array('status_code' => 200, 'message' => 'Get Record Successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }
    public static function proforma_invoice_generate($id)
    {
        $data=[];
        $quotation_data=proforma_invoice::find($id);
        $customer=Customer::find($quotation_data->c_id);
        $data['quotation_id']=$id;
        $customer_id=$customer->id;
        $data['customer_id']=$customer->id;
        $data['address']=$customer->address;
        $data['city']=$customer->city;
        $data['state']=$customer->state;
        $data['customer_name']=$customer->name;
        $data['customer_company_name']=$customer->company_name;
        $data['entrydate']=date('d-M-Y',strtotime($quotation_data->entrydate));
        $data['open_date']=date("d-M-Y", strtotime('7 day', strtotime($quotation_data->entrydate)));
        $data['title']=$quotation_data->title;
        $data['discount_amount']=$quotation_data->discount_amount;
        $data['invoice_no']=$quotation_data->invoice_no;
        $data['price']=$quotation_data->price;
        $data['taxable_amount']=$quotation_data->amount;
        $data['price']=$quotation_data->price;
        $data['discount']=$quotation_data->discount;
        $data['igst']=$quotation_data->igst;
        // $total_amount=$quotation_data[0]['total_amount'];
        $data['taxable_amount']=$quotation_data->amount;
        $data['gst_per']=$quotation_data->gst_per;

        $data['trn_no']=$quotation_data->trn_no;


        $data['gst_amount']=$quotation_data->gst_amount;
        $total_amount=$quotation_data->total_amount;
        $data['total_amount']=$quotation_data->total_amount;
        $data['gst_no']=$quotation_data->gst_no;
        $data['bank_details']=$quotation_data->bank_details;
        $company_address_id=$quotation_data->company_address_id;

        $company_address_data=company_address_master::find($company_address_id);
        $company_id=$company_address_data->company_id;
        $data['company_address']=$company_address_data->address;
        $data['company_city']=$company_address_data->city;
        $data['company_state']=$company_address_data->state;
        $data['company_mobile']=$company_address_data->mobile;
        $data['company_email']=$company_address_data->state;
        $data['company_signature']=$company_address_data->signature;

        $company_data=company_module_master::find($company_id);
        $data['company_data']=$company_data;

        $currency_data=Currency::getByID($quotation_data->currency_id);
        $data['currency_data']=$currency_data;

        $f = new \NumberFormatter( locale_get_default(), \NumberFormatter::SPELLOUT );
        $data['amount_word'] = $f->format($total_amount).' '.$currency_data->name.' Only';

        $item_id=$quotation_data->item_ids;

        $item=item_master::proforma_invoice_item($id, $item_id);

        $data['item_data']=$item;

        // dd($data);

        return array('status_code' => 200, 'message' => 'Get Record Successfully', 'data' => $data);
    }

    public static function final_invoice_data($id)
    {
        $data=[];
        $invoice_data=invoice_master::find($id);
        $quotation_data=proforma_invoice::where('id', $invoice_data->proforma_invoice_id)->get()->toArray();

        // dd($quotation_data);

        $customer=Customer::where('id',$quotation_data[0]['c_id'])->get()->toArray();
        $data['quotation_id']=$id;
        $customer_id=$customer[0]['id'];
        $data['customer_id']=$customer[0]['id'];
        $data['address']=$customer[0]['address'];
        $data['city']=$customer[0]['city'];
        $data['state']=$customer[0]['state'];
        $data['customer_name']=$customer[0]['name'];
        $data['customer_company_name']=$customer[0]['company_name'];
        $data['entrydate']=date('d-M-Y',strtotime($invoice_data->entrydate));
        $data['open_date']=date("d-M-Y", strtotime('7 day', strtotime($quotation_data[0]['entrydate'])));
        $data['title']=$quotation_data[0]['title'];
        $data['discount_amount']=$quotation_data[0]['discount_amount'];
        $data['invoice_no']=$invoice_data->invoice_no;
        $data['price']=$invoice_data->price;
        $data['taxable_amount']=$invoice_data->taxable_amount;
        $data['price']=$invoice_data->price;
        $data['discount']=$quotation_data[0]['discount'];
        $data['igst']=$quotation_data[0]['igst'];

        $data['trn_no']=$quotation_data[0]['trn_no'];

        // $total_amount=$quotation_data[0]['total_amount'];
        $data['taxable_amount']=$invoice_data->taxable_amount;
        $data['gst_per']=$invoice_data->gst_per;
        $data['gst_amount']=$invoice_data->gst_amount;
        $total_amount=$invoice_data->total_amount;
        $data['total_amount']=$invoice_data->total_amount;
        $data['gst_no']=$invoice_data->gst_no;
        $data['bank_details']=$invoice_data->bank_details;
        $currency_id=$invoice_data->currency_id;
        $data['currency_id']=$currency_id;
        $data['currency_amount']=$invoice_data->currency_amount;
        $data['payable_currency_amount']=$invoice_data->payable_currency_amount;
        $company_address_id=$quotation_data[0]['company_address_id'];

        $company_address_data=company_address_master::find($company_address_id);
        $company_id=$company_address_data->company_id;
        $data['company_address']=$company_address_data->address;
        $data['company_city']=$company_address_data->city;
        $data['company_state']=$company_address_data->state;
        $data['company_mobile']=$company_address_data->mobile;
        $data['company_email']=$company_address_data->email;
        $data['company_signature']=$company_address_data->signature;

        $company_data=company_module_master::find($company_id);
        $data['company_data']=$company_data;

        $currency_data=Currency::getByID($currency_id);
        $data['currency_data']=$currency_data;

        // $data['working_days']=$quotation_data[0]['working_days'];

        // $data['milestone']=$quotation_data[0]['milestone'];
        // $data['terms_conditions_flag']=$quotation_data[0]['terms_conditions_flag'];
        // $data['terms_conditions']=$quotation_data[0]['terms_conditions'];
        // $data['payment_terms_conditions_flag']=$quotation_data[0]['payment_terms_conditions_flag'];
        // $data['payment_terms_conditions']=$quotation_data[0]['payment_terms_conditions'];
        // $data['bank_details_flag']=$quotation_data[0]['bank_details_flag'];
        // $data['bank_details']=$quotation_data[0]['bank_details'];

        $f = new \NumberFormatter( locale_get_default(), \NumberFormatter::SPELLOUT );
        $data['amount_word'] = $f->format($total_amount).' '.$currency_data->name.' Only';

        $item_id=$invoice_data->item_ids;

        $item=item_master::final_invoice_item($id, $item_id);

        $data['item_data']=$item;

        // dd($data);

        // $company_data=company_module_master::module_data();
        // $data['company_data']=$company_data;

        return array('status_code' => 200, 'message' => 'Get Record Successfully', 'data' => $data);
    }

    public static function invoice_list_data($id)
    {
        try
        {
            $data=invoice_master::get_invoice_list($id);

            return array('status_code' => 200, 'message' => 'Get Record Successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function proforma_invoice_approve($id)
    {
        try
        {
            $req=array();
            $req['id']=$id;
            $req['status']=1;
            $data=proforma_invoice::change_status($req);

            return array('status_code' => 200, 'message' => 'invoice successfully approved', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function proforma_invoice_cancel($id)
    {
        try
        {
            $req=array();
            $req['id']=$id;
            $req['status']=2;
            $data=proforma_invoice::change_status($req);

            return array('status_code' => 200, 'message' => 'invoice successfully cancel', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }


    public static function staff_invoice_list_data($userId, $month, $year)
{
    try {
        $data = invoice_master::get_staff_invoice_list($userId, $month, $year);

        return [
            'status_code' => 200,
            'message' => 'Get Record Successfully',
            'data' => $data
        ];
    } catch (\Exception $e) {
        Log::error([
            'method' => __METHOD__,
            'error' => [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'message' => $e->getMessage()
            ],
            'created_at' => date("Y-m-d H:i:s")
        ]);

        return [
            'status_code' => 500,
            'message' => trans('api.messages.general.error')
        ];
    }
}


public static function staff_invoice_totals($userId, $month, $year)
{
    try {
        return [
            'status_code' => 200,
            'month_total' => invoice_master::get_staff_month_total($userId, $month, $year),
            'year_total'  => invoice_master::get_staff_year_total($userId, $year),
        ];
    } catch (\Exception $e) {
        Log::error([
            'method' => __METHOD__,
            'error' => $e->getMessage(),
        ]);

        return [
            'status_code' => 500,
            'month_total' => 0,
            'year_total'  => 0,
        ];
    }
}


}
