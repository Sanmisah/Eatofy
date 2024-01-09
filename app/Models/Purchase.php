<?php

namespace App\Models;
use Carbon\Carbon;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hotel;
use App\Models\PurchaseDetail;
use App\Models\Supplier;

class Purchase extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'hotel_id',
        'purchase_date',
        'supplier_id',
        'invoice_no',
        'invoice_date',
        'total_amount'
    ];

    public function setPurchaseDateAttribute($value)
    {       
        $this->attributes['purchase_date'] = $value != null  ? Carbon::createFromFormat('d/m/Y', $value) : null;
    }

    public function getPurchaseDateAttribute($value)
    {      
        return $value != null  ? Carbon::parse($value)->format('d/m/Y') : null;
    }

    public function setInvoiceDateAttribute($value)
    {        
        $this->attributes['invoice_date'] = $value != null  ? Carbon::createFromFormat('d/m/Y', $value) : null;
    }

    public function getInvoiceDateAttribute($value)
    {      
        return $value != null  ? Carbon::parse($value)->format('d/m/Y') : null;
    }

    public function PurchaseDetails() 
    {
        return $this->hasMany(PurchaseDetail::class, 'purchase_id');
    }

    public function Supplier() 
    {
        return $this->belongsTo(Supplier::class);
    }
}
