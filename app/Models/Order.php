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

class Order extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'hotel_id',
        'bill_date',
        'bill_no',
        'mobile_no',
        'customer_name',
        'table_id',
        'server_id',
        'total_amount',
        'closed'
    ];

    public function setBillDateAttribute($value)
    {       
        $this->attributes['purchase_date'] = $value != null  ? Carbon::createFromFormat('d/m/Y', $value) : null;
    }

    public function getBillDateAttribute($value)
    {      
        return $value != null  ? Carbon::parse($value)->format('d/m/Y') : null;
    }

    public function OrderDetails() 
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
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
            $order->bill_no = 'O'.str_pad($max + 1, 5, "0", STR_PAD_LEFT);
        });
    }
    
}
