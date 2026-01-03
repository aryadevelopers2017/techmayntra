<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class lead_remarks extends Model
{
    use HasFactory;

    protected $table = 'lead_remarks';

    protected $fillable = ['id', 'lead_id', 'follow_up_date', 'remarks'];

    public static function add_lead_remarks($request)
    {
    	$data =new lead_remarks();

        $data->lead_id=$request->id;
        $data->follow_up_date=$request->follow_up_date;
        $data->remarks=$request->remarks;

        $data->save();

        return $data;
    }

    public static function getlead_remarksByid($id)
    {
        $data=lead_remarks::where('lead_id', $id)->get();

        return $data;
    }
}
