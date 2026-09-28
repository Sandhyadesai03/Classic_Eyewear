<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Classic - Glasses Store')
    </title>

    <!-- FAVICON -->
    <link rel="icon"
          type="image/png"
          href="{{ asset('product-images/logo.png') }}">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">

    @stack('css')

</head>


<body class="d-flex flex-column min-vh-100 bg-white text-dark">


{{-- ============================================================ --}}
{{-- NAVBAR --}}
{{-- ============================================================ --}}

@if (!View::hasSection('hideNavbarFooter'))

<nav
    class="navbar navbar-expand-lg sticky-top bg-white py-3"
    style="
        border-bottom:1px solid #eeeeee;
        box-shadow:0 4px 20px rgba(0,0,0,0.05);
    "
>

    <div class="container">

        <!-- MOBILE TOGGLE -->

        <button
            class="navbar-toggler border-0 shadow-none p-2"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >

            <span class="navbar-toggler-icon"></span>

        </button>


        <!-- LOGO -->

        <a
            href="{{ url('/') }}"
            class="navbar-brand d-flex align-items-center text-decoration-none"
        >

            <div
                class="d-flex align-items-center justify-content-center rounded-4 me-2 shadow-sm"
                style="
                    width:48px;
                    height:48px;
                    background:linear-gradient(
                        135deg,
                        #8cc63f,
                        #a8d957
                    );
                "
            >

                <i
                    class="fa-solid fa-glasses text-white fs-4"
                ></i>

            </div>


            <div class="lh-1">

                <div
                    class="fw-bold text-dark"
                    style="
                        font-size:25px;
                        letter-spacing:-1px;
                    "
                >

                    Classic

                </div>


                <small
                    class="fw-semibold"
                    style="
                        color:#8cc63f;
                        font-size:8px;
                        letter-spacing:2.5px;
                    "
                >

                    PREMIUM EYEWEAR

                </small>

            </div>

        </a>


        <!-- MOBILE RIGHT SIDE -->

        <div class="d-flex align-items-center d-lg-none">

            @auth

                <!-- MOBILE MY ORDERS -->

                <a
                    href="{{ url('/my-orders') }}"
                    class="position-relative text-dark text-decoration-none me-3"
                    title="My Orders"
                >

                    <i
                        class="fa-solid fa-box-open fs-5"
                        style="color:#8cc63f;"
                    ></i>

                </a>


                @php

                    $mobileCartCount =
                        \App\Models\CartItem::where(
                            'user_id',
                            auth()->id()
                        )->sum('quantity');

                @endphp


                <!-- MOBILE CART -->

                <a
                    href="{{ url('/cart') }}"
                    class="position-relative text-dark text-decoration-none"
                    title="View Cart"
                >

                    <i
                        class="fa-solid fa-cart-shopping fs-5"
                        style="color:#8cc63f;"
                    ></i>


                    @if($mobileCartCount > 0)

                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill text-white"
                            style="
                                background-color:#e9b36a;
                                font-size:8px;
                                min-width:17px;
                                height:17px;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                border:2px solid white;
                            "
                        >

                            {{ $mobileCartCount }}

                        </span>

                    @endif

                </a>

            @else

                <!-- GUEST MOBILE CART -->

                <a
                    href="{{ url('/cart') }}"
                    class="position-relative text-dark text-decoration-none"
                    title="Cart"
                >

                    <i
                        class="fa-solid fa-cart-shopping fs-5"
                        style="color:#8cc63f;"
                    ></i>

                </a>

            @endauth

        </div>


        <!-- NAVIGATION -->

        <div
            class="collapse navbar-collapse"
            id="navbarNav"
        >

            <!-- CENTER NAV LINKS -->

            <ul
                class="navbar-nav mx-auto align-items-lg-center gap-lg-2 mt-3 mt-lg-0"
            >

                <li class="nav-item">

                    <a
                        href="{{ url('/home') }}"
                        class="nav-link px-3 py-2 rounded-pill fw-semibold"
                        style="color:#333333;"
                    >

                        <i
                            class="fa-solid fa-house me-1"
                            style="color:#8cc63f;"
                        ></i>

                        Home

                    </a>

                </li>


                <li class="nav-item">

                    <a
                        href="{{ url('/blog') }}"
                        class="nav-link px-3 py-2 rounded-pill fw-semibold"
                        style="color:#333333;"
                    >

                        <i
                            class="fa-regular fa-newspaper me-1"
                            style="color:#e9b36a;"
                        ></i>

                        Blog

                    </a>

                </li>


                <li class="nav-item">

                    <a
                        href="{{ url('/products') }}"
                        class="nav-link px-3 py-2 rounded-pill fw-semibold"
                        style="color:#333333;"
                    >

                        <i
                            class="fa-solid fa-glasses me-1"
                            style="color:#8cc63f;"
                        ></i>

                        Products

                    </a>

                </li>


                <li class="nav-item">

                    <a
                        href="{{ url('/contact') }}"
                        class="nav-link px-3 py-2 rounded-pill fw-semibold"
                        style="color:#333333;"
                    >

                        <i
                            class="fa-regular fa-envelope me-1"
                            style="color:#e9b36a;"
                        ></i>

                        Contact

                    </a>

                </li>

            </ul>


            <!-- RIGHT SIDE -->

            <div
                class="d-none d-lg-flex align-items-center gap-2"
            >

                @auth

                    <!-- USER NAME -->

                    <span
                        class="fw-semibold text-dark small px-2 d-flex align-items-center"
                        title="{{ auth()->user()->name }}"
                    >

                        <i
                            class="fa-regular fa-user me-1"
                            style="color:#8cc63f;"
                        ></i>

                        {{ auth()->user()->name }}

                    </span>


                    @php

                        $cartCount =
                            \App\Models\CartItem::where(
                                'user_id',
                                auth()->id()
                            )->sum('quantity');

                    @endphp


                    <!-- CART -->

                    <a
                        href="{{ url('/cart') }}"
                        class="position-relative text-decoration-none d-flex align-items-center justify-content-center ms-1 me-2"
                        title="View Cart"
                        style="
                            width:42px;
                            height:42px;
                            border-radius:50%;
                            background-color:#f5f9ec;
                            border:1px solid #dce9c2;
                            transition:all .2s ease;
                        "
                    >

                        <i
                            class="fa-solid fa-cart-shopping"
                            style="
                                color:#8cc63f;
                                font-size:17px;
                            "
                        ></i>


                        @if($cartCount > 0)

                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill text-white"
                                style="
                                    background-color:#e9b36a;
                                    font-size:9px;
                                    min-width:19px;
                                    height:19px;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    border:2px solid white;
                                "
                            >

                                {{ $cartCount }}

                            </span>

                        @endif

                    </a>


                    <!-- MY ORDERS -->

                    <a
                        href="{{ url('/my-orders') }}"
                        class="btn rounded-pill px-4 py-2 fw-semibold text-dark shadow-sm"
                        style="
                            background-color:#f5f9ec;
                            border:1px solid #dce9c2;
                            font-size:11px;
                            letter-spacing:.5px;
                        "
                    >

                        <i
                            class="fa-solid fa-box-open me-1"
                            style="color:#8cc63f;"
                        ></i>

                        My Orders

                    </a>


                    <!-- LOGOUT -->

                    <form
                        action="{{ url('/logout') }}"
                        method="POST"
                        class="d-inline"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="btn rounded-pill px-3 py-2 fw-semibold"
                            style="
                                border:1px solid #e9b36a;
                                color:#8d6b3d;
                                background-color:#fffaf3;
                                font-size:11px;
                            "
                        >

                            <i
                                class="fa-solid fa-right-from-bracket me-1"
                            ></i>

                            Logout

                        </button>

                    </form>

                @else

                    <!-- LOGIN -->

                    <a
                        href="{{ url('/login') }}"
                        class="btn rounded-pill px-4 py-2 fw-semibold text-dark shadow-sm"
                        style="
                            background-color:#f5f9ec;
                            border:1px solid #dce9c2;
                            font-size:11px;
                            letter-spacing:.5px;
                        "
                    >

                        <i
                            class="fa-regular fa-user me-1"
                            style="color:#8cc63f;"
                        ></i>

                        Login

                    </a>


                    <!-- REGISTER -->

                    <a
                        href="{{ url('/register') }}"
                        class="btn rounded-pill px-4 py-2 fw-bold text-white shadow-sm"
                        style="
                            background-color:#8cc63f;
                            font-size:11px;
                            letter-spacing:.5px;
                        "
                    >

                        Register

                    </a>

                @endauth


                <!-- ADMIN -->

                <a
                    href="{{ url('/admin') }}"
                    class="btn rounded-pill px-4 py-2 fw-semibold"
                    style="
                        border:1px solid #e9b36a;
                        color:#8d6b3d;
                        background-color:#fffaf3;
                        font-size:11px;
                    "
                >

                    <i class="fa-solid fa-user-shield me-1"></i>

                    Admin

                </a>

            </div>

        </div>

    </div>

