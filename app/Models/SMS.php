<?php

namespace App\Models;

use Database\Factories\SMSFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SMS extends Model
{
    /**
     * @OA\Schema(
     *     schema="SMSModel",
     *     type="object",
     *     title="SMSModel",
     *     description="SMS model",
     *     @OA\Property(
     *         property="id",
     *         title="ID",
     *         type="integer",
     *         format="int64",
     *         description="The internal ID",
     *         example="1443"
     *     ),
     *     @OA\Property(
     *         property="service",
     *         title="Service name",
     *         type="string",
     *         description="Service name",
     *         example="asman_mini"
     *     ),
     *      @OA\Property(
     *         property="phone",
     *         title="phone",
     *         type="integer",
     *         description="Phone number of user",
     *         example="99362615986"
     *     ),
     *     @OA\Property(
     *         property="content",
     *         title="Content",
     *         type="string",
     *         description="Raw sms body",
     *         example="Hello world"
     *     ),
     *     @OA\Property(
     *         property="created_at",
     *         title="RFC3339",
     *         type="date-time",
     *         description="Created datetime sms",
     *         example="2020-05-11T07:35:49.00Z"
     *     ),
     *     @OA\Property(
     *         property="diff_in_minutes",
     *         title="DiffInMinutes",
     *         type="integer",
     *         description="Minutes passed since created",
     *         example="30"
     *     ),
     *     @OA\Property(
     *         property="updated_at",
     *         title="RFC3339",
     *         type="date-time",
     *         description="Updated datetime of payment",
     *         example="2020-05-11T07:35:49.00Z"
     *     )
     *  )
     */
    use HasFactory;

    protected $table = 'sms';

    protected $guarded = [];

    protected static function newFactory(): SMSFactory
    {
        return SMSFactory::new();
    }

    // protected $appends = ['diff_in_minutes'];

    // protected $casts = [
    //     'created_at'  => 'immutable_datetime:Y-m-d H:i:s',
    // ];

    // public function getDiffInMinutesAttribute()
    // {
    //     return $this->created_at->diffInMinutes(now());
    // }

    // public function getDiffInSecondsAttribute()
    // {
    //     return $this->created_at->diffInSeconds(now());
    // }

    public function distribution(): BelongsTo
    {
        return $this->belongsTo(Distribution::class, 'distribution_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id','id');
    }

    public function usb()
    {
        return $this->belongsTo(Usb::class, 'usb_id', 'id');
    }
}
