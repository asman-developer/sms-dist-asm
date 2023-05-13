<div class="card">

    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">{{ __('message_all') }}</h4>
        <form action="{{route('sms.list')}}" type="GET">
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


    <div class="card-body border border-dashed border-end-0 border-start-0">
        @include('pages.sms.partials.filters',[
            'services' => $services
        ])
    </div>

    <div class="card-body">
        <div class="live-preview">
            <div class="table-responsive">
                <table class="table align-middle table-nowrap mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('message_service') }}</th>
                        <th>{{ __('message_phone') }}</th>
                        <th>{{ __('message_status') }}</th>
                        <th>{{ __('message_tries') }}</th>
                        <th>{{ __('message_process_number') }}</th>
                        <th>{{ __('message_type') }}</th>
                        <th>{{ __('message_completed_at') }}</th>
                        <th>{{ __('message_created_at') }}</th>
                        <th>{{ __('action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($messages as $message)
                        @php $resend = "resend{$message->id}"; @endphp
                        <tr>
                            <th>{{ $message->id }}</th>
                            <td>
                                <span class="badge badge-soft-secondary badge-border">
                                    {{ $message->service->getTrans() }}
                                </span>
                            </td>
                            <td>{{ $message->phone }} </td>
                            <td>
                                @if ($message->status == 0)
                                    <span class="badge badge-soft-warning">
                                        {{ __('message_status_PENDING') }}
                                    </span>
                                @else
                                    <span class="badge badge-soft-success">
                                        {{ __('message_status_COMPLETED') }}
                                    </span>
                                @endif

                            </td>
                            <td>{{ $message->tries }}</td>
                            <td>{{ $message->usb?->phone }}</td>
                            <td>
                                <span class="badge badge-soft-dark">
                                    @if ($message->type == 0)
                                        <i class="ri-inbox-unarchive-line fs-16"></i>
                                    @else
                                        <i class="ri-inbox-archive-line fs-16"></i>
                                    @endif
                                </span>
                            </td>
                            <td>{{ $message->completed_at }}</td>
                            <td>{{ $message->created_at }}</td>
                            <td>
                                <ul class="list-inline hstack gap-2 mb-0">
                                    <li class="list-inline-item edit"
                                        data-bs-toggle="tooltip"
                                        data-bs-trigger="hover"
                                        data-bs-placement="top"
                                        data-bs-original-title="{{ __('message_resend') }}">
                                        <a
                                            href="#"
                                            class="text-muted d-inline-block"
                                            data-bs-toggle="modal"
                                            data-bs-target=".{{ $resend }}">
                                            <i class="ri-refresh-line fs-16"></i>
                                        </a>
                                        @include('components.confirm', ['modalId' => $resend, 'route' => route('sms.resend', ['id' => $message->id]), 'method' => 'POST'])
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!-- end table -->
            </div>
            <!-- end table responsive -->
        </div>
    </div><!-- end card-body -->
    <div class="card-footer">
        <div class="d-flex justify-content-end">
            {{ $messages->links('layouts.partials.paginator') }}
        </div>
    </div>

</div><!-- end card -->
