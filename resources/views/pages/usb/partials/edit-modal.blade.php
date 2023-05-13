<div class="modal fade {{ $modalId }}" tabindex="-1" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalId }}customerModal">{{ __('update') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('settings.usb.update', $usb->id) }}" method="POST">
                    @csrf
                    <div class="my-2">
                        <label class="form-label" for="{{ $modalId }}phone"> {{ __('usb_phone') }} </label>
                        <input
                            type="text"
                            class="form-control @error('phone') is-invalid @enderror"
                            id="{{ $modalId }}phone"
                            name="phone"
                            value="{{ $usb->phone }}"
                            placeholder="{{ __('usb_phone') }}"
                        >
                        @include('components.invalid-feedback', ['key' => 'phone'])
                    </div>

                    <div class="my-2">
                        <label class="form-label" for="{{ $modalId }}port_numbers"> {{ __('usb_port_numbers') }} </label>
                        <input
                            type="text"
                            class="form-control @error('port_numbers') is-invalid @enderror"
                            id="{{ $modalId }}port_numbers"
                            name="port_numbers"
                            value="{{ \Illuminate\Support\Arr::join($usb->port_numbers, ',') }}"
                            placeholder="{{ __('usb_port_numbers') }}"
                        >
                        @include('components.invalid-feedback', ['key' => 'port_numbers'])
                    </div>

                    <div class="my-2">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_active"
                                id="{{ $modalId }}is_active"
                                {{ $usb->is_active ? "checked" : ""  }}
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
