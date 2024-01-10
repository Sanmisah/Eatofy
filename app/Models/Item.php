<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;
use App\Models\StockLedger;

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

    public function updateClosingQty($hotel_id)
    {
        // (opneing_qty + sum(received)) - sum(issude)       
        $opening_qty = Item::where('hotel_id', $hotel_id);
        $received = StockLedger::where('hotel_id', $hotel_id)->sum('received');
        $issued = StockLedger::where('hotel_id', $hotel_id)->sum('issued');
        $closingQty = ($opening_qty + $received - $issued);
        return $closingQty;
    }
}
