<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Enums\RoleEnum;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UpdateController extends Controller
{
    public function __invoke(Request $request)
    {
        $staff = Staff::query()->findOrFail($request->id);

        $data = $request->validate([
            'firstname' => 'required|string',
            'lastname'  => 'required|string',
            'phone'     => 'required|string',
            'email'     => 'nullable|string',
            'role'      => 'required|string',
            'password'  => 'nullable|min:6|max:25|confirmed',
            'is_active' => 'nullable',
            'services'  => 'nullable|array',
        ]);

        $staff->update([
            'firstname' => $data['firstname'],
            'lastname'  => $data['lastname'],
            'phone'     => $data['phone'],
            'email'     => $data['email'],
            'role'      => $data['role'],
            'status' => Arr::exists($data, 'is_active'),
            'password'  => $data['password'] ? Hash::make($data['password']) : $staff->password
        ]);

        if ($staff->role == RoleEnum::ADMIN->value){
            $services = Service::query()->whereIsActive(true)->get()->pluck('id')->toArray();
            $staff->services()->sync($services);
        }

        if (Arr::exists($data, 'services')){
            $staff->services()->sync($data['services']);
        }

        return redirect()->back();
    }
}
