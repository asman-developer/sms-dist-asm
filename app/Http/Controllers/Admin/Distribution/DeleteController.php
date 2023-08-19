<?php

namespace App\Http\Controllers\Admin\Distribution;

use App\Enums\RoleEnum;
use App\Models\Distribution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteController extends Controller
{
    public function __invoke(Request $request)
    {
        $staff = currentStaff();

        $distribution = Distribution::query()->findOrFail($request->id);

        if ($staff->role == RoleEnum::MANAGER->value){
            return redirect()->back()->withErrors(['error' => "Bagyşlaň {$staff->firstname} paýlamalary pozup bolmaýar! Saklamak üçin statusy çalşyň."]);
        }

        $distribution->delete();

        return redirect()->back();
    }
}
