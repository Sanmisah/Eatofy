<?php

namespace App\Models;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purchase;
use App\Models\Item;

class PurchaseDetail extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'purchase_id',
        'item_id',
        'unit',
        'qty',
        'rate',
        'amount'
    ];
     
    public function Item() 
    {
        return $this->belongsTo(Item::class);
    }
}
