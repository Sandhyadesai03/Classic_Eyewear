<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>
        {{ ucfirst($type ?? 'all') }} Report
    </title>

    <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
        }

        h1 {
            text-align: center;
            margin-bottom: 5px;
        }

        h2 {
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .date {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th {
            background: #8cc63f;
            color: white;
            padding: 7px;
            border: 1px solid #777;
        }

        td {
            padding: 6px;
            border: 1px solid #ccc;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .total {
            margin-top: 15px;
            text-align: right;
            font-size: 14px;
            font-weight: bold;
        }

    </style>

</head>


<body>


<h1>
    Classic - Store Report
</h1>


{{-- ====================================================
     DATE FILTER
===================================================== --}}

<div class="date">

    @if(!empty($dateFrom))

        From:
        {{ \Carbon\Carbon::parse($dateFrom)->format('d-m-Y') }}

    @endif


    @if(!empty($dateTo))

        &nbsp;&nbsp;

        To:
        {{ \Carbon\Carbon::parse($dateTo)->format('d-m-Y') }}

    @endif


    @if(empty($dateFrom) && empty($dateTo))

        Generated:
        {{ now()->format('d-m-Y H:i') }}

    @endif

</div>



{{-- ====================================================
     USERS
===================================================== --}}

@if(($type ?? 'all') === 'users' || ($type ?? 'all') === 'all')

<h2>
    User Report
</h2>

<table>

    <thead>

        <tr>

            <th>#</th>

            <th>ID</th>

            <th>Name</th>

            <th>Email</th>

            <th>Registration Date</th>

            <th>Time</th>

        </tr>

    </thead>


    <tbody>

        @forelse($users ?? [] as $user)

            <tr>

                <td class="center">
                    {{ $loop->iteration }}
                </td>

                <td>
                    #{{ $user->id }}
                </td>

                <td>
                    {{ $user->name ?? '-' }}
                </td>

                <td>
                    {{ $user->email ?? '-' }}
                </td>

                <td>

                    @if(!empty($user->created_at))

                        {{ \Carbon\Carbon::parse(
                            $user->created_at
                        )->format('d-m-Y') }}

                    @else

                        -

                    @endif

                </td>

                <td>

                    @if(!empty($user->created_at))

                        {{ \Carbon\Carbon::parse(
                            $user->created_at
                        )->format('H:i:s') }}

                    @else

                        -

                    @endif

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="6"
                    class="center"
                >
                    No users found for selected date range.
                </td>

            </tr>

        @endforelse

    </tbody>

</table>

@endif



{{-- ====================================================
     PRODUCTS
===================================================== --}}

@if(($type ?? 'all') === 'products' || ($type ?? 'all') === 'all')

<h2>
    Product Report
</h2>

<table>

    <thead>

        <tr>

            <th>#</th>

            <th>Product ID</th>

            <th>Product</th>

            <th>Category</th>

            <th>Price</th>

            <th>Stock</th>

            <th>Created Date</th>

        </tr>

    </thead>


    <tbody>

        @forelse($products ?? [] as $product)

            <tr>

                <td class="center">
                    {{ $loop->iteration }}
                </td>

                <td>
                    #{{ $product->id }}
                </td>

                <td>
                    {{ $product->name ?? '-' }}
                </td>

                <td>
                    {{ $product->category ?? '-' }}
                </td>

                <td>
                    ₹{{ number_format(
                        (float) (
                            $product->price ?? 0
                        ),
                        2
                    ) }}
                </td>

                <td>
                    {{ $product->stock ?? 0 }}
                </td>

                <td>

                    @if(!empty($product->created_at))

                        {{ \Carbon\Carbon::parse(
                            $product->created_at
                        )->format('d-m-Y H:i') }}

                    @else

                        -

                    @endif

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="7"
                    class="center"
                >
                    No products found for selected date range.
                </td>

            </tr>

        @endforelse

    </tbody>

</table>

@endif



{{-- ====================================================
     STOCK
===================================================== --}}

@if(($type ?? 'all') === 'stock' || ($type ?? 'all') === 'all')

<h2>
    Stock Report
</h2>

<table>

    <thead>

        <tr>

            <th>#</th>

            <th>Product</th>

            <th>Category</th>

            <th>Price</th>

            <th>Stock</th>

            <th>Status</th>

        </tr>

    </thead>


    <tbody>

        @forelse($products ?? [] as $product)

            @php

                $stock =
                    (int) (
                        $product->stock ?? 0
                    );

            @endphp


            <tr>

                <td class="center">
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $product->name ?? '-' }}
                </td>

                <td>
                    {{ $product->category ?? '-' }}
                </td>

                <td>
                    ₹{{ number_format(
                        (float) (
                            $product->price ?? 0
                        ),
                        2
                    ) }}
                </td>

                <td>
                    {{ $stock }}
                </td>

                <td>

                    @if($stock === 0)

                        Out of Stock

                    @elseif($stock <= 5)

                        Low Stock

                    @else

                        In Stock

                    @endif

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="6"
                    class="center"
                >
                    No stock data found.
                </td>

            </tr>

        @endforelse

    </tbody>

</table>

@endif