</nav>

@endif



{{-- ============================================================ --}}
{{-- MAIN CONTENT --}}
{{-- ============================================================ --}}

<main class="flex-grow-1">

    @yield('content')

</main>



{{-- ============================================================ --}}
{{-- FOOTER --}}
{{-- ============================================================ --}}

@if (!View::hasSection('hideNavbarFooter'))

<footer
    class="bg-white mt-5"
    style="
        border-top:1px solid #eeeeee;
        box-shadow:0 -8px 30px rgba(0,0,0,.04);
    "
>

    <div
        style="
            height:5px;
            background:linear-gradient(
                90deg,
                #8cc63f,
                #e9b36a,
                #8cc63f
            );
        "
    ></div>


    <!-- NEWSLETTER -->

    <div class="container pt-5">

        <div
            class="rounded-4 p-4 p-lg-5 shadow-sm"
            style="
                background:linear-gradient(
                    135deg,
                    #f6faed,
                    #fff8ed
                );
                border:1px solid #edf0df;
            "
        >

            <div class="row align-items-center g-4">

                <div class="col-lg-7">

                    <span
                        class="badge rounded-pill px-3 py-2 mb-3 text-white"
                        style="
                            background-color:#8cc63f;
                            font-size:9px;
                            letter-spacing:1.5px;
                        "
                    >

                        PREMIUM EYEWEAR

                    </span>


                    <h3 class="fw-bold text-dark mb-2">

                        See More. Live Better.

                    </h3>


                    <p class="text-muted small mb-0">

                        Subscribe to receive updates,
                        access to exclusive deals, and more.

                    </p>

                </div>


                <div class="col-lg-5">

                    <form
                        onsubmit="event.preventDefault();"
                        class="d-flex gap-2"
                    >

                        <input
                            type="email"
                            placeholder="Enter your email"
                            class="form-control rounded-pill border-0 shadow-sm px-4 py-3"
                        >

                        <button
                            type="submit"
                            class="btn rounded-pill px-4 fw-bold text-white shadow-sm"
                            style="background-color:#e9b36a;"
                        >

                            Subscribe

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>


    <!-- FOOTER CONTENT -->

    <div class="container py-5">

        <div class="row g-5">

            <!-- BRAND -->

            <div class="col-lg-4">

                <a
                    href="{{ url('/') }}"
                    class="text-decoration-none d-inline-flex align-items-center mb-3"
                >

                    <div
                        class="d-flex align-items-center justify-content-center rounded-4 me-2 shadow-sm"
                        style="
                            width:48px;
                            height:48px;
                            background:linear-gradient(
                                135deg,
                                #8cc63f,
                                #a8d957
                            );
                        "
                    >

                        <i
                            class="fa-solid fa-glasses text-white fs-4"
                        ></i>

                    </div>


                    <div class="lh-1">

                        <div
                            class="fw-bold text-dark"
                            style="
                                font-size:25px;
                                letter-spacing:-1px;
                            "
                        >

                            Classic

                        </div>


                        <small
                            class="fw-semibold"
                            style="
                                color:#8cc63f;
                                font-size:8px;
                                letter-spacing:2.5px;
                            "
                        >

                            PREMIUM EYEWEAR

                        </small>

                    </div>

                </a>


                <p class="text-muted small pe-lg-4">

                    A superb, well-designed, and fully responsive
                    eCommerce template built to showcase trendy
                    eyewear and fashion accessories.

                </p>


                <div class="d-flex gap-2 mt-4">

                    <a
                        href="#"
                        class="d-flex align-items-center justify-content-center rounded-circle text-decoration-none"
                        style="
                            width:42px;
                            height:42px;
                            background:#f4f9e9;
                            color:#8cc63f;
                            border:1px solid #e0ebc8;
                        "
                    >

                        <i class="fab fa-facebook-f"></i>

                    </a>


                    <a
                        href="#"
                        class="d-flex align-items-center justify-content-center rounded-circle text-decoration-none"
                        style="
                            width:42px;
                            height:42px;
                            background:#fff7eb;
                            color:#e9b36a;
                            border:1px solid #f0ddbf;
                        "
                    >

                        <i class="fab fa-twitter"></i>

                    </a>


                    <a
                        href="#"
                        class="d-flex align-items-center justify-content-center rounded-circle text-decoration-none"
                        style="
                            width:42px;
                            height:42px;
                            background:#f4f9e9;
                            color:#8cc63f;
                            border:1px solid #e0ebc8;
                        "
                    >

                        <i class="fab fa-instagram"></i>

                    </a>


                    <a
                        href="#"
                        class="d-flex align-items-center justify-content-center rounded-circle text-decoration-none"
                        style="
                            width:42px;
                            height:42px;
                            background:#fff7eb;
                            color:#e9b36a;
                            border:1px solid #f0ddbf;
                        "
                    >

                        <i class="fab fa-pinterest"></i>

                    </a>

                </div>

            </div>


            <!-- QUICK LINKS -->

            <div class="col-6 col-lg-2">

                <h6 class="fw-bold text-dark mb-4">

                    Quick Links

                </h6>


                <ul class="list-unstyled small d-flex flex-column gap-3">

                    <li>
                        <a href="{{ url('/home') }}"
                           class="text-muted text-decoration-none">
                            <i class="fa-solid fa-angle-right me-2"
                               style="color:#8cc63f;"></i>
                            Home
                        </a>
                    </li>


                    <li>
                        <a href="{{ url('/blog') }}"
                           class="text-muted text-decoration-none">
                            <i class="fa-solid fa-angle-right me-2"
                               style="color:#8cc63f;"></i>
                            Blog
                        </a>
                    </li>


                    <li>
                        <a href="{{ url('/products') }}"
                           class="text-muted text-decoration-none">
                            <i class="fa-solid fa-angle-right me-2"
                               style="color:#8cc63f;"></i>
                            Products
                        </a>
                    </li>


                    @auth

                    <li>
                        <a href="{{ url('/my-orders') }}"
                           class="text-muted text-decoration-none">
                            <i class="fa-solid fa-angle-right me-2"
                               style="color:#8cc63f;"></i>
                            My Orders
                        </a>
                    </li>

                    @endauth


                    <li>
                        <a href="{{ url('/contact') }}"
                           class="text-muted text-decoration-none">
                            <i class="fa-solid fa-angle-right me-2"
                               style="color:#8cc63f;"></i>
                            Contact
                        </a>
                    </li>


                    @guest

                    <li>
                        <a href="{{ url('/login') }}"
                           class="text-muted text-decoration-none">
                            <i class="fa-solid fa-angle-right me-2"
                               style="color:#8cc63f;"></i>
                            Login
                        </a>
                    </li>

                    @endguest

                </ul>

            </div>


            <!-- CUSTOMER CARE -->

            <div class="col-6 col-lg-2">

                <h6 class="fw-bold text-dark mb-4">

                    Customer Care

                </h6>


                <ul class="list-unstyled small d-flex flex-column gap-3">

                    <li>
                        <a href="{{ url('/register') }}"
                           class="text-muted text-decoration-none">
                            <i class="fa-solid fa-angle-right me-2"
                               style="color:#e9b36a;"></i>
                            Register
                        </a>
                    </li>


                    <li>
                        <a href="{{ url('/admin') }}"
                           class="text-muted text-decoration-none">
                            <i class="fa-solid fa-angle-right me-2"
                               style="color:#e9b36a;"></i>
                            Admin
                        </a>
                    </li>


                    @auth

                    <li>
                        <a href="{{ url('/my-orders') }}"
                           class="text-muted text-decoration-none">
                            <i class="fa-solid fa-angle-right me-2"
                               style="color:#e9b36a;"></i>
                            My Orders
                        </a>
                    </li>

                    @endauth


                    <li>
                        <a href="#"
                           class="text-muted text-decoration-none">
                            <i class="fa-solid fa-angle-right me-2"
                               style="color:#e9b36a;"></i>
                            Track Order
                        </a>
                    </li>


                    <li>
                        <a href="#"
                           class="text-muted text-decoration-none">
                            <i class="fa-solid fa-angle-right me-2"
                               style="color:#e9b36a;"></i>
                            FAQs
                        </a>
                    </li>

                </ul>

            </div>


            <!-- MAP -->

            <div class="col-lg-4">

                <div
                    class="d-flex align-items-center justify-content-between mb-3"
                >

                    <h6 class="fw-bold text-dark mb-0">

                        Find Our Store

                    </h6>


                    <span
                        class="badge rounded-pill px-3 py-2 text-white"
                        style="
                            background-color:#e9b36a;
                            font-size:9px;
                        "
                    >

                        LOCATION

                    </span>

                </div>


                <div
                    class="rounded-4 overflow-hidden shadow-sm"
                    style="
                        height:220px;
                        border:3px solid #f0e1cb;
                    "
                >

                    <iframe
                        src="https://www.google.com/maps?q=India&output=embed"
                        width="100%"
                        height="100%"
                        style="
                            border:0;
                            filter:grayscale(8%);
                        "
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>

                </div>


                <div class="d-flex align-items-center mt-3">

                    <div
                        class="d-flex align-items-center justify-content-center rounded-circle me-2"
                        style="
                            width:38px;
                            height:38px;
                            background:#f4f9e9;
                            border:1px solid #dce9c2;
                        "
                    >

                        <i
                            class="fa-solid fa-location-dot"
                            style="color:#8cc63f;"
                        ></i>

                    </div>


                    <div>

                        <small class="text-muted d-block">
                            Visit Us
                        </small>

                        <span class="text-dark small fw-semibold">
                            Classic Glasses Store
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- BOTTOM -->

    <div
        style="
            background:#fafafa;
            border-top:1px solid #eeeeee;
        "
    >

        <div class="container py-4">

            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3"
            >

                <p class="text-muted small mb-0">

                    &copy; {{ date('Y') }}

                    <span class="fw-semibold text-dark">
                        Classic Glasses Store
                    </span>

                    . All Rights Reserved.

                </p>


                <div class="d-flex gap-4">

                    <a href="#"
                       class="text-muted small text-decoration-none">
                        Privacy Policy
                    </a>

                    <a href="#"
                       class="text-muted small text-decoration-none">
                        Terms of Service
                    </a>

                </div>


                <div class="d-flex align-items-center gap-2">

                    <i
                        class="fa-solid fa-shield-halved"
                        style="color:#8cc63f;"
                    ></i>

                    <span class="text-muted small">
                        Secure Shopping
                    </span>

                </div>

            </div>

        </div>

    </div>

