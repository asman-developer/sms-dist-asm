<?php

namespace App\Http\Controllers\Admin\Service;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteController extends Controller
{
    public function __invoke(Request $request)
    {
        $service = Service::query()->findOrFail($request->id);

        $service->delete();

        return redirect()->back();
    }
}
