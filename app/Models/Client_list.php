<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Client_list extends Model
{
    use HasFactory;

    protected $table = 'client_list';

    protected $dates = ['deleted_at'];
    protected $fillable = ['client_name', 'company_name', 'email', 'mobile', 'address', 'city', 'state'];

    public static function client_lists()
    {
    	$data=client_list::orderBy('id', 'DESC')->get();
    	return $data;
    }

    public static function add_client_list($request)
    {
        $data =new Client_list();

        $data->client_name=$request->client_name;
        $data->company_name=$request->company_name;
        $data->email=$request->email;
        $data->mobile=$request->mobile;
        $data->address=$request->address;
        $data->city=$request->city;
        $data->state=$request->state;
        $data->save();

        return $data;
    }
}
