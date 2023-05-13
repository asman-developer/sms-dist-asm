<?php

namespace App\Http\Livewire\Staff;

use App\Enums\RoleEnum;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class StaffLivewire extends Component
{
    public $staff;

    public $roles = [];
    public $services = [];

    public $firstname, $lastname, $role, $email, $phone, $status, $password, $password_confirmation;

    protected $listeners = [
        'saveStaff',
        'fetchStaff',
        'refresh'  => '$refresh'
    ];

    protected function rules()
    {
        return [
            'email'   => [
                'nullable',
                'email',
                $this->staff ? Rule::unique('staff')->ignore($this->staff->id, 'id') : 'unique:staff,email',
            ],
            'phone'   => [
                'required',
                'digits:11',
                $this->staff ? Rule::unique('staff')->ignore($this->staff->id, 'id') : 'unique:staff,phone',
            ],

            'firstname' => 'required|string',
            'lastname'  => 'required|string',
            'role'      => 'required|string',
            'password'  => 'nullable|min:6|max:25|confirmed',
        ];
    }

    public function fetchStaff($id = null) : void
    {
        $this->staff = $id ? Staff::find($id) : null;

        $this->email = $this->staff?->email;
        $this->phone = $this->staff?->phone;
        $this->firstname = $this->staff?->firstname;
        $this->lastname = $this->staff?->lastname;
        $this->status = $this->staff?->status;
        $this->shop_id = $this->staff?->shop_id;
        $this->role = $this->staff?->role;

        $this->roles = RoleEnum::asArray();
        $this->services = Service::query()->whereIsActive(true)->get();
    }

    public function saveStaff() : void
    {
        $this->validate();

        $this->staff = $this->staff ? $this->staff : new Staff();
        $this->staff->firstname = $this->firstname;
        $this->staff->lastname = $this->lastname;
        $this->staff->phone = $this->phone;
        $this->staff->email = $this->email;
        $this->staff->role = $this->role;

        if ($this->password) {
            $this->staff->password = Hash::make($this->password);
        }

        $this->staff->save();

        $this->toastMessage('success', 'Staff updated');

        $this->emit('refresh');
    }

    public function render()
    {
        return view('pages.staff.livewire.edit-staff-modal');
    }

    public function toastMessage($type, $message): void
    {
        $this->dispatchBrowserEvent('alert', [
            'type'    => $type,
            'message' => $message
        ]);
    }
}
