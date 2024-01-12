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
    public function Purchase() 
    {
        return $this->belongsTo(Purchase::class);
    } 
    public function Payment() 
    {
        return $this->belongsTo(Payment::class);
    }
}
