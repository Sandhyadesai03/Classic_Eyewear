@extends('layout')

@section('title', 'My Orders')

@section('content')

<div class="container py-5">

```
{{-- ========================================================= --}}
{{-- PAGE HEADER --}}
{{-- ========================================================= --}}

<div class="text-center mb-5">

    <div class="d-inline-flex align-items-center justify-content-center
                bg-success bg-opacity-10 rounded-circle mb-3"
         style="width:75px;height:75px;">

        <i class="fas fa-box-open text-success fs-2"></i>

    </div>

    <h2 class="fw-bold mb-2">
        My Orders
    </h2>

    <p class="text-muted mb-0">
        Track your orders and view your purchase details
    </p>

</div>


{{-- ========================================================= --}}
{{-- SUCCESS MESSAGE --}}
{{-- ========================================================= --}}

@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show
                border-0 shadow-sm rounded-4 mb-4"
         role="alert">

        <div class="d-flex align-items-center">

            <div class="bg-success bg-opacity-10 rounded-circle
                        p-2 me-3">

                <i class="fas fa-check-circle text-success"></i>

            </div>

            <div class="fw-semibold">
                {{ session('success') }}
            </div>

        </div>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>

@endif



{{-- ========================================================= --}}
{{-- ORDERS --}}
{{-- ========================================================= --}}

@forelse($orders as $order)

    @php

        /*
        |--------------------------------------------------------------------------
        | ORIGINAL PRODUCT TOTAL
        |--------------------------------------------------------------------------
        */

        $originalTotal = $order->items->sum(function ($item) {

            return (float) $item->total;

        });


        /*
        |--------------------------------------------------------------------------
        | FINAL ORDER TOTAL
        |--------------------------------------------------------------------------
        |
        | This is the final amount actually stored in the order.
        |
        */

        $finalTotal = (float) $order->total_amount;


        /*
        |--------------------------------------------------------------------------
        | SHIPPING SETTINGS
        |--------------------------------------------------------------------------
        |
        | Admin settings are stored in shipping_settings table.
        |
        */

        $shippingSetting = \Illuminate\Support\Facades\DB::table(
            'shipping_settings'
        )
        ->latest('id')
        ->first();


        /*
        |--------------------------------------------------------------------------
        | DEFAULT SHIPPING VALUES
        |--------------------------------------------------------------------------
        */

        $adminShippingFee = 0;

        $freeShippingAmount = 1500;


        /*
        |--------------------------------------------------------------------------
        | GET ADMIN SHIPPING SETTINGS
        |--------------------------------------------------------------------------
        */

        if($shippingSetting) {

            /*
            | Shipping Charge
            */

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
            | Free Shipping Minimum Amount
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
        | Priority:
        |
        | 1. If order already has shipping_charge saved → use it.
        | 2. Otherwise calculate from current admin shipping settings.
        |
        */

        $shippingAmount = null;


        /*
        | Check whether shipping_charge was saved
        | directly inside orders table.
        */

        if(
            array_key_exists(
                'shipping_charge',
                $order->getAttributes()
            )
        ) {

            $shippingAmount =
                (float) $order->shipping_charge;

        }


        /*
        |--------------------------------------------------------------------------
        | IF SHIPPING NOT SAVED IN ORDER
        |--------------------------------------------------------------------------
        */

        if($shippingAmount === null) {

            if(
                $originalTotal >=
                $freeShippingAmount
            ) {

                $shippingAmount = 0;

            } else {

                $shippingAmount =
                    $adminShippingFee;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | FREE SHIPPING CHECK
        |--------------------------------------------------------------------------
        */

        $isFreeShipping =
            $shippingAmount <= 0;


        /*
        |--------------------------------------------------------------------------
        | CALCULATE DISCOUNT
        |--------------------------------------------------------------------------
        |
        | Final Total =
        | Product Total + Shipping - Discount
        |
        */

        $discountAmount =
            $originalTotal +
            $shippingAmount -
            $finalTotal;


        /*
        |--------------------------------------------------------------------------
        | PREVENT NEGATIVE DISCOUNT
        |--------------------------------------------------------------------------
        */

        if($discountAmount < 0) {

            $discountAmount = 0;

        }


        /*
        |--------------------------------------------------------------------------
        | DISCOUNT PERCENTAGE
        |--------------------------------------------------------------------------
        */

        $discountPercentage = 0;

        if(
            $originalTotal > 0 &&
            $discountAmount > 0
        ) {

            /*
            | Discount percentage should be based
            | on product subtotal, not shipping.
            */

            $discountOnly =
                min(
                    $discountAmount,
                    $originalTotal
                );

            $discountPercentage =
                ($discountOnly / $originalTotal) * 100;

        }


        /*
        |--------------------------------------------------------------------------
        | PRODUCT TOTAL AFTER DISCOUNT
        |--------------------------------------------------------------------------
        */

        $productAfterDiscount =
            $originalTotal -
            min(
                $discountAmount,
                $originalTotal
            );


        /*
        |--------------------------------------------------------------------------
        | FINAL TOTAL SAFETY
        |--------------------------------------------------------------------------
        */

        if($finalTotal < 0) {

            $finalTotal = 0;

        }

    @endphp



    {{-- ===================================================== --}}
    {{-- ORDER CARD --}}
    {{-- ===================================================== --}}

    <div class="card rounded-4 mb-4 overflow-hidden shadow-sm"
         style="border:2px solid #dceccf !important;">

        {{-- TOP ACCENT BORDER --}}

        <div style="height:5px;background:#8cc63f;"></div>


        <div class="card-body p-0">


            {{-- ================================================= --}}
            {{-- ORDER HEADER --}}
            {{-- ================================================= --}}

            <div class="p-4">

                <div class="row align-items-center">


                    {{-- ORDER INFORMATION --}}

                    <div class="col-lg-4 col-md-6">

                        <div class="d-flex align-items-center">

                            <div class="bg-success bg-opacity-10
                                        rounded-4
                                        d-flex align-items-center
                                        justify-content-center me-3"
                                 style="width:58px;height:58px;">

                                <i class="fas fa-receipt
                                          text-success fs-5"></i>

                            </div>


                            <div>

                                <small class="text-muted d-block">
                                    Order ID
                                </small>

                                <h5 class="fw-bold mb-1">
                                    #{{ $order->id }}
                                </h5>

                                <small class="text-muted">

                                    <i class="far fa-calendar-alt me-1"></i>

                                    {{ $order->created_at->format('d M Y, h:i A') }}

                                </small>

                            </div>

                        </div>

                    </div>



                    {{-- ================================================= --}}
                    {{-- ORDER STATUS --}}
                    {{-- ================================================= --}}

                    <div class="col-lg-4 col-md-6 text-md-center
                                mt-3 mt-md-0">

                        <small class="text-muted d-block mb-2">
                            Order Status
                        </small>


                        <span class="badge rounded-pill px-3 py-2

                            @if($order->status == 'Pending')
                                bg-warning text-dark

                            @elseif($order->status == 'Processing')
                                bg-primary

                            @elseif($order->status == 'Shipped')
                                bg-info text-dark

                            @elseif($order->status == 'Delivered')
                                bg-success

                            @else
                                bg-danger

                            @endif
                        ">


                            @if($order->status == 'Pending')

                                <i class="fas fa-clock me-1"></i>

                            @elseif($order->status == 'Processing')

                                <i class="fas fa-spinner me-1"></i>

                            @elseif($order->status == 'Shipped')

                                <i class="fas fa-truck me-1"></i>

                            @elseif($order->status == 'Delivered')

                                <i class="fas fa-check-circle me-1"></i>

                            @else

                                <i class="fas fa-times-circle me-1"></i>

                            @endif


                            {{ $order->status }}

                        </span>

                    </div>



                    {{-- ================================================= --}}
                    {{-- ORDER TOTAL --}}
                    {{-- ================================================= --}}

                    <div class="col-lg-4 text-md-end
                                mt-3 mt-lg-0">

                        <small class="text-muted d-block">
                            Total Amount
                        </small>


                        {{-- FINAL TOTAL --}}

                        <h4 class="fw-bold text-success mb-1">

                            ₹{{ number_format(
                                $finalTotal,
                                2
                            ) }}

                        </h4>


                        {{-- DISCOUNT MESSAGE --}}

                        @if($discountAmount > 0)

                            <div class="small">

                                <span class="text-muted text-decoration-line-through">

                                    ₹{{ number_format(
                                        $originalTotal + $shippingAmount,
                                        2
                                    ) }}

                                </span>

                                <span class="badge rounded-pill ms-1"
                                      style="
                                          background:#fff0d9;
                                          color:#b7791f;
                                      ">

                                    {{ number_format(
                                        $discountPercentage,
                                        0
                                    ) }}% OFF

                                </span>

                            </div>

                        @endif


                        <small class="text-muted">

                            <i class="fas fa-credit-card me-1"></i>

                            {{ $order->payment_method }}

                        </small>

                    </div>

                </div>

            </div>



            {{-- ================================================= --}}
            {{-- PRODUCTS HEADER --}}
            {{-- ================================================= --}}

            <div class="px-4 py-3"
                 style="
                    background:#f8fbf5;
                    border-top:1px solid #e8f1df;
                    border-bottom:1px solid #e8f1df;
                 ">

                <div class="d-flex align-items-center">

                    <div class="bg-white rounded-3 p-2 me-2 shadow-sm">

                        <i class="fas fa-shopping-bag text-success"></i>

                    </div>

                    <h6 class="fw-bold mb-0">
                        Ordered Products
                    </h6>

                </div>

            </div>



            {{-- ================================================= --}}
            {{-- PRODUCTS --}}
            {{-- ================================================= --}}

            <div class="p-4">

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead>

                            <tr class="text-muted small">

                                <th class="border-0">
                                    PRODUCT
                                </th>

                                <th class="border-0">
                                    PRICE
                                </th>

                                <th class="border-0 text-center">
                                    QUANTITY
                                </th>

                                <th class="border-0 text-end">
                                    TOTAL
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($order->items as $item)

                                <tr>


                                    {{-- PRODUCT IMAGE --}}

                                    <td class="py-3">

                                        <div class="d-flex align-items-center">

                                            <div class="bg-white border rounded-4
                                                        d-flex align-items-center
                                                        justify-content-center
                                                        me-3 overflow-hidden shadow-sm"
                                                 style="
                                                    width:80px;
                                                    height:80px;
                                                 ">


                                                @if($item->product && $item->product->image)

                                                    <img
                                                        src="{{ asset('product-images/' . $item->product->image) }}"
                                                        alt="{{ $item->product_name }}"
                                                        class="img-fluid"
                                                        style="
                                                            width:100%;
                                                            height:100%;
                                                            object-fit:contain;
                                                        "
                                                    >

                                                @else

                                                    <i class="fas fa-glasses
                                                              text-secondary
                                                              fs-3"></i>

                                                @endif

                                            </div>


                                            <div>

                                                <h6 class="fw-bold mb-1">

                                                    {{ $item->product_name }}

                                                </h6>

                                                <small class="text-muted">

                                                    Eyewear Product

                                                </small>

                                            </div>

                                        </div>

                                    </td>



                                    {{-- PRICE --}}

                                    <td>

                                        <span class="fw-semibold">

                                            ₹{{ number_format(
                                                $item->price,
                                                2
                                            ) }}

                                        </span>

                                    </td>



                                    {{-- QUANTITY --}}

                                    <td class="text-center">

                                        <span class="badge bg-light
                                                     text-dark border
                                                     rounded-pill px-3 py-2">

                                            {{ $item->quantity }}

                                        </span>

                                    </td>



                                    {{-- ITEM TOTAL --}}

                                    <td class="text-end">

                                        <span class="fw-bold">

                                            ₹{{ number_format(
                                                $item->total,
                                                2
                                            ) }}

                                        </span>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>



                {{-- ================================================= --}}
                {{-- DELIVERY INFORMATION --}}
                {{-- ================================================= --}}

                <div class="border-top mt-4 pt-4">

                    <div class="row g-4">


                        {{-- DELIVERY ADDRESS --}}

                        <div class="col-lg-7">

                            <div class="d-flex">

                                <div class="bg-danger bg-opacity-10
                                            rounded-4 p-3 me-3">

                                    <i class="fas fa-map-marker-alt
                                              text-danger"></i>

                                </div>


                                <div>

                                    <small class="text-muted d-block mb-1">
                                        Delivery Address
                                    </small>

                                    <div class="fw-semibold">

                                        {{ $order->address }},

                                        {{ $order->city }},

                                        {{ $order->state }}

                                        - {{ $order->pincode }}

                                    </div>

                                </div>

                            </div>

                        </div>



                        {{-- PAYMENT METHOD --}}

                        <div class="col-lg-5">

                            <div class="d-flex justify-content-lg-end">

                                <div class="text-lg-end">

                                    <small class="text-muted d-block mb-1">
                                        Payment Method
                                    </small>

                                    <span class="fw-semibold">

                                        <i class="fas fa-wallet
                                                  text-success me-1"></i>

                                        {{ $order->payment_method }}

                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- ================================================= --}}
                {{-- PRICE SUMMARY --}}
                {{-- ================================================= --}}

                <div class="rounded-4 p-4 mt-4"
                     style="
                        background:#f0f8e9;
                        border:1px solid #dceccf;
                     ">


                    {{-- ORIGINAL PRODUCT TOTAL --}}

                    <div class="d-flex justify-content-between
                                align-items-center mb-2">

                        <span class="text-muted">

                            Product Subtotal

                        </span>

                        <span class="fw-semibold">

                            ₹{{ number_format(
                                $originalTotal,
                                2
                            ) }}

                        </span>

                    </div>



                    {{-- ================================================= --}}
                    {{-- SHIPPING --}}
                    {{-- ================================================= --}}

                    <div class="d-flex justify-content-between
                                align-items-center mb-2">

                        <span class="text-muted">

                            <i class="fas fa-truck me-1"></i>

                            Shipping

                        </span>


                        @if($isFreeShipping)

                            <span class="fw-bold text-success">

                                <i class="fas fa-check-circle me-1"></i>

                                FREE

                            </span>

                        @else

                            <span class="fw-semibold">

                                ₹{{ number_format(
                                    $shippingAmount,
                                    2
                                ) }}

                            </span>

                        @endif

                    </div>



                    {{-- FREE SHIPPING MESSAGE --}}

                    @if($isFreeShipping)

                        <div class="alert alert-success py-2 px-3
                                    rounded-3 small mb-3">

                            <i class="fa-solid fa-circle-check me-1"></i>

                            Congratulations! You got FREE shipping.

                        </div>

                    @else

                        @if($freeShippingAmount > $originalTotal)

                            <div class="alert alert-light border
                                        py-2 px-3 rounded-3 small mb-3">

                                <i class="fa-solid fa-info-circle me-1"
                                   style="color:#8cc63f;"></i>

                                Add ₹{{ number_format(
                                    $freeShippingAmount - $originalTotal,
                                    2
                                ) }}
                                more to get FREE shipping.

                            </div>

                        @endif

                    @endif



                    {{-- DISCOUNT --}}

                    @if($discountAmount > 0)

                        <div class="d-flex justify-content-between
                                    align-items-center mb-2">

                            <span class="text-success">

                                <i class="fas fa-tag me-1"></i>

                                Discount

                            </span>

                            <span class="fw-bold text-success">

                                - ₹{{ number_format(
                                    $discountAmount,
                                    2
                                ) }}

                            </span>

                        </div>

                    @endif



                    <hr class="my-3">



                    {{-- FINAL TOTAL --}}

                    <div class="d-flex justify-content-between
                                align-items-center">

                        <div>

                            <small class="text-muted d-block">

                                Final Order Total

                            </small>

                            <span class="fw-semibold">

                                Product + Shipping - Discount

                            </span>

                        </div>


                        <div>

                            <span class="fw-bold fs-4 text-success">

                                ₹{{ number_format(
                                    $finalTotal,
                                    2
                                ) }}

                            </span>

                        </div>

                    </div>



                    {{-- SAVED AMOUNT --}}

                    @if($discountAmount > 0)

                        <div class="text-center mt-3">

                            <span class="badge rounded-pill px-3 py-2"
                                  style="
                                      background:#8cc63f;
                                      color:white;
                                  ">

                                <i class="fas fa-circle-check me-1"></i>

                                You saved ₹{{ number_format(
                                    min(
                                        $discountAmount,
                                        $originalTotal
                                    ),
                                    2
                                ) }}

                            </span>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

@empty


    {{-- ========================================================= --}}
    {{-- NO ORDERS --}}
    {{-- ========================================================= --}}

    <div class="card rounded-4 shadow-sm"
         style="border:2px solid #dceccf !important;">

        <div style="height:5px;background:#8cc63f;"></div>

        <div class="card-body text-center py-5">

            <div class="bg-success bg-opacity-10
                        rounded-circle
                        d-inline-flex
                        align-items-center
                        justify-content-center mb-4"
                 style="width:110px;height:110px;">

                <i class="fas fa-shopping-bag
                          text-success fs-1"></i>

            </div>


            <h4 class="fw-bold mb-2">

                No Orders Yet

            </h4>


            <p class="text-muted mb-4">

                You haven't placed any orders yet.
                Start shopping to see your orders here.

            </p>


            <a href="{{ route('products.index') }}"
               class="btn btn-success rounded-pill px-4 py-2">

                <i class="fas fa-shopping-cart me-2"></i>

                Start Shopping

            </a>

        </div>

    </div>

@endforelse
```

</div>

@endsection
