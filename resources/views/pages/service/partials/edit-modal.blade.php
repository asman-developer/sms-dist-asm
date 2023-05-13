<div class="modal fade {{ $modalId }}" tabindex="-1" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalId }}customerModal">{{ __('update') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('settings.service.update', $service->id) }}" method="POST">
                    @csrf
                    <div class="my-2">
                        <label class="form-label" for="{{ $modalId }}name"> {{ __('service_name') }} </label>
                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            id="{{ $modalId }}name"
                            name="name"
                            value="{{ $service->name }}"
                            placeholder="{{ __('service_name') }}"
                        >
                        @include('components.invalid-feedback', ['key' => 'name'])
                    </div>

                    <div class="my-2">
                        <label class="form-label" for="{{ $modalId }}usb">{{ __('service_usb_list') }}</label>
                        <select class="form-control @error('service_usbs') is-invalid @enderror qqqqqq" id="{{ $modalId }}usb" name="service_usbs[]" multiple>
                            <option value="{{ null }}">{{ __('service_usb_list') }}</option>
                            @foreach($usbList as $usb)
                                <option value="{{ $usb->id }}"
                                    {{  in_array($usb->id, $service->usbList->pluck('id')->toArray()) ? 'selected' : null }}
                                >{{ $usb->phone }}</option>
                            @endforeach
                        </select>
                        @include('components.invalid-feedback', ['key' => 'service_usbs'])
                    </div>

                    <div class="my-2">
                        <label class="form-label" for="{{ $modalId }}name_ru"> {{ __('service_name_ru') }} </label>
                        <input
                            type="text"
                            class="form-control @error('name_ru') is-invalid @enderror"
                            id="{{ $modalId }}name_ru"
                            name="name_ru"
                            value="{{ json_decode($service->trans)->ru }}"
                            placeholder="{{ __('service_name_ru') }}"
                        >
                        @include('components.invalid-feedback', ['key' => 'name_ru'])
                    </div>

                    <div class="my-2">
                        <label class="form-label" for="{{ $modalId }}name_tm"> {{ __('service_name_tm') }} </label>
                        <input
                            type="text"
                            class="form-control @error('name_tm') is-invalid @enderror"
                            id="{{ $modalId }}name_tm"
                            name="name_tm"
                            value="{{ json_decode($service->trans)->tm }}"
                            placeholder="{{ __('service_name_tm') }}"
                        >
                        @include('components.invalid-feedback', ['key' => 'name_tm'])
                    </div>

                    <input type="hidden" name="token" value="{{ $service->token }}">


                    <div class="my-2">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_active"
                                id="{{ $modalId }}is_active"
                                {{ $service->is_active ? "checked" : ""  }}
                            >
                            <label class="form-check-label" for="is_active">
                                {{ __("service_is_active") }}
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
