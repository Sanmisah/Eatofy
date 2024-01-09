<?php

namespace App\Models;
use Carbon\Carbon;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hotel;
use App\Models\StoreIssueDetail;
use Illuminate\Support\Str;

class StoreIssue extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $fillable = [
        'hotel_id',
        'issue_no',
        'issue_date',
    ];

    public function setIssueDateAttribute($value)
    {       
        $this->attributes['issue_date'] = $value != null  ? Carbon::createFromFormat('d/m/Y', $value) : null;
    }

    public function getIssueDateAttribute($value)
    {      
        return $value != null  ? Carbon::parse($value)->format('d/m/Y') : null;
    }   

    public function StoreIssueDetails() 
    {
        return $this->hasMany(StoreIssueDetail::class, 'store_issue_id');
    }

    public function Hotel() 
    {
        return $this->belongsTo(Hotel::class);
    }

    // public static function booted(): void
    // {
    //     static::creating(function(StoreIssue $store_issue){
    //         $storeIssues = StoreIssue::whereNotNull('issue_no')->orderBy('created_at','DESC')->first();
    //         $max = $storeIssues ? Str::substr($storeIssues->issue_no, 1) : 0;
    //         $store_issue->issue_no = 'SI'.str_pad($max + 1, 5, "0", STR_PAD_LEFT);
    //     });
    // }
}
