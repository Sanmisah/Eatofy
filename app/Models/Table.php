<?php

namespace App\Models;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'hotel_id',
        'name',
    ];
}
