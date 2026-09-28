
@extends('layout')

@section('title', 'My Cart')

@section('content')

<div class="container py-5">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

        <div>

            <span
                class="text-uppercase fw-bold small"
                style="color:#8cc63f;letter-spacing:2px;"
            >
                Shopping Cart
            </span>

            <h2 class="fw-bold mb-1">
                My Cart
            </h2>

            @if(Auth::check())

                <p class="text-muted mb-0">
                    Hello, {{ Auth::user()->name }} 👋
                </p>

            @endif

        </div>


        {{-- CONTINUE SHOPPING --}}

        <a
            href="{{ route('products.index') }}"
            class="btn btn-light border rounded-pill px-4 py-2 fw-semibold"
        >

            <i class="fa-solid fa-arrow-left me-2"></i>

            Continue Shopping

        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ========================================================= --}}

    @if(session('success'))

        <div
            class="alert alert-success alert-dismissible fade show rounded-3"
        >

            <i class="fa-solid fa-circle-check me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- ERROR MESSAGE --}}
    {{-- ========================================================= --}}

    @if(session('error'))

        <div
            class="alert alert-danger alert-dismissible fade show rounded-3"
        >

            <i class="fa-solid fa-circle-exclamation me-2"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- CART HAS ITEMS --}}
    {{-- ========================================================= --}}

    @if($cartItems->count() > 0)

        @php

            /*
            |--------------------------------------------------------------------------
            | SUBTOTAL
            |--------------------------------------------------------------------------
            */

            $subtotal = 0;

            foreach($cartItems as $item) {

                if($item->product) {

                    $subtotal +=
                        (float) $item->product->price *
                        (int) $item->quantity;

                }

            }


            /*
            |--------------------------------------------------------------------------
            | SHIPPING SETTINGS
            |--------------------------------------------------------------------------
            |
            | Admin shipping settings are stored in:
            |
            | shipping_settings
            |
            | We get:
            |
            | shipping_charge
            | free_shipping_amount
            |
            */

            $shippingSetting = \Illuminate\Support\Facades\DB::table('shipping_settings')
                ->latest('id')
                ->first();


            /*
            |--------------------------------------------------------------------------
            | DEFAULT VALUES
            |--------------------------------------------------------------------------
            */

            $adminShippingFee = 0;

            $freeShippingAmount = 2000;


            /*
            |--------------------------------------------------------------------------
            | GET ADMIN SHIPPING CHARGE
            |--------------------------------------------------------------------------
            */

            if($shippingSetting) {

                if(isset($shippingSetting->shipping_charge)) {

                    $adminShippingFee =
                        (float) $shippingSetting->shipping_charge;

                }

                elseif(isset($shippingSetting->charge)) {

                    $adminShippingFee =
                        (float) $shippingSetting->charge;

                }

                elseif(isset($shippingSetting->amount)) {

                    $adminShippingFee =
                        (float) $shippingSetting->amount;

                }


                /*
                |--------------------------------------------------------------------------
                | GET FREE SHIPPING ABOVE AMOUNT
                |--------------------------------------------------------------------------
                */

                if(
                    isset($shippingSetting->free_shipping_amount)
                    &&
                    $shippingSetting->free_shipping_amount !== null
                ) {

                    $freeShippingAmount =
                        (float) $shippingSetting->free_shipping_amount;

                }

            }


            /*
            |--------------------------------------------------------------------------
            | PREVENT NEGATIVE VALUES
            |--------------------------------------------------------------------------
            */

            if($adminShippingFee < 0) {

                $adminShippingFee = 0;

            }

            if($freeShippingAmount < 0) {

                $freeShippingAmount = 0;

            }


            /*
            |--------------------------------------------------------------------------
            | SHIPPING CALCULATION
            |--------------------------------------------------------------------------
            |
            | If subtotal >= admin free shipping amount:
            |
            | FREE SHIPPING
            |
            | Otherwise:
            |
            | Admin shipping charge
            |
            */

            if($subtotal >= $freeShippingAmount) {

                $delivery = 0;

            } else {

                $delivery = $adminShippingFee;

            }


            /*
            |--------------------------------------------------------------------------
            | GRAND TOTAL
            |--------------------------------------------------------------------------
            */

            $grandTotal =
                $subtotal +
                $delivery;


            /*
            |--------------------------------------------------------------------------
            | PREVENT NEGATIVE GRAND TOTAL
            |--------------------------------------------------------------------------
            */

            if($grandTotal < 0) {

                $grandTotal = 0;

            }


            /*
            |--------------------------------------------------------------------------
            | AMOUNT REMAINING FOR FREE SHIPPING
            |--------------------------------------------------------------------------
            */

            $remainingForFreeShipping =
                $freeShippingAmount - $subtotal;


            if($remainingForFreeShipping < 0) {

                $remainingForFreeShipping = 0;

            }

        @endphp


        <div class="row g-4">


            {{-- ===================================================== --}}
            {{-- CART ITEMS --}}
            {{-- ===================================================== --}}

            <div class="col-lg-8">

                <div class="card border-0 shadow-sm rounded-4">


                    {{-- CARD HEADER --}}

                    <div class="card-header bg-white border-0 p-4">

                        <h5 class="fw-bold mb-0">

                            <i
                                class="fa-solid fa-cart-shopping me-2"
                                style="color:#8cc63f;"
                            ></i>

                            Your Cart

                            <span
                                class="badge rounded-pill ms-2"
                                style="background-color:#8cc63f;"
                            >

                                {{ $cartItems->count() }}

                            </span>

                        </h5>

                    </div>


                    {{-- CARD BODY --}}

                    <div class="card-body p-3">


                        @foreach($cartItems as $item)

                            @if($item->product)

                                @php

                                    $itemTotal =
                                        (float) $item->product->price *
                                        (int) $item->quantity;

                                @endphp


                                {{-- ================================================= --}}
                                {{-- SINGLE CART ITEM --}}
                                {{-- ================================================= --}}

                                <div
                                    class="card border-0 bg-light rounded-4 mb-3"
                                >

                                    <div class="card-body p-3">

                                        <div
                                            class="row align-items-center g-3"
                                        >


                                            {{-- ================================================= --}}
                                            {{-- IMAGE --}}
                                            {{-- ================================================= --}}

                                            <div
                                                class="col-4 col-sm-3 col-md-2"
                                            >

                                                <div
                                                    class="rounded-3 overflow-hidden bg-white"
                                                    style="height:100px;"
                                                >

                                                    @if($item->product->image)

                                                        <img
                                                            src="{{ asset('product-images/' . $item->product->image) }}"
                                                            alt="{{ $item->product->name }}"
                                                            class="w-100 h-100"
                                                            style="object-fit:cover;"
                                                        >

                                                    @elseif(
                                                        isset($item->product->images)
                                                        &&
                                                        $item->product->images->count() > 0
                                                    )

                                                        <img
                                                            src="{{ asset('product-images/' . $item->product->images->first()->image) }}"
                                                            alt="{{ $item->product->name }}"
                                                            class="w-100 h-100"
                                                            style="object-fit:cover;"
                                                        >

                                                    @else

                                                        <div
                                                            class="w-100 h-100 d-flex align-items-center justify-content-center"
                                                        >

                                                            <i
                                                                class="fa-solid fa-image fa-2x text-muted"
                                                            ></i>

                                                        </div>

                                                    @endif

                                                </div>

                                            </div>


                                            {{-- ================================================= --}}
                                            {{-- PRODUCT DETAILS --}}
                                            {{-- ================================================= --}}

                                            <div
                                                class="col-8 col-sm-9 col-md-4"
                                            >

                                                <span
                                                    class="badge rounded-pill mb-2"
                                                    style="background-color:#8cc63f;"
                                                >

                                                    {{ $item->product->category }}

                                                </span>


                                                <h6 class="fw-bold mb-1">

                                                    {{ $item->product->name }}

                                                </h6>


                                                <p
                                                    class="text-muted small mb-1"
                                                >

                                                    ₹{{ number_format($item->product->price, 2) }}

                                                    ×

                                                    {{ $item->quantity }}

                                                </p>

                                            </div>


                                            {{-- ================================================= --}}
                                            {{-- QUANTITY --}}
                                            {{-- ================================================= --}}

                                            <div
                                                class="col-6 col-md-3 text-center"
                                            >

                                                <small
                                                    class="text-muted d-block mb-2"
                                                >

                                                    Quantity

                                                </small>


                                                <div
                                                    class="d-flex justify-content-center align-items-center gap-2"
                                                >


                                                    {{-- MINUS --}}

                                                    <form
                                                        action="{{ route('cart.decrease', $item->id) }}"
                                                        method="POST"
                                                    >

                                                        @csrf

                                                        <button
                                                            type="submit"
                                                            class="btn btn-light border rounded-circle"
                                                            style="
                                                                width:35px;
                                                                height:35px;
                                                            "
                                                        >

                                                            <i
                                                                class="fa-solid fa-minus"
                                                            ></i>

                                                        </button>

                                                    </form>


                                                    {{-- QUANTITY NUMBER --}}

                                                    <span
                                                        class="fw-bold px-2"
                                                    >

                                                        {{ $item->quantity }}

                                                    </span>


                                                    {{-- PLUS --}}

                                                    <form
                                                        action="{{ route('cart.increase', $item->id) }}"
                                                        method="POST"
                                                    >

                                                        @csrf

                                                        <button
                                                            type="submit"
                                                            class="btn text-white rounded-circle"
                                                            style="
                                                                width:35px;
                                                                height:35px;
                                                                background-color:#8cc63f;
                                                            "
                                                        >

                                                            <i
                                                                class="fa-solid fa-plus"
                                                            ></i>

                                                        </button>

                                                    </form>

                                                </div>

                                            </div>


                                            {{-- ================================================= --}}
                                            {{-- TOTAL + REMOVE --}}
                                            {{-- ================================================= --}}

                                            <div
                                                class="col-6 col-md-3 text-end"
                                            >

                                                <div
                                                    class="fw-bold fs-6 mb-2"
                                                    style="color:#8cc63f;"
                                                >

                                                    ₹{{ number_format($itemTotal, 2) }}

                                                </div>


                                                <form
                                                    action="{{ route('cart.remove', $item->id) }}"
                                                    method="POST"
                                                >

                                                    @csrf

                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="btn btn-outline-danger btn-sm rounded-pill px-3"
                                                        onclick="return confirm('Remove this product from cart?');"
                                                    >

                                                        <i
                                                            class="fa-solid fa-trash me-1"
                                                        ></i>

                                                        Remove

                                                    </button>

                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @endif

                        @endforeach

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- ORDER SUMMARY --}}
            {{-- ===================================================== --}}

            <div class="col-lg-4">

                <div
                    class="card border-0 shadow-sm rounded-4"
                >

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-4">

                            <i
                                class="fa-solid fa-receipt me-2"
                                style="color:#8cc63f;"
                            ></i>

                            Order Summary

                        </h5>


                        {{-- ================================================= --}}
                        {{-- SUBTOTAL --}}
                        {{-- ================================================= --}}

                        <div
                            class="d-flex justify-content-between mb-3"
                        >

                            <span class="text-muted">

                                Subtotal

                            </span>

                            <span class="fw-semibold">

                                ₹{{ number_format($subtotal, 2) }}

                            </span>

                        </div>


                        {{-- ================================================= --}}
                        {{-- SHIPPING --}}
                        {{-- ================================================= --}}

                        <div
                            class="d-flex justify-content-between mb-3"
                        >

                            <span class="text-muted">

                                <i
                                    class="fa-solid fa-truck me-1"
                                ></i>

                                Shipping

                            </span>


                            @if($subtotal >= $freeShippingAmount)

                                <span
                                    class="fw-semibold text-success"
                                >

                                    FREE

                                </span>

                            @elseif($delivery > 0)

                                <span class="fw-semibold">

                                    ₹{{ number_format($delivery, 2) }}

                                </span>

                            @else

                                <span
                                    class="fw-semibold text-success"
                                >

                                    FREE

                                </span>

                            @endif

                        </div>


                        {{-- ================================================= --}}
                        {{-- FREE SHIPPING MESSAGE --}}
                        {{-- ================================================= --}}

                        @if($subtotal >= $freeShippingAmount)

                            <div
                                class="alert alert-success py-2 px-3 rounded-3 small mb-3"
                            >

                                <i
                                    class="fa-solid fa-circle-check me-1"
                                ></i>

                                Congratulations! You got FREE shipping.

                            </div>

                        @else

                            @if($freeShippingAmount > 0)

                                <div
                                    class="alert alert-light border py-2 px-3 rounded-3 small mb-3"
                                >

                                    <i
                                        class="fa-solid fa-info-circle me-1"
                                        style="color:#8cc63f;"
                                    ></i>

                                    Add

                                    <strong>
                                        ₹{{ number_format($remainingForFreeShipping, 2) }}
                                    </strong>

                                    more to get FREE shipping.

                                    <div class="mt-1 text-muted">

                                        Free shipping above
                                        ₹{{ number_format($freeShippingAmount, 2) }}

                                    </div>

                                </div>

                            @endif

                        @endif


                        <hr>


                        {{-- ================================================= --}}
                        {{-- GRAND TOTAL --}}
                        {{-- ================================================= --}}

                        <div
                            class="d-flex justify-content-between align-items-center mb-4"
                        >

                            <span class="fw-bold">

                                Grand Total

                            </span>

                            <span
                                class="fw-bold fs-4"
                                style="color:#8cc63f;"
                            >

                                ₹{{ number_format($grandTotal, 2) }}

                            </span>

                        </div>


                        {{-- ================================================= --}}
                        {{-- CHECKOUT BUTTON --}}
                        {{-- ================================================= --}}

                        <a
                            href="{{ route('checkout') }}"
                            class="btn w-100 text-white rounded-pill py-3 fw-bold"
                            style="background-color:#8cc63f;"
                        >

                            Proceed to Checkout

                            <i
                                class="fa-solid fa-arrow-right ms-2"
                            ></i>

                        </a>


                        {{-- ================================================= --}}
                        {{-- SECURE CHECKOUT --}}
                        {{-- ================================================= --}}

                        <div class="text-center mt-3">

                            <small class="text-muted">

                                <i
                                    class="fa-solid fa-shield-halved me-1"
                                ></i>

                                Secure checkout

                            </small>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- BENEFITS --}}
                {{-- ================================================= --}}

                <div
                    class="card border-0 bg-light rounded-4 mt-3"
                >

                    <div class="card-body p-4">


                        {{-- FAST DELIVERY --}}

                        <div
                            class="d-flex align-items-center mb-3"
                        >

                            <div
                                class="rounded-circle bg-white d-flex align-items-center justify-content-center me-3 shadow-sm"
                                style="
                                    width:45px;
                                    height:45px;
                                "
                            >

                                <i
                                    class="fa-solid fa-truck-fast"
                                    style="color:#8cc63f;"
                                ></i>

                            </div>

                            <div>

                                <h6 class="fw-bold mb-0">

                                    Fast Delivery

                                </h6>

                                <small class="text-muted">

                                    Quick & reliable delivery

                                </small>

                            </div>

                        </div>


                        {{-- SECURE PAYMENT --}}

                        <div
                            class="d-flex align-items-center mb-3"
                        >

                            <div
                                class="rounded-circle bg-white d-flex align-items-center justify-content-center me-3 shadow-sm"
                                style="
                                    width:45px;
                                    height:45px;
                                "
                            >

                                <i
                                    class="fa-solid fa-shield-halved"
                                    style="color:#8cc63f;"
                                ></i>

                            </div>

                            <div>

                                <h6 class="fw-bold mb-0">

                                    Secure Payment

                                </h6>

                                <small class="text-muted">

                                    Safe & secure checkout

                                </small>

                            </div>

                        </div>


                        {{-- CUSTOMER SUPPORT --}}

                        <div
                            class="d-flex align-items-center"
                        >

                            <div
                                class="rounded-circle bg-white d-flex align-items-center justify-content-center me-3 shadow-sm"
                                style="
                                    width:45px;
                                    height:45px;
                                "
                            >

                                <i
                                    class="fa-solid fa-headset"
                                    style="color:#8cc63f;"
                                ></i>

                            </div>

                            <div>

                                <h6 class="fw-bold mb-0">

                                    Customer Support

                                </h6>

                                <small class="text-muted">

                                    We're here to help

                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


    @else


        {{-- ========================================================= --}}
        {{-- EMPTY CART --}}
        {{-- ========================================================= --}}

        <div
            class="card border-0 shadow-sm rounded-4"
        >

            <div
                class="card-body text-center py-5"
            >

                <div
                    class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                    style="
                        width:120px;
                        height:120px;
                    "
                >

                    <i
                        class="fa-solid fa-cart-shopping fa-3x text-muted"
                    ></i>

                </div>


                <h4 class="fw-bold mb-2">

                    Your Cart is Empty

                </h4>


                <p class="text-muted mb-4">

                    You haven't added any eyewear products to your cart yet.

                </p>


                <a
                    href="{{ route('products.index') }}"
                    class="btn text-white rounded-pill px-4 py-3 fw-bold"
                    style="background-color:#8cc63f;"
                >

                    <i
                        class="fa-solid fa-glasses me-2"
                    ></i>

                    Explore Products

                </a>

            </div>

        </div>

    @endif

</div>

@endsection

