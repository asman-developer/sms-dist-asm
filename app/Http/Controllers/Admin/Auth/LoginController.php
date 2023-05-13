<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Staff;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->validated();

        $staff = Staff::query()->whereStatus(true)->wherePhone($request->phone)->first();

        if ($staff && auth('staff')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard.index');
        }

        return redirect()->back()->withErrors(['distribution' => 'error'])->onlyInput('phone');
    }
}
