<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\CompanyModuleServiceProvider;
use Illuminate\Http\Request;

class CompanyModuleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public static function index()
    {
    	$data=CompanyModuleServiceProvider::module_list();
    	
        return view('module_list')->with('module_data', $data['data'])->with('currency', $data['currency']);
    }

    public static function update_module(Request $request)
    {
		
		$data=CompanyModuleServiceProvider::update_module($request);

        if($data['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$data['message'];

        return redirect('/company_module')->with($status, $message);
    }

    public static function address_list()
    {
        $address_data=CompanyModuleServiceProvider::company_address_list();
        
        return view('company_address_list')->with('address_data', $address_data['data']);
    }

    public static function company_address_add()
    {
        $data=CompanyModuleServiceProvider::module_list();
        return view('company_address_add')->with('company', $data['data']);
    }

    public static function update_address_status($id)
    {
        CompanyModuleServiceProvider::updateaddress_status($id);
        return redirect('/company_address_list');
    }

    public static function add_company_address(Request $request)
    {
        $data=CompanyModuleServiceProvider::add_address_company($request);
        return redirect('/company_address_list');
    }
}
