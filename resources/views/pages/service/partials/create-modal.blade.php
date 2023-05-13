<div class="modal fade createModal" tabindex="-1" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden">
            <div class="modal-header">
                <h5 class="modal-title" id="customerModal">{{ __('create') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('settings.service.store') }}" method="POST">
                    @csrf
                    <div class="my-2">
                        <label class="form-label" for="name"> {{ __('service_name') }} </label>
                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            id="name"
                            name="name"
                            placeholder="{{ __('service_name') }}"
                        >
                        @include('components.invalid-feedback', ['key' => 'name'])
                    </div>

                    <div class="my-2">
                        <label class="form-label" for="usb">{{ __('service_usb_list') }}</label>
                        <select class="form-control @error('service_usbs') is-invalid @enderror" id="usb" name="service_usbs[]" multiple>
                            <option value="{{ null }}">{{ __('service_usb_list') }}</option>
                            @foreach($usbList as $usb)
                                <option value="{{ $usb->id }}">{{ $usb->phone }}</option>
                            @endforeach
                        </select>
                        @include('components.invalid-feedback', ['key' => 'service_usbs'])
                    </div>

                    <div class="my-2">
                        <label class="form-label" for="name_ru"> {{ __('service_name_ru') }} </label>
                        <input
                            type="text"
                            class="form-control @error('name_ru') is-invalid @enderror"
                            id="name_ru"
                            name="name_ru"
                            placeholder="{{ __('service_name_ru') }}"
                        >
                        @include('components.invalid-feedback', ['key' => 'name_ru'])
                    </div>

                    <div class="my-2">
                        <label class="form-label" for="name_tm"> {{ __('service_name_tm') }} </label>
                        <input
                            type="text"
                            class="form-control @error('name_tm') is-invalid @enderror"
                            id="name_tm"
                            name="name_tm"
                            placeholder="{{ __('service_name_tm') }}"
                        >
                        @include('components.invalid-feedback', ['key' => 'name_tm'])
                    </div>



                    <div class="my-2">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_active"
                                id="is_active">
                            <label class="form-check-label" for="is_active">
                                {{ __("service_is_active") }}
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-4">
                        {{ __('create') }}
                    </button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

@once
    @push('script')
        <script type='text/javascript' src="/assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
        <script>
            const element = document.getElementById('usb');

            var choices = new Choices(element, {
                searchEnabled: true,
                searchChoices: true,
                addItems: true,
                editItems: true,
                removeItems: true,
                removeItemButton: true,
                delimiter: ',',
                maxItemCount: 10,
            })

        </script>
    @endpush
@endonce
