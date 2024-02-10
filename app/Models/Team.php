<?php

namespace App\Models;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Team extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [        
        'name',
        'address',
        'email',
        'contact_no',
        'role',
        'salary',        
    ];

    public function User()
    {
        return $this->hasOne(User::class, 'id');
    }
}
