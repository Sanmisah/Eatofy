<?php

namespace App\Models;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'hotel_id',
        'supplier_name',
        'supplier_contact_no',
        'customer_name',
        'customer_contact_no',
        'customer_address',
        'gstin',
    ];
}
