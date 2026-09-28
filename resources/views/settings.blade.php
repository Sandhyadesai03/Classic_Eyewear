@extends('layout')

@section('title', 'Payment Settings')

@section('hideNavbarFooter', true)

@section('content')

<div class="container-fluid min-vh-100 py-5"
     style="background:#f8f9fa;">

    <div class="container">

        {{-- ================================================= --}}
        {{-- PAGE HEADER --}}
        {{-- ================================================= --}}

        <div class="d-flex flex-column flex-md-row
                    justify-content-between
                    align-items-md-center
                    mb-4">

            <div>

                <div class="d-flex align-items-center mb-2">

                    <div
                        class="d-flex align-items-center
                               justify-content-center
                               rounded-3 me-3"
                        style="
                            width:50px;
                            height:50px;
                            background:#f4f9e9;
                        "
                    >

                        <i
                            class="fa-solid fa-gear fs-4"
                            style="color:#8cc63f;"
                        ></i>

                    </div>

                    <div>

                        <h2 class="fw-bold mb-0">
                            Payment Settings
                        </h2>

                        <p class="text-muted mb-0 small">
                            Manage your UPI payment details
                        </p>

                    </div>

                </div>

            </div>


            <a
                href="{{ url('/admin') }}"
                class="btn rounded-pill px-4"
                style="
                    border:1px solid #e9b36a;
                    color:#8d6b3d;
                    background:#fffaf3;
                "
            >

                <i class="fa-solid fa-arrow-left me-2"></i>

                Back to Dashboard

            </a>

        </div>


        {{-- ================================================= --}}
        {{-- SUCCESS MESSAGE --}}
        {{-- ================================================= --}}

        @if(session('success'))

            <div
                class="alert alert-success
                       border-0 shadow-sm rounded-4
                       d-flex align-items-center"
            >

                <i
                    class="fa-solid fa-circle-check
                           fs-5 me-3"
                ></i>

                <div>

                    <strong>Success!</strong>

                    <div>
                        {{ session('success') }}
                    </div>

                </div>

            </div>

        @endif


        {{-- ================================================= --}}
        {{-- VALIDATION ERRORS --}}
        {{-- ================================================= --}}

        @if($errors->any())

            <div
                class="alert alert-danger
                       border-0 shadow-sm rounded-4"
            >

                <strong>
                    Please fix the following:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <div class="row g-4">


            {{-- ================================================= --}}
            {{-- SETTINGS FORM --}}
            {{-- ================================================= --}}

            <div class="col-lg-7">

                <div
                    class="card border-0 shadow-sm rounded-4"
                >

                    <div class="card-body p-4 p-lg-5">

                        <div class="mb-4">

                            <span
                                class="badge rounded-pill
                                       text-white px-3 py-2"
                                style="
                                    background:#8cc63f;
                                    font-size:10px;
                                    letter-spacing:1px;
                                "
                            >

                                UPI PAYMENT

                            </span>

                            <h4 class="fw-bold mt-3">
                                Configure UPI
                            </h4>

                            <p class="text-muted small">
                                Enter the UPI details that customers
                                will use for QR payments.
                            </p>

                        </div>


                        <form
                            action="{{ route('admin.settings.update') }}"
                            method="POST"
                        >

                            @csrf


                            {{-- UPI ID --}}

                            <div class="mb-4">

                                <label
                                    class="form-label fw-semibold"
                                >

                                    UPI ID

                                </label>

                                <div class="input-group">

                                    <span
                                        class="input-group-text bg-white"
                                    >

                                        <i
                                            class="fa-solid fa-at"
                                            style="color:#8cc63f;"
                                        ></i>

                                    </span>

                                    <input
                                        type="text"
                                        name="upi_id"
                                        class="form-control
                                               form-control-lg"
                                        placeholder="example@upi"
                                        value="{{ old(
                                            'upi_id',
                                            $setting->upi_id ?? ''
                                        ) }}"
                                        required
                                    >

                                </div>

                                <small class="text-muted">
                                    Example:
                                    classicglasses@upi
                                </small>

                            </div>


                            {{-- MERCHANT NAME --}}

                            <div class="mb-4">

                                <label
                                    class="form-label fw-semibold"
                                >

                                    Store / Merchant Name

                                </label>

                                <div class="input-group">

                                    <span
                                        class="input-group-text bg-white"
                                    >

                                        <i
                                            class="fa-solid fa-store"
                                            style="color:#e9b36a;"
                                        ></i>

                                    </span>

                                    <input
                                        type="text"
                                        name="merchant_name"
                                        class="form-control
                                               form-control-lg"
                                        placeholder="Classic Glasses Store"
                                        value="{{ old(
                                            'merchant_name',
                                            $setting->merchant_name ?? ''
                                        ) }}"
                                        required
                                    >

                                </div>

                            </div>


                            {{-- INFO BOX --}}

                            <div
                                class="rounded-4 p-3 mb-4"
                                style="
                                    background:#fffaf3;
                                    border:1px solid #f0ddbf;
                                "
                            >

                                <div class="d-flex">

                                    <i
                                        class="fa-solid
                                               fa-circle-info
                                               me-3 mt-1"
                                        style="color:#e9b36a;"
                                    ></i>

                                    <div>

                                        <strong>
                                            Automatic QR Payment
                                        </strong>

                                        <p
                                            class="small
                                                   text-muted
                                                   mb-0 mt-1"
                                        >

                                            This UPI ID will automatically
                                            be used to create the QR code
                                            on the customer checkout page.

                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- SAVE BUTTON --}}

                            <button
                                type="submit"
                                class="btn w-100
                                       rounded-pill
                                       py-3
                                       fw-bold
                                       text-white"
                                style="
                                    background:#8cc63f;
                                "
                            >

                                <i
                                    class="fa-solid fa-save me-2"
                                ></i>

                                Save UPI Settings

                            </button>

                        </form>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- PREVIEW --}}
            {{-- ================================================= --}}

            <div class="col-lg-5">

                <div
                    class="card border-0 shadow-sm
                           rounded-4 h-100"
                >

                    <div class="card-body p-4">

                        <div class="text-center">

                            <div
                                class="d-inline-flex
                                       align-items-center
                                       justify-content-center
                                       rounded-circle mb-3"
                                style="
                                    width:70px;
                                    height:70px;
                                    background:#f4f9e9;
                                "
                            >

                                <i
                                    class="fa-solid fa-qrcode fs-2"
                                    style="color:#8cc63f;"
                                ></i>

                            </div>


                            <h5 class="fw-bold">
                                UPI QR Preview
                            </h5>

                            <p class="text-muted small">
                                QR will be generated automatically
                                during checkout.
                            </p>

                        </div>


                        <div
                            class="rounded-4 p-4 mt-4"
                            style="
                                background:#fafafa;
                                border:1px solid #eeeeee;
                            "
                        >

                            <div class="text-center">

                                <div
                                    class="d-flex
                                           align-items-center
                                           justify-content-center
                                           mx-auto
                                           rounded-3"
                                    style="
                                        width:180px;
                                        height:180px;
                                        background:white;
                                        border:2px dashed #dce9c2;
                                    "
                                >

                                    <i
                                        class="fa-solid fa-qrcode"
                                        style="
                                            font-size:80px;
                                            color:#8cc63f;
                                        "
                                    ></i>

                                </div>


                                <div class="mt-4">

                                    <p class="text-muted
                                              small mb-1">

                                        Current UPI ID

                                    </p>

                                    <h6 class="fw-bold">

                                        {{ $setting->upi_id
                                            ?? 'Not configured' }}

                                    </h6>

                                </div>


                                <div class="mt-3">

                                    <p class="text-muted
                                              small mb-1">

                                        Merchant

                                    </p>

                                    <h6 class="fw-bold">

                                        {{ $setting->merchant_name
                                            ?? 'Not configured' }}

                                    </h6>

                                </div>

                            </div>

                        </div>


                        <div
                            class="d-flex
                                   align-items-center
                                   mt-4"
                        >

                            <i
                                class="fa-solid
                                       fa-shield-halved
                                       me-2"
                                style="color:#8cc63f;"
                            ></i>

                            <small class="text-muted">

                                UPI payment details are stored
                                in your application database.

                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection