
@extends('layout')

@section('title', 'Classic - Admin Login')

@section('content')

<section class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-light py-4">

    <div class="container">

        <div class="row g-0 bg-white rounded-4 overflow-hidden shadow-lg"
             style="min-height:650px;">


            {{-- ================================================= --}}
            {{-- LEFT SIDE - ADMIN LOGIN --}}
            {{-- ================================================= --}}

            <div class="col-lg-6 d-flex align-items-center">

                <div class="w-100 px-4 px-md-5 py-5">

                    <div class="mx-auto" style="max-width:450px;">


                        {{-- BRAND --}}

                        <div class="d-flex align-items-center mb-5">

                            <div class="d-flex align-items-center justify-content-center
                                        rounded-circle me-3"
                                 style="
                                    width:54px;
                                    height:54px;
                                    background-color:#f1f8e8;
                                 ">

                                <i class="fa-solid fa-glasses fs-4"
                                   style="color:#8cc63f;"></i>

                            </div>

                            <div>

                                <h5 class="fw-bold text-dark mb-0">
                                    Classic
                                </h5>

                                <small class="text-muted">
                                    Admin Control Center
                                </small>

                            </div>

                        </div>


                        {{-- HEADER --}}

                        <div class="mb-4">

                            <span class="badge rounded-pill text-white px-3 py-2 mb-3"
                                  style="
                                    background-color:#8cc63f;
                                    font-size:0.65rem;
                                    letter-spacing:1.5px;
                                  ">

                                RESTRICTED ACCESS

                            </span>


                            <h1 class="fw-bold text-dark mb-2"
                                style="font-size:2rem;">

                                Welcome, Admin

                            </h1>


                            <p class="text-muted small mb-0">

                                Sign in to securely manage your Seemy
                                store, products and customer orders.

                            </p>

                        </div>


                        {{-- SECURITY NOTICE --}}

                        <div class="d-flex align-items-center rounded-3 p-3 mb-4"
                             style="background-color:#f7faF3;">

                            <div class="rounded-circle d-flex align-items-center
                                        justify-content-center me-3"
                                 style="
                                    width:40px;
                                    height:40px;
                                    background-color:#e8f4d8;
                                 ">

                                <i class="fa-solid fa-shield-halved"
                                   style="color:#8cc63f;"></i>

                            </div>

                            <div>

                                <div class="small fw-bold text-dark">

                                    Secure Admin Access

                                </div>

                                <div class="small text-muted">

                                    Authorized personnel only

                                </div>

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- ADMIN LOGIN FORM --}}
                        {{-- ================================================= --}}

                        <form action="{{ route('admin.login.submit') }}"
                              method="POST"
                              autocomplete="off">

                            @csrf


                            {{-- ADMIN EMAIL --}}

                            <div class="mb-4">

                                <label class="form-label small fw-semibold text-dark">

                                    Admin Email

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text border-0 bg-light px-3">

                                        <i class="fa-solid fa-user-shield"
                                           style="color:#8cc63f;"></i>

                                    </span>

                                    <input
                                        type="email"
                                        name="email"
                                        value=""
                                        class="form-control border-0 bg-light shadow-none py-3"
                                        placeholder="Enter admin email"
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

                                    <label class="form-label small fw-semibold text-dark mb-2">

                                        Security Password

                                    </label>


                                    <a href="#"
                                       class="text-decoration-none small fw-semibold mb-2"
                                       style="color:#8cc63f;">

                                        Reset key?

                                    </a>

                                </div>


                                <div class="input-group">

                                    <span class="input-group-text border-0 bg-light px-3">

                                        <i class="fa-solid fa-key"
                                           style="color:#8cc63f;"></i>

                                    </span>

                                    <input
                                        type="password"
                                        name="password"
                                        value=""
                                        class="form-control border-0 bg-light shadow-none py-3"
                                        placeholder="Enter security password"
                                        autocomplete="new-password"
                                        required
                                    >

                                </div>

                            </div>


                            {{-- ADMIN ERROR --}}

                            @if(session('admin_error'))

                                <div class="alert alert-danger border-0 rounded-3 small shadow-sm">

                                    <i class="fa-solid fa-circle-exclamation me-2"></i>

                                    {{ session('admin_error') }}

                                </div>

                            @endif


                            {{-- VALIDATION ERROR --}}

                            @if($errors->any())

                                <div class="alert alert-danger border-0 rounded-3 small shadow-sm">

                                    <i class="fa-solid fa-triangle-exclamation me-2"></i>

                                    {{ $errors->first() }}

                                </div>

                            @endif


                            {{-- REMEMBER SESSION --}}

                            <div class="mb-4 form-check">

                                <input
                                    type="checkbox"
                                    class="form-check-input shadow-none"
                                    id="secureSession"
                                    name="remember"
                                >

                                <label
                                    class="form-check-label text-muted small"
                                    for="secureSession"
                                >

                                    Keep session secure on this device

                                </label>

                            </div>


                            {{-- ACCESS DASHBOARD --}}

                            <div class="d-grid mb-4">

                                <button
                                    type="submit"
                                    class="btn text-white rounded-3 py-3 fw-bold shadow-sm"
                                    style="
                                        background-color:#8cc63f;
                                        border:0;
                                    "
                                >

                                    Access Dashboard

                                    <i class="fa-solid fa-arrow-right ms-2"></i>

                                </button>

                            </div>


                            {{-- RETURN TO STORE --}}

                            <div class="text-center">

                                <a href="/"
                                   class="text-muted small text-decoration-none">

                                    <i class="fa-solid fa-arrow-left me-1"></i>

                                    Return to store frontend

                                </a>

                            </div>

                        </form>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- RIGHT SIDE - ADMIN VISUAL --}}
            {{-- ================================================= --}}

            <div class="col-lg-6 d-none d-lg-block position-relative overflow-hidden">


                <img
                    src="https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&w=1400&q=85"
                    alt="Seemy Admin Dashboard"
                    class="w-100 h-100 position-absolute object-fit-cover"
                >


                {{-- DARK OVERLAY --}}

                <div class="position-absolute top-0 start-0 w-100 h-100"
                     style="background:rgba(0,0,0,0.63);">
                </div>


                {{-- RIGHT CONTENT --}}

                <div class="position-absolute top-0 start-0 w-100 h-100
                            d-flex flex-column justify-content-between
                            p-4 p-xl-5 text-white">


                    {{-- TOP BRAND --}}

                    <div class="d-flex justify-content-between align-items-center">

                        <div class="d-flex align-items-center">

                            <div class="bg-white rounded-circle
                                        d-flex align-items-center
                                        justify-content-center me-2"
                                 style="width:44px;height:44px;">

                                <i class="fa-solid fa-chart-line"
                                   style="color:#8cc63f;"></i>

                            </div>

                            <div>

                                <span class="fw-bold text-white d-block">
                                    Admin
                                </span>

                                <small class="text-white-50">
                                    Management Portal
                                </small>

                            </div>

                        </div>


                        <span class="badge rounded-pill px-3 py-2"
                              style="background-color:#8cc63f;">

                            SECURE

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

                            SYSTEM CONTROL

                        </span>


                        <h2 class="display-5 fw-bold text-white mb-3">

                            Manage everything.
                            <br>

                            <span style="color:#b8e47b;">

                                From one place.

                            </span>

                        </h2>


                        <p class="text-white-50 small mb-4"
                           style="max-width:430px;">

                            Manage products, monitor customer orders,
                            track inventory and keep your Seemy
                            eyewear store running smoothly.

                        </p>


                        {{-- ADMIN FEATURES --}}

                        <div class="row g-3">

                            <div class="col-6">

                                <div class="rounded-3 p-3"
                                     style="
                                        background-color:rgba(255,255,255,0.10);
                                        backdrop-filter:blur(4px);
                                     ">

                                    <div class="d-flex align-items-center mb-2">

                                        <div class="rounded-circle d-flex
                                                    align-items-center justify-content-center me-2"
                                             style="
                                                width:34px;
                                                height:34px;
                                                background-color:rgba(140,198,63,0.20);
                                             ">

                                            <i class="fa-solid fa-box"
                                               style="color:#b8e47b;"></i>

                                        </div>

                                        <span class="small fw-bold">
                                            Products
                                        </span>

                                    </div>

                                    <small class="text-white-50">
                                        Manage catalog
                                    </small>

                                </div>

                            </div>


                            <div class="col-6">

                                <div class="rounded-3 p-3"
                                     style="
                                        background-color:rgba(255,255,255,0.10);
                                        backdrop-filter:blur(4px);
                                     ">

                                    <div class="d-flex align-items-center mb-2">

                                        <div class="rounded-circle d-flex
                                                    align-items-center justify-content-center me-2"
                                             style="
                                                width:34px;
                                                height:34px;
                                                background-color:rgba(140,198,63,0.20);
                                             ">

                                            <i class="fa-solid fa-cart-shopping"
                                               style="color:#b8e47b;"></i>

                                        </div>

                                        <span class="small fw-bold">
                                            Orders
                                        </span>

                                    </div>

                                    <small class="text-white-50">
                                        Track customer orders
                                    </small>

                                </div>

                            </div>


                            <div class="col-6">

                                <div class="rounded-3 p-3"
                                     style="
                                        background-color:rgba(255,255,255,0.10);
                                        backdrop-filter:blur(4px);
                                     ">

                                    <div class="d-flex align-items-center mb-2">

                                        <div class="rounded-circle d-flex
                                                    align-items-center justify-content-center me-2"
                                             style="
                                                width:34px;
                                                height:34px;
                                                background-color:rgba(140,198,63,0.20);
                                             ">

                                            <i class="fa-solid fa-chart-column"
                                               style="color:#b8e47b;"></i>

                                        </div>

                                        <span class="small fw-bold">
                                            Analytics
                                        </span>

                                    </div>

                                    <small class="text-white-50">
                                        View store insights
                                    </small>

                                </div>

                            </div>


                            <div class="col-6">

                                <div class="rounded-3 p-3"
                                     style="
                                        background-color:rgba(255,255,255,0.10);
                                        backdrop-filter:blur(4px);
                                     ">

                                    <div class="d-flex align-items-center mb-2">

                                        <div class="rounded-circle d-flex
                                                    align-items-center justify-content-center me-2"
                                             style="
                                                width:34px;
                                                height:34px;
                                                background-color:rgba(140,198,63,0.20);
                                             ">

                                            <i class="fa-solid fa-shield-halved"
                                               style="color:#b8e47b;"></i>

                                        </div>

                                        <span class="small fw-bold">
                                            Security
                                        </span>

                                    </div>

                                    <small class="text-white-50">
                                        Protected admin access
                                    </small>

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
