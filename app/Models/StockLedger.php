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


    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function (StockLedger $stockLedger) {
            $item = Item::find($stockLedger->item_id);
            $item->closing_qty = $item->getClosingQty($stockLedger->item_id);
            $item->save();
        });

        static::deleted(function (StockLedger $stockLedger) {
            $item = Item::find($stockLedger->item_id);
            $item->closing_qty = $item->getClosingQty($stockLedger->item_id);
            $item->save();
        });        
    }    
}
