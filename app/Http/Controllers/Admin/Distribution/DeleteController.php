<?php

namespace App\Http\Controllers\Admin\Distribution;

use App\Enums\DistributionStatesEnum;
use App\Enums\RoleEnum;
use App\Models\Distribution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteController extends Controller
{
    public function __invoke(Request $request)
    {
        abort(404);
        $staff = currentStaff();

        $distribution = Distribution::query()->findOrFail($request->id);

        if ($staff->role == RoleEnum::MANAGER->value && $distribution->state == DistributionStatesEnum::COMPLETED->value){
            return redirect()->back()->withErrors(['error' => "fuck you!"]);
        }

        $distribution->delete();

        return redirect()->back();
    }
}
