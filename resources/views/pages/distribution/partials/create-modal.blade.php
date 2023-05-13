<div class="modal fade createModal" tabindex="-1" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden">
            <div class="modal-header">
                <h5 class="modal-title" id="customerModal">{{ __('distribution_create') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('distribution.store') }}" method="POST">
                    @csrf

                    <div class="my-2">
                        <label class="form-label" for="service">{{ __('distribution_service') }}</label>
                        <select class="form-control @error('service_id') is-invalid @enderror" id="service" name="service_id">
                            <option value="{{ null }}">{{ __('distribution_service') }}</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->getTrans() }}</option>
                            @endforeach
                        </select>

                        @include('components.invalid-feedback', ['key' => 'service_id'])
                    </div>

                    <div class="my-2">
                        <label class="form-label" for="name">{{ __('distribution_name') }}</label>
                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            id="name"
                            name="name"
                            required="true"
                            placeholder="{{ __('distribution_name') }}"
                        >
                        @include('components.invalid-feedback', ['key' => 'name'])
                    </div>

                    <div class="my-2">
                        <label class="form-label" for="start_time">{{ __('distribution_start_time') }}</label>
                        <input
                            type="datetime-local"
                            class="form-control @error('start_time') is-invalid @enderror"
                            id="start_time"
                            name="start_time"
                            required="true"
                            placeholder="{{ __('distribution_start_time') }}"
                        >
                        @include('components.invalid-feedback', ['key' => 'start_time'])
                    </div>

                    <div class="my-2">
                        <label class="form-label" for="excel_link">{{ __('distribution_excel') }}</label>
                        <input
                            type="text"
                            class="form-control @error('excel_link') is-invalid @enderror"
                            id="excel_link"
                            name="excel_link"
                            required="true"
                            placeholder="{{ __('distribution_excel') }}"
                        >
                        @include('components.invalid-feedback', ['key' => 'excel_link'])
                    </div>

                    <div class="my-2">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_active"
                                id="is_active">
                            <label class="form-check-label" for="is_active">
                                {{ __("distribution_is_active") }}
                            </label>
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit">
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
            const element = document.getElementById('service');

            var choices = new Choices(element, {
                searchEnabled: true,
                searchChoices: true,
                addItems: true,
                editItems: true,
                removeItems: true,
                removeItemButton: true
            })

        </script>
    @endpush
@endonce
