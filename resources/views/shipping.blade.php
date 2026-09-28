```blade
@extends('layout')

@section('title', 'Shipping Charges')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="mb-4">

        <h3 class="fw-bold mb-1">

            <i class="fas fa-truck-fast text-primary me-2"></i>

            Shipping Charges

        </h3>

        <p class="text-muted mb-0">

            Manage shipping charges for customer purchases.

        </p>

    </div>


    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="fas fa-circle-check me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ERROR MESSAGE --}}
    @if($errors->any())

        <div class="alert alert-danger">

            @foreach($errors->all() as $error)

                <div>
                    <i class="fas fa-circle-exclamation me-2"></i>
                    {{ $error }}
                </div>

            @endforeach

        </div>

    @endif


    <div class="row g-4">


        {{-- SETTINGS FORM --}}
        <div class="col-lg-7">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">

                        <i class="fas fa-gear me-2"></i>

                        Shipping Settings

                    </h5>


                    <form method="POST"
                          action="{{ route('admin.shipping.update') }}">

                        @csrf


                        {{-- SHIPPING CHARGE --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">

                                Standard Shipping Charge

                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    ₹
                                </span>

                                <input
                                    type="number"
                                    name="shipping_charge"
                                    class="form-control"
                                    min="0"
                                    step="0.01"
                                    value="{{ old('shipping_charge', $shipping->shipping_charge) }}"
                                    required
                                >

                            </div>

                            <small class="text-muted">

                                This charge will apply to orders
                                below the free shipping limit.

                            </small>

                        </div>


                        {{-- FREE SHIPPING --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">

                                Free Shipping Above

                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    ₹
                                </span>

                                <input
                                    type="number"
                                    name="free_shipping_amount"
                                    class="form-control"
                                    min="0"
                                    step="0.01"
                                    value="{{ old('free_shipping_amount', $shipping->free_shipping_amount) }}"
                                    required
                                >

                            </div>

                            <small class="text-muted">

                                Orders equal to or above this amount
                                will get FREE shipping.

                            </small>

                        </div>


                        {{-- SAVE --}}
                        <button type="submit"
                                class="btn btn-primary px-4">

                            <i class="fas fa-save me-2"></i>

                            Save Shipping Settings

                        </button>

                    </form>

                </div>

            </div>

        </div>


        {{-- CURRENT SETTINGS --}}
        <div class="col-lg-5">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">

                        <i class="fas fa-circle-info text-primary me-2"></i>

                        Current Shipping

                    </h5>


                    {{-- SHIPPING --}}
                    <div class="d-flex justify-content-between
                                align-items-center mb-4">

                        <span class="text-muted">

                            Shipping Charge

                        </span>

                        <span class="fw-bold fs-5">

                            ₹{{ number_format(
                                $shipping->shipping_charge,
                                2
                            ) }}

                        </span>

                    </div>


                    {{-- FREE SHIPPING --}}
                    <div class="d-flex justify-content-between
                                align-items-center mb-4">

                        <span class="text-muted">

                            Free Shipping Above

                        </span>

                        <span class="fw-bold fs-5 text-success">

                            ₹{{ number_format(
                                $shipping->free_shipping_amount,
                                2
                            ) }}

                        </span>

                    </div>


                    <hr>


                    <div class="alert alert-info mb-0">

                        <i class="fas fa-truck me-2"></i>

                        These charges are automatically applied
                        during checkout.

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
```
