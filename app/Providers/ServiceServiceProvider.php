<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use App\Models\Service;
use App\Models\ServiceCategory;

class ServiceServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        //
    }

    /* =====================
       GET LIST
    ===================== */
    public static function get_data()
    {
        try {
            $data = Service::get_list();

            return [
                'status_code' => 200,
                'message' => 'Service data fetched successfully',
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
                'created_at' => now()
            ]);

            return [
                'status_code' => 500,
                'message' => trans('api.messages.general.error')
            ];
        }
    }

    /* =====================
       GET CATEGORY LIST
    ===================== */
    public static function get_category_data()
    {
        try {
            $data = ServiceCategory::where('status', 1)->get();

            return [
                'status_code' => 200,
                'message' => 'Category data fetched',
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
                'created_at' => now()
            ]);

            return [
                'status_code' => 500,
                'message' => trans('api.messages.general.error')
            ];
        }
    }

    /* =====================
       ADD
    ===================== */
    public static function add_service($request)
    {
        try {
            $data = Service::add_service($request);

            return [
                'status_code' => 200,
                'message' => 'Service successfully added',
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
                'created_at' => now()
            ]);

            return [
                'status_code' => 500,
                'message' => trans('api.messages.general.error')
            ];
        }
    }

    /* =====================
       EDIT
    ===================== */
    public static function service_edit($id)
    {
        try {
            $data = Service::get_by_id($id);

            return [
                'status_code' => 200,
                'message' => 'Service data fetched',
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
                'created_at' => now()
            ]);

            return [
                'status_code' => 500,
                'message' => trans('api.messages.general.error')
            ];
        }
    }

    /* =====================
       UPDATE
    ===================== */
    public static function update_service($request)
    {
        try {
            $data = Service::update_service($request);

            return [
                'status_code' => 200,
                'message' => 'Service successfully updated',
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
                'created_at' => now()
            ]);

            return [
                'status_code' => 500,
                'message' => trans('api.messages.general.error')
            ];
        }
    }

    /* =====================
       FILTER BY CATEGORY
    ===================== */
    public static function service_by_category($id)
    {
        try {
            $data = Service::get_serviceByCategory_Id($id);

            return [
                'status_code' => 200,
                'message' => 'Service data fetched',
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
                'created_at' => now()
            ]);

            return [
                'status_code' => 500,
                'message' => trans('api.messages.general.error')
            ];
        }
    }
}
