<?php

namespace App\Models;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hotel;
use App\Models\PurchaseDetail;

class Purchase extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'hotel_id',
        'purchase_date',
        'supplier_id',
        'invoice_no',
        'total_amount'
    ];

    public function PurchaseDetails() 
    {
        return $this->hasMany(PurchaseDetail::class, 'purchase_id');
    }
}
