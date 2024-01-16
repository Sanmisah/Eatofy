<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Menu;

class OrderDetail extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'order_id',
        'menu_id',
        'qty',
        'rate',
        'instruction',
        'amount'
    ];
     
    public function Menu() 
    {
        return $this->belongsTo(Menu::class);
    }
}
