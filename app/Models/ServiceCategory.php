<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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


   public static function serviceTypes()
{
    return self::with('services')
        ->where('status', 1)
        ->get()
        ->map(function ($category) {
            return [
                'id'   => $category->id,
                'code' => Str::upper(Str::slug($category->name, '_')),
                'name' => $category->name,
                'services' => $category->services->map(function ($service) {
                    return [
                        'id'   => $service->id,
                        'code' => Str::upper(Str::slug($service->name, '_')),
                        'name' => $service->name,
                    ];
                })->values(),
            ];
        })
        ->values()
        ->toArray();
}

    public function services()
{
    return $this->hasMany(Service::class, 'category_id');
}

}
