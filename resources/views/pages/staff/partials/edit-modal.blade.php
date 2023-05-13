<div class="modal fade {{ $modalId }}" tabindex="-1" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalId }}customerModal">{{ __('update') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('staff.update', $staff->id) }}" method="POST">
                    @csrf
                    <div class="my-2">
                        <label class="form-label" for="{{ $modalId }}firstname"> {{ __('staff_firstname') }} </label>
                        <input
                            type="text"
                            class="form-control @error('firstname') is-invalid @enderror"
                            id="{{ $modalId }}firstname"
                            name="firstname"
                            value="{{ $staff->firstname }}"
                            placeholder="{{ __('staff_firstname') }}"
                        >
                        @include('components.invalid-feedback', ['key' => 'firstname'])
                    </div>

                    <div class="my-2">
                        <label class="form-label" for="{{ $modalId }}lastname">{{ __('staff_lastname') }}</label>
                        <input
                            type="text"
                            class="form-control @error('lastname') is-invalid @enderror"
                            id="{{ $modalId }}lastname"
                            name="lastname"
                            value="{{ $staff->lastname }}"
                            placeholder="{{ __('staff_lastname') }}"
                        >
                        @include('components.invalid-feedback', ['key' => 'lastname'])
                    </div>

                    <div class="my-2">
                        <label class="form-label" for="{{ $modalId }}phone">{{ __('staff_phone') }}</label>
                        <input
                            type="number"
                            class="form-control @error('phone') is-invalid @enderror"
                            id="{{ $modalId }}phone"
                            name="phone"
                            value="{{ $staff->phone }}"
                            placeholder="{{ __('staff_phone') }}"
                        >
                        @include('components.invalid-feedback', ['key' => 'phone'])
                    </div>

                    <div class="my-2">
                        <label class="form-label" for="{{ $modalId }}email">{{ __('staff_email') }}</label>
                        <input
                            type="email"
                            class="form-control"
                            id="{{ $modalId }}email"
                            name="email"
                            value="{{ $staff->email }}"
                            placeholder="{{ __('staff_email') }}"
                        >
                        @include('components.invalid-feedback', ['key' => 'email'])
                    </div>

                    <div class="my-2">
                        <label class="form-label" for="{{ $modalId }}service">{{ __('staff_services') }}</label>
                        <select class="form-control @error('services') is-invalid @enderror qqqqqq" id="{{ $modalId }}service" name="services[]" multiple>
                            <option value="{{ null }}">{{ __('staff_services') }}</option>
                            @foreach($services as $service)
                                <option
                                    value="{{ $service->id }}"
                                    {{  in_array($service->id, $staff->services->pluck('id')->toArray()) ? 'selected' : null }}
                                >{{ __("service_{$service->name}") }}</option>
                            @endforeach
                        </select>

                        @include('components.invalid-feedback', ['key' => 'services'])
                    </div>

                    <div class="my-2">
                        <label class="form-label" for="{{ $modalId }}roles">{{ __('staff_role') }}</label>
                        <select class="form-select @error('role') is-invalid @enderror" id="{{ $modalId }}roles" name="role">
                            <option value="">{{ __('staff_role') }}</option>
                            @foreach($roles as $role_name)
                                <option
                                    value="{{ $role_name }}"
                                    {{ $role_name == $staff->role ? 'selected' : null }}
                                >{{ $role_name }}</option>
                            @endforeach
                        </select>
                        @include('components.invalid-feedback', ['key' => 'role'])
                    </div>

                    <hr>

                    <div class="my-2">
                        <label class="form-label" for="{{ $modalId }}password">{{ __('staff_password') }}</label>
                        <input
                            type="password"
                            class="form-control  @error('password') is-invalid @enderror"
                            id="{{ $modalId }}password"
                            name="password"
                            placeholder="{{ __('staff_password') }}"
                        >
                        @include('components.invalid-feedback', ['key' => 'password'])
                    </div>

                    <div class="my-2">
                        <input
                            type="password"
                            class="form-control  @error('password_confirmation') is-invalid @enderror"
                            id="{{ $modalId }}password_confirmation"
                            name="password_confirmation"
                            placeholder="{{ __('staff_password_confirm') }}"
                        >
                        @include('components.invalid-feedback', ['key' => 'password_confirmation'])
                    </div>

                    <div class="my-2">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_active"
                                id="{{ $modalId }}is_active"
                                {{ $staff->status ? "checked" : ""  }}
                            >
                            <label class="form-check-label" for="is_active">
                                {{ __("staff_status") }}
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        {{ __('update') }}
                    </button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

@once
    @push('script')
        <script>
            const elementEdit = document.getElementsByClassName("qqqqqq");

            Array.from(elementEdit).map(
                (element) => {
                    new Choices(element, {
                        searchEnabled: true,
                        searchChoices: true,
                        addItems: true,
                        editItems: true,
                        removeItems: true,
                        removeItemButton: true,
                        delimiter: ',',
                        maxItemCount: 10,
                    })
                }
            );
        </script>
    @endpush
@endonce
