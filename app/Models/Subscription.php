<?php

namespace App\Models;
use Carbon\Carbon;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hotel;
use App\Models\Package;

class Subscription extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'hotel_id',
        'subscription_no',
        'subscription_date',
        'expiry_date',
        'package_id',
        'payment_mode',
        'cheque_no',
        'bank_name',
        'reference_no',
        'upi_no',
        'payment_date',
    ];

    public function setSubscriptionDateAttribute($value)
    {       
        $this->attributes['subscription_date'] = $value != null  ? Carbon::createFromFormat('d/m/Y', $value) : null;
    }

    public function getSubscriptionDateAttribute($value)
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

    public function Package() 
    {
        return $this->belongsTo(Package::class);
    }

    public static function booted(): void
    {
        static::creating(function(Subscription $subscription){
            $subscriptions = Subscription::whereNotNull('subscription_no')->orderBy('created_at','DESC')->first();
            $max = $subscriptions ? Str::substr($subscriptions->subscription_no, 1) : 0;
            $subscription->subscription_no = 'S'.str_pad($max + 1, 5, "0", STR_PAD_LEFT);
        });
    }
}
