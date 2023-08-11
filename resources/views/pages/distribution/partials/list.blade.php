<div class="card">
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1 opacity-0">qwe</h4>
        <div class="ms-2">
            <button type="button" class="btn btn-success add-btn"
                    data-bs-toggle="modal"
                    data-bs-target=".createModal">
                <i class="ri-add-line align-bottom me-1"></i>
                {{ __('create') }}</button>
            @include('pages.distribution.partials.create-modal')
        </div>
    </div>
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">{{ __('distribution_all') }}</h4>
        <form action="{{route('distribution.list')}}" type="GET">
            <div class="d-flex justify-content-sm-end">
                <div class="search-box ms-2">
                    <input
                        name="q"
                        type="text"
                        autocomplete="off"
                        class="form-control search"
                        placeholder="{{ __('search') }}..."
                        value="{{ request()->q }}"
                    >
                    <i class="ri-search-line search-icon"></i>
                </div>
                <div class="ms-2">
                    <button type="submit" class="btn btn-success add-btn">
                        <i class="ri-search-line align-bottom me-1"></i>
                        {{ __('search') }}</button>
                </div>
            </div>
        </form>
    </div><!-- end card header -->



    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger alert-border-left alert-dismissible fade show" role="alert">
            <i class="ri-notification-off-line me-3 align-middle"></i> <strong>Error</strong>
            {{ __(session()->get('fail')) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <livewire:distributions.list-distribution />
    </div><!-- end card-body -->
    <div class="card-footer">
        <div class="d-flex justify-content-end">
            {{ $distributions->links('layouts.partials.paginator') }}
        </div>
    </div>

</div><!-- end card -->
