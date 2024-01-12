<?php

namespace App\Models;
use Carbon\Carbon;
use App\Traits\CreatedUpdatedBy;
use App\Models\Hotel;
use App\Models\Supplier;
use App\Models\PaymentDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'hotel_id',
        'supplier_id',
        'voucher_no',
        'voucher_date',
        'amount',
        'payment_mode',
        'cheque_no',
        'bank_name',
        'reference_no',
        'upi_no'
    ];

    public function setVoucherDateAttribute($value)
    {       
        $this->attributes['voucher_date'] = $value != null  ? Carbon::createFromFormat('d/m/Y', $value) : null;
    }

    public function getVoucherDateAttribute($value)
    {      
        return $value != null  ? Carbon::parse($value)->format('d/m/Y') : null;
    }   

    public function PaymentDetails() 
    {
        return $this->hasMany(PaymentDetail::class, 'payment_id');
    }

    public function Supplier() 
    {
        return $this->belongsTo(Supplier::class);
    }
}