</footer>

@endif



{{-- ============================================================ --}}
{{-- BOOTSTRAP JS --}}
{{-- ============================================================ --}}

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js">
</script>


@stack('js')



{{-- ============================================================ --}}
{{-- ============================================================ --}}
{{-- USER ORDER STATUS NOTIFICATION --}}
{{-- ============================================================ --}}
{{-- ============================================================ --}}

@if(
    auth()->check()
    && !request()->is('admin')
    && !request()->is('admin/*')
)

<style>

    #orderNotificationPopup {

        position:fixed;

        top:25px;

        right:25px;

        width:380px;

        max-width:calc(100% - 30px);

        z-index:999999;

        display:none;

    }


    #orderNotificationPopup .notification-card {

        border-radius:18px;

        overflow:hidden;

        border:0;

        box-shadow:
            0 15px 40px rgba(0,0,0,.20);

        animation:
            orderNotificationSlide .35s ease;

    }


    @keyframes orderNotificationSlide {

        from {

            opacity:0;

            transform:translateX(40px);

        }

        to {

            opacity:1;

            transform:translateX(0);

        }

    }


    #orderNotificationPopup .notification-header {

        background:
            linear-gradient(
                135deg,
                #8cc63f,
                #6da82d
            );

        color:white;

        padding:16px 18px;

    }


    #orderNotificationPopup .notification-icon {

        width:48px;

        height:48px;

        border-radius:50%;

        background:
            rgba(255,255,255,.20);

        display:flex;

        align-items:center;

        justify-content:center;

        font-size:22px;

    }


    #orderNotificationPopup .notification-body {

        padding:20px;

        background:white;

    }


    #orderNotificationPopup .order-status {

        display:inline-block;

        padding:6px 14px;

        border-radius:50px;

        font-size:13px;

        font-weight:600;

        background:#eef7e7;

        color:#5c8f28;

    }


    #orderNotificationPopup .close-notification {

        border:0;

        background:transparent;

        color:white;

        font-size:24px;

        line-height:1;

        cursor:pointer;

    }


    @media(max-width:576px) {

        #orderNotificationPopup {

            top:15px;

            right:15px;

            left:15px;

            width:auto;

        }

    }