{{-- ====================================================
     ORDERS
===================================================== --}}

@if(($type ?? 'all') === 'orders' || ($type ?? 'all') === 'all')

<h2>
    Order Report
</h2>

<table>

    <thead>

        <tr>

            <th>#</th>

            <th>Order ID</th>

            <th>Customer</th>

            <th>Email</th>

            <th>Amount</th>

            <th>Payment</th>

            <th>Status</th>

            <th>Date</th>

        </tr>

    </thead>


    <tbody>

        @forelse($orders ?? [] as $order)

            @php

                $amount =
                    (float) (
                        $order->total_amount
                        ?? $order->total
                        ?? 0
                    );

                $payment =
                    $order->payment_method
                    ?? $order->payment
                    ?? 'N/A';

            @endphp


            <tr>

                <td class="center">
                    {{ $loop->iteration }}
                </td>

                <td>
                    #{{ $order->id }}
                </td>

                <td>
                    {{ $order->name ?? 'Guest' }}
                </td>

                <td>
                    {{ $order->email ?? '-' }}
                </td>

                <td>
                    ₹{{ number_format(
                        $amount,
                        2
                    ) }}
                </td>

                <td>
                    {{ $payment }}
                </td>

                <td>
                    {{ $order->status ?? '-' }}
                </td>

                <td>

                    @if(!empty($order->created_at))

                        {{ \Carbon\Carbon::parse(
                            $order->created_at
                        )->format('d-m-Y H:i') }}

                    @else

                        -

                    @endif

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="8"
                    class="center"
                >
                    No orders found for selected date range.
                </td>

            </tr>

        @endforelse

    </tbody>

</table>

@endif



{{-- ====================================================
     BILLS
===================================================== --}}

@if(
    ($type ?? 'all') === 'bills'
    ||
    ($type ?? 'all') === 'bill'
)

<h2>
    Bill Report
</h2>

<table>

    <thead>

        <tr>

            <th>#</th>

            <th>Bill / Order ID</th>

            <th>Customer</th>

            <th>Email</th>

            <th>Amount</th>

            <th>Payment</th>

            <th>Date</th>

            <th>Status</th>

        </tr>

    </thead>


    <tbody>

        @forelse($orders ?? [] as $order)

            @php

                $amount =
                    (float) (
                        $order->total_amount
                        ?? $order->total
                        ?? 0
                    );

                $payment =
                    $order->payment_method
                    ?? $order->payment
                    ?? 'N/A';

            @endphp


            <tr>

                <td class="center">
                    {{ $loop->iteration }}
                </td>

                <td>
                    BILL-{{ $order->id }}
                </td>

                <td>
                    {{ $order->name ?? 'Guest' }}
                </td>

                <td>
                    {{ $order->email ?? '-' }}
                </td>

                <td>
                    ₹{{ number_format(
                        $amount,
                        2
                    ) }}
                </td>

                <td>
                    {{ $payment }}
                </td>

                <td>

                    @if(!empty($order->created_at))

                        {{ \Carbon\Carbon::parse(
                            $order->created_at
                        )->format('d-m-Y H:i')
                        }}

                    @else

                        -

                    @endif

                </td>

                <td>
                    {{ $order->status ?? '-' }}
                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="8"
                    class="center"
                >
                    No bills found for selected date range.
                </td>

            </tr>

        @endforelse

    </tbody>

</table>


{{-- BILL TOTAL --}}

@php

    $billTotal = collect($orders ?? [])
        ->sum(function ($order) {

            return (float) (
                $order->total_amount
                ?? $order->total
                ?? 0
            );

        });

@endphp


<div class="total">

    Total Bill Amount:
    ₹{{ number_format(
        $billTotal,
        2
    ) }}

</div>

@endif



{{-- ====================================================
     DATE WISE
===================================================== --}}

@if(($type ?? 'all') === 'date')

<h2>
    Date Wise Order Report
</h2>

<table>

    <thead>

        <tr>

            <th>#</th>

            <th>Order ID</th>

            <th>Customer</th>

            <th>Email</th>

            <th>Amount</th>

            <th>Status</th>

            <th>Date</th>

        </tr>

    </thead>


    <tbody>

        @forelse($orders ?? [] as $order)

            @php

                $amount =
                    (float) (
                        $order->total_amount
                        ?? $order->total
                        ?? 0
                    );

            @endphp


            <tr>

                <td>
                    {{ $loop->iteration }}
                </td>

                <td>
                    #{{ $order->id }}
                </td>

                <td>
                    {{ $order->name ?? 'Guest' }}
                </td>

                <td>
                    {{ $order->email ?? '-' }}
                </td>

                <td>
                    ₹{{ number_format(
                        $amount,
                        2
                    ) }}
                </td>

                <td>
                    {{ $order->status ?? '-' }}
                </td>

                <td>

                    @if(!empty($order->created_at))

                        {{ \Carbon\Carbon::parse(
                            $order->created_at
                        )->format('d-m-Y H:i') }}

                    @else

                        -

                    @endif

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="7"
                    class="center"
                >
                    No orders found for selected date range.
                </td>

            </tr>

        @endforelse

    </tbody>

</table>

@endif



</body>

</html>