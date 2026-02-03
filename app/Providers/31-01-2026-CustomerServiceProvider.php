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

            if($request->country!='')
            {
                $country=Customer::getCountryName($request->country);
                $request->country=$country[0]->name;
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
public static function update_customer($request)
{
    try {

        // Convert IDs → Names
        if ($request->state) {
            $state = Customer::getStateName($request->state);
            $request->state = $state[0]->name ?? null;
        }

        if ($request->city) {
            $city = Customer::getCityName($request->city);
            $request->city = $city[0]->name ?? null;
        }

        if ($request->country) {
            $country = Customer::getCountryName($request->country);
            $request->country = $country[0]->name ?? null;
        }

        $data = Customer::update_customer($request);

        return [
            'status_code' => 200,
            'message' => 'Customer Data Successfully Updated',
            'data' => $data
        ];

    } catch (\Exception $e) {
        Log::error($e);
        return [
            'status_code' => 500,
            'message' => $e->getMessage()
        ];
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

            // dd($data);

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

    public static function getDocumentTypes()
{
    // You can hardcode or fetch from DB
    return [
        ['id' => 1, 'name' => 'Passport Front', 'slug' => 'passport_front'],
        ['id' => 2, 'name' => 'Passport Back', 'slug' => 'passport_back'],
        ['id' => 3, 'name' => 'Passport Cover', 'slug' => 'passport_cover'],
        ['id' => 4, 'name' => 'White Background Photo', 'slug' => 'white_background_photo'],
        ['id' => 5, 'name' => 'Birth Certificate if Minor', 'slug' => 'birth_certificate'],
        ['id' => 6, 'name' => 'Marriage Certificate for Family Visa', 'slug' => 'marriage_certificate'],
        ['id' => 7, 'name' => 'Sponsor Documents', 'slug' => 'sponsor_documents'],
        ['id' => 8, 'name' => 'National ID Card', 'slug' => 'national_id_card'],
    ];
}



public static function getCustomerDocuments($customer_id)
{
    try {
        $documents = DB::table('customer_documents')
            ->where('customer_id', $customer_id)
            ->orderBy('id', 'DESC')
            ->get();

        return $documents;
    } catch (\Exception $e) {
        Log::error([
            'method' => __METHOD__,
            'error' => [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'message' => $e->getMessage()
            ]
        ]);

        return [];
    }
}


}
