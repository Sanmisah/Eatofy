<?php

namespace App\Models;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\Supplier;

class SupplierDetail extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'supplier_id',
        'item_name',
    ];

    public function Supplier() 
    {
        return $this->belongsTo(Supplier::class);
    } 

    public function Item() 
    {
        return $this->belongsTo(Item::class);
    }

    public function setItemAttribute($value)
    {
        $this->attributes['item_name'] = json_encode($value);
    }

    public function getItemAttribute($value)
    {
        return $this->attributes['item_name'] = json_decode($value);
    }
}
