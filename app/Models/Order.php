<?php

namespace App\Models;
use Carbon\Carbon;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Table;
use App\Models\Server;
use App\Models\Hotel;
use App\Models\OrderPaymentDetail;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'hotel_id',
        'bill_date',
        'bill_no',
        'order_type',
        'mobile_no',
        'customer_name',
        'table_id',
        'server_id',
        'total',
        'discount_amount',
        'total_amount',
        'balance_amount',
        'payment_mode',
        'cheque_no',
        'bank_name',
        'reference_no',
        'upi_no',
        'payment_date',
        'closed'
    ];

    public function setBillDateAttribute($value)
    {       
        $this->attributes['bill_date'] = $value != null  ? Carbon::createFromFormat('d/m/Y', $value) : null;
    }

    public function getBillDateAttribute($value)
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

    public function OrderDetails() 
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function OrderPaymentDetails() 
    {
        return $this->hasMany(OrderPaymentDetail::class, 'order_id');
    }

    public function Table() 
    {
        return $this->belongsTo(Table::class);
    }

    public function Server() 
    {
        return $this->belongsTo(Server::class);
    }

    public static function booted(): void
    {
        static::creating(function(Order $order){
            $orders = Order::whereNotNull('bill_no')->orderBy('created_at','DESC')->first();
            $max = $orders ? Str::substr($orders->bill_no, 1) : 0;
            $order->bill_no = 'B'.str_pad($max + 1, 5, "0", STR_PAD_LEFT);
        });
    }
    
    public function getTotalPaidAmount($order_id)
    {
        $orderPaymentDetail = OrderPaymentDetail::where('order_id', $order_id);
        return $orderPaymentDetail->sum('paid_amount');
    }
}
