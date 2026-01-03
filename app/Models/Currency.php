<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $table = 'currency';

    public static function getAll()
    {
        return Currency::where('status', 0)->orderBy('serial_no', 'ASC')->get();
    }

    public static function getByID($id)
    {
        return Currency::find($id);
    }
}