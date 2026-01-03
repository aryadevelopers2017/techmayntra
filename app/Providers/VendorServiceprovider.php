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

            $data=vendor_master::add_vendor($request);

            return array('status_code' => 200, 'message' => 'vendor successfully added', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }
}
