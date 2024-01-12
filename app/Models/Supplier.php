<?php

namespace App\Models;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purchase;

class Supplier extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'hotel_id',
        'supplier_name',
        'supplier_contact_no',
        'gstin',
        'address_line_1',
        'address_line_2',
        'state',
        'city',
        'pincode'
    ];

    public function Purchase() 
    {
        return $this->belongsTo(Purchase::class);
    }
}
