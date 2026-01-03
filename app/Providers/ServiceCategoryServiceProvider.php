<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use App\Models\ServiceCategory;

class ServiceCategoryServiceProvider extends ServiceProvider
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
            $data = ServiceCategory::get_list();

            return [
                'status_code' => 200,
                'message' => 'Service category data fetched successfully',
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
    public static function add_service_category($request)
    {
        try {
            $data = ServiceCategory::add_category($request);

            return [
                'status_code' => 200,
                'message' => 'Service category successfully added',
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
    public static function service_category_edit($id)
    {
        try {
            $data = ServiceCategory::get_by_id($id);

            return [
                'status_code' => 200,
                'message' => 'Service category data fetched',
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
    public static function update_service_category($request)
    {
        try {
            $data = ServiceCategory::update_category($request);

            return [
                'status_code' => 200,
                'message' => 'Service category successfully updated',
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