</style>


<div id="orderNotificationPopup">

    <div class="card notification-card">

        <div class="notification-header">

            <div
                class="d-flex align-items-center justify-content-between"
            >

                <div
                    class="d-flex align-items-center gap-3"
                >

                    <div class="notification-icon">

                        <i class="fas fa-bell"></i>

                    </div>


                    <div>

                        <div class="fw-bold">
                            Order Update
                        </div>

                        <small>
                            Classic Glasses Store
                        </small>

                    </div>

                </div>


                <button
                    type="button"
                    class="close-notification"
                    onclick="closeOrderNotification()"
                >

                    &times;

                </button>

            </div>

        </div>


        <div class="notification-body">

            <div class="mb-2">

                <strong id="notificationOrderId">
                    Order #0
                </strong>

            </div>


            <div class="mb-3">

                <span
                    id="notificationStatus"
                    class="order-status"
                >
                    Status
                </span>

            </div>


            <p
                id="notificationMessage"
                class="mb-3 text-muted"
            >
                Your order status has been updated.
            </p>


            <a
                href="{{ route('my.orders') }}"
                class="btn btn-success w-100"
            >

                <i class="fas fa-box me-2"></i>

                View My Orders

            </a>

        </div>

    </div>

</div>


<script>

(function () {

    "use strict";


    let currentNotificationId = null;

    let notificationTimer = null;


    function checkOrderNotification()
    {

        fetch(
            "{{ route('order.notification') }}",
            {

                method:"GET",

                headers:{

                    "X-Requested-With":
                        "XMLHttpRequest",

                    "Accept":
                        "application/json"

                }

            }
        )

        .then(
            response => {

                if (!response.ok) {

                    throw new Error(
                        "Notification request failed"
                    );

                }

                return response.json();

            }
        )

        .then(
            data => {

                if (
                    !data.success ||
                    !data.notification
                ) {

                    return;

                }


                const notification =
                    data.notification;


                if (
                    currentNotificationId ===
                    notification.id
                ) {

                    return;

                }


                currentNotificationId =
                    notification.id;


                const orderIdElement =
                    document.getElementById(
                        'notificationOrderId'
                    );


                if (orderIdElement) {

                    orderIdElement.innerText =
                        'Order #' +
                        notification.order_id;

                }


                const statusElement =
                    document.getElementById(
                        'notificationStatus'
                    );


                if (statusElement) {

                    statusElement.innerText =
                        notification.status;

                }


                const messageElement =
                    document.getElementById(
                        'notificationMessage'
                    );


                if (messageElement) {

                    messageElement.innerText =
                        notification.message;

                }


                const popup =
                    document.getElementById(
                        'orderNotificationPopup'
                    );


                if (popup) {

                    popup.style.display =
                        'block';

                }


                // =============================================
                // SOUND
                // =============================================

                playProfessionalNotificationSound();


                clearTimeout(
                    notificationTimer
                );


                notificationTimer =
                    setTimeout(
                        function () {

                            closeOrderNotification();

                        },
                        8000
                    );

            }
        )

        .catch(
            error => {

                console.log(
                    'User notification error:',
                    error
                );

            }
        );

    }


    function closeOrderNotification()
    {

        const popup =
            document.getElementById(
                'orderNotificationPopup'
            );


        if (popup) {

            popup.style.display =
                'none';

        }


        clearTimeout(
            notificationTimer
        );


        if (currentNotificationId) {

            fetch(
                "{{ url('/order-notification') }}/"
                + currentNotificationId
                + "/read",
                {

                    method:"POST",

                    headers:{

                        "X-CSRF-TOKEN":
                            "{{ csrf_token() }}",

                        "X-Requested-With":
                            "XMLHttpRequest",

                        "Accept":
                            "application/json"

                    }

                }
            )
            .catch(
                error => {

                    console.log(
                        'Notification read error:',
                        error
                    );

                }
            );

        }

    }


    document.addEventListener(
        'DOMContentLoaded',
        function ()
        {

            checkOrderNotification();


            setInterval(
                checkOrderNotification,
                5000
            );

        }
    );

})();

