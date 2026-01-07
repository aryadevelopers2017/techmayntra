<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;
use App\Models\User;

class userServiceprovider extends ServiceProvider
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

    public static function user_list()
    {
        try
        {
            $data= User::where(['sub_admin' =>1])->get();

            return array('status_code' => 200, 'message' => 'Get Data Successfully', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function add_user($request)
    {
        try
        {
            $data= User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'company_id' => Auth::user()->company_id,
                'sub_admin' => 1
            ]);

            return array('status_code' => 200, 'message' => 'User Successfully Added', 'data' => $data);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

    public static function UpdatePassword($request)
    {
        try
        {
            $authdata=Auth::user();
            $user_data=User::find($authdata->id);
            $newpassword=$request->newpassword;
            $confirm_password=$request->confirm_password;

            if($newpassword!=$confirm_password)
            {
                $status_code=402;
                $message="password and confirm password are not same";
            }
            elseif(!Hash::check($request->currentpassword, $user_data->password))
            {
                $status_code=402;
                $message="Current Password is wrong";
            }
            else
            {
                User::updatePass($newpassword, $user_data->id);
                $status_code=200;
                $message="Password Change Successfully";
            }

            return array('status_code' => $status_code, 'message' => $message);
        }
        catch (\Exception $e)
        {
            Log::error(['method' => __METHOD__, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
            return array('status_code' => 500, 'message' => trans('api.messages.general.error') . $e->getMessage() . $e->getFile());
        }
    }

public static function checkemail($request)
{
    $exists = User::where(
        'email',
        trim(strtolower($request->email))
    )->exists();

    return [
        'status_code' => 200,
        'data' => $exists // BOOLEAN
    ];
}


}
