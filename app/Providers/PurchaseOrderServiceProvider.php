<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use DB;
use App\Models\purchase_order;
use App\Models\vendor_master;
use App\Models\Project;
use App\Models\Customer;
use App\Models\company_module_master;
use App\Models\company_address_master;

class PurchaseOrderServiceProvider extends ServiceProvider
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

    public static function get_vendordata()
    {
        try
        {
            $data=[];
            $vendor_data=vendor_master::vendor_list();
            $data['vendor_list']=$vendor_data;
            $data['state_data']=Customer::getState();

            return array('status_code' => 200, 'message' => 'get data successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }
    
    public static function get_data()
    {
        try
        {
            $data=purchase_order::get_list();

            return array('status_code' => 200, 'message' => 'get data successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function purchaseorder_project_list($id)
    {
        try
        {
            $data=purchase_order::get_purchaseorderByProject_Id($id);

            return array('status_code' => 200, 'message' => 'get data successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function add_purchase_order($request)
    {
        try
        {
            $state=Customer::getStateName($request->state);
            $request->state=$state[0]->name;

            $city=Customer::getCityName($request->city);
            $request->city=$city[0]->name;

            $data=purchase_order::add($request);

            return array('status_code' => 200, 'message' => 'Purchase Order Successfully Saved', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function purchase_order_edit($id)
    {
        try
        {
            $data=purchase_order::get_find_DataById($id);
            $state=$data->state;
            $statedata=Customer::getStatedata($state);
            $state_id=$statedata[0]->id;

            $data['state_data']=Customer::getState();
            $data['city_data']=Customer::getCityBystateId($state_id);

            $vendor_data=vendor_master::vendor_list();
            $data['vendor_list']=$vendor_data;

            $project_data=project::where(['vendor_id' => $data->vender_id])->get();
            $data['project_list']=$project_data;

            return array('status_code' => 200, 'message' => 'get data successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function update_purchase_order($request)
    {
        try
        {
            $state=Customer::getStateName($request->state);
            $request->state=$state[0]->name;

            $city=Customer::getCityName($request->city);
            $request->city=$city[0]->name;

            $data=purchase_order::update_order($request);

            return array('status_code' => 200, 'message' => 'Purchase order successfully updated', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function generate_invoice($id)
    {
        try
        {
            $data=purchase_order::generate_invoice_qry($id);
            
            $vendor_data=vendor_master::get_vendorById($data->vender_id);
            $data['vendor_data']=$vendor_data;

            $company_address_data=company_address_master::find($data->company_id);

            $company_data=company_module_master::find($company_address_data->company_id);

            $company_data->address=$company_address_data->address;
            $company_data->city=$company_address_data->city;
            $company_data->state=$company_address_data->state;
            
            $data['company_data']=$company_data;

            return array('status_code' => 200, 'message' => 'get data successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }
}
