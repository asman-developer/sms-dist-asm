<div class="live-preview" wire:poll.visible.5s >
    <div class="table-responsive">
        <table class="table align-middle table-nowrap mb-0">
            <thead class="table-light">
            <tr>
                <th>{{ __('ID') }}</th>
                <th>{{ __('distribution_name') }}</th>
                <th>{{ __('distribution_service') }}</th>
                <th>{{ __('distribution_state') }}</th>
                <th>{{ __('distribution_message_count') }} / <br> {{ __('distribution_completed_count') }}</th>
                <th>{{ __('distribution_start_time') }} / <br> {{ __('distribution_end_time') }} </th>
                <th>{{ __('distribution_is_active') }}</th>
                <th>{{ __('action') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($distributions as $distribution)
                @php
                    $resend = "resend{$distribution->id}";
                    $sendUnsentModal = "sendUnsentModal{$distribution->id}";
                    $deleteModal = "deleteModal{$distribution->id}";
                    $updateStatus = "updateStatus{$distribution->id}";
                @endphp
                <tr>
                    <th>{{ $distribution->id }}</th>
                    <td>{{ $distribution->name }}</td>
                    <td>
                        <span class="badge badge-soft-secondary badge-border">
                            {{ $distribution->service->getTrans() }}
                        </span>
                    <td>
                        <span class="{{ \App\Enums\DistributionStatesEnum::fromBadgeColor($distribution->state) }}">
                            {{ \App\Enums\DistributionStatesEnum::fromValue($distribution->state) }}
                        </span>
                    </td>
                    <td>
                        {{ $distribution->message_count }} / {{ $distribution->completed_count }} <br>
                        <div class="progress" style="height: 2px;">
                            <div
                                class="progress-bar bg-info"
                                role="progressbar"
                                style="width: {{ $distribution->getCompletePercent() }}%;"
                                aria-valuenow="{{ $distribution->getCompletePercent() }}"
                                aria-valuemin="0"
                                aria-valuemax="{{ $distribution->message_count }}"
                            ></div>
                        </div>
                    </td>
                    <td>
                        {{ $distribution->start_time }} / <br> {{ $distribution->completed_at ?? " -- " }}
                    </td>
                    <td>
                        @if ($distribution->is_active == false)
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
                                data-bs-original-title="{{ __('distribution_update_status') }}">
                                <a
                                   href="#"
                                   class="text-muted d-inline-block"
                                   data-bs-toggle="modal"
                                   data-bs-target=".{{ $updateStatus }}">
                                    <i class="ri-creative-commons-sa-line fs-16"></i>
                                </a>
                                @include('components.confirm', ['modalId' => $updateStatus, 'route' => route('sms.update-status', ['id' => $distribution->id]), 'method' => 'POST'])
                            </li>

                            <li class="list-inline-item edit"
                                data-bs-toggle="tooltip"
                                data-bs-trigger="hover"
                                data-bs-placement="top"
                                data-bs-original-title="{{ __('distribution_show_all') }}">
                                <a href="{{ route('sms.list', ['distribution_id' => $distribution->id]) }}" class="text-muted d-inline-block">
                                    <i class="ri-mail-line fs-16"></i>
                                </a>
                            </li>
                            <li class="list-inline-item edit"
                                data-bs-toggle="tooltip"
                                data-bs-trigger="hover"
                                data-bs-placement="top"
                                data-bs-original-title="{{ __('distribution_show_unsent_messages') }}">
                                <a href="{{ route('sms.list', ['distribution_id' => $distribution->id, 'status' => 0]) }}" class="text-muted d-inline-block">
                                    <i class="ri-mail-close-line fs-16"></i>
                                </a>
                            </li>

                            <li class="list-inline-item edit"
                                data-bs-toggle="tooltip"
                                data-bs-trigger="hover"
                                data-bs-placement="top"
                                data-bs-original-title="{{ __('distribution_send_all') }}">
                                <a
                                    href="#"
                                    class="text-muted d-inline-block"
                                    data-bs-toggle="modal"
                                    data-bs-target=".{{ $resend }}">
                                    <i class="ri-refresh-line fs-16"></i>
                                </a>
                                @include('components.confirm', ['modalId' => $resend, 'route' => route('distribution.resend', ['id' => $distribution->id, 'type' => 'all']), 'method' => 'POST'])
                            </li>

                            <li class="list-inline-item edit"
                                data-bs-toggle="tooltip"
                                data-bs-trigger="hover"
                                data-bs-placement="top"
                                data-bs-original-title="{{ __('distribution_send_unsent_messages') }}">
                                <a
                                    href="#"
                                    class="text-muted d-inline-block"
                                    data-bs-toggle="modal"
                                    data-bs-target=".{{ $sendUnsentModal }}">
                                    <i class="ri-mail-send-line fs-16"></i>
                                </a>
                                @include('components.confirm', ['modalId' => $sendUnsentModal, 'route' => route('distribution.resend', ['id' => $distribution->id, 'type' => 'unsent']), 'method' => 'POST'])
                            </li>

                            <li class="list-inline-item edit"
                                data-bs-toggle="tooltip"
                                data-bs-trigger="hover"
                                data-bs-placement="top"
                                data-bs-original-title="{{ __('distribution_delete') }}">
                                <a
                                    href="#"
                                    class="text-muted d-inline-block"
                                    data-bs-toggle="modal"
                                    data-bs-target=".{{ $deleteModal }}">
                                    <i class="ri-delete-bin-5-line fs-16"></i>
                                </a>
                                @include('components.confirm', ['modalId' => $deleteModal, 'route' => route('distribution.delete', $distribution->id), 'method' => 'DELETE'])
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
