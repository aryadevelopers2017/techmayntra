<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use DB;
use App\Models\vendor_master;
use App\Models\Customer;

class VendorServiceprovider extends ServiceProvider
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

    public static function get_list()
    {
        try
        {
            $data=vendor_master::vendor_list();

            return array('status_code' => 200, 'message' => 'get data successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function add_vendor($request)
    {
        try
        {
            $state=Customer::getStateName($request->state);
            $request->state=$state[0]->name;

            $city=Customer::getCityName($request->city);
            $request->city=$city[0]->name;

            if($request->country!=''){
                $country=Customer::getCountryName($request->country);
                $request->country=$country[0]->name;
            }

            $data=vendor_master::add_vendor($request);

            return array('status_code' => 200, 'message' => 'vendor successfully added', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function update_vendor($request, $id)
{
    try
    {
        // State Name
        if(!empty($request->state)){
            $state = Customer::getStateName($request->state);
            $request->state = $state[0]->name ?? '';
        }

        // City Name
        if(!empty($request->city)){
            $city = Customer::getCityName($request->city);
            $request->city = $city[0]->name ?? '';
        }

        // Country Name
        if(!empty($request->country)){
            $country = Customer::getCountryName($request->country);
            $request->country = $country[0]->name ?? '';
        }

        $data = vendor_master::update_vendor($request, $id);

        return array(
            'status_code' => 200,
            'message' => 'Vendor successfully updated',
            'data' => $data
        );
    }
    catch (\Exception $e)
    {
        Log::error([
            'method' => __METHOD__,
            'error' => [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'message' => $e->getMessage()
            ],
            'created_at' => date("Y-m-d H:i:s")
        ]);

        return array(
            'status_code' => 500,
            'message' => trans('api.messages.general.error') . $e->getMessage()
        );
    }
}


    // update_vendor
        public static function get_vendor_info($id)
    {
        try
        {
            $data=[];
            $data=vendor_master::get_vendorById($id);

            return array('status_code' => 200, 'message' => 'Get Record Successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

}
