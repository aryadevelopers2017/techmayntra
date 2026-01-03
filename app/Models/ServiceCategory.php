<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $table = 'service_categories';

    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    /* =========================
       LIST
    ========================= */
    public static function get_list()
    {
        return self::orderBy('id', 'DESC')->get();
    }

    /* =========================
       FIND BY ID
    ========================= */
    public static function get_by_id($id)
    {
        return self::find($id);
    }

    /* =========================
       ADD
    ========================= */
    public static function add_category($request)
    {
        $category = new self();

        $category->name        = $request->name;
        $category->description = $request->description ?? '';
        $category->status      = $request->status ?? 1;

        $category->save();

        return $category;
    }

    /* =========================
       UPDATE
    ========================= */
    public static function update_category($request)
    {
        $category = self::find($request->id);

        $category->name        = $request->name;
        $category->description = $request->description ?? '';
        $category->status      = $request->status ?? 1;

        $category->save();

        return $category;
    }
}
