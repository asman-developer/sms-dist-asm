<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usb extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'port_numbers' => 'array'
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'services_usbs',  'usb_id', 'service_id');
    }

    public function messages()
    {
        return $this->hasMany(SMS::class, 'usb_id',  'id');
    }
}
