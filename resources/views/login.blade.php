@extends('layout')

@section('title', 'Classic - Login')

@section('content')

<section class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-light py-4">

    <div class="container">

        <div class="row g-0 shadow-lg rounded-4 overflow-hidden bg-white"
             style="min-height: 650px;">

            {{-- ================================================= --}}
            {{-- LEFT SIDE - LOGIN --}}
            {{-- ================================================= --}}

            <div class="col-lg-6 d-flex align-items-center bg-white">

                <div class="w-100 px-4 px-md-5 py-5">

                    <div class="mx-auto" style="max-width: 430px;">

                        {{-- LOGO / BRAND --}}

                        <div class="text-center mb-4">

                            <div class="d-inline-flex align-items-center justify-content-center
                                        rounded-circle shadow-sm mb-3"
                                 style="
                                    width:65px;
                                    height:65px;
                                    background-color:#f3f9e9;
                                 ">

                                <i class="fa-solid fa-glasses fs-3"
                                   style="color:#8cc63f;"></i>

                            </div>

                            <h4 class="fw-bold text-dark mb-1">
                                Classic
                            </h4>

                            <p class="text-muted small mb-0">
                                Premium Eyewear
                            </p>

                        </div>


                        {{-- HEADING --}}

                        <div class="mb-4">

                            <span class="badge rounded-pill text-white px-3 py-2 mb-3"
                                  style="
                                    background-color:#8cc63f;
                                    font-size:0.65rem;
                                    letter-spacing:1.5px;
                                  ">

                                WELCOME BACK

                            </span>

                            <h1 class="fw-bold text-dark mb-2"
                                style="font-size:2rem;">

                                Sign in to your account

                            </h1>

                            <p class="text-muted small mb-0">

                                Welcome back! Please enter your details
                                to continue shopping.

                            </p>

                        </div>


                        {{-- SUCCESS MESSAGE --}}

                        @if(session('success'))

                            <div class="alert alert-success border-0 rounded-3 small shadow-sm">

                                <i class="fa-solid fa-circle-check me-2"></i>

                                {{ session('success') }}

                            </div>

                        @endif


                        {{-- ERROR MESSAGE --}}

                        @if($errors->any())

                            <div class="alert alert-danger border-0 rounded-3 small shadow-sm">

                                <div class="fw-semibold mb-1">

                                    <i class="fa-solid fa-circle-exclamation me-2"></i>

                                    Please check the following:

                                </div>

                                <ul class="mb-0 ps-4">

                                    @foreach($errors->all() as $error)

                                        <li>
                                            {{ $error }}
                                        </li>

                                    @endforeach

                                </ul>

                            </div>

                        @endif


                        {{-- LOGIN FORM --}}

                        <form action="{{ route('login.store') }}"
                              method="POST"
                              autocomplete="off">

                            @csrf


                            {{-- EMAIL --}}

                            <div class="mb-4">

                                <label class="form-label fw-semibold small text-dark">

                                    Email Address

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text border-0 bg-light px-3">

                                        <i class="fa-regular fa-envelope"
                                           style="color:#8cc63f;"></i>

                                    </span>

                                    <input
                                        type="email"
                                        name="email"
                                        value=""
                                        class="form-control border-0 bg-light shadow-none py-3"
                                        placeholder="Enter your email address"
                                        autocomplete="off"
                                        autocapitalize="none"
                                        spellcheck="false"
                                        required
                                    >

                                </div>

                            </div>


                            {{-- PASSWORD --}}

                            <div class="mb-3">

                                <div class="d-flex justify-content-between align-items-center">

                                    <label class="form-label fw-semibold small text-dark mb-2">

                                        Password

                                    </label>

                                    <a href="#"
                                       class="text-decoration-none small fw-semibold mb-2"
                                       style="color:#8cc63f;">

                                        Forgot password?

                                    </a>

                                </div>


                                <div class="input-group">

                                    <span class="input-group-text border-0 bg-light px-3">

                                        <i class="fa-solid fa-lock"
                                           style="color:#8cc63f;"></i>

                                    </span>

                                    <input
                                        type="password"
                                        name="password"
                                        value=""
                                        class="form-control border-0 bg-light shadow-none py-3"
                                        placeholder="Enter your password"
                                        autocomplete="new-password"
                                        required
                                    >

                                </div>

                            </div>


                            {{-- REMEMBER ME --}}

                            <div class="d-flex justify-content-between align-items-center mb-4">

                                <div class="form-check">

                                    <input
                                        type="checkbox"
                                        class="form-check-input shadow-none"
                                        id="rememberMe"
                                        name="remember"
                                    >

                                    <label
                                        class="form-check-label text-muted small"
                                        for="rememberMe"
                                    >

                                        Remember me

                                    </label>

                                </div>

                            </div>


                            {{-- LOGIN BUTTON --}}

                            <div class="d-grid mb-4">

                                <button
                                    type="submit"
                                    class="btn text-white rounded-3 py-3 fw-bold shadow-sm"
                                    style="
                                        background-color:#8cc63f;
                                        border:0;
                                    "
                                >

                                    Sign In

                                    <i class="fa-solid fa-arrow-right ms-2"></i>

                                </button>

                            </div>


                            {{-- DIVIDER --}}

                            <div class="d-flex align-items-center mb-4">

                                <div class="flex-grow-1 border-top"></div>

                                <span class="px-3 text-muted small">
                                    OR
                                </span>

                                <div class="flex-grow-1 border-top"></div>

                            </div>


                            {{-- REGISTER --}}

                            <div class="text-center">

                                <p class="text-muted small mb-0">

                                    Don't have an account?

                                    <a href="{{ route('register') }}"
                                       class="fw-bold text-decoration-none"
                                       style="color:#8cc63f;">

                                        Create an account

                                    </a>

                                </p>

                            </div>

                        </form>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- RIGHT SIDE - IMAGE --}}
            {{-- ================================================= --}}

            <div class="col-lg-6 d-none d-lg-block position-relative overflow-hidden">

                <img
                    src="https://images.unsplash.com/photo-1574258495973-f010dfbb5371?auto=format&fit=crop&w=1400&q=85"
                    alt="Premium Eyewear"
                    class="w-100 h-100 position-absolute object-fit-cover"
                >


                {{-- DARK OVERLAY --}}

                <div class="position-absolute top-0 start-0 w-100 h-100"
                     style="background:rgba(0,0,0,0.48);">
                </div>


                {{-- RIGHT CONTENT --}}

                <div class="position-absolute top-0 start-0 w-100 h-100
                            d-flex flex-column justify-content-between
                            p-4 p-xl-5 text-white">

                    {{-- TOP --}}

                    <div class="d-flex justify-content-between align-items-center">

                        <div class="d-flex align-items-center">

                            <div class="rounded-circle bg-white d-flex
                                        align-items-center justify-content-center me-2"
                                 style="width:42px;height:42px;">

                                <i class="fa-solid fa-glasses"
                                   style="color:#8cc63f;"></i>

                            </div>

                            <span class="fw-bold">
                                Classic
                            </span>

                        </div>

                        <span class="badge rounded-pill px-3 py-2"
                              style="background-color:#8cc63f;">

                            PREMIUM

                        </span>

                    </div>


                    {{-- BOTTOM CONTENT --}}

                    <div>

                        <span class="badge rounded-pill px-3 py-2 mb-3"
                              style="
                                background-color:#8cc63f;
                                font-size:0.65rem;
                                letter-spacing:1.5px;
                              ">

                            CLASSIC EYEWEAR

                        </span>


                        <h2 class="display-5 fw-bold text-white mb-3">

                            See the world
                            <br>

                            <span style="color:#b8e47b;">
                                differently.

                            </span>

                        </h2>


                        <p class="text-white-50 mb-4"
                           style="max-width:450px;">

                            Discover stylish frames, crystal-clear lenses
                            and eyewear designed to match your personality.

                        </p>


                        {{-- FEATURES --}}

                        <div class="row g-2">

                            <div class="col-sm-4">

                                <div class="bg-white bg-opacity-10
                                            rounded-3 p-3">

                                    <i class="fa-solid fa-eye mb-2"
                                       style="color:#b8e47b;"></i>

                                    <div class="small fw-semibold">
                                        Clear Vision
                                    </div>

                                </div>

                            </div>


                            <div class="col-sm-4">

                                <div class="bg-white bg-opacity-10
                                            rounded-3 p-3">

                                    <i class="fa-solid fa-star mb-2"
                                       style="color:#b8e47b;"></i>

                                    <div class="small fw-semibold">
                                        Premium Quality
                                    </div>

                                </div>

                            </div>


                            <div class="col-sm-4">

                                <div class="bg-white bg-opacity-10
                                            rounded-3 p-3">

                                    <i class="fa-solid fa-truck-fast mb-2"
                                       style="color:#b8e47b;"></i>

                                    <div class="small fw-semibold">
                                        Fast Delivery
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection