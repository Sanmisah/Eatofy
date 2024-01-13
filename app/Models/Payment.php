<?php

namespace App\Models;
use Carbon\Carbon;
use App\Traits\CreatedUpdatedBy;
use App\Models\Hotel;
use App\Models\Supplier;
use App\Models\PaymentDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'upi_no',
        'payment_date',
        'total',
    ];

    public function setVoucherDateAttribute($value)
    {       
        $this->attributes['voucher_date'] = $value != null  ? Carbon::createFromFormat('d/m/Y', $value) : null;
    }

    public function getVoucherDateAttribute($value)
    {      
        return $value != null  ? Carbon::parse($value)->format('d/m/Y') : null;
    }   

    public function setPaymentDateAttribute($value)
    {       
        $this->attributes['payment_date'] = $value != null  ? Carbon::createFromFormat('d/m/Y', $value) : null;
    }

    public function getPaymentDateAttribute($value)
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

    public static function booted(): void
    {
        static::creating(function(Payment $payment){
            $payments = Payment::whereNotNull('voucher_no')->orderBy('created_at','DESC')->first();
            $max = $payments ? Str::substr($payments->voucher_no, 1) : 0;
            $payment->voucher_no = 'V'.str_pad($max + 1, 5, "0", STR_PAD_LEFT);
        });
    }
}
