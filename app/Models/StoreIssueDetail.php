<?php

namespace App\Models;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StoreIssue;
use App\Models\Item;

class StoreIssueDetail extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'store_issue_id',
        'item_id',
        'closing_qty',
        'qty',
    ];
    public function StoreIssue() 
    {
        return $this->belongsTo(StoreIssue::class);
    } 
    public function Item() 
    {
        return $this->belongsTo(Item::class);
    }
}
