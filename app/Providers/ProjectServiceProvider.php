<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use DB;
use App\Models\quotation;
use App\Models\proforma_invoice;
use App\Models\invoice_master;
use App\Models\purchase_order;
use App\Models\Customer;
use App\Models\vendor_master;
use App\Models\Project;
use App\Models\project_milestone;

class ProjectServiceProvider extends ServiceProvider
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

    public static function get_project_list()
    {
        try
        {
            $data=Project::get_project_list();

            return array('status_code' => 200, 'message' => 'get data successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function project_add()
    {
        try
        {
            $data=[];

            $quotation=quotation::accept_quotation_list();
            $data['quotation']=$quotation;

            // $customer=Customer::customer_list();
            // $data['customer']=$customer;

            $vendor=vendor_master::vendor_list();
            $data['vendor']=$vendor;

            return array('status_code' => 200, 'message' => 'get data successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function add_project($request)
    {
        try
        {
            $data=Project::add($request);

            return array('status_code' => 200, 'message' => 'project successfully added', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function project_milestoneadd($request)
    {
        try
        {
            $data=project_milestone::add($request);

            return array('status_code' => 200, 'message' => 'project milestone Successfully updated', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function get_projectByvendor_ajax($id)
    {
        try
        {
            $data=Project::get_projectByvendor_id($id);

            return array('status_code' => 200, 'message' => 'get data successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function get_project_all_info($id)
    {
        try
        {
            $data=Project::get_projectById($id);
            $customer_id=$data->customer_id;
            $vendor_id=$data->vendor_id;
            $quotation_id=$data->quotation_id;
            $project_id=$data->id;

            $project_milestone_data=project_milestone::get_ProjectMilestoneByProjectId($project_id);
            $milestone_arr=array();

            if(!empty($project_milestone_data))
            {
                foreach ($project_milestone_data as $value)
                {
                    $milestone_arr[$value->milestone]=$value;
                }
            }

            $data['project_milestone_data']=$milestone_arr;

            $customer_data=Customer::get_CustomerByid($customer_id);
            $data['customer_data']=$customer_data;

            $vendor_data=vendor_master::get_vendorById($vendor_id);
            $data['vendor_data']=$vendor_data;

            $quotation_data=quotation::get_quotationById($quotation_id);
            $data['quotation_data']=$quotation_data;

            $invoice_master_data=invoice_master::get_invoiceByquotation_id($quotation_id);
            $data['invoice_master_data']=$invoice_master_data;

            $purchase_order_data=purchase_order::get_purchaseByProject_id($project_id);
            $data['purchase_order_data']=$purchase_order_data;

            return array('status_code' => 200, 'message' => 'get data successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function project_approve($id)
    {
        try
        {
            $data=project::project_approve($id);
            
            return array('status_code' => 200, 'message' => 'project successfully approved', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function project_cancel($id)
    {
        try
        {
            $data=project::project_cancel($id);
            
            return array('status_code' => 200, 'message' => 'project successfully cancel', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }    
}
