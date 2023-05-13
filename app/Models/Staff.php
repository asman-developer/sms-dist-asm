<?php

namespace App\Models;

use Database\Factories\StaffFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Staff extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected static function newFactory(): StaffFactory
    {
        return StaffFactory::new();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Return the full name of the customer.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return trim(
            preg_replace(
                '/\s+/',
                ' ',
                "{$this->firstname} {$this->lastname}"
            )
        );
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'staffs_services',  'staff_id', 'service_id')
            ->orderBy('id');
    }

    public function messages()
    {
        $services = $this->services->pluck('id')->toArray();

        return SMS::query()->whereIn('service_id', $services);
    }
}
