<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'status'
    ];

    /* =========================
       LIST WITH CATEGORY
    ========================= */
    public static function get_list()
    {
        return self::select(
                'services.*',
                'service_categories.name as category_name'
            )
            ->leftJoin(
                'service_categories',
                'service_categories.id',
                '=',
                'services.category_id'
            )
            ->orderBy('services.id', 'DESC')
            ->get();
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
    public static function add_service($request)
    {
        $service = new self();

        $service->category_id = $request->category_id;
        $service->name        = $request->name;
        $service->description = $request->description ?? '';
        $service->status      = $request->status ?? 1;

        $service->save();

        return $service;
    }

    /* =========================
       UPDATE
    ========================= */
    public static function update_service($request)
    {
        $service = self::find($request->id);

        $service->category_id = $request->category_id;
        $service->name        = $request->name;
        $service->description = $request->description ?? '';
        $service->status      = $request->status ?? 1;

        $service->save();

        return $service;
    }
}
