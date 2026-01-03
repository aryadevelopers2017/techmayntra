<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\ServiceCategoryServiceProvider;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function index()
    {
        $data = ServiceCategoryServiceProvider::get_data();

        return view('service_category_list')->with('data', $data['data']);
    }

    public static function service_category_add()
    {
        return view('service_category_add');
    }

    public static function add_service_category(Request $request)
    {
        $data = ServiceCategoryServiceProvider::add_service_category($request);

        $status = ($data['status_code'] == 200) ? 'success' : 'fail';
        return redirect('/service_category_list')->with($status, $data['message']);
    }

    public static function service_category_edit($id)
    {
        $data = ServiceCategoryServiceProvider::service_category_edit($id);

        return view('service_category_edit')->with('data', $data['data']);
    }

    public static function update_service_category(Request $request)
    {
        $data = ServiceCategoryServiceProvider::update_service_category($request);

        $status = ($data['status_code'] == 200) ? 'success' : 'fail';
        return redirect('/service_category_list')->with($status, $data['message']);
    }

    public static function service_category_delete($id)
{
    try {
        $category = \App\Models\ServiceCategory::find($id);
        if ($category) {

            $category->delete();
            return redirect('/service_category_list')->with('success', 'Category deleted successfully');
        } else {
            return redirect('/service_category_list')->with('fail', 'Category not found');
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
        return redirect('/service_category_list')->with('fail', 'Something went wrong');
    }
}

}
