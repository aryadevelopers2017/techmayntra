<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class qty_master extends Model
{
    use HasFactory;

    protected $table = 'qty_master';

    protected $dates = ['deleted_at'];
    protected $fillable = ['qty_name'];

    public static function qty_list()
    {
    	$data=qty_master::orderBy('id', 'DESC')->get();
    	return $data;
    }
}
