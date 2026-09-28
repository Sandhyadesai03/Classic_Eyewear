<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Order Bill #{{ $order->id }}</title>

<style>

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 30px;
        background: #f5f7f2;
        font-family: "DejaVu Sans", Arial, Helvetica, sans-serif;
        color: #333;
    }

    .invoice {
        max-width: 850px;
        margin: auto;
        background: #ffffff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 2px solid #8cc63f;
        padding-bottom: 25px;
        margin-bottom: 25px;
    }

    .brand h1 {
        margin: 0;
        color: #8cc63f;
        font-size: 30px;
        font-weight: bold;
    }

    .brand p {
        margin: 5px 0 0;
        color: #777;
        font-size: 14px;
    }

    .invoice-info {
        text-align: right;
    }

    .invoice-info h2 {
        margin: 0 0 8px;
        font-size: 22px;
    }

    .invoice-info p {
        margin: 4px 0;
        font-size: 14px;
    }

    .customer-section {
        display: flex;
        justify-content: space-between;
        gap: 30px;
        margin-bottom: 30px;
    }

    .customer-box {
        width: 50%;
    }

    .customer-box h4 {
        margin: 0 0 10px;
        color: #8cc63f;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 1px;
    }

    .customer-box p {
        margin: 4px 0;
        font-size: 14px;
    }

    .status {
        display: inline-block;
        padding: 6px 15px;
        border-radius: 30px;
        background: #d1e7dd;
        color: #146c43;
        font-size: 12px;
        font-weight: bold;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th {
        background: #8cc63f;
        color: white;
        padding: 12px;
        text-align: left;
        font-size: 13px;
    }

    td {
        padding: 13px 12px;
        border-bottom: 1px solid #eeeeee;
        font-size: 14px;
    }

    .text-right {
        text-align: right;
    }

    .summary {
        width: 320px;
        margin-left: auto;
        margin-top: 25px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        font-size: 14px;
    }

    .discount {
        color: #198754;
    }

    .free-shipping {
        color: #198754;
        font-weight: bold;
    }

    .paid-shipping {
        color: #333;
        font-weight: bold;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        padding: 15px 0;
        margin-top: 10px;
        border-top: 2px solid #8cc63f;
        font-size: 20px;
        font-weight: bold;
        color: #8cc63f;
    }

    .shipping-message {
        margin-top: 10px;
        padding: 8px 12px;
        border-radius: 6px;
        background: #f0f8e9;
        color: #198754;
        font-size: 12px;
        text-align: center;
    }

    .footer {
        text-align: center;
        border-top: 1px solid #eeeeee;
        margin-top: 35px;
        padding-top: 20px;
        color: #777;
        font-size: 13px;
    }

    .print-buttons {
        max-width: 850px;
        margin: 20px auto 0;
        text-align: right;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: bold;
        margin-left: 8px;
        border: none;
        cursor: pointer;
        font-family: "DejaVu Sans", Arial, sans-serif;
    }

    .btn-green {
        background: #8cc63f;
        color: white;
    }

    .btn-dark {
        background: #333;
        color: white;
    }

    @media print {

        body {
            background: white;
            padding: 0;
        }

        .invoice {
            box-shadow: none;
            border-radius: 0;
            max-width: 100%;
        }

        .print-buttons {
            display: none !important;
        }
    }

    .pdf-mode .print-buttons {
        display: none !important;
    }

    .pdf-mode body {
        background: white;
    }

    .pdf-mode .invoice {
        box-shadow: none;
    }

</style>

</head>

@php

/*
=========================================================
PDF CHECK
=========================================================
*/

$isPdf = request()->routeIs('admin.orders.bill.pdf');


/*
=========================================================
PRODUCT SUBTOTAL
=========================================================

Example:

Product total = ₹1700
*/

$subtotal = (float) $order->items->sum('total');


/*
=========================================================
SHIPPING SETTINGS
=========================================================
*/

$shippingSetting = \App\Models\ShippingSetting::latest('id')->first();


/*
=========================================================
DEFAULT VALUES
=========================================================
*/

$shippingCharge = 0;

$freeShippingAmount = 0;


/*
=========================================================
GET ADMIN SHIPPING SETTINGS
=========================================================
*/

if ($shippingSetting) {

    $shippingCharge = (float) (
        $shippingSetting->shipping_charge ?? 0
    );

    $freeShippingAmount = (float) (
        $shippingSetting->free_shipping_amount ?? 0
    );
}


/*
=========================================================
PREVENT NEGATIVE VALUES
=========================================================
*/

if ($shippingCharge < 0) {
    $shippingCharge = 0;
}

if ($freeShippingAmount < 0) {
    $freeShippingAmount = 0;
}


/*
=========================================================
COUPON DISCOUNT
=========================================================

IMPORTANT:

Your My Orders calculation is:

Subtotal = ₹1700
Coupon = 10%
Discount = ₹170

So bill must also show ₹170.

If coupon_discount was saved in order data,
use it.

Otherwise use the stored final amount together
with shipping to determine the actual discount.
*/


$storedFinalTotal = (float) $order->total_amount;


/*
=========================================================
SHIPPING FOR THIS ORDER
=========================================================

IMPORTANT:

Shipping rule is based on SUBTOTAL,
same as placeOrder().

Example:

Subtotal ₹1700
Free shipping threshold ₹2000
Shipping ₹100

Therefore:

₹1700 + ₹100
*/

if (
    $freeShippingAmount > 0 &&
    $subtotal >= $freeShippingAmount
) {

    $delivery = 0;

    $isFreeShipping = true;

} else {

    $delivery = $shippingCharge;

    $isFreeShipping = false;
}


/*
=========================================================
CALCULATE DISCOUNT FROM ACTUAL ORDER TOTAL
=========================================================

Formula:

Discount =
Subtotal + Shipping - Final Total

Example:

₹1700 + ₹100 - ₹1630
= ₹170
*/

$discount = (
    $subtotal +
    $delivery -
    $storedFinalTotal
);


/*
=========================================================
PREVENT NEGATIVE DISCOUNT
=========================================================
*/

if ($discount < 0) {
    $discount = 0;
}


/*
=========================================================
DISCOUNT CANNOT EXCEED SUBTOTAL
=========================================================
*/

if ($discount > $subtotal) {
    $discount = $subtotal;
}


/*
=========================================================
ROUND DISCOUNT
=========================================================
*/

$discount = round($discount, 2);


/*
=========================================================
AMOUNT AFTER DISCOUNT
=========================================================
*/

$amountAfterDiscount = (
    $subtotal -
    $discount
);


if ($amountAfterDiscount < 0) {
    $amountAfterDiscount = 0;
}


$amountAfterDiscount = round(
    $amountAfterDiscount,
    2
);


/*
=========================================================
FINAL TOTAL
=========================================================

Use the ACTUAL amount stored in database.

This guarantees:

My Orders = Bill = PDF

*/

$finalTotal = round(
    $storedFinalTotal,
    2
);


/*
=========================================================
DISCOUNT PERCENTAGE
=========================================================
*/

$discountPercentage = 0;

if (
    $subtotal > 0 &&
    $discount > 0
) {

    $discountPercentage =
        ($discount / $subtotal) * 100;
}


/*
=========================================================
ROUND PERCENTAGE
=========================================================
*/

$discountPercentage = round(
    $discountPercentage,
    0
);


@endphp

<body class="{{ $isPdf ? 'pdf-mode' : '' }}">

<div class="invoice">


{{-- =====================================================
     HEADER
===================================================== --}}

<div class="top">

    <div class="brand">

        <h1>
            CLASSIC
        </h1>

        <p>
            Premium Eyewear Store
        </p>

    </div>


    <div class="invoice-info">

        <h2>
            ORDER BILL
        </h2>

        <p>

            <strong>
                Order ID:
            </strong>

            #{{ $order->id }}

        </p>


        <p>

            <strong>
                Date:
            </strong>

            {{ $order->created_at->format('d M Y') }}

        </p>


        <p>

            <strong>
                Status:
            </strong>

            <span class="status">

                {{ $order->status }}

            </span>

        </p>

    </div>

</div>



{{-- =====================================================
     CUSTOMER INFORMATION
===================================================== --}}

<div class="customer-section">


    <div class="customer-box">

        <h4>
            Bill To
        </h4>


        <p>

            <strong>

                {{ $order->name ?? ($order->user->name ?? 'Customer') }}

            </strong>

        </p>


        <p>

            {{ $order->email ?? ($order->user->email ?? '') }}

        </p>


        @if(!empty($order->mobile))

            <p>

                {{ $order->mobile }}

            </p>

        @endif

    </div>



    <div class="customer-box">

        <h4>
            Delivery Information
        </h4>


        @if(!empty($order->address))

            <p>
                {{ $order->address }}
            </p>

        @endif


        @if(!empty($order->city))

            <p>
                {{ $order->city }}
            </p>

        @endif


        @if(!empty($order->state))

            <p>
                {{ $order->state }}
            </p>

        @endif


        @if(!empty($order->pincode))

            <p>
                PIN: {{ $order->pincode }}
            </p>

        @endif

    </div>

</div>



{{-- =====================================================
     PRODUCTS
===================================================== --}}

<table>

    <thead>

        <tr>

            <th>
                #
            </th>

            <th>
                Product
            </th>

            <th>
                Quantity
            </th>

            <th>
                Price
            </th>

            <th class="text-right">
                Total
            </th>

        </tr>

    </thead>


    <tbody>


        @foreach($order->items as $index => $item)

            <tr>

                <td>
                    {{ $index + 1 }}
                </td>


                <td>
                    {{ $item->product_name }}
                </td>


                <td>
                    {{ $item->quantity }}
                </td>


                <td>
                    ₹{{ number_format((float)$item->price, 2) }}
                </td>


                <td class="text-right">

                    ₹{{ number_format((float)$item->total, 2) }}

                </td>

            </tr>

        @endforeach


    </tbody>

</table>



{{-- =====================================================
     SUMMARY
===================================================== --}}

<div class="summary">


    {{-- SUBTOTAL --}}

    <div class="summary-row">

        <span>
            Subtotal
        </span>

        <strong>

            ₹{{ number_format($subtotal, 2) }}

        </strong>

    </div>



    {{-- COUPON DISCOUNT --}}

    @if($discount > 0)

        <div class="summary-row discount">

            <span>
                Coupon Discount
            </span>

            <strong>

                - ₹{{ number_format($discount, 2) }}

            </strong>

        </div>


        <div class="summary-row discount">

            <span>
                Discount
            </span>

            <strong>

                {{ number_format($discountPercentage, 0) }}% OFF

            </strong>

        </div>

    @endif



    {{-- AMOUNT AFTER DISCOUNT --}}

    <div class="summary-row">

        <span>
            Amount After Discount
        </span>

        <strong>

            ₹{{ number_format($amountAfterDiscount, 2) }}

        </strong>

    </div>



    {{-- SHIPPING --}}

    <div class="summary-row">

        <span>
            Shipping
        </span>


        @if($isFreeShipping)

            <strong class="free-shipping">
                FREE
            </strong>

        @else

            <strong class="paid-shipping">

                ₹{{ number_format($delivery, 2) }}

            </strong>

        @endif

    </div>



    {{-- SHIPPING MESSAGE --}}

    @if($isFreeShipping)

        <div class="shipping-message">

            ✓ Congratulations! You got FREE shipping.

        </div>

    @else

        @if(
            $freeShippingAmount > 0 &&
            $subtotal < $freeShippingAmount
        )

            <div class="shipping-message">

                Add ₹{{ number_format(
                    max(
                        0,
                        $freeShippingAmount - $subtotal
                    ),
                    2
                ) }}

                more to get FREE shipping.

            </div>

        @endif

    @endif



    {{-- GRAND TOTAL --}}

    <div class="summary-total">

        <span>
            Grand Total
        </span>

        <span>

            ₹{{ number_format($finalTotal, 2) }}

        </span>

    </div>

</div>



{{-- =====================================================
     FOOTER
===================================================== --}}

<div class="footer">

    <strong>
        Thank you for shopping with Classic!
    </strong>

    <br>

    Premium eyewear designed for your style.

    <br><br>

    This is a computer-generated invoice.

</div>


</div>

{{-- =========================================================
PRINT / DOWNLOAD BUTTONS
========================================================= --}}

@if(!$isPdf)


<div class="print-buttons">


    <button
        onclick="window.print()"
        class="btn btn-dark">

        Print Bill

    </button>


    <a
        href="{{ route('admin.orders.bill.pdf', $order->id) }}"
        class="btn btn-green">

        Download PDF

    </a>


</div>

@endif

</body>

</html>
