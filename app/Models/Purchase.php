<?php

namespace App\Models;
use Carbon\Carbon;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hotel;
use App\Models\PurchaseDetail;
use App\Models\PaymentDetail;
use App\Models\Supplier;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Purchase extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, CreatedUpdatedBy;
    protected $fillable = [
        'hotel_id',
        'purchase_date',
        'supplier_id',
        'invoice_no',
        'invoice_date',
        'total_amount',
        'balance_amount',
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

    public function getTotalPaidAmount($purchase_id)
    {
        $paymentDetail = PaymentDetail::where('purchase_id', $purchase_id);
        return $paymentDetail->sum('paid_amount');
    }
}
