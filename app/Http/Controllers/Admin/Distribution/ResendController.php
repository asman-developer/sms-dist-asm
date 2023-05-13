<?php

namespace App\Http\Controllers\Admin\Distribution;

use App\Enums\DistributionStatesEnum;
use App\Models\Distribution;
use App\Models\SMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResendController extends Controller
{
    public function __invoke(Request $request)
    {
        $distribution = Distribution::query()->findOrFail($request->id);

        if ($request->type == 'all'){
            $distribution->state = DistributionStatesEnum::PENDING;
            $distribution->completed_count = 0;
            $distribution->completed_at = null;
            $distribution->save();

            SMS::query()
                ->where('distribution_id', $distribution->id)
                ->update(['status' => 0]);
        }

        if ($request->type == 'unsent'){
            $distribution->state = DistributionStatesEnum::PENDING;
            $distribution->save();
        }

        return redirect()->back()->with('success');
    }
}
