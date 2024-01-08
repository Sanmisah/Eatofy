<?php

namespace App\Models;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purchase;

class PurchaseDetail extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'purchase_id',
        'item',
        'unit',
        'qty',
        'rate',
        'amount'
    ];
    public function Purchase() 
    {
        return $this->belongsTo(Purchase::class);
    } 
}
