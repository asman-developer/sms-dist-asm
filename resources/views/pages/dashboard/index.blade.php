@extends('layouts.app')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0"> {{ __('dashboard_analytics') }} </h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);"> {{ __('dashboards') }} </a></li>
                        <li class="breadcrumb-item active"> {{ __('dashboard_analytics') }} </li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col">

            <div class="h-100">
                <div class="row mb-3 pb-1">
                    <div class="col-12">
                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-16 mb-1">{{ __('welcome') }}, {{ currentStaff()?->fullName }}!</h4>
                                <p class="text-muted mb-0"> {{ __('dashboard_heres_whats_happening_today') }} </p>
                            </div>
                            <div class="mt-3 mt-lg-0">
                                <form action="javascript:void(0);">
                                    <div class="row g-3 mb-0 align-items-center">
                                        <div class="col-sm-auto">
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control border-0 dash-filter-picker shadow"
                                                    data-provider="flatpickr"
                                                    data-range-date="true"
                                                    data-date-format="d M, Y"
                                                    data-deafult-date="01 Jan 2022 to 31 Jan 2022">
                                                <div class="input-group-text bg-primary border-primary text-white">
                                                    <i class="ri-calendar-2-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                        </div><!-- end card header -->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->

                <div class="row">
                    @foreach($services as $service)
                        <div class="col-xl-3 col-md-6">
                            @include('pages.dashboard.partials.count-card', [
                                'service' => $service
                            ])
                        </div><!-- end col -->
                    @endforeach

                </div> <!-- end row-->

                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-0 align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1"></h4>
                            <div>
                                <a href="{{ route('dashboard.index', ['type' => '30-day']) }}" 
                                class="btn btn-sm @if(request()->get('type') == '30-day') {{ 'btn-soft-primary' }} @else {{ 'btn-soft-secondary' }} @endif">
                                    {{ __('dashboard_chart_last_30_day') }}
                                </a>
                                <a href="{{ route('dashboard.index', ['type' => 'today']) }}" 
                                class="btn btn-sm @if(request()->get('type') == 'today') {{ 'btn-soft-primary' }} @else {{ 'btn-soft-secondary' }} @endif">
                                    {{ __('dashboard_chart_today') }}
                                </a>
                            </div>
                        </div><!-- end card header -->

                        <div class="card-header p-0 border-0 bg-soft-light">
                            <div class="row g-0 text-center">
                                <div class="col">
                                    <div class="row">
                                    <div class="p-3 border border-dashed border-start-0 col-4">
                                        <h5 class="mb-1"><span class="counter-value" data-target="{{ $otp_messages['total_messages'] }}">{{ $otp_messages['total_messages'] }}</span></h5>
                                        <p class="text-muted mb-0">{{ __('dashboard_chart_total_otp') }}</p>
                                    </div>
                                    <div class="p-3 border border-dashed border-start-0 col-4">
                                        <h5 class="mb-1"><span class="counter-value" data-target="{{ $otp_messages['total_success_messages'] }}">{{ $otp_messages['total_success_messages'] }}</span></h5>
                                        <p class="text-muted mb-0">{{ __('dashboard_chart_send_total_otp') }}</p>
                                    </div>
                                    <div class="p-3 border border-dashed border-start-0 col-4">
                                        <h5 class="mb-1"><span class="counter-value" data-target="{{ $otp_messages['total_error_messages'] }}">{{ $otp_messages['total_error_messages'] }}</span></h5>
                                        <p class="text-muted mb-0">{{ __('dashboard_chart_unsent_total_otp') }}</p>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card header -->
                        <div class="card-body p-0 pb-2">
                            <div id="column_stacked_chart" data-colors='["--vz-success", "--vz-primary", "--vz-warning"]' class="apex-charts" dir="ltr"></div>
                        </div><!-- end card body -->
                    </div>

                </div>

            </div> <!-- end .h-100-->

        </div> <!-- end col -->
    </div>
@endsection

@once
    @push('script')
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }} "></script>
    <script>

        var options={
            series:[
                {name:"{{ __('message_status_COMPLETED') }}",data:@json($otp_messages['success_data'])},
                {name:"{{ __('message_status_PENDING') }}",data:@json($otp_messages['error_data'])},
            ],
            chart:{
                type:"bar",
                height:350,
                stacked: true,
                stackType: '100%',
                toolbar:{show:true},
                zoom:{enabled: true}
            },
            xaxis:{
                categories:@json($otp_messages['categories'])
            }
        }

        var chart = new ApexCharts(document.querySelector("#column_stacked_chart"),options);

        chart.render();
    </script>
    @endpush
@endonce
