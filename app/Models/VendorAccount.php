<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'order_no',
        'date',
        'company_name',
        'address',
        'country_id',
        'state_id',
        'city_id',
        'description',
        'status',
        'total_amount',
        'payment_mode',
    ];

    // Relationships

    public function vendor()
    {
        return $this->belongsTo(vendor_master::class, 'vendor_id');
    }

}
