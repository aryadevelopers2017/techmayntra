<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use App\Models\company_module_master;
use App\Models\Currency;
use App\Models\company_address_master;

class CompanyModuleServiceProvider extends ServiceProvider
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

    public static function module_list()
    {
        try
        {
            $data=company_module_master::module_list();
            $currency=Currency::getAll();

            return array('status_code' => 200, 'message' => 'Get Record Successfully', 'data' => $data, 'currency' => $currency);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function update_module($request)
    {
        try
        {
            if($request->id!='')
            {
                $data=company_module_master::update_module($request);
                $data->company_id=$request->id;
                $request->company_id=$request->id;
                $request->company_signature=isset($data->company_signature) ? $data->company_signature : '';
                company_address_master::add_companyadrress($request);
            }
            else
            {
                $data=company_module_master::add_module($request);
                $data->company_id=$data->id;
                $request->company_id=$data->id;
                $request->company_signature=isset($data->company_signature) ? $data->company_signature : '';
                company_address_master::add_companyadrress($request);
            }

            return array('status_code' => 200, 'message' => 'Data Successfully Saved', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function company_address_list()
    {
        try
        {
            $data=company_address_master::companyaddress_list();

            return array('status_code' => 200, 'message' => 'Get Record Successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }
    
    public static function updateaddress_status($id)
    {
        try
        {
            $data=company_address_master::update_status_address($id);

            return array('status_code' => 200, 'message' => 'Data Successfully Saved', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function add_address_company($request)
    {
        try
        {
            if($request->id!='')
            {
                $data=company_address_master::update_companyadrress($request);
            }
            else
            {
                $data=company_address_master::add_companyadrress($request);
            }

            return array('status_code' => 200, 'message' => 'Data Successfully Saved', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }
}
