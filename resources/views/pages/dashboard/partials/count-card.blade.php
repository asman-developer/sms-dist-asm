<!-- card -->
<div class="card card-animate">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div class="flex-grow-1 overflow-hidden">
                <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> {{ $service->getTrans() }} </p>
            </div>
            <div class="flex-shrink-0">
                <h5 class="text-success fs-14 mb-0">
                    <!-- <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +29.08 % -->
                </h5>
            </div>
        </div>
        <div class="mt-3 pt-2">

            <div class="d-flex mb-2">
                <div class="flex-grow-1">
                    <p class="text-truncate text-muted fs-14 mb-0 d-flex align-items-center">
                        <i class="ri-mail-line text-primary me-2"></i>
                        {{ __("dashboard_all_messages") }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <p class="mb-0">{{ $service->messages()->whereDate('created_at', now()->today())->count() }}</p>
                </div>
            </div>

            <div class="d-flex mb-2">
                <div class="flex-grow-1">
                    <p class="text-truncate text-muted fs-14 mb-0 d-flex align-items-center">
                        <i class="ri-mail-close-line text-danger me-2"></i>
                        {{ __("dashboard_unsent_messages") }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <p class="mb-0">{{ $service->messages()->whereDate('created_at', now()->today())->whereStatus(0)->count() }}</p>
                </div>
            </div>

            <div class="d-flex mb-2">
                <div class="flex-grow-1">
                    <p class="text-truncate text-muted fs-14 mb-0 d-flex align-items-center">
                        <i class="ri-mail-check-line text-success me-2"></i>
                        {{ __("dashboard_send_messages") }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <p class="mb-0">{{ $service->messages()->whereDate('created_at', now()->today())->whereStatus(1)->count() }}</p>
                </div>
            </div>
            <div class="d-flex mb-2">
                <div class="flex-grow-1">
                    <p class="text-truncate text-muted fs-14 mb-0 d-flex align-items-center">
                        <i class="ri-mail-download-line text-warning me-2"></i>
                        {{ __("dashboard_received_messages") }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <p class="mb-0">{{ $service->messages()->whereDate('created_at', now()->today())->whereType(\App\Enums\SmsTypeEnum::INBOX->value)->count() }}</p>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-end justify-content-between mt-4">
            <div>
                <a href="{{ route('sms.list', ['service_id' => $service->id]) }}" class="text-decoration-underline"> {{ __('dashboard_see_details') }} </a>
            </div>
            <div class="avatar-sm flex-shrink-0">
            </div>
        </div>
    </div><!-- end card body -->
</div><!-- end card -->
