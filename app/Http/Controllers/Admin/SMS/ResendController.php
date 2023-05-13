<?php

namespace App\Http\Controllers\Admin\SMS;

use App\Jobs\SendSMSJob;
use App\Models\SMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResendController extends Controller
{
    public function __invoke(Request $request)
    {
        $sms = SMS::query()->findOrFail($request->id);
        $sms->status = 0;
        $sms->save();

        SendSMSJob::dispatch($sms);

        return redirect()->back()->with('success');
    }
}
