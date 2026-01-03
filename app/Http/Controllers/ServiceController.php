<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\ServiceServiceProvider;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function index()
    {
        $data = ServiceServiceProvider::get_data();

        return view('service_list')->with('data', $data['data']);
    }

    public static function service_add()
    {
        $categories = ServiceServiceProvider::get_category_data();

        return view('service_add')->with('categories', $categories['data']);
    }

    public static function add_service(Request $request)
    {
        $data = ServiceServiceProvider::add_service($request);

        $status = ($data['status_code'] == 200) ? 'success' : 'fail';
        return redirect('/service_list')->with($status, $data['message']);
    }

    public static function service_edit($id)
    {
        $data = ServiceServiceProvider::service_edit($id);
        $categories = ServiceServiceProvider::get_category_data();

        return view('service_edit')->with('categories', $categories['data'])->with('data', $data['data']);
    }

    public static function update_service(Request $request)
    {
        $data = ServiceServiceProvider::update_service($request);

        $status = ($data['status_code'] == 200) ? 'success' : 'fail';
        return redirect('/service_list')->with($status, $data['message']);
    }

    public static function service_by_category($id)
    {
        $data = ServiceServiceProvider::service_by_category($id);

        return view('service_list')->with('data', $data['data']);
    }

    public static function service_delete($id)
{
    try {
        // Find the service by id and delete
        $service = \App\Models\Service::find($id);
        if ($service) {
            $service->delete();
            return redirect('/service_list')->with('success', 'Service deleted successfully');
        } else {
            return redirect('/service_list')->with('fail', 'Service not found');
        }
    } catch (\Exception $e) {
        \Log::error([
            'method' => __METHOD__,
            'error' => [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'message' => $e->getMessage()
            ],
            'created_at' => now()
        ]);
        return redirect('/service_list')->with('fail', 'Something went wrong');
    }
}

}
