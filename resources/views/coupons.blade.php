@extends('layout')

@section('title', 'Add Coupon')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-header bg-dark text-white rounded-top-4 p-4">

                    <h4 class="mb-1 fw-bold">
                        <i class="fas fa-ticket-alt me-2"></i>
                        Add New Coupon
                    </h4>

                    <small class="text-white-50">
                        Create a discount coupon for customers
                    </small>

                </div>

                <div class="card-body p-4">

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.coupons.store') }}"
                          method="POST">

                        @csrf

                        {{-- COUPON CODE --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Coupon Code
                            </label>

                            <input type="text"
                                   name="code"
                                   class="form-control form-control-lg"
                                   placeholder="Example: SAVE10"
                                   value="{{ old('code') }}"
                                   required>

                        </div>


                        {{-- DISCOUNT TYPE --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Discount Type
                            </label>

                            <select name="discount_type"
                                    class="form-select form-select-lg"
                                    required>

                                <option value="percentage">
                                    Percentage (%)
                                </option>

                                <option value="fixed">
                                    Fixed Amount (₹)
                                </option>

                            </select>

                        </div>


                        {{-- DISCOUNT VALUE --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Discount Value
                            </label>

                            <input type="number"
                                   name="discount_value"
                                   class="form-control form-control-lg"
                                   placeholder="Example: 10"
                                   min="1"
                                   step="0.01"
                                   required>

                        </div>


                        <div class="row">

                            {{-- START DATE --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">
                                    Start Date
                                </label>

                                <input type="date"
                                       name="start_date"
                                       class="form-control form-control-lg">

                            </div>


                            {{-- EXPIRY DATE --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">
                                    Expiry Date
                                </label>

                                <input type="date"
                                       name="expiry_date"
                                       class="form-control form-control-lg">

                            </div>

                        </div>


                        {{-- USAGE LIMIT --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Usage Limit
                            </label>

                            <input type="number"
                                   name="usage_limit"
                                   class="form-control form-control-lg"
                                   placeholder="Example: 100"
                                   min="1">

                            <small class="text-muted">
                                Leave empty for unlimited usage.
                            </small>

                        </div>


                        {{-- STATUS --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Status
                            </label>

                            <select name="status"
                                    class="form-select form-select-lg">

                                <option value="1">
                                    Active
                                </option>

                                <option value="0">
                                    Inactive
                                </option>

                            </select>

                        </div>


                        {{-- BUTTON --}}
                        <div class="d-flex gap-2">

                            <button type="submit"
                                    class="btn btn-dark px-4 py-2">

                                <i class="fas fa-plus me-2"></i>
                                Add Coupon

                            </button>

                            <a href="{{ url('/admin/dashboard') }}"
                               class="btn btn-outline-secondary px-4 py-2">

                                Cancel

                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection