<?php

namespace App\Models;
use App\Models\Payment;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_id',
        'purchase_id',
        'paid_amount',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function (PaymentDetail $paymentDetail) {
            $purchase = Purchase::find($paymentDetail->purchase_id);
            $purchase->balance_amount = $purchase->total_amount - $purchase->getTotalPaidAmount($paymentDetail->purchase_id);
            $purchase->save();
        });

        static::deleted(function (PaymentDetail $paymentDetail) {
            $purchase = Purchase::find($paymentDetail->purchase_id);
            $purchase->balance_amount = $purchase->total_amount - $purchase->getTotalPaidAmount($paymentDetail->purchase_id);
            $purchase->save();
        });        
    }        

    public function Purchase() 
    {
        return $this->belongsTo(Purchase::class);
    } 

    public function Payment() 
    {
        return $this->belongsTo(Payment::class);
    }
}
