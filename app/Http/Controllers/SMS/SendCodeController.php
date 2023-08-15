<?php

namespace App\Http\Controllers\SMS;

use App\Http\Controllers\Controller;
use App\Jobs\SendSMSJob;
use Illuminate\Http\Response;
use App\Models\SMS;
use Illuminate\Http\Request;


class SendCodeController extends Controller
{
    public function __invoke(Request $r)
    {
        $r->validate([
            'phone' => 'required',
            'code'  => 'required'
        ]);

        $sms = SMS::create([
            'service_id'  => 3,
            'phone'    => $r->phone,
            'content'  => $r->code,
        ]);

        SendSMSJob::dispatch($sms);

        return response()
            ->json([
                'success' => true,
                'data'    => $sms
            ], Response::HTTP_CREATED);
    }
}
