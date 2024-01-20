<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Menu;
use App\Models\MenuCategory;

class OrderDetail extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'order_id',
        'menu_category_id',
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

    public function MenuCategory() 
    {
        return $this->belongsTo(MenuCategory::class);
    }
}
