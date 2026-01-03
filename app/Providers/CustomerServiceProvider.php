<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use DB;
use App\Models\Customer;

class CustomerServiceProvider extends ServiceProvider
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

    public static function add_customer($request)
    {
        try
        {
            if($request->state!='')
            {
                $state=Customer::getStateName($request->state);
                $request->state=$state[0]->name;
            }

            if($request->city!='')
            {
                $city=Customer::getCityName($request->city);
                $request->city=$city[0]->name;
            }

            $data=Customer::add_customer($request);

            return array('status_code' => 200, 'message' => 'Customer Data Successfully Saved', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function customer_list()
    {
        try
        {
            $data=Customer::customer_list();
            
            return array('status_code' => 200, 'message' => 'Get Record Successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function checkemail($request)
    {
        try
        {
            $data=[];
            $data=Customer::checkemail($request);
            
            return array('status_code' => 200, 'message' => 'Get Record Successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function get_customer_info($id)
    {
        try
        {
            $data=[];
            $data=Customer::get_CustomerByid($id);
            $quotation_data= DB::table('quotation')
                ->select(DB::raw('IFNULL(count(id),0) AS total_quotation'))
                ->where('quotation_status','=','1')
                ->where('c_id',$id)
                ->get();
            $data['total_quotation']=$quotation_data[0]->total_quotation;

            $quotation_data= DB::table('proforma_invoice')
                ->select(DB::raw('IFNULL(count(id),0) AS total_proforma'))
                ->where('status','=','1')
                ->where('c_id',$id)
                ->get();
            $data['total_proforma']=$quotation_data[0]->total_proforma;
            
            return array('status_code' => 200, 'message' => 'Get Record Successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function delete_customer($id)
    {
        try
        {
            $data=Customer::remove_customer($id);
            
            return array('status_code' => 200, 'message' => 'Customer Deleted Successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function getCityBystateId($id)
    {
        try
        {
            $data=Customer::getCityBystateId($id);

            return array('status_code' => 200, 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }
	public static function getStateBycountryId($id)
    {
        try
        {
            $data=Customer::getStateBycountryId($id);

            return array('status_code' => 200, 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }
}
