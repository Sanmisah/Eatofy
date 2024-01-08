<?php

namespace App\Models;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class HotelStaff extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'hotel_id',
        'staff_name',
        'address',
        'contact_no',
        'role',
        'salary',
        'email'
    ];
    public function User()
    {
        return $this->hasOne(User::class, 'id');
    }
}
