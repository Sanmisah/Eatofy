<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Menu extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'menu_category_id',
        'hotel_id',
        'type',
        'item_name',
        'item_description',
        'rate',
        'gst_rate',        
        'additional_tax',
    ];
}
