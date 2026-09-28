
@extends('layout')

@section('title', 'Classic - Register')

@section('content')

<section class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-light py-4">

    <div class="container">

        <div class="row g-0 bg-white rounded-4 overflow-hidden shadow-lg"
             style="min-height:680px;">

            {{-- ================================================= --}}
            {{-- LEFT SIDE - REGISTER FORM --}}
            {{-- ================================================= --}}

            <div class="col-lg-7 d-flex align-items-center">

                <div class="w-100 px-4 px-md-5 py-5">

                    <div class="mx-auto" style="max-width:560px;">

                        {{-- BRAND --}}

                        <div class="d-flex align-items-center mb-4">

                            <div class="d-flex align-items-center justify-content-center
                                        rounded-circle me-3"
                                 style="
                                    width:52px;
                                    height:52px;
                                    background-color:#f1f8e8;
                                 ">

                                <i class="fa-solid fa-glasses fs-4"
                                   style="color:#8cc63f;"></i>

                            </div>

                            <div>

                                <h5 class="fw-bold text-dark mb-0">
                                    Registration
                                </h5>

                                <small class="text-muted">
                                    Classic Eyewear
                                </small>

                            </div>

                        </div>


                        {{-- HEADING --}}

                        <div class="mb-4">

                            <span class="badge rounded-pill text-white px-3 py-2 mb-3"
                                  style="
                                    background-color:#8cc63f;
                                    font-size:0.65rem;
                                    letter-spacing:1.5px;
                                  ">

                                JOIN THE COMMUNITY

                            </span>

                            <h1 class="fw-bold text-dark mb-2"
                                style="font-size:2rem;">

                                Create your account

                            </h1>

                            <p class="text-muted small mb-0">

                                Create your Seemy account and discover
                                eyewear that matches your style.

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


                        {{-- REGISTER FORM --}}

                        <form action="{{ route('register.store') }}"
                              method="POST"
                              autocomplete="off">

                            @csrf


                            {{-- FIRST NAME + LAST NAME --}}

                            <div class="row g-3 mb-3">

                                <div class="col-md-6">

                                    <label class="form-label small fw-semibold text-dark">

                                        First Name

                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text border-0 bg-light px-3">

                                            <i class="fa-regular fa-user"
                                               style="color:#8cc63f;"></i>

                                        </span>

                                        <input
                                            type="text"
                                            name="first_name"
                                            value=""
                                            class="form-control border-0 bg-light shadow-none py-3"
                                            placeholder="Enter first name"
                                            autocomplete="off"
                                            autocapitalize="words"
                                            spellcheck="false"
                                            required
                                        >

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label small fw-semibold text-dark">

                                        Last Name

                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text border-0 bg-light px-3">

                                            <i class="fa-regular fa-user"
                                               style="color:#8cc63f;"></i>

                                        </span>

                                        <input
                                            type="text"
                                            name="last_name"
                                            value=""
                                            class="form-control border-0 bg-light shadow-none py-3"
                                            placeholder="Enter last name"
                                            autocomplete="off"
                                            autocapitalize="words"
                                            spellcheck="false"
                                            required
                                        >

                                    </div>

                                </div>

                            </div>


                            {{-- EMAIL + PHONE --}}

                            <div class="row g-3 mb-3">

                                <div class="col-md-7">

                                    <label class="form-label small fw-semibold text-dark">

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
                                            placeholder="Enter your email"
                                            autocomplete="off"
                                            autocapitalize="none"
                                            spellcheck="false"
                                            required
                                        >

                                    </div>

                                </div>


                                <div class="col-md-5">

                                    <label class="form-label small fw-semibold text-dark">

                                        Phone Number

                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text border-0 bg-light px-3">

                                            <i class="fa-solid fa-phone"
                                               style="color:#8cc63f;"></i>

                                        </span>

                                        <input
                                            type="tel"
                                            name="phone"
                                            value=""
                                            class="form-control border-0 bg-light shadow-none py-3"
                                            placeholder="+91 00000 00000"
                                            autocomplete="off"
                                            inputmode="tel"
                                        >

                                    </div>

                                </div>

                            </div>


                            {{-- PASSWORD + CONFIRM PASSWORD --}}

                            <div class="row g-3 mb-3">

                                <div class="col-md-6">

                                    <label class="form-label small fw-semibold text-dark">

                                        Password

                                    </label>

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
                                            placeholder="Create password"
                                            autocomplete="new-password"
                                            required
                                        >

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label small fw-semibold text-dark">

                                        Confirm Password

                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text border-0 bg-light px-3">

                                            <i class="fa-solid fa-shield-halved"
                                               style="color:#8cc63f;"></i>

                                        </span>

                                        <input
                                            type="password"
                                            name="password_confirmation"
                                            value=""
                                            class="form-control border-0 bg-light shadow-none py-3"
                                            placeholder="Confirm password"
                                            autocomplete="new-password"
                                            required
                                        >

                                    </div>

                                </div>

                            </div>


                            {{-- TERMS --}}

                            <div class="mb-4 form-check">

                                <input
                                    type="checkbox"
                                    class="form-check-input shadow-none"
                                    id="termsCheck"
                                    required
                                >

                                <label
                                    class="form-check-label text-muted small"
                                    for="termsCheck"
                                >

                                    I agree to the

                                    <a href="#"
                                       class="fw-semibold text-decoration-none"
                                       style="color:#8cc63f;">

                                        Terms & Conditions

                                    </a>

                                    and Privacy Policy

                                </label>

                            </div>


                            {{-- CREATE ACCOUNT BUTTON --}}

                            <div class="d-grid mb-4">

                                <button
                                    type="submit"
                                    class="btn text-white rounded-3 py-3 fw-bold shadow-sm"
                                    style="
                                        background-color:#8cc63f;
                                        border:0;
                                    "
                                >

                                    Create My Account

                                    <i class="fa-solid fa-arrow-right ms-2"></i>

                                </button>

                            </div>


                            {{-- LOGIN LINK --}}

                            <div class="text-center">

                                <p class="text-muted small mb-0">

                                    Already have an account?

                                    <a href="{{ route('login') }}"
                                       class="fw-bold text-decoration-none"
                                       style="color:#8cc63f;">

                                        Sign in

                                    </a>

                                </p>

                            </div>

                        </form>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- RIGHT SIDE - PREMIUM IMAGE --}}
            {{-- ================================================= --}}

            <div class="col-lg-5 d-none d-lg-block position-relative overflow-hidden">

                <img
                    src="https://images.unsplash.com/photo-1591076482161-42ce6da69f67?auto=format&fit=crop&w=1400&q=85"
                    alt="Premium Eyewear"
                    class="w-100 h-100 position-absolute object-fit-cover"
                >


                {{-- IMAGE OVERLAY --}}

                <div class="position-absolute top-0 start-0 w-100 h-100"
                     style="background:rgba(0,0,0,0.50);">
                </div>


                {{-- IMAGE CONTENT --}}

                <div class="position-absolute top-0 start-0 w-100 h-100
                            d-flex flex-column justify-content-between
                            p-4 p-xl-5 text-white">


                    {{-- TOP BRAND --}}

                    <div class="d-flex justify-content-between align-items-center">

                        <div class="d-flex align-items-center">

                            <div class="bg-white rounded-circle
                                        d-flex align-items-center
                                        justify-content-center me-2"
                                 style="width:42px;height:42px;">

                                <i class="fa-solid fa-glasses"
                                   style="color:#8cc63f;"></i>

                            </div>

                            <span class="fw-bold text-white">

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

                            EXCLUSIVE BENEFITS

                        </span>


                        <h2 class="display-5 fw-bold text-white mb-3">

                            Your vision.
                            <br>

                            <span style="color:#b8e47b;">

                                Your style.

                            </span>

                        </h2>


                        <p class="text-white-50 small mb-4"
                           style="max-width:400px;">

                            Join Seemy and discover premium eyewear,
                            personalized recommendations and exclusive
                            offers designed just for you.

                        </p>


                        {{-- BENEFITS --}}

                        <div class="d-flex flex-column gap-3">

                            <div class="d-flex align-items-center">

                                <div class="rounded-circle d-flex
                                            align-items-center justify-content-center
                                            me-3"
                                     style="
                                        width:38px;
                                        height:38px;
                                        background-color:rgba(140,198,63,0.2);
                                     ">

                                    <i class="fa-solid fa-eye"
                                       style="color:#b8e47b;"></i>

                                </div>

                                <div>

                                    <div class="small fw-bold text-white">

                                        Personalized Eyewear

                                    </div>

                                    <div class="small text-white-50">

                                        Frames made for your style

                                    </div>

                                </div>

                            </div>


                            <div class="d-flex align-items-center">

                                <div class="rounded-circle d-flex
                                            align-items-center justify-content-center
                                            me-3"
                                     style="
                                        width:38px;
                                        height:38px;
                                        background-color:rgba(140,198,63,0.2);
                                     ">

                                    <i class="fa-solid fa-tag"
                                       style="color:#b8e47b;"></i>

                                </div>

                                <div>

                                    <div class="small fw-bold text-white">

                                        Exclusive Offers

                                    </div>

                                    <div class="small text-white-50">

                                        Special deals for members

                                    </div>

                                </div>

                            </div>


                            <div class="d-flex align-items-center">

                                <div class="rounded-circle d-flex
                                            align-items-center justify-content-center
                                            me-3"
                                     style="
                                        width:38px;
                                        height:38px;
                                        background-color:rgba(140,198,63,0.2);
                                     ">

                                    <i class="fa-solid fa-truck-fast"
                                       style="color:#b8e47b;"></i>

                                </div>

                                <div>

                                    <div class="small fw-bold text-white">

                                        Easy Shopping

                                    </div>

                                    <div class="small text-white-50">

                                        Fast and reliable delivery

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

