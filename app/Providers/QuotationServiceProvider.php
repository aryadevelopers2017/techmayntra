<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
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
use App\Models\company_address_master;

class QuotationServiceProvider extends ServiceProvider
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

    public static function add_quotation($request)
    {
        try
        {
            $request->item_id=implode(",", $request->item);
            $amount=0;
            foreach ($request->item as $key => $value)
            {
                $field='item_price_'.$value;
                $amount=$amount+$request->$field;
            }
            $request->price=$amount;

            $data=quotation::add($request);
            $request->invoice_id=$data->id;

            quotation_item::add($request);

            return array('status_code' => 200, 'message' => 'Quotation Successfully Saved', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function quotation_list($id)
    {
        try
        {
            $data=quotation::quotation_list($id);

            return array('status_code' => 200, 'message' => 'Get Record Successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function quotation_edit($id)
    {
        $data=[];
        $quotation_data=quotation::where('id', $id)->get()->toArray();
        $customer=Customer::where('id',$quotation_data[0]['c_id'])->get()->toArray();
        $data['quotation_id']=$id;
        $customer_id=$customer[0]['id'];
        $data['customer_id']=$customer[0]['id'];
        $data['customer_name']=$customer[0]['name'];
        $data['customer_company_name']=$customer[0]['company_name'];
        $data['title']=$quotation_data[0]['title'];
        $data['price']=$quotation_data[0]['price'];
        $data['discount']=$quotation_data[0]['discount'];
        $data['discount_amount']=$quotation_data[0]['discount_amount'];
        $data['gst']=$quotation_data[0]['gst'];
        $data['igst']=$quotation_data[0]['igst'];
        $data['gst_per']=$quotation_data[0]['gst_per'];
        $data['total_amount']=$quotation_data[0]['total_amount'];

        $data['milestone']=$quotation_data[0]['milestone'];
        $data['working_days']=$quotation_data[0]['working_days'];
        $data['terms_conditions_flag']=$quotation_data[0]['terms_conditions_flag'];
        $data['terms_conditions']=$quotation_data[0]['terms_conditions'];
        $data['payment_terms_conditions_flag']=$quotation_data[0]['payment_terms_conditions_flag'];
        $data['payment_terms_conditions']=$quotation_data[0]['payment_terms_conditions'];
        $data['bank_details_flag']=$quotation_data[0]['bank_details_flag'];
        $data['bank_details']=$quotation_data[0]['bank_details'];
        $data['company_address_id']=$quotation_data[0]['company_address_id'];

        $quotation_item_id=$quotation_data[0]['quotation_item_id'];

        $customer=Customer::customer_list();
        $data['customer_data']=$customer;

        $item=item_master::quotation_item_check($id, $quotation_item_id);
        $data['item_data']=$item;

        $company_data=company_module_master::module_data();
        $data['company_data']=$company_data;
        $currency_id=$quotation_data[0]['currency_id'];

        $data['currency_data']=Currency::getByID($currency_id);

        $company_address_data=company_address_master::company_address_data();
            $data['company_address_data']=$company_address_data;

        $qty=qty_master::qty_list();
        $data['qty_data']=$qty;

        return array('status_code' => 200, 'message' => 'Get Record Successfully', 'data' => $data);
    }

    public static function get_customer_item_list()
    {
        try
        {
            $data=[];
            $customer=Customer::customer_list();
            $data['customer_data']=$customer;

            $item=item_master::item_list();
            $data['item_data']=$item;

            $qty=qty_master::qty_list();
            $data['qty_data']=$qty;

            $company_address_data=company_address_master::company_address_data();
            $data['company_address_data']=$company_address_data;

            $company_data=company_module_master::module_data();
            $data['company_data']=$company_data;
            $currency_id=$company_data[0]->currency_id;

            $data['currency_data']=Currency::getByID($currency_id);

            return array('status_code' => 200, 'message' => 'Get Record Successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function update_quotation($request)
    {
        try
        {
            $request->item_id=implode(",", $request->item);
            $amount=0;
            foreach ($request->item as $key => $value)
            {
                $field='item_price_'.$value;
                $amount=$amount+$request->$field;
            }
            $request->price=$amount;

            $data=quotation::update_quotation($request);
            $request->invoice_id=$data->id;

            quotation_item::update_quotation_item($request);
            
            return array('status_code' => 200, 'message' => 'Quotation Successfully Updated', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function invoice($id)
    {
        $data=[];
        $quotation_data=quotation::where('id', $id)->get()->toArray();
        $customer=Customer::where('id',$quotation_data[0]['c_id'])->get()->toArray();
        $data['quotation_id']=$id;
        $customer_id=$customer[0]['id'];
        $data['customer_id']=$customer[0]['id'];
        $data['address']=$customer[0]['address'];
        $data['city']=$customer[0]['city'];
        $data['state']=$customer[0]['state'];
        $data['customer_name']=$customer[0]['name'];
        $data['customer_company_name']=$customer[0]['company_name'];
        $data['entrydate']=date('d-M-Y',strtotime($quotation_data[0]['entrydate']));
        $data['open_date']=date("d-M-Y", strtotime('7 day', strtotime($quotation_data[0]['entrydate'])));
        // $data['open_date']=$date;
        $data['title']=$quotation_data[0]['title'];
        $data['discount_amount']=$quotation_data[0]['discount_amount'];
        $data['invoice_no']=$quotation_data[0]['invoice_no'];
        $data['price']=$quotation_data[0]['price'];
        $data['discount']=$quotation_data[0]['discount'];
        $data['igst']=$quotation_data[0]['igst'];
        $data['gst_per']=$quotation_data[0]['gst_per'];
        $data['gst_amount']=$quotation_data[0]['gst_amount'];
        $total_amount=$quotation_data[0]['total_amount'];
        $data['total_amount']=$total_amount;
        $data['working_days']=$quotation_data[0]['working_days'];

        $data['technology']=$quotation_data[0]['technology'];
        $data['milestone']=$quotation_data[0]['milestone'];
        $data['terms_conditions_flag']=$quotation_data[0]['terms_conditions_flag'];
        $data['terms_conditions']=$quotation_data[0]['terms_conditions'];
        $data['payment_terms_conditions_flag']=$quotation_data[0]['payment_terms_conditions_flag'];
        $data['payment_terms_conditions']=$quotation_data[0]['payment_terms_conditions'];
        $data['bank_details_flag']=$quotation_data[0]['bank_details_flag'];
        $data['bank_details']=$quotation_data[0]['bank_details'];
        $company_address_id=$quotation_data[0]['company_address_id'];
        $data['company_address_id']=$company_address_id;

        $company_address_data=company_address_master::find($company_address_id);
        $company_id=$company_address_data->company_id;
        $data['company_address']=$company_address_data->address;
        $data['company_city']=$company_address_data->city;
        $data['company_state']=$company_address_data->state;
        $data['company_mobile']=$company_address_data->mobile;
        $data['company_email']=$company_address_data->email;

        $currency_data=Currency::getByID($quotation_data[0]['currency_id']);
        $data['currency_data']=$currency_data;

        $company_data=company_module_master::find($company_id);
        $data['company_data']=$company_data;

        $f = new \NumberFormatter(locale_get_default(), \NumberFormatter::SPELLOUT );
        $data['amount_word'] = $f->format($total_amount).' '.$currency_data->name.' Only';

        $quotation_item_id=$quotation_data[0]['quotation_item_id'];

        $item=item_master::invoice_item($id, $quotation_item_id);

        $data['item_data']=$item;

        // $company_data=company_module_master::module_data();
        // $data['company_data']=$company_data;

        return array('status_code' => 200, 'message' => 'Get Record Successfully', 'data' => $data);
    }

    public static function delete_quotation($id)
    {
        try
        {
            quotation::delete_quotation($id);
            
            quotation_item::delete_quotation_item($id);
            
            return array('status_code' => 200, 'message' => 'Quotation Successfully Deleted');
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function quotation_approve($id)
    {
        try
        {
            $data=[];
            $quotation_data=quotation::quotation_approve($id);
            $data['quotation_data']=$quotation_data;

            $pro_inv=proforma_invoice::add($quotation_data);
            $data['pro_inv']=$pro_inv;

            $pro_inv_item=proforma_invoice_item::add($pro_inv);
            $data['pro_inv_item']=$pro_inv_item;
            
            return array('status_code' => 200, 'message' => 'Quotation Successfully Approved', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function quotation_cancel($id)
    {
        try
        {
            $data=quotation::quotation_cancel($id);
            
            return array('status_code' => 200, 'message' => 'Quotation Successfully Cancel', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }
}