</script>

@endif



{{-- ============================================================ --}}
{{-- ============================================================ --}}
{{-- USER ENQUIRY REPLY NOTIFICATION --}}
{{-- ============================================================ --}}
{{-- ============================================================ --}}

@if(auth()->check())

<style>

    #userEnquiryNotificationContainer {

        position:fixed;

        top:80px;

        right:25px;

        width:390px;

        max-width:calc(100% - 30px);

        z-index:999999;

    }


    .user-enquiry-popup {

        background:#ffffff;

        border:0;

        border-left:5px solid #8cc63f !important;

        border-radius:18px;

        box-shadow:
            0 15px 45px rgba(0,0,0,.18);

        overflow:hidden;

        animation:
            userEnquirySlide .35s ease;

    }


    @keyframes userEnquirySlide {

        from {

            opacity:0;

            transform:
                translateX(50px)
                scale(.96);

        }

        to {

            opacity:1;

            transform:
                translateX(0)
                scale(1);

        }

    }


    .user-enquiry-icon {

        width:48px;

        height:48px;

        min-width:48px;

        border-radius:50%;

        display:flex;

        align-items:center;

        justify-content:center;

        color:white;

        background:
            linear-gradient(
                135deg,
                #8cc63f,
                #6da82d
            );

        box-shadow:
            0 5px 15px rgba(140,198,63,.30);

    }


    .user-enquiry-title {

        font-size:16px;

        font-weight:700;

        color:#222;

    }


    .user-enquiry-subtitle {

        font-size:11px;

        color:#8cc63f;

        font-weight:600;

        letter-spacing:.4px;

    }


    .user-enquiry-close {

        border:0;

        background:transparent;

        font-size:20px;

        color:#888;

        cursor:pointer;

        padding:0;

    }


    .user-enquiry-close:hover {

        color:#222;

    }


    .user-enquiry-message {

        background:#f6faef;

        border-radius:10px;

        padding:10px 12px;

        font-size:13px;

        line-height:1.5;

        color:#333;

        word-break:break-word;

    }


    .user-enquiry-reply {

        background:#f3f8ec;

        border-left:3px solid #8cc63f;

        border-radius:10px;

        padding:12px;

        font-size:13px;

        line-height:1.5;

        color:#222;

        word-break:break-word;

    }


    @media(max-width:576px) {

        #userEnquiryNotificationContainer {

            top:15px;

            right:15px;

            left:15px;

            width:auto;

            max-width:none;

        }

    }

</style>


<div id="userEnquiryNotificationContainer"></div>


<script>

