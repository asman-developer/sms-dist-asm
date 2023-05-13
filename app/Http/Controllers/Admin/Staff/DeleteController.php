<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Models\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteController extends Controller
{
    public function __invoke(Request $request)
    {
        $staff = Staff::query()->findOrFail($request->id);

        $staff->delete();

        return redirect()->back();
    }
}
