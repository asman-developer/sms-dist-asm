<div class="card">
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1 opacity-0">qwe</h4>
        <div class="ms-2">
            <button type="submit" class="btn btn-success add-btn" data-bs-toggle="modal"
                    data-bs-target=".createModal">
                <i class="ri-add-line align-bottom me-1"></i>
                {{ __('create') }}</button>
            @include('pages.staff.partials.create-modal')
        </div>
    </div><!-- end card header -->

    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">{{ __('staffs') }}</h4>
        <form action="{{route('staff.list')}}" type="GET">
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
                        <i class="ri-search-line align-bottom me-1"></i>{{ __('search') }}
                    </button>
                </div>
            </div>
        </form>
    </div><!-- end card header -->



    <div class="card-body">
        <div class="live-preview">
            <div class="table-responsive">
                <table class="table align-middle table-nowrap mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('staff_full_name') }}</th>
                        <th>{{ __('staff_email') }}</th>
                        <th>{{ __('staff_phone') }}</th>
                        <th>{{ __('staff_role') }}</th>
                        <th>{{ __('staff_services') }}</th>
                        <th>{{ __('staff_status') }}</th>
                        <th>{{ __('action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($staffs as $staff)
                        @php
                            $modalEdit = "modalEdit{$staff->id}";
                            $deleteModal = "deleteModal{$staff->id}";
                        @endphp
                        <tr>
                            <th>{{ $staff->id }}</th>
                            <td>{{ $staff->full_name }}</td>
                            <td>{{ $staff->email }}</td>
                            <td>{{ $staff->phone }}</td>
                            <td>{{ $staff->role }}</td>
                            <td>
                                @foreach($staff->services as $service)
                                    <span class="badge badge-soft-secondary badge-border">
                                        {{ $service->getTrans() }}
                                    </span>
                                @endforeach
                            </td>
                            <td>
                                @if ($staff->status == false)
                                    <span class="badge badge-soft-warning">
                                        {{ __('inactive') }}
                                    </span>
                                @else
                                    <span class="badge badge-soft-success">
                                        {{ __('active') }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <ul class="list-inline hstack gap-2 mb-0">
                                    <li class="list-inline-item edit"
                                        data-bs-toggle="tooltip"
                                        data-bs-trigger="hover"
                                        data-bs-placement="top"
                                        data-bs-original-title="{{ __('update') }}">
                                        <a
                                            href="#"
                                            class="text-muted d-inline-block"
                                            data-bs-toggle="modal"
                                            data-bs-target=".{{ $modalEdit }}">
                                            <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                        </a>
                                        @include('pages.staff.partials.edit-modal', ['modalId' => $modalEdit, 'staff' => $staff])
                                    </li>
                                    <li class="list-inline-item edit"
                                        data-bs-toggle="tooltip"
                                        data-bs-trigger="hover"
                                        data-bs-placement="top"
                                        data-bs-original-title="{{ __('delete') }}">
                                        <a
                                            href="#"
                                            class="text-muted d-inline-block"
                                            data-bs-toggle="modal"
                                            data-bs-target=".{{ $deleteModal }}">
                                            <i class="ri-delete-bin-5-line fs-16"></i>
                                        </a>
                                        @include('components.confirm', ['modalId' => $deleteModal, 'route' => route('staff.delete', $staff->id), 'method' => 'DELETE'])
                                    </li>
                                </ul>
                            </td>
                        </tr>
{{--                        @include('components.confirm', ['modalId' => $deleteModal, 'route' => route('staff.delete', $staff->id), 'method' => 'DELETE'])--}}
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
            {{ $staffs->links('layouts.partials.paginator') }}
        </div>
    </div>
</div><!-- end card -->