(function () {

    "use strict";


    let userKnownReplies = [];

    let userFirstCheck = true;

    let checkingUserNotification = false;


    // =========================================================
    // PROFESSIONAL BROWSER SOUND
    // NO MP3 FILE REQUIRED
    // =========================================================

    let userAudioContext = null;


    function getUserAudioContext()
    {

        if (!userAudioContext) {

            const AudioContext =
                window.AudioContext ||
                window.webkitAudioContext;


            if (!AudioContext) {

                return null;

            }


            userAudioContext =
                new AudioContext();

        }


        return userAudioContext;

    }


    function unlockUserAudio()
    {

        const ctx =
            getUserAudioContext();


        if (!ctx) {

            return;

        }


        if (
            ctx.state ===
            "suspended"
        ) {

            ctx.resume()
                .catch(
                    function () {}
                );

        }

    }


    document.addEventListener(
        "click",
        unlockUserAudio,
        {
            passive:true
        }
    );


    document.addEventListener(
        "touchstart",
        unlockUserAudio,
        {
            passive:true
        }
    );


    document.addEventListener(
        "keydown",
        unlockUserAudio
    );


    // =========================================================
    // PROFESSIONAL NOTIFICATION SOUND
    // =========================================================

    function playUserEnquirySound()
    {

        try {

            const ctx =
                getUserAudioContext();


            if (!ctx) {

                return;

            }


            if (
                ctx.state ===
                "suspended"
            ) {

                ctx.resume();

            }


            const now =
                ctx.currentTime;


            // -----------------------------------------------
            // FIRST TONE
            // -----------------------------------------------

            const oscillator1 =
                ctx.createOscillator();


            const gain1 =
                ctx.createGain();


            oscillator1.type =
                "sine";


            oscillator1.frequency.setValueAtTime(
                880,
                now
            );


            oscillator1.frequency.exponentialRampToValueAtTime(
                1174,
                now + 0.12
            );


            gain1.gain.setValueAtTime(
                0.0001,
                now
            );


            gain1.gain.exponentialRampToValueAtTime(
                0.22,
                now + 0.02
            );


            gain1.gain.exponentialRampToValueAtTime(
                0.0001,
                now + 0.28
            );


            oscillator1.connect(
                gain1
            );


            gain1.connect(
                ctx.destination
            );


            oscillator1.start(
                now
            );


            oscillator1.stop(
                now + 0.30
            );


            // -----------------------------------------------
            // SECOND TONE
            // -----------------------------------------------

            const oscillator2 =
                ctx.createOscillator();


            const gain2 =
                ctx.createGain();


            oscillator2.type =
                "sine";


            oscillator2.frequency.setValueAtTime(
                1174,
                now + 0.13
            );


            oscillator2.frequency.exponentialRampToValueAtTime(
                1568,
                now + 0.25
            );


            gain2.gain.setValueAtTime(
                0.0001,
                now + 0.13
            );


            gain2.gain.exponentialRampToValueAtTime(
                0.18,
                now + 0.15
            );


            gain2.gain.exponentialRampToValueAtTime(
                0.0001,
                now + 0.48
            );


            oscillator2.connect(
                gain2
            );


            gain2.connect(
                ctx.destination
            );


            oscillator2.start(
                now + 0.13
            );


            oscillator2.stop(
                now + 0.50
            );


            console.log(
                "🔊 USER REPLY SOUND PLAYED"
            );

        }
        catch(error) {

            console.log(
                "Sound error:",
                error
            );

        }

    }


    // =========================================================
    // UNIQUE REPLY SIGNATURE
    // =========================================================

    function getReplySignature(enquiry)
    {

        const id =
            enquiry.id ?? "";


        const reply =
            enquiry.reply ?? "";


        const repliedAt =
            enquiry.replied_at ??
            enquiry.updated_at ??
            "";


        return (
            String(id)
            + "|"
            + String(reply)
            + "|"
            + String(repliedAt)
        );

    }


    // =========================================================
    // ESCAPE HTML
    // =========================================================

    function escapeHtml(text)
    {

        const div =
            document.createElement(
                "div"
            );


        div.textContent =
            text ?? "";


        return div.innerHTML;

    }


    // =========================================================
    // SHOW USER REPLY POPUP
    // =========================================================

    function showUserReplyPopup(
        enquiry
    )
    {

        const container =
            document.getElementById(
                "userEnquiryNotificationContainer"
            );


        if (!container) {

            return;

        }


        const popup =
            document.createElement(
                "div"
            );


        popup.className =
            "user-enquiry-popup mb-3";


        popup.innerHTML = `

            <div class="p-3">

                <div
                    class="d-flex
                           align-items-start
                           justify-content-between"
                >

                    <div
                        class="d-flex
                               align-items-center
                               gap-3"
                    >

                        <div
                            class="user-enquiry-icon"
                        >

                            <i
                                class="fa-solid fa-reply"
                            ></i>

                        </div>


                        <div>

                            <div
                                class="user-enquiry-title"
                            >

                                Admin Replied

                            </div>


                            <div
                                class="user-enquiry-subtitle"
                            >

                                Classic Glasses Store

                            </div>

                        </div>

                    </div>


                    <button
                        type="button"
                        class="user-enquiry-close"
                        aria-label="Close"
                    >

                        <i
                            class="fa-solid fa-xmark"
                        ></i>

                    </button>

                </div>


                <div class="mt-3">


                    <div
                        class="fw-bold
                               text-dark
                               mb-2"
                        style="
                            font-size:14px;
                            word-break:break-word;
                        "
                    >

                        <i
                            class="fa-solid
                                   fa-envelope
                                   me-1"
                            style="
                                color:#8cc63f;
                            "
                        ></i>

                        ${escapeHtml(
                            enquiry.subject ||
                            "Your Enquiry"
                        )}

                    </div>


                    <div
                        class="small
                               text-muted
                               mb-1"
                    >

                        Your enquiry:

                    </div>


                    <div
                        class="user-enquiry-message"
                    >

                        ${escapeHtml(
                            enquiry.message ||
                            ""
                        )}

                    </div>


                    <div
                        class="small
                               text-muted
                               mt-3
                               mb-1"
                    >

                        <i
                            class="fa-solid
                                   fa-comment-dots
                                   me-1"
                            style="
                                color:#8cc63f;
                            "
                        ></i>

                        Admin Reply:

                    </div>


                    <div
                        class="user-enquiry-reply"
                    >

                        ${escapeHtml(
                            enquiry.reply ||
                            ""
                        )}

                    </div>


                    <div
                        class="small
                               text-muted
                               mt-2"
                    >

                        <i
                            class="fa-regular
                                   fa-clock
                                   me-1"
                        ></i>

                        ${escapeHtml(
                            enquiry.replied_at ||
                            ""
                        )}

                    </div>


                    <a
                        href="{{ url('/contact') }}"
                        class="btn
                               btn-sm
                               text-white
                               rounded-pill
                               px-4
                               mt-3
                               w-100"
                        style="
                            background:#8cc63f;
                        "
                    >

                        <i
                            class="fa-solid
                                   fa-envelope-open
                                   me-1"
                        ></i>

                        View My Enquiries

                    </a>

                </div>

            </div>

        `;


        const closeButton =
            popup.querySelector(
                ".user-enquiry-close"
            );


        if (closeButton) {

            closeButton.addEventListener(
                "click",
                function () {

                    popup.remove();

                }
            );

        }


        container.prepend(
            popup
        );


        setTimeout(
            function () {

                if (
                    popup &&
                    popup.parentNode
                ) {

                    popup.remove();

                }

            },
            12000
        );

    }


    // =========================================================
    // CHECK USER REPLY
    // =========================================================

    function checkUserEnquiryNotification()
    {

        if (
            checkingUserNotification
        ) {

            return;

        }


        checkingUserNotification =
            true;


        fetch(
            "{{ route('user.enquiry.notification') }}",
            {

                method:"GET",

                headers:{

                    "Accept":
                        "application/json",

                    "X-Requested-With":
                        "XMLHttpRequest"

                },

                credentials:
                    "same-origin",

                cache:
                    "no-store"

            }
        )


        .then(
            function(response)
            {

                if (!response.ok) {

                    throw new Error(
                        "User notification request failed: "
                        + response.status
                    );

                }


                return response.json();

            }
        )


        .then(
            function(data)
            {

                console.log(
                    "📩 USER ENQUIRY DATA:",
                    data
                );


                if (
                    !data.success ||
                    !Array.isArray(
                        data.enquiries
                    )
                ) {

                    return;

                }


                data.enquiries.forEach(
                    function(enquiry)
                    {

                        const signature =
                            getReplySignature(
                                enquiry
                            );


                        // =====================================
                        // FIRST PAGE LOAD
                        // =====================================

                        if (
                            userFirstCheck
                        ) {

                            if (
                                !userKnownReplies.includes(
                                    signature
                                )
                            ) {

                                userKnownReplies.push(
                                    signature
                                );

                            }


                            return;

                        }


                        // =====================================
                        // NEW REPLY
                        // =====================================

                        if (
                            !userKnownReplies.includes(
                                signature
                            )
                        ) {

                            console.log(
                                "🆕 NEW ADMIN REPLY:",
                                enquiry
                            );


                            // Save unique signature

                            userKnownReplies.push(
                                signature
                            );


                            // Show popup

                            showUserReplyPopup(
                                enquiry
                            );


                            // Play sound EVERY TIME

                            playUserEnquirySound();


                            // Browser title

                            const oldTitle =
                                document.title;


                            document.title =
                                "🔔 Admin Replied";


                            setTimeout(
                                function()
                                {

                                    document.title =
                                        oldTitle;

                                },
                                5000
                            );

                        }

                    }
                );


                userFirstCheck =
                    false;

            }
        )


        .catch(
            function(error)
            {

                console.error(
                    "❌ USER ENQUIRY NOTIFICATION ERROR:",
                    error
                );

            }
        )


        .finally(
            function()
            {

                checkingUserNotification =
                    false;

            }
        );

    }


    // =========================================================
    // START USER NOTIFICATION
    // =========================================================

    function startUserNotificationSystem()
    {

        console.log(
            "🚀 USER ENQUIRY NOTIFICATION STARTED"
        );


        checkUserEnquiryNotification();


        setInterval(
            function()
            {

                checkUserEnquiryNotification();

            },
            3000
        );

    }


    // =========================================================
    // DOM READY
    // =========================================================

    if (
        document.readyState ===
        "loading"
    )
    {

        document.addEventListener(
            "DOMContentLoaded",
            startUserNotificationSystem
        );

    }
    else
    {

        startUserNotificationSystem();

    }


})();

