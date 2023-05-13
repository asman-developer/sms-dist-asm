<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Distribution extends Model
{
    protected $guarded = [];

    public function messages(): HasMany
    {
        return $this->hasMany(SMS::class, 'distribution_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id','id');
    }

    public function getCompletePercent()
    {
        if ($this->message_count !== 0) {
            return ($this->completed_count / $this->message_count) * 100;
        }

        return 0;
    }
}
