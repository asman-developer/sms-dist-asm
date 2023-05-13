<form action="{{ route(Route::currentRouteName()) }}" method="GET" id="filterForm">
    <div class="row g-3 d-flex justify-content-end">

        <div class="col-xxl-1 col-sm-2">
            <a href="">

            </a>
        </div>

        <div class="col-xxl-1 col-sm-2">

        </div>

        <div class="col-xxl-2 col-sm-2">

        </div>

        <div class="col-xxl-2 col-sm-2">
            <select class="form-select" name="type">
                <option value="">{{ __('message_type') }}</option>
                <option value=1 {{ request()->type == 1 ? 'selected' : null }}>
                    {{ __('message_status_OUTBOX') }}
                </option>
                <option value=2 {{ request()->type == 2 ? 'selected' : null }}>
                    {{ __('message_type_INBOX') }}
                </option>
            </select>
        </div>

        <div class="col-xxl-2 col-sm-2">
            <select class="form-select" name="status">
                <option value="">{{ __('message_status') }}</option>
                    <option value=1 {{ request()->status == 1 ? 'selected' : null }}>
                        {{ __('message_status_PENDING') }}
                    </option>
                    <option value=2 {{ request()->status == 2 ? 'selected' : null }}>
                        {{ __('message_status_COMPLETED') }}
                    </option>
            </select>
        </div>

        <div class="col-xxl-2 col-sm-2">
            <select class="form-select" name="service_id">
                <option value="">{{ __('message_service') }}</option>
                @foreach($services as $service)
                    <option
                        value="{{ $service->id}}"
                        {{ $service->id == request()->service_id ? 'selected' : null }}
                    >{{ $service->getTrans() }}</option>
                @endforeach
            </select>
        </div>
        <!--end col-->
        <div class="col-xxl-2 col-sm-2">
            <div>
                <button
                    class="btn btn-primary w-100"
                    type="submit"
                    form="filterForm"
                > <i class="ri-equalizer-fill me-1 align-bottom"></i>
                    {{ __('filters') }}
                </button>
            </div>
        </div>

        <!--end col-->
    </div>
    <!--end row-->
</form>