</script>

@endif



{{-- ============================================================ --}}
{{-- ============================================================ --}}
{{-- ADMIN ENQUIRY NOTIFICATION --}}
{{-- ============================================================ --}}
{{-- ============================================================ --}}

@if(
    auth()->check()
    && request()->is('admin/*')
)

<style>

    #enquiryPopup {

        display:none;

        position:fixed;

        top:90px;

        right:25px;

        width:390px;

        max-width:calc(100% - 30px);

        z-index:999999;

        opacity:0;

        transform:translateX(40px);

        transition:
            all .35s ease;

    }


    @media(max-width:576px) {

        #enquiryPopup {

            top:15px;

            right:15px;

            left:15px;

            width:auto;

            max-width:none;

        }

    }

</style>


<div id="enquiryPopup">

    <div
        class="card border-0 shadow-lg rounded-4 overflow-hidden"
    >

        <!-- HEADER -->

        <div
            class="p-3 text-white d-flex justify-content-between align-items-center"
            style="background:#8cc63f;"
        >

            <div>

                <div class="fw-bold">

                    <i class="fa-solid fa-bell me-2"></i>

                    New Enquiry

                    <span
                        id="enquiryNotificationBadge"
                        class="badge bg-danger ms-2"
                        style="display:none;"
                    >
                        0
                    </span>

                </div>


                <small>
                    New customer message received
                </small>

            </div>


            <button
                type="button"
                onclick="hideEnquiryPopup()"
                class="btn btn-sm text-white border-0"
            >

                <i class="fa-solid fa-xmark fs-5"></i>

            </button>

        </div>


        <!-- CONTENT -->

        <div
            id="enquiryPopupContent"
            class="p-4 bg-white"
        ></div>


        <!-- FOOTER -->

        <div
            class="p-3 border-top bg-white text-center"
        >

            <a
                href="{{ route('admin.dashboard', ['page' => 'enquiries']) }}"
                class="btn rounded-pill px-4 text-white"
                style="background:#8cc63f;"
            >

                <i
                    class="fa-solid
                           fa-envelope-open
                           me-1"
                ></i>

                View Enquiries

            </a>

        </div>

    </div>

</div>


<script>

