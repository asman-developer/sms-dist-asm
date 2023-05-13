<div class="modal fade createModal" tabindex="-1" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden">
            <div class="modal-header">
                <h5 class="modal-title" id="customerModal">{{ __('create') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('settings.usb.store') }}" method="POST">
                    @csrf

                    <div class="my-2">
                        <label class="form-label" for="phone"> {{ __('usb_phone') }} </label>
                        <input
                            type="text"
                            class="form-control @error('phone') is-invalid @enderror"
                            id="phone"
                            name="phone"
                            placeholder="{{ __('usb_phone') }}"
                        >
                        @include('components.invalid-feedback', ['key' => 'phone'])
                    </div>

                    <div class="my-2">
                        <label class="form-label" for="port_numbers"> {{ __('usb_port_numbers') }} </label>
                        <input
                            type="text"
                            class="form-control @error('port_numbers') is-invalid @enderror"
                            id="port_numbers"
                            name="port_numbers"
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
                                id="is_active">
                            <label class="form-check-label" for="is_active">
                                {{ __("staff_status") }}
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        {{ __('create') }}
                    </button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
