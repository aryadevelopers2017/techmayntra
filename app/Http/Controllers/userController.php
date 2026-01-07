<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\userServiceprovider;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;


class userController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function index()
    {
        $data=userServiceprovider::user_list();

        return view('user_list')->with('users',  $data['data']);
    }

    public static function user_add()
    {
        return view('user_add');
    }

    public static function changePassword()
    {
        return view('change_password');
    }

    public static function add_user(Request $request)
    {
    	$user=userServiceprovider::add_user($request);

    	if($user['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$user['message'];
	    return redirect('/user_list')->with($status, $message);
    // 	return redirect('/user_list/'.Auth::user()->company_id.'')->with($status, $message);
    }

    public static function updatePassword(Request $request)
    {
        $user=userServiceprovider::UpdatePassword($request);
        if($user['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }

        $message=$user['message'];

        return redirect('/changepassword')->with($status, $message);
    }



    public static function user_checkemail(Request $request)
    {



        if (!$request->filled('email')) {


            return 'fail';
        }


        $data = userServiceprovider::checkemail($request);



        if ($data['data'] === true) {
          

            return 'fail';
        }


        return 'success';
    }



}
