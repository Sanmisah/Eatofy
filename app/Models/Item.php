<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Item extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'item_category_id',
        'hotel_id',
        'name',
        'unit',
        'opening_qty',
        'closing_qty',        
    ];
}
