<?php

namespace App\Models;
use Carbon\Carbon;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Subscription;

class Hotel extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'hotel_name',
        'branch_name',
        'address',
        'state',
        'city',
        'contact_no',
        'website_url',
        'owner_name',
        'email',
        'owner_contact_no',
        'gstin',
        'expiry_date',
        'tagline'
    ];

    public function User()
    {
        return $this->hasOne(User::class, 'id');
    }

    public function Subscriptions() 
    {
        return $this->hasMany(Subscription::class);
    }

    public function setExpiryDateAttribute($value)
    {       
        $this->attributes['expiry_date'] = $value != null  ? Carbon::createFromFormat('d/m/Y', $value) : null;
    }

    public function getExpiryDateAttribute($value)
    {      
        return $value != null  ? Carbon::parse($value)->format('d/m/Y') : null;
    }
}
