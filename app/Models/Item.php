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

    public function getClosingQty($item_id)
    {
        $item = Item::where('id', $item_id)->first();
        $stockLedger = StockLedger::where('item_id', $item_id);
        return ($item->opening_qty + $stockLedger->sum('received')) - $stockLedger->sum('issued');
    }
}