(function () {

    "use strict";


    let lastKnownIds = [];

    let firstCheck = true;

    let checking = false;

    let popupTimer = null;

    let adminAudioContext = null;


    const popup =
        document.getElementById(
            "enquiryPopup"
        );


    const popupContent =
        document.getElementById(
            "enquiryPopupContent"
        );


    const badge =
        document.getElementById(
            "enquiryNotificationBadge"
        );


    // =========================================================
    // ADMIN AUDIO CONTEXT
    // =========================================================

    function getAdminAudioContext()
    {

        if (!adminAudioContext) {

            const AudioContext =
                window.AudioContext ||
                window.webkitAudioContext;


            if (!AudioContext) {

                return null;

            }


            adminAudioContext =
                new AudioContext();

        }


        return adminAudioContext;

    }


    function unlockAdminSound()
    {

        const ctx =
            getAdminAudioContext();


        if (!ctx) {

            return;

        }


        if (
            ctx.state ===
            "suspended"
        ) {

            ctx.resume()
                .catch(
                    function () {}
                );

        }

    }


    document.addEventListener(
        "click",
        unlockAdminSound,
        {
            passive:true
        }
    );


    document.addEventListener(
        "touchstart",
        unlockAdminSound,
        {
            passive:true
        }
    );


    document.addEventListener(
        "keydown",
        unlockAdminSound
    );


    // =========================================================
    // ADMIN PROFESSIONAL SOUND
    // =========================================================

    function playSound()
    {

        try {

            const ctx =
                getAdminAudioContext();


            if (!ctx) {

                return;

            }


            if (
                ctx.state ===
                "suspended"
            ) {

                ctx.resume();

            }


            const now =
                ctx.currentTime;


            const frequencies = [
                880,
                1174,
                1568
            ];


            frequencies.forEach(
                function(freq,index)
                {

                    const oscillator =
                        ctx.createOscillator();


                    const gain =
                        ctx.createGain();


                    const start =
                        now +
                        (index * 0.12);


                    oscillator.type =
                        "sine";


                    oscillator.frequency.setValueAtTime(
                        freq,
                        start
                    );


                    gain.gain.setValueAtTime(
                        0.0001,
                        start
                    );


                    gain.gain.exponentialRampToValueAtTime(
                        0.20,
                        start + 0.02
                    );


                    gain.gain.exponentialRampToValueAtTime(
                        0.0001,
                        start + 0.28
                    );


                    oscillator.connect(
                        gain
                    );


                    gain.connect(
                        ctx.destination
                    );


                    oscillator.start(
                        start
                    );


                    oscillator.stop(
                        start + 0.30
                    );

                }
            );


            console.log(
                "🔊 ADMIN NOTIFICATION SOUND PLAYED"
            );

        }
        catch(error) {

            console.log(
                "Admin sound error:",
                error
            );

        }

    }


    // =========================================================
    // ESCAPE
    // =========================================================

    function escapeText(value)
    {

        const div =
            document.createElement(
                "div"
            );


        div.textContent =
            value ?? "";


        return div.innerHTML;

    }


    // =========================================================
    // SHOW POPUP
    // =========================================================

    window.showEnquiryPopup =
        function(enquiry)
        {

            if (
                !popup ||
                !popupContent
            ) {

                return;

            }


            const name =
                escapeText(
                    enquiry.name ||
                    "Customer"
                );


            const email =
                escapeText(
                    enquiry.email ||
                    ""
                );


            const subject =
                escapeText(
                    enquiry.subject ||
                    "New Enquiry"
                );


            const message =
                escapeText(
                    enquiry.message ||
                    ""
                );


            const createdAt =
                escapeText(
                    enquiry.created_at ||
                    ""
                );


            popupContent.innerHTML = `

                <div class="d-flex align-items-start">

                    <div
                        class="rounded-circle
                               d-flex
                               align-items-center
                               justify-content-center
                               text-white
                               me-3"
                        style="
                            width:50px;
                            height:50px;
                            background:#8cc63f;
                            flex-shrink:0;
                        "
                    >

                        <i
                            class="fa-solid fa-user"
                        ></i>

                    </div>


                    <div
                        class="flex-grow-1"
                        style="min-width:0;"
                    >

                        <div
                            class="fw-bold
                                   fs-5
                                   text-dark"
                            style="
                                word-break:break-word;
                            "
                        >

                            ${name}

                        </div>


                        <div
                            class="small
                                   text-muted"
                            style="
                                word-break:break-word;
                            "
                        >

                            <i
                                class="fa-solid
                                       fa-envelope
                                       me-1"
                            ></i>

                            ${email}

                        </div>


                        <div
                            class="mt-3
                                   fw-bold
                                   text-dark"
                            style="
                                word-break:break-word;
                            "
                        >

                            <i
                                class="fa-solid
                                       fa-pen
                                       me-1"
                            ></i>

                            ${subject}

                        </div>


                        <div
                            class="mt-2
                                   p-3
                                   rounded-3
                                   bg-light
                                   small"
                            style="
                                max-height:130px;
                                overflow-y:auto;
                                word-break:break-word;
                            "
                        >

                            ${message}

                        </div>


                        <div
                            class="small
                                   text-muted
                                   mt-2"
                        >

                            <i
                                class="fa-regular
                                       fa-clock
                                       me-1"
                            ></i>

                            ${createdAt}

                        </div>

                    </div>

                </div>

            `;


            popup.style.display =
                "block";


            setTimeout(
                function()
                {

                    popup.style.opacity =
                        "1";


                    popup.style.transform =
                        "translateX(0)";

                },
                10
            );


            clearTimeout(
                popupTimer
            );


            popupTimer =
                setTimeout(
                    function()
                    {

                        hideEnquiryPopup();

                    },
                    15000
                );

        };


    // =========================================================
    // HIDE
    // =========================================================

    window.hideEnquiryPopup =
        function()
        {

            if (!popup) {

                return;

            }


            popup.style.opacity =
                "0";


            popup.style.transform =
                "translateX(40px)";


            setTimeout(
                function()
                {

                    popup.style.display =
                        "none";

                },
                300
            );

        };


    // =========================================================
    // BADGE
    // =========================================================

    function updateBadge(count)
    {

        if (!badge) {

            return;

        }


        if (count > 0) {

            badge.style.display =
                "inline-block";


            badge.textContent =
                count;

        }
        else {

            badge.style.display =
                "none";

        }

    }


    // =========================================================
    // CHECK ADMIN ENQUIRY
    // =========================================================

    function checkEnquiry()
    {

        if (checking) {

            return;

        }


        checking =
            true;


        fetch(
            "{{ route('admin.enquiry.notification') }}",
            {

                method:"GET",

                headers:{

                    "Accept":
                        "application/json",

                    "X-Requested-With":
                        "XMLHttpRequest"

                },

                credentials:
                    "same-origin",

                cache:
                    "no-store"

            }
        )


        .then(
            function(response)
            {

                if (!response.ok) {

                    throw new Error(
                        "HTTP " +
                        response.status
                    );

                }


                return response.json();

            }
        )


        .then(
            function(data)
            {

                if (!data.success) {

                    firstCheck =
                        false;

                    return;

                }


                const enquiries =
                    Array.isArray(
                        data.enquiries
                    )
                    ? data.enquiries
                    : [];


                const count =
                    Number(
                        data.count || 0
                    );


                updateBadge(
                    count
                );


                const currentIds =
                    enquiries
                        .map(
                            function(item)
                            {

                                return Number(
                                    item.id
                                );

                            }
                        )
                        .filter(
                            function(id)
                            {

                                return !isNaN(
                                    id
                                );

                            }
                        );


                // ============================================
                // FIRST CHECK
                // ============================================

                if (firstCheck) {

                    lastKnownIds =
                        currentIds;


                    firstCheck =
                        false;


                    return;

                }


                // ============================================
                // NEW ENQUIRIES
                // ============================================

                const newEnquiries =
                    enquiries.filter(
                        function(item)
                        {

                            const id =
                                Number(
                                    item.id
                                );


                            return !lastKnownIds.includes(
                                id
                            );

                        }
                    );


                // ============================================
                // NEW ENQUIRY FOUND
                // ============================================

                if (
                    newEnquiries.length > 0
                ) {

                    const latest =
                        newEnquiries[0];


                    showEnquiryPopup(
                        latest
                    );


                    // SOUND EVERY NEW ENQUIRY

                    playSound();


                    document.title =
                        "🔔 New Enquiry";


                    setTimeout(
                        function()
                        {

                            document.title =
                                "Admin Dashboard";

                        },
                        5000
                    );

                }


                lastKnownIds =
                    currentIds;

            }
        )


        .catch(
            function(error)
            {

                console.error(
                    "❌ ADMIN NOTIFICATION ERROR:",
                    error
                );

            }
        )


        .finally(
            function()
            {

                checking =
                    false;

            }
        );

    }


    // =========================================================
    // START
    // =========================================================

    function startNotificationSystem()
    {

        console.log(
            "🚀 ADMIN ENQUIRY SYSTEM STARTED"
        );


        checkEnquiry();


        setInterval(
            checkEnquiry,
            3000
        );

    }


    if (
        document.readyState ===
        "loading"
    ) {

        document.addEventListener(
            "DOMContentLoaded",
            startNotificationSystem
        );

    }
    else {

        startNotificationSystem();

    }


})();

</script>

@endif


</body>

</html>