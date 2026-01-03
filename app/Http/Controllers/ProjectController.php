<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\ProjectServiceProvider;
use Illuminate\Http\Request;

class ProjectController extends Controller
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
    	$data=ProjectServiceProvider::get_project_list();

        return view('project_list')->with('data',  $data['data']);
    }

    public static function project_add()
    {
        $data=ProjectServiceProvider::project_add();

        return view('project_add')->with('data',  $data['data']);
    }

    public static function project_milestone_add(Request $request)
    {
        $data=ProjectServiceProvider::project_milestoneadd($request);

        if($data['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$data['message'];

        return redirect('/project_list')->with($status, $message);
    }

    public static function add_project(Request $request)
    {
        $data=ProjectServiceProvider::add_project($request);

        if($data['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$data['message'];
        
        return redirect('/project_list')->with($status, $message);
    }

    public static function get_projectByvendor_ajax(Request $request)
    {
        $data=ProjectServiceProvider::get_projectByvendor_ajax($request->id);
        return json_encode($data);
    }

    public static function project_payment_info($id)
    {
        $data=ProjectServiceProvider::get_project_all_info($id);

        return view('project_payment_info')->with('data',  $data['data']);
    }

    public static function project_approve($id)
    {
        $data=ProjectServiceProvider::project_approve($id);

        if($data['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$data['message'];
        
        return redirect('/project_list')->with($status, $message);
    }

    public static function project_cancel($id)
    {
        $data=ProjectServiceProvider::project_cancel($id);

        if($data['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$data['message'];

        return redirect('/project_list')->with($status, $message);
    }
}
