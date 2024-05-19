<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'bundle_type', 
        'price',
        'max_speed',
        'max_bundle',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
