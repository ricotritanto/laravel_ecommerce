@extends('layouts.ecommerce')

@section('title')
    <title> Login - Laravel Ecommerce </title>
@endsection

@section('content')
    <!----------------------------- Home Banner area ----------------------->
        <section class="banner_area">
            <div class="banner_inner dflex align-items-center">
                <div class="container">
                    <div class="banner_content text-center">
                        <h2> Login / Register </h2>
                        <div class="page_link">
                            <a href="{{url('/')}}"> Home </a>
                            <a href="{{ route ('customer.login')}}"> Login </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!----------------------------- END Home Banner area -------------------->

    <!----------------------------- Login Banner area ----------------------->
        <section class="login_box_area p_120">
            <div class="container">
                <div class="row">
                    <div class="offset-md-3 col-log-6">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                            <div class="login_form_inner">
                                <h3>Log in to enter</h3>
                                <form class="row login_form" action="{{ route('customer.post_login') }}" method="post" id="contactForm" novalidate="novalidate">
                                    @csrf
                                    <div class="col-md-12 form-group">
                                        <input type="email" name="email" id="email" placeholder="Email Address" class="form-control">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <input type="password" id="password" name="password" placeholder="******" class="form-control">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <div class="creat_account">
                                            <input type="checkbox" id="f-option2" name="remember">
                                            <label for="f-option2">Keep me logged in</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <button class="btn submit_btn" type="submit" value="submit">Log In</button>
                                        <a href="#">Forgot Password?</a>
                                    </div>                                
                                </form>
                            </div>
                    </div>
                </div>
            </div>
        </section>
@endsection
