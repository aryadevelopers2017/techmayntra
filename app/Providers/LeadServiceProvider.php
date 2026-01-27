<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\CustomerServiceProvider;
use Illuminate\Support\Facades\Log;
use DB;
use App\Models\Lead_master;
use App\Models\Customer;
use App\Models\quotation;
use App\Models\lead_remarks;

class LeadServiceProvider extends ServiceProvider
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

    public static function lead_list()
    {
        try
        {
            $data=Lead_master::lead_list();

            return array('status_code' => 200, 'message' => 'Get Record Successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function lead_add()
    {
        try
        {
            $data=[];
            $data['state_data']=Customer::getState();
			$data['country_data']=Customer::getCountry();
            $data['client_lists']=Customer::customer_list();
            // $data['city_data']=Customer::getCity();

            return array('status_code' => 200, 'message' => 'Get Record Successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function add_leads($request)
    {
        try
        {
            $request->state='';
            $request->city='';
			$request->country='';
			if($request->country>0)
            {
                $country=Customer::getCountryName($request->country);
                $request->country=$country[0]->name;
            }

            if($request->state>0)
            {
                $state=Customer::getStateName($request->state);
                $request->state=$state[0]->name;
            }

            if($request->city)
            {
                $city=Customer::getCityName($request->city);
                $request->city=$city[0]->name;
            }


            $data=Lead_master::add_lead_master($request);
			$request->id=$data->id;

            $remarks_data='';
            if($request->remarks!='')
            {
                $remarks_data=lead_remarks::add_lead_remarks($request);
            }

            return array('status_code' => 200, 'message' => 'Data Successfully Saved', 'data' => $remarks_data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function get_lead_data($id)
    {
        try
        {
            $data=Lead_master::get_lead_dataByID($id);
            $remarks_data=lead_remarks::getlead_remarksByid($id);
            $data['remarks_data']=$remarks_data;

			$country=$data->country;
            $countrydata='';
            if($country!='')
            {
                $countrydata=Customer::getStatedata($country);
            }
            $country_id=0;
            if(!empty($countrydata))
            {
                $country_id=$countrydata[0]->id;
            }

            $state=$data->state;
            $statedata='';
            if($state!='')
            {
                $statedata=Customer::getStatedata($state);
            }
            $state_id=0;
            if(!empty($statedata))
            {
                $state_id=$statedata[0]->id;
            }

            return $data['state_data']=Customer::getState();
            $data['client_lists']=Customer::customer_list();
            $data['city_data']=Customer::getCityBystateId($state_id);

            return array('status_code' => 200, 'message' => 'Data Successfully Saved', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function update_lead($request)
    {
        try
        {
			$country=Customer::getCountryName($request->country);
            $request->country=$country[0]->name;

            $city=Customer::getCityName($request->city);
            $request->city=$city[0]->name;

            $state=Customer::getStateName($request->state);
            $request->state=$state[0]->name;

            $data=Lead_master::update_lead_master($request);

            if($request->remarks!='')
            {
                $remarks_data=lead_remarks::add_lead_remarks($request);
            }

            return array('status_code' => 200, 'message' => 'Data Successfully Saved', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function update_lead_status($id, $status)
    {
        try
        {
            $data=Lead_master::update_lead_status($id, $status);
            $state_id=$data->state;
            if($state_id>0)
            {
                $statedata=Customer::getStatedata($state);
                $state_id=$statedata[0]->id;
            }

			$country_id=$data->country;
            if($country_id>0)
            {
                $countrydata=Customer::getCounrydata($country);
                $country_id=$statedata[0]->id;
            }
			$data['state_data']=Customer::getStateBycountryId();

            //$data['state_data']=Customer::getState();
            $data['city_data']=Customer::getCityBystateId($state_id);

            return array('status_code' => 200, 'message' => 'Record Delete Successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function lead_delete($id)
    {
        try
        {
            $data=Lead_master::delete_lead($id);

            return array('status_code' => 200, 'message' => 'Record Delete Successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }
}
