<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'hotel_name',
        'address',
        'state',
        'city',
        'contact_no',
        'website_url',
        'owner_name',
        'email',
        'owner_contact_no',
        'gstin',
    ];
}
