@extends('layouts.cover')

@section('content')
    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100">
                                        <div class="bg-white"></div>
                                        <div class="d-flex align-center h-100">
{{--                                            <img class="position-relative img-fluid" src="{{ asset('assets/images/asmanshop-dark.svg') }}" alt="" height="18">--}}
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-primary"> {{ __('welcome') }} </h5>
                                            <p class="text-muted"> {{ __('auth_sign_in_to_continue') }} </p>
                                        </div>

                                        <div class="mt-4">
                                            <form
                                                method="POST"
                                                action="{{ route('auth.login') }}"
                                            >
                                                @csrf()
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label"> {{ __('auth_phone') }} </label>
                                                    <input
                                                        id="phone"
                                                        name="phone"
                                                        type="number"
                                                        value="{{ old('phone') }}"
                                                        class="form-control @error('phone') {{ 'is-invalid' }} @enderror"
                                                        placeholder="{{ __('auth_enter_phone') }}"
                                                        required="true"
                                                    >
                                                    @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input"> {{ __('auth_password') }} </label>
                                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                                        <input
                                                            id="password"
                                                            name="password"
                                                            type="password"
                                                            value="{{ old('password') }}"
                                                            class="form-control pe-5 @error('password') {{ 'is-invalid' }} @enderror"
                                                            placeholder="{{ __('auth_enter_password') }}"
                                                            required="required"
                                                            id="password-input"
                                                        >
                                                        @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="password-addon">
                                                            <i class="ri-eye-fill align-middle"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="mt-4">
                                                    <button class="btn btn-success w-100" type="submit"> {{ __('auth_sign_in') }} </button>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
    @include('pages.auth.partials.footer')
    <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->
@endsection
