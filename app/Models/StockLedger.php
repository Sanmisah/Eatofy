<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hotel;
use App\Models\Item;

class StockLedger extends Model
{
    use HasFactory;
    protected $fillable = [
        'hotel_id',
        'item_id',
        'received',
        'issued',
        'model',
        'foreign_key'
    ];
}
