<?php

namespace App\Http\Controllers\Admin\SMS;

use App\Models\Distribution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateStatusController extends Controller
{
    public function __invoke(Request $request)
    {
        $distribution = Distribution::query()->findOrFail($request->id);

        $distribution->is_active = !$distribution->is_active;
        $distribution->save();

        return redirect()->back();
    }
}
