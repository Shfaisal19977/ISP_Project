<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;
    protected $fillable = [
        'iptv_subscription_id',
        'name',
        'category',
    ];
    public function iptvSubscriptions()
    {
        return $this->belongsToMany(IptvSubscription::class);
    }
    public function iptvSubscription()
    {
        return $this->belongsTo(IptvSubscription::class);
    }
}
