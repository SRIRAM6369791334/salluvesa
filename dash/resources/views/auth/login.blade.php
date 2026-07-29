@extends('layouts.master-without_nav')

@section('title')
    Saaluvesa | @lang('translation.Login')
@endsection

@section('content')
    <div class="authentication-bg min-vh-100">
        <div class="bg-overlay" style="background-color: #9ddbdd"></div>
        <div class="container">
            <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                <div class="row justify-content-center my-auto">
                    <div class="col-md-8 col-lg-6 col-xl-5">

                        <div class="text-center mb-4">
                            <a href="/">
                                <img src="{{ URL::asset('assets/images/Saaluvesa_log_trans.png') }}" alt=""
                                    style="width: 150px">

                            </a>
                        </div>

                        <div class="card">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p class="text-muted">Sign in to continue to Saaluvesa.</p>
                                </div>
                                <div class="p-2 mt-4">
                                    @if (Session::has('success'))
                                        <div class="alert alert-success text-center">
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif
                                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                                        @csrf

                                        <div class="mb-3">
                                            <label class="form-label" for="username">Email</label>
                                            <input name="email" type="email" id="useremail"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}" placeholder="Enter Email" autocomplete="email"
                                                autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            {{-- <div class="float-end">
                                                @if (Route::has('password.request'))
                                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                                        {{ __('Forgot Password?') }}
                                                    </a>
                                                @endif
                                            </div> --}}
                                            <label class="form-label" for="userpassword">Password</label>
                                            <div class="password-input-container">
                                                <input type="password" name="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="userpassword" value="" data-toggle="password"
                                                    placeholder="Enter password" aria-label="Password"
                                                    aria-describedby="password-addon" maxlength="10">
                                                <span class="password-toggle-icon" title="Show/Hide Password">
                                                    <i class="fa fa-fw fa-eye password-toggle-icon-show"></i>
                                                    <i class="fa fa-fw fa-eye-slash password-toggle-icon-hide"></i>
                                                </span>
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                        {{-- <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember"> Remember me </label>
                                        </div> --}}

                                        <div class="mt-3 text-center">
                                            <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">Log
                                                In</button>
                                        </div>

                                        {{-- <div class="mt-4 text-center">
                                        <div class="signin-other-title">
                                            <h5 class="font-size-14 mb-3 title">Sign in with</h5>
                                        </div>

                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <a href="javascript:void()" class="social-list-item bg-primary text-white border-primary">
                                                    <i class="mdi mdi-facebook"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void()" class="social-list-item bg-info text-white border-info">
                                                    <i class="mdi mdi-twitter"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void()" class="social-list-item bg-danger text-white border-danger">
                                                    <i class="mdi mdi-google"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div> --}}

                                        {{-- <div class="mt-4 text-center">
                                            <p class="mb-0">Do not have an account ? <a href="{{ url('register') }}"
                                                    class="fw-medium text-primary"> Signup
                                                    now </a> </p>
                                        </div> --}}
                                    </form>
                                </div>

                            </div>
                        </div>

                    </div><!-- end col -->
                </div><!-- end row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center   p-4" style="color:white">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> Saaluvesa. Developed with <i class="mdi mdi-heart text-danger"></i>
                            by
                            Sai Techno Solutions.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- end container -->
    </div>
@endsection


@section('script')
    <script src="{{ URL::asset('assets/js/app/LoginPage.js') }}"></script>
@endsection
