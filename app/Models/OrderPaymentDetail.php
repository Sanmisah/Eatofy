<?php

namespace App\Models;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\OrderDetail;

class OrderPaymentDetail extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'order_id',
        'paid_amount',
    ];

    protected static function booted(): void
    {
        static::created(function (OrderPaymentDetail $orderPaymentDetail) {
            $order = Order::find($orderPaymentDetail->order_id);
            $order->balance_amount = $order->total_amount - $order->getTotalPaidAmount($orderPaymentDetail->order_id);
            $order->save();
        });

        static::updated(function (OrderPaymentDetail $orderPaymentDetail) {
            $order = Order::find($orderPaymentDetail->order_id);
            $order->balance_amount = $order->total_amount - $order->getTotalPaidAmount($orderPaymentDetail->order_id);
            $order->save();
        });

        static::deleted(function (OrderPaymentDetail $orderPaymentDetail) {
            $order = Order::find($orderPaymentDetail->order_id);
            $order->balance_amount = $order->total_amount - $order->getTotalPaidAmount($orderPaymentDetail->order_id);
            $order->save();
        });        
    }  

    public function Order() 
    {
        return $this->belongsTo(Order::class);
    } 
}
