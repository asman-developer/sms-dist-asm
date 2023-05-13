<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function usbList()
    {
        return $this
            ->belongsToMany(Usb::class, 'services_usbs', 'service_id', 'usb_id')
            ->where('is_active', true);
    }

    public function staffs()
    {
        return $this->belongsToMany(Staff::class, 'staffs_services', 'service_id', 'staff_id');
    }

    public function distributions()
    {
        return $this->hasMany(Distribution::class, 'service_id', 'id');
    }

    public function messages()
    {
        return $this->hasMany(SMS::class, 'service_id', 'id');
    }

    public function getTrans()
    {
        return app()->getLocale() == "ru" ? json_decode($this->trans)->ru : json_decode($this->trans)->tm;
    }
}
