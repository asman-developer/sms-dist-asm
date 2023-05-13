@extends('layouts.app')
@section('content')
    <div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 opacity-0">qwe</h4>
                    <div class="page-title-right">
                        @include('components.breadcrumbs', [
                            'title' => __('message_all'),
                            'li_1' => __('messages')
                        ])
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                @include('pages.sms.partials.list', [
                    'messages' => $messages
                ])
            </div><!-- end col -->
        </div>
    </div>
@endsection
