<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'bundle_size',
        'current_usage',
        'start_date',
        'end_date',
        'speed',
        'status',
        'service_type_id',
    ];
    public function getStatusAttribute()
    {
        if ($this->current_usage === 0 && $this->end_date > now()) {
            return 'active';
        } elseif ($this->current_usage > 0 && $this->end_date > now()) {
            return 'limited';
        } else {
            return 'suspended';
        }
    }
    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }
}
