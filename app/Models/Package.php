<?php

namespace App\Models;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'package_name',
        'validity_in_days',
        'cost',
    ];
}
