@extends('layout')

@section('title', 'Checkout')

@section('content')

<div class="container-fluid bg-light min-vh-100 py-5"
     style="padding-top:100px !important;">

<div class="container">

    {{-- ================================================= --}}
    {{-- TOP HEADER --}}
    {{-- ================================================= --}}

    <div class="row align-items-center mb-4">

        <div class="col-md-7">

            <div class="d-flex align-items-center">

                <div class="rounded-4 d-flex align-items-center justify-content-center me-3"
                     style="
                        width:58px;
                        height:58px;
                        background:#8cc63f;
                     ">

                    <i class="fa-solid fa-cart-shopping text-white fa-lg"></i>

                </div>

                <div>

                    <div class="small fw-bold text-uppercase"
                         style="
                            color:#8cc63f;
                            letter-spacing:2px;
                         ">

                        Checkout

                    </div>

                    <h2 class="fw-bold mb-0">

                        Complete Your Order

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-5 text-md-end mt-3 mt-md-0">

            <div class="d-inline-flex align-items-center bg-white rounded-pill px-3 py-2 shadow-sm">

                <i class="fa-solid fa-shield-halved text-success me-2"></i>

                <small class="fw-semibold">

                    Secure Checkout

                </small>

            </div>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- ALERTS --}}
    {{-- ================================================= --}}

    @if(session('error'))

        <div class="alert alert-danger border-0 rounded-4 shadow-sm">

            <i class="fa-solid fa-circle-exclamation me-2"></i>

            {{ session('error') }}

        </div>

    @endif


    @if(session('success'))

        <div class="alert alert-success border-0 rounded-4 shadow-sm">

            <i class="fa-solid fa-circle-check me-2"></i>

            {{ session('success') }}

        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-danger border-0 rounded-4 shadow-sm">

            <strong>

                <i class="fa-solid fa-circle-exclamation me-2"></i>

                Please correct the following errors

            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    @if($cartItems->count() > 0)

        @php

            /* =====================================================
               SUBTOTAL
            ===================================================== */

            $subtotal = 0;

            foreach($cartItems as $item) {

                if($item->product) {

                    $subtotal +=
                        $item->product->price *
                        $item->quantity;

                }

            }


            /* =====================================================
               SHIPPING SETTINGS
               Get directly from ShippingSetting table
            ===================================================== */

            $shipping = \App\Models\ShippingSetting::first();

            $shippingChargeSetting = (float) (
                $shipping->shipping_charge ?? 0
            );

            $freeShippingAmount = (float) (
                $shipping->free_shipping_amount ?? 0
            );


            /* =====================================================
               CALCULATE SHIPPING
            ===================================================== */

            if (
                $freeShippingAmount > 0 &&
                $subtotal >= $freeShippingAmount
            ) {

                // Free shipping
                $shippingCharge = 0;

            } else {

                // Normal shipping
                $shippingCharge = $shippingChargeSetting;

            }


            /* =====================================================
               COUPON DISCOUNT
            ===================================================== */

            $couponDiscount = (float) session(
                'coupon_discount',
                0
            );


            /* =====================================================
               FINAL TOTAL
            ===================================================== */

            $grandTotal = max(
                0,
                $subtotal +
                $shippingCharge -
                $couponDiscount
            );

        @endphp


        {{-- ================================================= --}}
        {{-- MAIN CHECKOUT --}}
        {{-- ================================================= --}}

        <div class="row g-4">


            {{-- ================================================= --}}
            {{-- LEFT SIDE --}}
            {{-- ================================================= --}}

            <div class="col-lg-8">


                {{-- ================================================= --}}
                {{-- DELIVERY DETAILS --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-4 shadow-sm p-4 mb-4">

                    <div class="d-flex align-items-center mb-4">

                        <div class="rounded-3 d-flex align-items-center justify-content-center me-3"
                             style="
                                width:45px;
                                height:45px;
                                background:#eef8df;
                             ">

                            <i class="fa-solid fa-location-dot"
                               style="color:#8cc63f;"></i>

                        </div>

                        <div>

                            <h5 class="fw-bold mb-0">

                                Delivery Details

                            </h5>

                            <small class="text-muted">

                                Enter your delivery information

                            </small>

                        </div>

                    </div>


                    <div class="row g-3">


                        {{-- NAME --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold small">

                                Full Name

                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-white">

                                    <i class="fa-solid fa-user"
                                       style="color:#8cc63f;"></i>

                                </span>

                                <input
                                    type="text"
                                    name="name"
                                    form="orderForm"
                                    value="{{ old('name', Auth::user()->name ?? '') }}"
                                    class="form-control"
                                    placeholder="Enter full name"
                                    required
                                >

                            </div>

                        </div>


                        {{-- EMAIL --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold small">

                                Email Address

                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-white">

                                    <i class="fa-solid fa-envelope"
                                       style="color:#8cc63f;"></i>

                                </span>

                                <input
                                    type="email"
                                    name="email"
                                    form="orderForm"
                                    value="{{ old('email', Auth::user()->email ?? '') }}"
                                    class="form-control"
                                    placeholder="Enter email"
                                    required
                                >

                            </div>

                        </div>


                        {{-- MOBILE --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold small">

                                Mobile Number

                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-white">

                                    <i class="fa-solid fa-phone"
                                       style="color:#8cc63f;"></i>

                                </span>

                                <input
                                    type="text"
                                    name="mobile"
                                    form="orderForm"
                                    value="{{ old('mobile') }}"
                                    class="form-control"
                                    placeholder="10 digit mobile"
                                    maxlength="10"
                                    pattern="[0-9]{10}"
                                    required
                                >

                            </div>

                        </div>


                        {{-- PINCODE --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold small">

                                Pincode

                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-white">

                                    <i class="fa-solid fa-location-dot"
                                       style="color:#8cc63f;"></i>

                                </span>

                                <input
                                    type="text"
                                    name="pincode"
                                    form="orderForm"
                                    value="{{ old('pincode') }}"
                                    class="form-control"
                                    placeholder="6 digit pincode"
                                    maxlength="6"
                                    pattern="[0-9]{6}"
                                    required
                                >

                            </div>

                        </div>


                        {{-- ADDRESS --}}

                        <div class="col-12">

                            <label class="form-label fw-semibold small">

                                Delivery Address

                            </label>

                            <textarea
                                name="address"
                                form="orderForm"
                                class="form-control"
                                rows="3"
                                placeholder="House no, street, area..."
                                required
                            >{{ old('address') }}</textarea>

                        </div>


                        {{-- CITY --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold small">

                                City

                            </label>

                            <input
                                type="text"
                                name="city"
                                form="orderForm"
                                value="{{ old('city') }}"
                                class="form-control"
                                placeholder="Enter city"
                                required
                            >

                        </div>


                        {{-- STATE --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold small">

                                State

                            </label>

                            <input
                                type="text"
                                name="state"
                                form="orderForm"
                                value="{{ old('state') }}"
                                class="form-control"
                                placeholder="Enter state"
                                required
                            >

                        </div>

                    </div>

                </div>



                {{-- ================================================= --}}
                {{-- PAYMENT --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-4 shadow-sm p-4 mb-4">

                    <div class="d-flex align-items-center mb-4">

                        <div class="rounded-3 d-flex align-items-center justify-content-center me-3"
                             style="
                                width:45px;
                                height:45px;
                                background:#eef8df;
                             ">

                            <i class="fa-solid fa-wallet"
                               style="color:#8cc63f;"></i>

                        </div>

                        <div>

                            <h5 class="fw-bold mb-0">

                                Payment Method

                            </h5>

                            <small class="text-muted">

                                Choose your preferred payment option

                            </small>

                        </div>

                    </div>


                    {{-- COD --}}

                    <label
                        for="cod"
                        class="d-block border rounded-4 p-3 mb-3"
                        style="cursor:pointer;"
                    >

                        <div class="form-check">

                            <input
                                class="form-check-input"
                                type="radio"
                                name="payment_method"
                                value="Cash on Delivery"
                                id="cod"
                                form="orderForm"
                                checked
                                required
                            >

                            <span class="ms-2">

                                <strong>

                                    <i class="fa-solid fa-money-bill-wave text-success me-2"></i>

                                    Cash on Delivery

                                </strong>

                                <small class="d-block text-muted ms-4 mt-1">

                                    Pay when your order arrives.

                                </small>

                            </span>

                        </div>

                    </label>



                    {{-- ================================================= --}}
                    {{-- UPI --}}
                    {{-- ================================================= --}}

                    <div class="border rounded-4 p-4 mb-3">

                        <div class="form-check">

                            <input
                                class="form-check-input"
                                type="radio"
                                name="payment_method"
                                value="UPI"
                                id="upi"
                                form="orderForm"
                            >

                            <label
                                class="form-check-label fw-semibold"
                                for="upi"
                                style="cursor:pointer;"
                            >

                                <i
                                    class="fa-solid fa-qrcode me-2"
                                    style="color:#8cc63f;"
                                ></i>

                                UPI Payment

                            </label>

                        </div>


                        <div
                            id="upiBox"
                            class="text-center mt-4"
                            style="display:none;"
                        >

                            <div
                                class="rounded-4 p-4"
                                style="
                                    background:#f9fbf4;
                                    border:1px solid #e1ebcc;
                                "
                            >

                                <span
                                    class="badge rounded-pill text-white px-3 py-2 mb-3"
                                    style="
                                        background:#8cc63f;
                                        font-size:10px;
                                        letter-spacing:1px;
                                    "
                                >

                                    SCAN & PAY

                                </span>


                                <h5 class="fw-bold">

                                    Scan QR Code

                                </h5>


                                <p class="text-muted small">

                                    Scan this QR using
                                    Google Pay, PhonePe, Paytm or BHIM

                                </p>


                                <div
                                    id="qrcode"
                                    class="d-flex justify-content-center my-4"
                                >
                                </div>


                                <div class="rounded-3 p-3 bg-white border">

                                    <small class="text-muted d-block">

                                        UPI ID

                                    </small>

                                    <strong id="displayUpiId">

                                        {{ $setting->upi_id ?? 'Not configured' }}

                                    </strong>

                                </div>


                                <div class="mt-3">

                                    <small class="text-muted">

                                        Merchant

                                    </small>

                                    <div class="fw-semibold">

                                        {{ $setting->merchant_name
                                            ?? 'Classic Glasses Store' }}

                                    </div>

                                </div>


                                {{-- UPI AMOUNT INCLUDING SHIPPING --}}

                                <div class="mt-3">

                                    <small class="text-muted">

                                        Amount

                                    </small>

                                    <h4
                                        class="fw-bold mb-0"
                                        style="color:#8cc63f;"
                                    >

                                        ₹<span id="upiAmount">

                                            {{ number_format($grandTotal, 2) }}

                                        </span>

                                    </h4>

                                </div>


                                @if(!$setting || !$setting->upi_id)

                                    <div
                                        class="alert alert-warning rounded-3 mt-4 mb-0 small"
                                    >

                                        <i class="fa-solid fa-triangle-exclamation me-2"></i>

                                        UPI payment is currently not configured.

                                    </div>

                                @else

                                    <div class="small text-success mt-3">

                                        <i class="fa-solid fa-circle-check me-1"></i>

                                        UPI payment is ready.

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>



                    {{-- ================================================= --}}
                    {{-- CARD --}}
                    {{-- ================================================= --}}

                    <label
                        for="card"
                        class="d-block border rounded-4 p-3"
                        style="cursor:pointer;"
                    >

                        <div class="form-check">

                            <input
                                class="form-check-input"
                                type="radio"
                                name="payment_method"
                                value="Credit/Debit Card"
                                id="card"
                                form="orderForm"
                            >

                            <span class="ms-2">

                                <strong>

                                    <i class="fa-solid fa-credit-card text-warning me-2"></i>

                                    Credit / Debit Card

                                </strong>

                                <small class="d-block text-muted ms-4 mt-1">

                                    Secure card payment.

                                </small>

                            </span>

                        </div>


                        <div
                            id="cardDetails"
                            class="mt-3"
                            style="display:none;"
                        >

                            <div
                                class="rounded-4 p-4"
                                style="background:#f7faf2;"
                            >

                                <h6 class="fw-bold mb-3">

                                    <i class="fa-solid fa-lock text-success me-2"></i>

                                    Secure Card Details

                                </h6>


                                <div class="mb-3">

                                    <label class="form-label small fw-semibold">

                                        Card Holder Name

                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        name="card_holder_name"
                                        id="card_holder_name"
                                        placeholder="Card holder name"
                                        form="orderForm"
                                        autocomplete="cc-name"
                                    >

                                </div>


                                <div class="mb-3">

                                    <label class="form-label small fw-semibold">

                                        Card Number

                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text bg-white">

                                            <i class="fa-solid fa-credit-card"></i>

                                        </span>

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="card_number"
                                            id="card_number"
                                            placeholder="1234 5678 9012 3456"
                                            maxlength="19"
                                            inputmode="numeric"
                                            form="orderForm"
                                            autocomplete="cc-number"
                                        >

                                    </div>

                                </div>


                                <div class="row g-3">

                                    <div class="col-md-6">

                                        <label class="form-label small fw-semibold">

                                            Expiry Date

                                        </label>

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="card_expiry"
                                            id="card_expiry"
                                            placeholder="MM/YY"
                                            maxlength="5"
                                            inputmode="numeric"
                                            form="orderForm"
                                        >

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label small fw-semibold">

                                            CVV

                                        </label>

                                        <input
                                            type="password"
                                            class="form-control"
                                            name="card_cvv"
                                            id="card_cvv"
                                            placeholder="123"
                                            maxlength="4"
                                            inputmode="numeric"
                                            form="orderForm"
                                        >

                                    </div>

                                </div>


                                <small class="text-muted d-block mt-3">

                                    <i class="fa-solid fa-shield-halved text-success me-1"></i>

                                    Your payment information is secure.

                                </small>

                            </div>

                        </div>

                    </label>

                </div>



                {{-- ================================================= --}}
                {{-- YOUR ORDER --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-4 shadow-sm p-4">

                    <div class="d-flex align-items-center justify-content-between mb-3">

                        <div>

                            <h5 class="fw-bold mb-0">

                                <i
                                    class="fa-solid fa-bag-shopping me-2"
                                    style="color:#8cc63f;"
                                ></i>

                                Your Order

                            </h5>

                            <small class="text-muted">

                                {{ $cartItems->sum('quantity') }} item(s)

                            </small>

                        </div>

                    </div>


                    @foreach($cartItems as $item)

                        @if($item->product)

                            @php

                                $itemTotal =
                                    $item->product->price *
                                    $item->quantity;

                            @endphp


                            <div class="border rounded-4 p-3 mb-2">

                                <div class="d-flex align-items-center">

                                    <div
                                        class="rounded-3 overflow-hidden"
                                        style="
                                            width:70px;
                                            height:70px;
                                            flex-shrink:0;
                                        "
                                    >

                                        @if($item->product->image)

                                            <img
                                                src="{{ asset('product-images/' . $item->product->image) }}"
                                                alt="{{ $item->product->name }}"
                                                class="w-100 h-100"
                                                style="object-fit:cover;"
                                            >

                                        @else

                                            <div
                                                class="w-100 h-100 bg-light d-flex align-items-center justify-content-center"
                                            >

                                                <i class="fa-solid fa-image text-muted"></i>

                                            </div>

                                        @endif

                                    </div>


                                    <div class="flex-grow-1 ms-3">

                                        <h6 class="fw-bold mb-1">

                                            {{ $item->product->name }}

                                        </h6>

                                        <small class="text-muted">

                                            ₹{{ number_format($item->product->price, 2) }}

                                            ×

                                            {{ $item->quantity }}

                                        </small>

                                    </div>


                                    <div class="fw-bold">

                                        ₹{{ number_format($itemTotal, 2) }}

                                    </div>

                                </div>

                            </div>

                        @endif

                    @endforeach

                </div>

            </div>



            {{-- ================================================= --}}
            {{-- RIGHT SUMMARY --}}
            {{-- ================================================= --}}

            <div class="col-lg-4">

                <div class="bg-white rounded-4 shadow-sm overflow-hidden">


                    {{-- SUMMARY HEADER --}}

                    <div
                        class="p-4"
                        style="
                            background:#8cc63f;
                            color:white;
                        "
                    >

                        <div class="d-flex align-items-center">

                            <div
                                class="rounded-circle bg-white d-flex align-items-center justify-content-center me-3"
                                style="
                                    width:48px;
                                    height:48px;
                                "
                            >

                                <i
                                    class="fa-solid fa-receipt"
                                    style="color:#8cc63f;"
                                ></i>

                            </div>

                            <div>

                                <h5 class="fw-bold mb-0">

                                    Order Summary

                                </h5>

                                <small class="opacity-75">

                                    Review before placing order

                                </small>

                            </div>

                        </div>

                    </div>


                    {{-- SUMMARY BODY --}}

                    <div class="p-4">


                        {{-- SUBTOTAL --}}

                        <div class="d-flex justify-content-between mb-3">

                            <span class="text-muted">

                                Subtotal

                            </span>

                            <strong>

                                ₹{{ number_format($subtotal, 2) }}

                            </strong>

                        </div>


                        {{-- COUPON --}}

                        <div
                            class="border rounded-4 p-3 mb-3"
                            style="background:#f9fbf4;"
                        >

                            <div class="d-flex align-items-center mb-2">

                                <i
                                    class="fa-solid fa-ticket me-2"
                                    style="color:#8cc63f;"
                                ></i>

                                <strong>

                                    Have a Coupon?

                                </strong>

                            </div>


                            <form
                                action="{{ route('coupon.apply') }}"
                                method="POST"
                            >

                                @csrf

                                <div class="input-group">

                                    <input
                                        type="text"
                                        name="coupon_code"
                                        class="form-control"
                                        placeholder="Enter coupon code"
                                        value="{{ session('coupon_code') ?? '' }}"
                                        style="text-transform:uppercase;"
                                        required
                                    >

                                    <button
                                        type="submit"
                                        class="btn text-white fw-semibold"
                                        style="background:#8cc63f;"
                                    >

                                        Apply

                                    </button>

                                </div>

                            </form>


                            @if(session('coupon_success'))

                                <div class="small text-success mt-2">

                                    <i class="fa-solid fa-circle-check me-1"></i>

                                    {{ session('coupon_success') }}

                                </div>

                            @endif


                            @if(session('coupon_error'))

                                <div class="small text-danger mt-2">

                                    <i class="fa-solid fa-circle-exclamation me-1"></i>

                                    {{ session('coupon_error') }}

                                </div>

                            @endif


                            @if(session('coupon_code'))

                                <form
                                    action="{{ route('coupon.remove') }}"
                                    method="POST"
                                    class="mt-2"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-outline-danger rounded-pill"
                                    >

                                        <i class="fa-solid fa-xmark me-1"></i>

                                        Remove Coupon

                                    </button>

                                </form>

                            @endif

                        </div>


                        {{-- COUPON DISCOUNT --}}

                        @if(session('coupon_code') && session('coupon_discount', 0) > 0)

                            <div class="d-flex justify-content-between mb-3">

                                <span class="text-muted">

                                    Coupon Discount

                                </span>

                                <strong class="text-success">

                                    - ₹{{ number_format(session('coupon_discount'), 2) }}

                                </strong>

                            </div>

                        @endif


                        {{-- ================================================= --}}
                        {{-- SHIPPING CHARGE --}}
                        {{-- ================================================= --}}

                        <div class="d-flex justify-content-between mb-3">

                            <span class="text-muted">

                                <i
                                    class="fa-solid fa-truck-fast me-1"
                                    style="color:#8cc63f;"
                                ></i>

                                Shipping Charges

                            </span>


                            @if($shippingCharge > 0)

                                <strong>

                                    ₹{{ number_format($shippingCharge, 2) }}

                                </strong>

                            @else

                                <strong class="text-success">

                                    FREE

                                </strong>

                            @endif

                        </div>


                        {{-- FREE SHIPPING MESSAGE --}}

                        @if(
                            $freeShippingAmount > 0 &&
                            $subtotal < $freeShippingAmount
                        )

                            <div
                                class="alert alert-light border rounded-3 small py-2 mb-3"
                            >

                                <i
                                    class="fa-solid fa-circle-info me-1"
                                    style="color:#8cc63f;"
                                ></i>

                                Add

                                <strong>
                                    ₹{{ number_format($freeShippingAmount - $subtotal, 2) }}
                                </strong>

                                more to get

                                <strong class="text-success">
                                    FREE shipping
                                </strong>

                            </div>

                        @elseif(
                            $freeShippingAmount > 0 &&
                            $subtotal >= $freeShippingAmount
                        )

                            <div
                                class="alert alert-success border-0 rounded-3 small py-2 mb-3"
                            >

                                <i class="fa-solid fa-circle-check me-1"></i>

                                Congratulations! You got

                                <strong>FREE shipping.</strong>

                            </div>

                        @endif


                        <hr>


                        {{-- GRAND TOTAL --}}

                        <div
                            class="d-flex justify-content-between align-items-center mb-4"
                        >

                            <span class="fw-bold fs-5">

                                Total

                            </span>

                            <span
                                class="fw-bold fs-3"
                                style="color:#8cc63f;"
                            >

                                ₹{{ number_format($grandTotal, 2) }}

                            </span>

                        </div>


                        {{-- ORDER FORM --}}

                        <form
                            action="{{ route('order.place') }}"
                            method="POST"
                            id="orderForm"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="btn w-100 text-white rounded-pill py-3 fw-bold"
                                style="
                                    background:#8cc63f;
                                    border:0;
                                "
                            >

                                <i class="fa-solid fa-lock me-2"></i>

                                Place Order Securely

                            </button>

                        </form>


                        {{-- BACK TO CART --}}

                        <a
                            href="{{ route('cart') }}"
                            class="btn btn-light border w-100 rounded-pill py-3 mt-2 fw-semibold"
                        >

                            <i class="fa-solid fa-arrow-left me-2"></i>

                            Back to Cart

                        </a>


                        <div class="text-center mt-3">

                            <small class="text-muted">

                                <i
                                    class="fa-solid fa-shield-halved text-success me-1"
                                ></i>

                                Secure & safe checkout

                            </small>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- BENEFITS --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-4 shadow-sm p-4 mt-3">

                    <h6 class="fw-bold mb-4">

                        Why Shop With Us?

                    </h6>


                    <div class="d-flex align-items-center mb-3">

                        <div
                            class="rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="
                                width:42px;
                                height:42px;
                                background:#eef8df;
                            "
                        >

                            <i
                                class="fa-solid fa-truck-fast"
                                style="color:#8cc63f;"
                            ></i>

                        </div>

                        <div>

                            <div class="fw-bold small">

                                Fast Delivery

                            </div>

                            <small class="text-muted">

                                Quick & reliable delivery

                            </small>

                        </div>

                    </div>


                    <div class="d-flex align-items-center mb-3">

                        <div
                            class="rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="
                                width:42px;
                                height:42px;
                                background:#eef8df;
                            "
                        >

                            <i
                                class="fa-solid fa-shield-halved"
                                style="color:#8cc63f;"
                            ></i>

                        </div>

                        <div>

                            <div class="fw-bold small">

                                Secure Payment

                            </div>

                            <small class="text-muted">

                                Safe checkout process

                            </small>

                        </div>

                    </div>


                    <div class="d-flex align-items-center">

                        <div
                            class="rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="
                                width:42px;
                                height:42px;
                                background:#eef8df;
                            "
                        >

                            <i
                                class="fa-solid fa-headset"
                                style="color:#8cc63f;"
                            ></i>

                        </div>

                        <div>

                            <div class="fw-bold small">

                                Customer Support

                            </div>

                            <small class="text-muted">

                                We're here to help

                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>


    @else

        {{-- ================================================= --}}
        {{-- EMPTY CART --}}
        {{-- ================================================= --}}

        <div class="bg-white rounded-4 shadow-sm text-center p-5">

            <div
                class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                style="
                    width:100px;
                    height:100px;
                    background:#eef8df;
                "
            >

                <i
                    class="fa-solid fa-cart-shopping fa-2x"
                    style="color:#8cc63f;"
                ></i>

            </div>


            <h3 class="fw-bold">

                Your Cart is Empty

            </h3>


            <p class="text-muted">

                Add some eyewear products before checkout.

            </p>


            <a
                href="{{ route('products.index') }}"
                class="btn text-white rounded-pill px-4 py-2 fw-bold"
                style="background:#8cc63f;"
            >

                <i class="fa-solid fa-glasses me-2"></i>

                Explore Products

            </a>

        </div>

    @endif

</div>
```

</div>

{{-- ============================================================ --}}
{{-- QR CODE LIBRARY --}}
{{-- ============================================================ --}}

<script
    src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js">
</script>

{{-- ============================================================ --}}
{{-- JAVASCRIPT --}}
{{-- ============================================================ --}}

<script>

document.addEventListener("DOMContentLoaded", function () {


    const upiRadio =
        document.getElementById("upi");


    const codRadio =
        document.getElementById("cod");


    const cardRadio =
        document.getElementById("card");


    const upiBox =
        document.getElementById("upiBox");


    const cardDetails =
        document.getElementById("cardDetails");


    const qrCode =
        document.getElementById("qrcode");


    const upiAmount =
        document.getElementById("upiAmount");


    {{-- ADMIN UPI SETTINGS --}}

    const upiId =
        @json($setting->upi_id ?? '');


    const merchantName =
        @json($setting->merchant_name ?? 'Classic Glasses Store');


    {{-- FINAL AMOUNT INCLUDING SHIPPING --}}

    const amount =
        {{ number_format($grandTotal, 2, '.', '') }};


    {{-- ======================================================== --}}
    {{-- GENERATE UPI QR --}}
    {{-- ======================================================== --}}

    function generateUpiQr() {


        if (qrCode) {

            qrCode.innerHTML = "";

        }


        if (upiAmount) {

            upiAmount.innerText =
                amount.toFixed(2);

        }


        if (!upiId) {

            return;

        }


        const upiUrl =
            "upi://pay" +
            "?pa=" +
            encodeURIComponent(upiId) +
            "&pn=" +
            encodeURIComponent(merchantName) +
            "&am=" +
            encodeURIComponent(amount.toFixed(2)) +
            "&cu=INR";


        if (
            typeof QRCode !== "undefined" &&
            qrCode
        ) {

            new QRCode(
                qrCode,
                {
                    text: upiUrl,
                    width: 220,
                    height: 220,
                    colorDark: "#222222",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                }
            );

        }

    }


    {{-- ======================================================== --}}
    {{-- PAYMENT TOGGLE --}}
    {{-- ======================================================== --}}

    function updatePaymentView() {


        if (
            upiRadio &&
            upiRadio.checked
        ) {

            if (upiBox) {

                upiBox.style.display = "block";

            }

            generateUpiQr();

        }

        else {

            if (upiBox) {

                upiBox.style.display = "none";

            }

        }


        if (
            cardRadio &&
            cardRadio.checked
        ) {

            if (cardDetails) {

                cardDetails.style.display = "block";

            }

        }

        else {

            if (cardDetails) {

                cardDetails.style.display = "none";

            }

        }

    }


    {{-- PAYMENT EVENTS --}}

    const paymentMethods =
        document.querySelectorAll(
            'input[name="payment_method"]'
        );


    paymentMethods.forEach(function (radio) {

        radio.addEventListener(
            "change",
            updatePaymentView
        );

    });


    updatePaymentView();


    {{-- ======================================================== --}}
    {{-- CARD NUMBER --}}
    {{-- ======================================================== --}}

    const cardNumber =
        document.getElementById("card_number");


    if (cardNumber) {

        cardNumber.addEventListener(
            "input",
            function () {

                let value =
                    this.value
                        .replace(/\D/g, "")
                        .substring(0, 16);


                let formatted =
                    value.match(/.{1,4}/g);


                this.value =
                    formatted
                    ? formatted.join(" ")
                    : "";

            }
        );

    }


    {{-- ======================================================== --}}
    {{-- EXPIRY --}}
    {{-- ======================================================== --}}

    const expiry =
        document.getElementById("card_expiry");


    if (expiry) {

        expiry.addEventListener(
            "input",
            function () {

                let value =
                    this.value
                        .replace(/\D/g, "")
                        .substring(0, 4);


                if (value.length >= 3) {

                    value =
                        value.substring(0, 2) +
                        "/" +
                        value.substring(2);

                }


                this.value = value;

            }
        );

    }


    {{-- ======================================================== --}}
    {{-- CVV --}}
    {{-- ======================================================== --}}

    const cvv =
        document.getElementById("card_cvv");


    if (cvv) {

        cvv.addEventListener(
            "input",
            function () {

                this.value =
                    this.value
                        .replace(/\D/g, "")
                        .substring(0, 4);

            }
        );

    }


    {{-- ======================================================== --}}
    {{-- CARD HOLDER --}}
    {{-- ======================================================== --}}

    const cardHolder =
        document.getElementById("card_holder_name");


    if (cardHolder) {

        cardHolder.addEventListener(
            "input",
            function () {

                this.value =
                    this.value.replace(
                        /[^a-zA-Z\s]/g,
                        ""
                    );

            }
        );

    }

});

</script>

@endsection
