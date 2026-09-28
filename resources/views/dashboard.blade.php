@extends('layout')

@section('hideNavbarFooter', true)

@section('title', 'Admin Dashboard')

@section('content')


<div class="container-fluid bg-light min-vh-100 p-0">

    <div class="row g-0">
{{-- ================================================= --}}
{{-- SIDEBAR --}}
{{-- ================================================= --}}

<div class="col-lg-2 bg-dark text-white p-4 d-flex flex-column justify-content-between"
     style="min-height:100vh;">

    <div>

        {{-- ================================================= --}}
        {{-- ADMIN INFORMATION / BRAND --}}
        {{-- ================================================= --}}

        <div class="mb-4 pb-3 border-bottom border-secondary">

            <span class="text-uppercase fw-bold px-2 py-1 rounded-pill text-white d-inline-block mb-1"
                  style="background-color:#8cc63f;font-size:.6rem;">

                ADMIN PANEL

            </span>

            <h5 class="fw-bold text-white mb-1 fs-5">
                Store Manager
            </h5>

            {{-- CURRENT ADMIN --}}

            @php

                /*
                |--------------------------------------------------------------------------
                | CHECK CURRENT ADMIN
                |--------------------------------------------------------------------------
                */

                $currentAdmin = session('admin_user');

                /*
                |--------------------------------------------------------------------------
                | SUPER ADMIN CHECK
                |--------------------------------------------------------------------------
                |
                | Your original Super Admin login uses:
                | admin@seemy.com
                |
                */

                $isSuperAdmin =
                    session('admin_logged_in') === true
                    &&
                    (
                        session('admin_email') === 'admin@seemy.com'
                        ||
                        (
                            is_array($currentAdmin)
                            &&
                            ($currentAdmin['role'] ?? '') === 'superadmin'
                        )
                    );

                /*
                |--------------------------------------------------------------------------
                | GET PERMISSIONS
                |--------------------------------------------------------------------------
                */

                $adminPermissions = [];

                if (!$isSuperAdmin && is_array($currentAdmin)) {

                    $adminPermissions =
                        $currentAdmin['permissions'] ?? [];

                }

            @endphp


            @if($isSuperAdmin)

                <small class="text-success fw-semibold">
                    <i class="fa-solid fa-shield-halved me-1"></i>
                    Super Admin
                </small>

            @else

                <small class="text-white-50">
                    <i class="fa-solid fa-user-shield me-1"></i>
                    Administrator
                </small>

            @endif

        </div>


        {{-- ================================================= --}}
        {{-- SIDEBAR MENU --}}
        {{-- ================================================= --}}

        <ul class="nav flex-column gap-2">


            @if($isSuperAdmin || in_array('dashboard', $adminPermissions))

    <li class="nav-item">

    <a href="{{ route('admin.dashboard') }}"
       class="nav-link rounded-pill px-3 py-2 small fw-semibold
       {{ !request('page') ? 'text-white' : 'text-white-50' }}"
       style="{{ !request('page')
            ? 'background-color:rgba(140,198,63,.2);color:#8cc63f!important;'
            : '' }}">

        <i class="fa-solid fa-chart-pie me-2"></i>

        Dashboard

    </a>

</li>

@endif



            {{-- ================================================= --}}
            {{-- ADD PRODUCT --}}
            {{-- Permission: products --}}
            {{-- ================================================= --}}

            @if($isSuperAdmin || in_array('products', $adminPermissions))

                <li class="nav-item">

                    <a href="{{ route('admin.dashboard',['page'=>'add-product']) }}"
                       class="nav-link rounded-pill px-3 py-2 small fw-semibold
                       {{ request('page') == 'add-product' ? 'text-white' : 'text-white-50' }}"
                       style="{{ request('page') == 'add-product'
                            ? 'background-color:rgba(140,198,63,.2);color:#8cc63f!important;'
                            : '' }}">

                        <i class="fa-solid fa-plus me-2"></i>

                        Add Product

                    </a>

                </li>

            @endif



            {{-- ================================================= --}}
            {{-- MANAGE CATALOG --}}
            {{-- Permission: products --}}
            {{-- ================================================= --}}

            @if($isSuperAdmin || in_array('products', $adminPermissions))

                <li class="nav-item">

                    <a href="{{ route('admin.dashboard',['page'=>'manage-products']) }}"
                       class="nav-link rounded-pill px-3 py-2 small fw-semibold
                       {{ request('page') == 'manage-products' ? 'text-white' : 'text-white-50' }}"
                       style="{{ request('page') == 'manage-products'
                            ? 'background-color:rgba(140,198,63,.2);color:#8cc63f!important;'
                            : '' }}">

                        <i class="fa-solid fa-box-open me-2"></i>

                        Manage Catalog

                    </a>

                </li>

            @endif



            {{-- ================================================= --}}
            {{-- USER MANAGEMENT --}}
            {{-- Permission: user-management --}}
            {{-- ================================================= --}}

            @if($isSuperAdmin || in_array('user-management', $adminPermissions))

                <li class="nav-item">

                    <a href="{{ route('admin.dashboard',['page'=>'user-management']) }}"
                       class="nav-link rounded-pill px-3 py-2 small fw-semibold
                       {{ request('page') == 'user-management' ? 'text-white' : 'text-white-50' }}"
                       style="{{ request('page') == 'user-management'
                            ? 'background-color:rgba(140,198,63,.2);color:#8cc63f!important;'
                            : '' }}">

                        <i class="fa-solid fa-users me-2"></i>

                        User Management

                    </a>

                </li>

            @endif



            {{-- ================================================= --}}
            {{-- CATEGORIES --}}
            {{-- Permission: categories --}}
            {{-- ================================================= --}}

            @if($isSuperAdmin || in_array('categories', $adminPermissions))

                <li class="nav-item">

                    <a href="{{ route('admin.dashboard',['page'=>'categories']) }}"
                       class="nav-link rounded-pill px-3 py-2 small fw-semibold
                       {{ request('page') == 'categories' ? 'text-white' : 'text-white-50' }}"
                       style="{{ request('page') == 'categories'
                            ? 'background-color:rgba(140,198,63,.2);color:#8cc63f!important;'
                            : '' }}">

                        <i class="fa-solid fa-layer-group me-2"></i>

                        Categories

                    </a>

                </li>

            @endif



            {{-- ================================================= --}}
            {{-- STOCK MANAGEMENT --}}
            {{-- Permission: stock-management --}}
            {{-- ================================================= --}}

            @if($isSuperAdmin || in_array('stock-management', $adminPermissions))

                <li class="nav-item">

                    <a href="{{ route('admin.dashboard',['page'=>'stock-management']) }}"
                       class="nav-link rounded-pill px-3 py-2 small fw-semibold
                       {{ request('page') == 'stock-management' ? 'text-white' : 'text-white-50' }}"
                       style="{{ request('page') == 'stock-management'
                            ? 'background-color:rgba(140,198,63,.2);color:#8cc63f!important;'
                            : '' }}">

                        <i class="fa-solid fa-boxes-stacked me-2"></i>

                        Stock Management

                    </a>

                </li>

            @endif



            {{-- ================================================= --}}
            {{-- VIEW ORDERS --}}
            {{-- Permission: view-orders --}}
            {{-- ================================================= --}}

            @if($isSuperAdmin || in_array('view-orders', $adminPermissions))

                <li class="nav-item">

                    <a href="{{ route('admin.dashboard',['page'=>'view-orders']) }}"
                       class="nav-link rounded-pill px-3 py-2 small fw-semibold
                       {{ request('page') == 'view-orders' ? 'text-white' : 'text-white-50' }}"
                       style="{{ request('page') == 'view-orders'
                            ? 'background-color:rgba(140,198,63,.2);color:#8cc63f!important;'
                            : '' }}">

                        <i class="fa-solid fa-cart-shopping me-2"></i>

                        View Orders

                    </a>

                </li>

            @endif
{{-- ================================================= --}}
{{-- ENQUIRIES --}}
{{-- Permission: enquiries --}}
{{-- ================================================= --}}

@if($isSuperAdmin || in_array('enquiries', $adminPermissions))

    @php
        $pendingEnquiries = \App\Models\Enquiry::where('status', 'pending')->count();
    @endphp

    <li class="nav-item">

        <a href="{{ route('admin.dashboard', ['page' => 'enquiries']) }}"
           class="nav-link rounded-pill px-3 py-2 small fw-semibold d-flex align-items-center
           {{ request('page') == 'enquiries' ? 'text-white' : 'text-white-50' }}"
           style="{{ request('page') == 'enquiries'
                ? 'background-color:rgba(140,198,63,.2);color:#8cc63f!important;'
                : '' }}">

            <i class="fa-solid fa-envelope me-2"></i>

            <span class="flex-grow-1">
                Enquiries
            </span>

            @if($pendingEnquiries > 0)

                <span class="badge bg-danger rounded-pill ms-2">
                    {{ $pendingEnquiries }}
                </span>

            @endif

        </a>

    </li>

@endif

            {{-- ================================================= --}}
            {{-- WEBSITE VISITORS --}}
            {{-- Permission: website-visitors --}}
            {{-- ================================================= --}}

            @if($isSuperAdmin || in_array('website-visitors', $adminPermissions))

                <li class="nav-item">

                    <a href="{{ route('admin.dashboard',['page'=>'website-visitors']) }}"
                       class="nav-link rounded-pill px-3 py-2 small fw-semibold
                       {{ request('page') == 'website-visitors' ? 'text-white' : 'text-white-50' }}"
                       style="{{ request('page') == 'website-visitors'
                            ? 'background-color:rgba(140,198,63,.2);color:#8cc63f!important;'
                            : '' }}">

                        <i class="fa-solid fa-users me-2"></i>

                        Website Visitors

                    </a>

                </li>

            @endif



            {{-- ================================================= --}}
            {{-- COUPONS --}}
            {{-- Permission: coupons --}}
            {{-- ================================================= --}}

            @if($isSuperAdmin || in_array('coupons', $adminPermissions))

                <li class="nav-item">

                    <a href="{{ route('admin.dashboard',['page'=>'coupons']) }}"
                       class="nav-link rounded-pill px-3 py-2 small fw-semibold
                       {{ request('page') == 'coupons' ? 'text-white' : 'text-white-50' }}"
                       style="{{ request('page') == 'coupons'
                            ? 'background-color:rgba(140,198,63,.2);color:#8cc63f!important;'
                            : '' }}">

                        <i class="fas fa-ticket-alt me-2"></i>

                        Coupons

                    </a>

                </li>

            @endif



            {{-- ================================================= --}}
            {{-- SETTINGS --}}
            {{-- Permission: settings --}}
            {{-- ================================================= --}}

            @if($isSuperAdmin || in_array('settings', $adminPermissions))

                <li class="nav-item">

                    <a href="{{ route('admin.dashboard',['page'=>'settings']) }}"
                       class="nav-link rounded-pill px-3 py-2 small fw-semibold
                       {{ request('page') == 'settings' ? 'text-white' : 'text-white-50' }}"
                       style="{{ request('page') == 'settings'
                            ? 'background-color:rgba(140,198,63,.2);color:#8cc63f!important;'
                            : '' }}">

                        <i class="fa-solid fa-gear me-2"></i>

                        Settings

                    </a>

                </li>

            @endif

            {{-- ================================================= --}}
{{-- TWO FACTOR AUTHENTICATION --}}
{{-- Permission: settings --}}
{{-- ================================================= --}}

@if($isSuperAdmin || in_array('settings', $adminPermissions))

    <li class="nav-item">

        <a href="{{ route('admin.dashboard', ['page' => 'two-factor']) }}"
           class="nav-link rounded-pill px-3 py-2 small fw-semibold
           {{ request('page') == 'two-factor' ? 'text-white' : 'text-white-50' }}"
           style="{{ request('page') == 'two-factor'
                ? 'background-color:rgba(140,198,63,.2);color:#8cc63f!important;'
                : '' }}">

            <i class="fa-solid fa-shield-halved me-2"></i>

            Two-Factor Authentication

        </a>

    </li>

@endif
{{-- ================================================= --}}
{{-- SHIPPING CHARGES --}}
{{-- Permission: shipping-charges --}}
{{-- ================================================= --}}

@if($isSuperAdmin || in_array('shipping-charges', $adminPermissions))

    <li class="nav-item">

        <a href="{{ route('admin.dashboard', ['page' => 'shipping-charges']) }}"
           class="nav-link rounded-pill px-3 py-2 small fw-semibold
           {{ request('page') == 'shipping-charges' ? 'text-white' : 'text-white-50' }}"
           style="{{ request('page') == 'shipping-charges'
                ? 'background-color:rgba(140,198,63,.2);color:#8cc63f!important;'
                : '' }}">

            <i class="fa-solid fa-truck-fast me-2"></i>

            Shipping Charges

        </a>

    </li>

@endif

            {{-- ================================================= --}}
            {{-- REPORTS --}}
            {{-- Permission: reports --}}
            {{-- ================================================= --}}

            @if($isSuperAdmin || in_array('reports', $adminPermissions))

                <li class="nav-item">

                    <a href="{{ route('admin.dashboard',['page'=>'reports']) }}"
                       class="nav-link rounded-pill px-3 py-2 small fw-semibold
                       {{ request('page') == 'reports' ? 'text-white' : 'text-white-50' }}"
                       style="{{ request('page') == 'reports'
                            ? 'background-color:rgba(140,198,63,.2);color:#8cc63f!important;'
                            : '' }}">

                        <i class="fa-solid fa-chart-line me-2"></i>

                        Reports

                    </a>

                </li>

            @endif

        </ul>

    </div>

{{-- ================================================= --}}
{{-- DATABASE BACKUP --}}
{{-- Permission: backup --}}
{{-- ================================================= --}}

@if($isSuperAdmin || in_array('backup', $adminPermissions))

    <li class="nav-item">

        <a href="{{ route('admin.dashboard', ['page' => 'backup']) }}"
           class="nav-link rounded-pill px-3 py-2 small fw-semibold
           {{ request('page') == 'backup' ? 'text-white' : 'text-white-50' }}"
           style="{{ request('page') == 'backup'
                ? 'background-color:rgba(140,198,63,.2);color:#8cc63f!important;'
                : '' }}">

            <i class="fa-solid fa-database me-2"></i>

            Backup

        </a>

    </li>

@endif

    {{-- ================================================= --}}
    {{-- SIDEBAR FOOTER --}}
    {{-- ================================================= --}}

    <div class="pt-4 border-top border-secondary">


        {{-- VIEW LIVE STORE --}}

        <a href="{{ url('/products') }}"
           class="btn btn-outline-light rounded-pill w-100 py-2 small fw-semibold text-decoration-none mb-2">

            <i class="fa-solid fa-eye me-1"></i>

            View Live Store

        </a>


        {{-- LOGOUT --}}

        <form action="{{ route('admin.logout') }}"
              method="POST">

            @csrf

            <button type="submit"
                    class="btn btn-outline-danger rounded-pill w-100 py-2 small fw-semibold">

                <i class="fa-solid fa-right-from-bracket me-1"></i>

                Logout

            </button>

        </form>

    </div>

</div>
        {{-- ================================================= --}}
        {{-- MAIN CONTENT --}}
        {{-- ================================================= --}}

        <div class="col-lg-10 p-4 p-lg-5">


            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))

                <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4">

                    <i class="fa-solid fa-circle-check me-2"></i>

                    {{ session('success') }}

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                    </button>

                </div>

            @endif


            {{-- ERROR MESSAGE --}}
            @if(session('error'))

                <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm mb-4">

                    <i class="fa-solid fa-circle-exclamation me-2"></i>

                    {{ session('error') }}

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                    </button>

                </div>

            @endif


            {{-- VALIDATION ERRORS --}}
            @if($errors->any())

                <div class="alert alert-danger rounded-4 mb-4">

                    <strong>Please fix the following:</strong>

                    <ul class="mb-0 mt-2">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- ================================================= --}}
{{-- ADD PRODUCT --}}
{{-- ================================================= --}}

@if(request('page') == 'add-product')

    <div class="card border-0 rounded-4 shadow-sm bg-white">

        <div class="card-body p-4 p-lg-5">

            <div class="mb-4">

                <span class="text-uppercase fw-bold px-3 py-1 rounded-pill text-white d-inline-block mb-2"
                      style="background-color:#8cc63f;font-size:.7rem;">

                    PRODUCT

                </span>

                <h2 class="fw-bold text-dark mb-1">
                    Add New Product
                </h2>

                <p class="text-muted mb-0">
                    Add a new product to your store catalog.
                </p>

            </div>


            <form action="{{ route('products.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="row g-4">


                    {{-- ================================================= --}}
                    {{-- PRODUCT NAME --}}
                    {{-- ================================================= --}}

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">

                            <i class="fa-solid fa-tag me-2"
                               style="color:#8cc63f;"></i>

                            Product Name

                        </label>

                        <input type="text"
                               name="name"
                               class="form-control form-control-lg rounded-3"
                               value="{{ old('name') }}"
                               placeholder="Enter product name"
                               required>

                    </div>


                    {{-- ================================================= --}}
                    {{-- CATEGORY --}}
                    {{-- ================================================= --}}

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">

                            <i class="fa-solid fa-layer-group me-2"
                               style="color:#8cc63f;"></i>

                            Category

                        </label>

                        <select name="category"
                                class="form-select form-select-lg rounded-3"
                                required>

                            <option value=""
                                    disabled
                                    {{ old('category') ? '' : 'selected' }}>

                                Select Category

                            </option>

                            <option value="Optical Frame"
                                {{ old('category') == 'Optical Frame' ? 'selected' : '' }}>

                                Optical Frame

                            </option>

                            <option value="Sunglasses"
                                {{ old('category') == 'Sunglasses' ? 'selected' : '' }}>

                                Sunglasses

                            </option>

                            <option value="Smart Glasses"
                                {{ old('category') == 'Smart Glasses' ? 'selected' : '' }}>

                                Smart Glasses

                            </option>

                        </select>

                    </div>


                    {{-- ================================================= --}}
                    {{-- PRICE --}}
                    {{-- ================================================= --}}

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">

                            <i class="fa-solid fa-indian-rupee-sign me-2"
                               style="color:#8cc63f;"></i>

                            Price

                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                ₹
                            </span>

                            <input type="number"
                                   name="price"
                                   class="form-control form-control-lg"
                                   value="{{ old('price') }}"
                                   min="0"
                                   step="0.01"
                                   placeholder="Enter price"
                                   required>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- STOCK --}}
                    {{-- ================================================= --}}

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">

                            <i class="fa-solid fa-boxes-stacked me-2"
                               style="color:#8cc63f;"></i>

                            Stock Quantity

                        </label>

                        <input type="number"
                               name="stock"
                               class="form-control form-control-lg rounded-3"
                               value="{{ old('stock', 0) }}"
                               min="0"
                               placeholder="Enter stock quantity"
                               required>

                    </div>


                    {{-- ================================================= --}}
                    {{-- PRODUCT IMAGES - 5 SEPARATE BOXES --}}
                    {{-- ================================================= --}}

                    <div class="col-12">

                        <label class="form-label fw-semibold">

                            <i class="fa-solid fa-images me-2"
                               style="color:#8cc63f;"></i>

                            Product Images

                        </label>

                        <p class="text-muted small mb-3">

                            Select up to 5 product images.
                            Click each box to choose an image.

                        </p>


                        {{-- ================================================= --}}
                        {{-- IMAGE BOXES --}}
                        {{-- ================================================= --}}

                        <div class="row g-3">


                            {{-- ================= IMAGE 1 ================= --}}

                            <div class="col-6 col-md-4 col-lg">

                                <label for="productImage1"
                                       class="w-100 mb-0"
                                       style="cursor:pointer;">

                                    <div id="imageBox1"
                                         class="border border-2 rounded-4 bg-light position-relative overflow-hidden"
                                         style="height:180px;">

                                        {{-- PLACEHOLDER --}}

                                        <div id="placeholder1"
                                             class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center">

                                            <div class="rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center mb-2"
                                                 style="width:55px;height:55px;">

                                                <i class="fa-solid fa-plus fa-lg"
                                                   style="color:#8cc63f;"></i>

                                            </div>

                                            <span class="fw-bold text-dark">
                                                Image 1
                                            </span>

                                            <small class="text-muted">
                                                Choose Image
                                            </small>

                                        </div>


                                        {{-- PREVIEW --}}

                                        <img id="preview1"
                                             src=""
                                             class="w-100 h-100 d-none"
                                             style="object-fit:cover;">

                                    </div>

                                </label>

                                <input type="file"
                                       name="images[]"
                                       id="productImage1"
                                       class="d-none product-image-input"
                                       accept=".jpg,.jpeg,.png,.webp"
                                       data-number="1">

                            </div>


                            {{-- ================= IMAGE 2 ================= --}}

                            <div class="col-6 col-md-4 col-lg">

                                <label for="productImage2"
                                       class="w-100 mb-0"
                                       style="cursor:pointer;">

                                    <div id="imageBox2"
                                         class="border border-2 rounded-4 bg-light position-relative overflow-hidden"
                                         style="height:180px;">

                                        <div id="placeholder2"
                                             class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center">

                                            <div class="rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center mb-2"
                                                 style="width:55px;height:55px;">

                                                <i class="fa-solid fa-plus fa-lg"
                                                   style="color:#8cc63f;"></i>

                                            </div>

                                            <span class="fw-bold text-dark">
                                                Image 2
                                            </span>

                                            <small class="text-muted">
                                                Choose Image
                                            </small>

                                        </div>

                                        <img id="preview2"
                                             src=""
                                             class="w-100 h-100 d-none"
                                             style="object-fit:cover;">

                                    </div>

                                </label>

                                <input type="file"
                                       name="images[]"
                                       id="productImage2"
                                       class="d-none product-image-input"
                                       accept=".jpg,.jpeg,.png,.webp"
                                       data-number="2">

                            </div>


                            {{-- ================= IMAGE 3 ================= --}}

                            <div class="col-6 col-md-4 col-lg">

                                <label for="productImage3"
                                       class="w-100 mb-0"
                                       style="cursor:pointer;">

                                    <div id="imageBox3"
                                         class="border border-2 rounded-4 bg-light position-relative overflow-hidden"
                                         style="height:180px;">

                                        <div id="placeholder3"
                                             class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center">

                                            <div class="rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center mb-2"
                                                 style="width:55px;height:55px;">

                                                <i class="fa-solid fa-plus fa-lg"
                                                   style="color:#8cc63f;"></i>

                                            </div>

                                            <span class="fw-bold text-dark">
                                                Image 3
                                            </span>

                                            <small class="text-muted">
                                                Choose Image
                                            </small>

                                        </div>

                                        <img id="preview3"
                                             src=""
                                             class="w-100 h-100 d-none"
                                             style="object-fit:cover;">

                                    </div>

                                </label>

                                <input type="file"
                                       name="images[]"
                                       id="productImage3"
                                       class="d-none product-image-input"
                                       accept=".jpg,.jpeg,.png,.webp"
                                       data-number="3">

                            </div>


                            {{-- ================= IMAGE 4 ================= --}}

                            <div class="col-6 col-md-4 col-lg">

                                <label for="productImage4"
                                       class="w-100 mb-0"
                                       style="cursor:pointer;">

                                    <div id="imageBox4"
                                         class="border border-2 rounded-4 bg-light position-relative overflow-hidden"
                                         style="height:180px;">

                                        <div id="placeholder4"
                                             class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center">

                                            <div class="rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center mb-2"
                                                 style="width:55px;height:55px;">

                                                <i class="fa-solid fa-plus fa-lg"
                                                   style="color:#8cc63f;"></i>

                                            </div>

                                            <span class="fw-bold text-dark">
                                                Image 4
                                            </span>

                                            <small class="text-muted">
                                                Choose Image
                                            </small>

                                        </div>

                                        <img id="preview4"
                                             src=""
                                             class="w-100 h-100 d-none"
                                             style="object-fit:cover;">

                                    </div>

                                </label>

                                <input type="file"
                                       name="images[]"
                                       id="productImage4"
                                       class="d-none product-image-input"
                                       accept=".jpg,.jpeg,.png,.webp"
                                       data-number="4">

                            </div>


                            {{-- ================= IMAGE 5 ================= --}}

                            <div class="col-6 col-md-4 col-lg">

                                <label for="productImage5"
                                       class="w-100 mb-0"
                                       style="cursor:pointer;">

                                    <div id="imageBox5"
                                         class="border border-2 rounded-4 bg-light position-relative overflow-hidden"
                                         style="height:180px;">

                                        <div id="placeholder5"
                                             class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center">

                                            <div class="rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center mb-2"
                                                 style="width:55px;height:55px;">

                                                <i class="fa-solid fa-plus fa-lg"
                                                   style="color:#8cc63f;"></i>

                                            </div>

                                            <span class="fw-bold text-dark">
                                                Image 5
                                            </span>

                                            <small class="text-muted">
                                                Choose Image
                                            </small>

                                        </div>

                                        <img id="preview5"
                                             src=""
                                             class="w-100 h-100 d-none"
                                             style="object-fit:cover;">

                                    </div>

                                </label>

                                <input type="file"
                                       name="images[]"
                                       id="productImage5"
                                       class="d-none product-image-input"
                                       accept=".jpg,.jpeg,.png,.webp"
                                       data-number="5">

                            </div>

                        </div>


                        <small class="text-muted d-block mt-3">

                            JPG, JPEG, PNG or WEBP.
                            Maximum 2MB per image.

                        </small>

                    </div>


                    {{-- ================================================= --}}
                    {{-- DESCRIPTION --}}
                    {{-- ================================================= --}}

                    <div class="col-12">

                        <label class="form-label fw-semibold">

                            <i class="fa-solid fa-align-left me-2"
                               style="color:#8cc63f;"></i>

                            Description

                        </label>

                        <textarea name="description"
                                  rows="5"
                                  class="form-control rounded-3"
                                  placeholder="Enter product description"
                                  required>{{ old('description') }}</textarea>

                    </div>


                    {{-- ================================================= --}}
                    {{-- BUTTONS --}}
                    {{-- ================================================= --}}

                    <div class="col-12">

                        <div class="d-flex flex-wrap gap-3">

                            <button type="submit"
                                    class="btn text-white rounded-pill px-4 py-2 fw-bold"
                                    style="background-color:#8cc63f;">

                                <i class="fa-solid fa-plus me-2"></i>

                                Add Product

                            </button>


                            <a href="{{ route('admin.dashboard') }}"
                               class="btn btn-light border rounded-pill px-4 py-2 fw-semibold">

                                Cancel

                            </a>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- IMAGE PREVIEW SCRIPT --}}
    {{-- ================================================= --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const imageInputs =
                document.querySelectorAll('.product-image-input');


            imageInputs.forEach(function(input) {

                input.addEventListener('change', function(event) {

                    const file = event.target.files[0];

                    const number =
                        this.getAttribute('data-number');

                    const preview =
                        document.getElementById('preview' + number);

                    const placeholder =
                        document.getElementById('placeholder' + number);

                    const box =
                        document.getElementById('imageBox' + number);


                    if (!file) {

                        preview.src = '';

                        preview.classList.add('d-none');

                        placeholder.classList.remove('d-none');

                        box.classList.remove('border-success');

                        return;

                    }


                    // =================================================
                    // FILE TYPE CHECK
                    // =================================================

                    const allowedTypes = [

                        'image/jpeg',
                        'image/jpg',
                        'image/png',
                        'image/webp'

                    ];


                    if (!allowedTypes.includes(file.type)) {

                        alert(
                            'Please select JPG, JPEG, PNG or WEBP image.'
                        );

                        this.value = '';

                        preview.src = '';

                        preview.classList.add('d-none');

                        placeholder.classList.remove('d-none');

                        return;

                    }


                    // =================================================
                    // FILE SIZE CHECK - 2MB
                    // =================================================

                    if (file.size > 2 * 1024 * 1024) {

                        alert(
                            'Image ' + number +
                            ' must be less than 2MB.'
                        );

                        this.value = '';

                        preview.src = '';

                        preview.classList.add('d-none');

                        placeholder.classList.remove('d-none');

                        return;

                    }


                    // =================================================
                    // SHOW IMAGE PREVIEW
                    // =================================================

                    const reader =
                        new FileReader();


                    reader.onload = function(e) {

                        preview.src =
                            e.target.result;

                        preview.classList.remove('d-none');

                        placeholder.classList.add('d-none');

                        box.classList.add('border-success');

                    };


                    reader.readAsDataURL(file);

                });

            });

        });

    </script>


            {{-- ================================================= --}}
            {{-- MANAGE PRODUCTS --}}
            {{-- ================================================= --}}

            @elseif(request('page') == 'manage-products')

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                    <div>

                        <span class="text-uppercase fw-bold px-3 py-1 rounded-pill text-white d-inline-block mb-2"
                              style="background-color:#8cc63f;font-size:.7rem;">

                            CATALOG

                        </span>

                        <h2 class="fw-bold text-dark mb-1">
                            Manage Products
                        </h2>

                        <p class="text-muted mb-0">
                            Manage, update and organize your eyewear products.
                        </p>

                    </div>


                    <a href="{{ route('admin.dashboard',['page'=>'add-product']) }}"
                       class="btn text-white rounded-pill px-4 py-2 fw-bold"
                       style="background-color:#8cc63f;">

                        <i class="fa-solid fa-plus me-2"></i>
                        Add Product

                    </a>

                </div>


                <div class="card border-0 rounded-4 shadow-sm bg-white">

                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0">

                                <thead class="table-light">

                                    <tr>

                                        <th class="px-4 py-3">Image</th>
                                        <th class="py-3">Product</th>
                                        <th class="py-3">Category</th>
                                        <th class="py-3">Price</th>
                                        <th class="py-3">Stock</th>
                                        <th class="py-3">Description</th>
                                        <th class="py-3 text-center">Action</th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse($products as $product)

                                        <tr id="view-row-{{ $product->id }}">

                                            <td class="px-4">

                                                @if($product->image)

                                                    <img src="{{ asset('product-images/'.$product->image) }}"
                                                         alt="{{ $product->name }}"
                                                         class="rounded-3 border"
                                                         style="width:75px;height:65px;object-fit:cover;">

                                                @else

                                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center"
                                                         style="width:75px;height:65px;">

                                                        <i class="fa-solid fa-image text-muted"></i>

                                                    </div>

                                                @endif

                                            </td>


                                            <td>

                                                <div class="fw-bold text-dark">
                                                    {{ $product->name }}
                                                </div>

                                            </td>


                                            <td>

                                                <span class="badge rounded-pill px-3 py-2"
                                                      style="background-color:#8cc63f;">

                                                    {{ $product->category }}

                                                </span>

                                            </td>


                                            <td>

                                                <span class="fw-bold"
                                                      style="color:#8cc63f;">

                                                    ₹{{ number_format($product->price,2) }}

                                                </span>

                                            </td>


                                            <td>

                                                @if($product->stock == 0)

                                                    <span class="badge bg-danger rounded-pill px-3 py-2">
                                                        Out of Stock
                                                    </span>

                                                @elseif($product->stock <= 5)

                                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                                        Low: {{ $product->stock }}
                                                    </span>

                                                @else

                                                    <span class="badge bg-success rounded-pill px-3 py-2">
                                                        {{ $product->stock }}
                                                    </span>

                                                @endif

                                            </td>


                                            <td style="max-width:260px;">

                                                <span class="text-muted small">

                                                    {{ \Illuminate\Support\Str::limit($product->description,55) }}

                                                </span>

                                            </td>


                                            <td class="text-center">

                                                <div class="d-flex justify-content-center gap-2">

                                                    <button type="button"
                                                            onclick="showEdit({{ $product->id }})"
                                                            class="btn btn-outline-primary btn-sm rounded-pill px-3">

                                                        <i class="fa-solid fa-pen me-1"></i>
                                                        Edit

                                                    </button>


                                                    <form action="{{ route('products.destroy',$product->id) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Are you sure you want to delete this product?');">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                                class="btn btn-outline-danger btn-sm rounded-pill px-3">

                                                            <i class="fa-solid fa-trash me-1"></i>
                                                            Delete

                                                        </button>

                                                    </form>

                                                </div>

                                            </td>

                                        </tr>


                                        {{-- INLINE EDIT --}}
                                        <tr id="edit-row-{{ $product->id }}"
                                            style="display:none;background-color:#f8fbf3;">

                                            <td colspan="7" class="p-4">

                                                <div class="card border-0 shadow-sm rounded-4">

                                                    <div class="card-body p-4">

                                                        <h5 class="fw-bold mb-4">

                                                            <i class="fa-solid fa-pen me-2"
                                                               style="color:#8cc63f;"></i>

                                                            Edit Product

                                                        </h5>


                                                        <form action="{{ route('products.update',$product->id) }}"
                                                              method="POST"
                                                              enctype="multipart/form-data">

                                                            @csrf
                                                            @method('PUT')

                                                            <div class="row g-3">

                                                                <div class="col-md-4">

                                                                    <label class="form-label fw-semibold">
                                                                        Product Name
                                                                    </label>

                                                                    <input type="text"
                                                                           name="name"
                                                                           value="{{ $product->name }}"
                                                                           class="form-control rounded-3"
                                                                           required>

                                                                </div>


                                                                <div class="col-md-4">

                                                                    <label class="form-label fw-semibold">
                                                                        Category
                                                                    </label>

                                                                    <select name="category"
                                                                            class="form-select rounded-3"
                                                                            required>

                                                                        <option value="Optical Frame"
                                                                            {{ $product->category == 'Optical Frame' ? 'selected' : '' }}>
                                                                            Optical Frame
                                                                        </option>

                                                                        <option value="Sunglasses"
                                                                            {{ $product->category == 'Sunglasses' ? 'selected' : '' }}>
                                                                            Sunglasses
                                                                        </option>

                                                                        <option value="Smart Glasses"
                                                                            {{ $product->category == 'Smart Glasses' ? 'selected' : '' }}>
                                                                            Smart Glasses
                                                                        </option>

                                                                    </select>

                                                                </div>


                                                                <div class="col-md-4">

                                                                    <label class="form-label fw-semibold">
                                                                        Price
                                                                    </label>

                                                                    <input type="number"
                                                                           name="price"
                                                                           value="{{ $product->price }}"
                                                                           min="0"
                                                                           step="0.01"
                                                                           class="form-control"
                                                                           required>

                                                                </div>


                                                                <div class="col-md-4">

                                                                    <label class="form-label fw-semibold">
                                                                        Stock
                                                                    </label>

                                                                    <input type="number"
                                                                           name="stock"
                                                                           value="{{ $product->stock }}"
                                                                           min="0"
                                                                           class="form-control rounded-3"
                                                                           required>

                                                                </div>


                                                                <div class="col-md-4">

                                                                    <label class="form-label fw-semibold">
                                                                        Current Image
                                                                    </label>

                                                                    @if($product->image)

                                                                        <img src="{{ asset('product-images/'.$product->image) }}"
                                                                             class="rounded-3 border"
                                                                             style="width:70px;height:60px;object-fit:cover;">

                                                                    @else

                                                                        <span class="text-muted small">
                                                                            No image
                                                                        </span>

                                                                    @endif

                                                                </div>


                                                                <div class="col-md-4">

                                                                    <label class="form-label fw-semibold">
                                                                        Change Image
                                                                    </label>

                                                                    <input type="file"
                                                                           name="image"
                                                                           class="form-control rounded-3"
                                                                           accept=".jpg,.jpeg,.png,.webp">

                                                                </div>


                                                                <div class="col-12">

                                                                    <label class="form-label fw-semibold">
                                                                        Description
                                                                    </label>

                                                                    <textarea name="description"
                                                                              rows="3"
                                                                              class="form-control rounded-3"
                                                                              required>{{ $product->description }}</textarea>

                                                                </div>


                                                                <div class="col-12">

                                                                    <button type="submit"
                                                                            class="btn text-white rounded-pill px-4 fw-bold"
                                                                            style="background-color:#8cc63f;">

                                                                        <i class="fa-solid fa-check me-1"></i>
                                                                        Save Changes

                                                                    </button>


                                                                    <button type="button"
                                                                            onclick="hideEdit({{ $product->id }})"
                                                                            class="btn btn-outline-secondary rounded-pill px-4">

                                                                        Cancel

                                                                    </button>

                                                                </div>

                                                            </div>

                                                        </form>

                                                    </div>

                                                </div>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="7"
                                                class="text-center py-5">

                                                <i class="fa-solid fa-box-open fa-2x text-muted mb-3"></i>

                                                <h5 class="fw-bold">
                                                    No Products Found
                                                </h5>

                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>
<script>
    // ====================================================
    // SHOW EDIT FORM
    // ====================================================

    function showEdit(id) {

        // Hide normal product row
        const viewRow = document.getElementById('view-row-' + id);

        // Show edit row
        const editRow = document.getElementById('edit-row-' + id);

        if (viewRow && editRow) {

            viewRow.style.display = 'none';

            editRow.style.display = 'table-row';

            // Scroll smoothly to edit form
            setTimeout(function () {

                editRow.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

            }, 100);
        }
    }


    // ====================================================
    // HIDE EDIT FORM
    // ====================================================

    function hideEdit(id) {

        // Show normal product row
        const viewRow = document.getElementById('view-row-' + id);

        // Hide edit row
        const editRow = document.getElementById('edit-row-' + id);

        if (viewRow && editRow) {

            editRow.style.display = 'none';

            viewRow.style.display = 'table-row';

        }
    }
</script>

                {{-- ================================================= --}}
{{-- USER MANAGEMENT --}}
{{-- ================================================= --}}

@if($page == 'user-management')

    <div class="container-fluid">

        {{-- PAGE HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h2 class="fw-bold mb-1">
                    User Management
                </h2>

                <p class="text-muted mb-0">
                    Manage registered customers and their access.
                </p>
            </div>

            <div class="bg-primary text-white rounded-4 px-4 py-3">

                <div class="small">
                    Total Users
                </div>

                <div class="fs-4 fw-bold">
                    {{ $users->count() }}
                </div>

            </div>

        </div>


        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show rounded-4">

                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- USER TABLE --}}
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-dark">

                            <tr>

                                <th class="px-4">
                                    #
                                </th>

                                <th>
                                    User Name
                                </th>

                                <th>
                                    Email
                                </th>

                                <th>
                                    Registered Date
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($users as $user)

                                <tr>

                                    <td class="px-4 fw-semibold">
                                        {{ $loop->iteration }}
                                    </td>


                                    <td>

                                        <div class="d-flex align-items-center">

                                            <div
                                                class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                                style="width:42px;height:42px;"
                                            >

                                                {{ strtoupper(substr($user->name, 0, 1)) }}

                                            </div>

                                            <div>

                                                <div class="fw-semibold">
                                                    {{ $user->name }}
                                                </div>

                                            </div>

                                        </div>

                                    </td>


                                    <td>
                                        {{ $user->email }}
                                    </td>


                                    <td>

                                        {{ $user->created_at
                                            ? $user->created_at->format('d M Y')
                                            : '-' }}

                                    </td>


                                    <td>

                                        <span class="badge bg-success rounded-pill px-3 py-2">
                                            Active
                                        </span>

                                    </td>


                                    <td>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-primary rounded-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#userModal{{ $user->id }}"
                                        >

                                            <i class="bi bi-eye me-1"></i>
                                            View

                                        </button>

                                    </td>

                                </tr>


                                {{-- USER DETAILS MODAL --}}

                                <div
                                    class="modal fade"
                                    id="userModal{{ $user->id }}"
                                    tabindex="-1"
                                >

                                    <div class="modal-dialog modal-dialog-centered">

                                        <div class="modal-content border-0 rounded-4 shadow">

                                            <div class="modal-header">

                                                <h5 class="modal-title fw-bold">
                                                    User Details
                                                </h5>

                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal">
                                                </button>

                                            </div>


                                            <div class="modal-body">

                                                <div class="text-center mb-4">

                                                    <div
                                                        class="bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                                        style="width:70px;height:70px;font-size:28px;"
                                                    >

                                                        {{ strtoupper(substr($user->name, 0, 1)) }}

                                                    </div>

                                                    <h5 class="fw-bold mt-3 mb-1">
                                                        {{ $user->name }}
                                                    </h5>

                                                    <p class="text-muted mb-0">
                                                        {{ $user->email }}
                                                    </p>

                                                </div>


                                                <div class="border rounded-3 p-3 mb-2">

                                                    <div class="small text-muted">
                                                        User ID
                                                    </div>

                                                    <div class="fw-semibold">
                                                        #{{ $user->id }}
                                                    </div>

                                                </div>


                                                <div class="border rounded-3 p-3 mb-2">

                                                    <div class="small text-muted">
                                                        Name
                                                    </div>

                                                    <div class="fw-semibold">
                                                        {{ $user->name }}
                                                    </div>

                                                </div>


                                                <div class="border rounded-3 p-3 mb-2">

                                                    <div class="small text-muted">
                                                        Email
                                                    </div>

                                                    <div class="fw-semibold">
                                                        {{ $user->email }}
                                                    </div>

                                                </div>


                                                <div class="border rounded-3 p-3">

                                                    <div class="small text-muted">
                                                        Registration Date
                                                    </div>

                                                    <div class="fw-semibold">

                                                        {{ $user->created_at
                                                            ? $user->created_at->format('d M Y h:i A')
                                                            : '-' }}

                                                    </div>

                                                </div>

                                            </div>


                                            <div class="modal-footer">

                                                <button
                                                    type="button"
                                                    class="btn btn-secondary rounded-3"
                                                    data-bs-dismiss="modal"
                                                >
                                                    Close
                                                </button>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="text-center py-5"
                                    >

                                        <i class="bi bi-people fs-1 text-muted"></i>

                                        <h5 class="fw-bold mt-3">
                                            No Users Found
                                        </h5>

                                        <p class="text-muted mb-0">
                                            No registered users are available.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endif

            {{-- ================================================= --}}
            {{-- CATEGORIES --}}
            {{-- ================================================= --}}

            @elseif(request('page') == 'categories')

                <div class="mb-4">

                    <span class="text-uppercase fw-bold px-3 py-1 rounded-pill text-white d-inline-block mb-2"
                          style="background-color:#8cc63f;font-size:.7rem;">

                        CATEGORY

                    </span>

                    <h2 class="fw-bold text-dark mb-1">
                        Categories
                    </h2>

                    <p class="text-muted mb-0">
                        Categories currently used by your products.
                    </p>

                </div>


                <div class="d-flex flex-wrap gap-2 mb-4">

                    <button type="button"
                            class="btn text-white rounded-pill px-4 py-2 fw-semibold category-filter"
                            onclick="filterCategory('all', this)"
                            style="background-color:#8cc63f;">

                        <i class="fa-solid fa-box-open me-1"></i>
                        All Products

                    </button>


                    @foreach($categories as $category)

                        <button type="button"
                                class="btn btn-light border rounded-pill px-4 py-2 fw-semibold category-filter"
                                onclick="filterCategory('{{ $category }}', this)">

                            <i class="fa-solid fa-layer-group me-1"></i>

                            {{ $category }}

                        </button>

                    @endforeach

                </div>


                <div class="row g-4" id="categoryProducts">

                    @forelse($products as $product)

                        <div class="col-md-6 col-lg-4 category-product"
                             data-category="{{ $product->category }}">

                            <div class="card border-0 rounded-4 shadow-sm bg-white h-100">

                                <div class="p-3">

                                    @if($product->image)

                                        <img src="{{ asset('product-images/'.$product->image) }}"
                                             alt="{{ $product->name }}"
                                             class="w-100 rounded-4"
                                             style="height:220px;object-fit:cover;">

                                    @else

                                        <div class="bg-light rounded-4 d-flex align-items-center justify-content-center"
                                             style="height:220px;">

                                            <i class="fa-solid fa-image fa-2x text-muted"></i>

                                        </div>

                                    @endif

                                </div>


                                <div class="card-body p-4">

                                    <span class="badge rounded-pill px-3 py-2 mb-2"
                                          style="background-color:#8cc63f;">

                                        {{ $product->category }}

                                    </span>


                                    <h5 class="fw-bold text-dark mb-2">
                                        {{ $product->name }}
                                    </h5>


                                    <h5 class="fw-bold mb-2"
                                        style="color:#8cc63f;">

                                        ₹{{ number_format($product->price,2) }}

                                    </h5>


                                    @if($product->stock == 0)

                                        <span class="badge bg-danger rounded-pill px-3 py-2">
                                            Out of Stock
                                        </span>

                                    @elseif($product->stock <= 5)

                                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                            Low Stock: {{ $product->stock }}
                                        </span>

                                    @else

                                        <span class="badge bg-success rounded-pill px-3 py-2">
                                            Stock: {{ $product->stock }}
                                        </span>

                                    @endif


                                    <p class="text-muted small mt-3 mb-0">

                                        {{ \Illuminate\Support\Str::limit($product->description,100) }}

                                    </p>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="col-12">

                            <div class="card border-0 rounded-4 shadow-sm">

                                <div class="card-body text-center py-5">

                                    <i class="fa-solid fa-box-open fa-2x text-muted mb-3"></i>

                                    <h5 class="fw-bold">
                                        No Products Found
                                    </h5>

                                </div>

                            </div>

                        </div>

                    @endforelse

                </div>


                <div id="noCategoryProducts"
                     class="card border-0 rounded-4 shadow-sm bg-white mt-4"
                     style="display:none;">

                    <div class="card-body text-center py-5">

                        <i class="fa-solid fa-box-open fa-2x text-muted mb-3"></i>

                        <h5 class="fw-bold">
                            No Products Found
                        </h5>

                        <p class="text-muted mb-0">
                            No products are available in this category.
                        </p>

                    </div>

                </div>



            {{-- ================================================= --}}
            {{-- STOCK MANAGEMENT --}}
            {{-- ================================================= --}}

            @elseif(request('page') == 'stock-management')

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                    <div>

                        <span class="text-uppercase fw-bold px-3 py-1 rounded-pill text-white d-inline-block mb-2"
                              style="background-color:#8cc63f;font-size:.7rem;">

                            INVENTORY

                        </span>

                        <h2 class="fw-bold text-dark mb-1">
                            Stock Management
                        </h2>

                        <p class="text-muted mb-0">
                            Monitor product stock and identify low or out of stock products.
                        </p>

                    </div>


                    <a href="{{ route('admin.dashboard',['page'=>'manage-products']) }}"
                       class="btn text-white rounded-pill px-4 py-2 fw-bold"
                       style="background-color:#8cc63f;">

                        <i class="fa-solid fa-box-open me-2"></i>
                        Manage Products

                    </a>

                </div>


                {{-- STOCK SUMMARY --}}
                <div class="row g-4 mb-4">

                    <div class="col-md-3">

                        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 h-100">

                            <span class="text-muted small fw-semibold text-uppercase">
                                Total Stock
                            </span>

                            <h3 class="fw-bold mt-2 mb-0">
                                {{ $products->sum('stock') }}
                            </h3>

                        </div>

                    </div>


                    <div class="col-md-3">

                        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 h-100">

                            <span class="text-muted small fw-semibold text-uppercase">
                                In Stock
                            </span>

                            <h3 class="fw-bold mt-2 mb-0 text-success">
                                {{ $products->where('stock', '>', 5)->count() }}
                            </h3>

                        </div>

                    </div>


                    <div class="col-md-3">

                        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 h-100">

                            <span class="text-muted small fw-semibold text-uppercase">
                                Low Stock
                            </span>

                            <h3 class="fw-bold mt-2 mb-0 text-warning">

                                {{ $products->filter(function($product) {
                                    return $product->stock > 0 && $product->stock <= 5;
                                })->count() }}

                            </h3>

                        </div>

                    </div>


                    <div class="col-md-3">

                        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 h-100">

                            <span class="text-muted small fw-semibold text-uppercase">
                                Out of Stock
                            </span>

                            <h3 class="fw-bold mt-2 mb-0 text-danger">

                                {{ $products->where('stock', 0)->count() }}

                            </h3>

                        </div>

                    </div>

                </div>


                {{-- STOCK TABLE --}}
                <div class="card border-0 rounded-4 shadow-sm bg-white">

                    <div class="card-body p-0">

                        <div class="d-flex justify-content-between align-items-center p-4 border-bottom">

                            <div>

                                <h5 class="fw-bold mb-1">
                                    Product Stock
                                </h5>

                                <small class="text-muted">
                                    Current inventory status
                                </small>

                            </div>

                            <span class="badge rounded-pill px-3 py-2"
                                  style="background-color:#8cc63f;">

                                {{ $products->count() }} Products

                            </span>

                        </div>


                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0">

                                <thead class="table-light">

                                    <tr>

                                        <th class="px-4 py-3">
                                            Product
                                        </th>

                                        <th class="py-3">
                                            Category
                                        </th>

                                        <th class="py-3">
                                            Price
                                        </th>

                                        <th class="py-3">
                                            Stock
                                        </th>

                                        <th class="py-3">
                                            Status
                                        </th>

                                        <th class="py-3 text-center">
                                            Action
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse($products as $product)

                                        <tr>

                                            <td class="px-4">

                                                <div class="d-flex align-items-center">

                                                    @if($product->image)

                                                        <img src="{{ asset('product-images/'.$product->image) }}"
                                                             alt="{{ $product->name }}"
                                                             class="rounded-3 border me-3"
                                                             style="width:65px;height:55px;object-fit:cover;">

                                                    @else

                                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center me-3"
                                                             style="width:65px;height:55px;">

                                                            <i class="fa-solid fa-image text-muted"></i>

                                                        </div>

                                                    @endif


                                                    <div>

                                                        <div class="fw-bold text-dark">
                                                            {{ $product->name }}
                                                        </div>

                                                        <small class="text-muted">
                                                            Product #{{ $product->id }}
                                                        </small>

                                                    </div>

                                                </div>

                                            </td>


                                            <td>

                                                <span class="badge rounded-pill px-3 py-2"
                                                      style="background-color:#8cc63f;">

                                                    {{ $product->category }}

                                                </span>

                                            </td>


                                            <td>

                                                <span class="fw-bold"
                                                      style="color:#8cc63f;">

                                                    ₹{{ number_format($product->price,2) }}

                                                </span>

                                            </td>


                                            <td>

                                                <span class="fw-bold fs-6">
                                                    {{ $product->stock }}
                                                </span>

                                                <small class="text-muted">
                                                    units
                                                </small>

                                            </td>


                                            <td>

                                                @if($product->stock == 0)

                                                    <span class="badge bg-danger rounded-pill px-3 py-2">
                                                        Out of Stock
                                                    </span>

                                                @elseif($product->stock <= 5)

                                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                                        Low Stock
                                                    </span>

                                                @else

                                                    <span class="badge bg-success rounded-pill px-3 py-2">
                                                        In Stock
                                                    </span>

                                                @endif

                                            </td>


                                            <td class="text-center">

                                                <a href="{{ route('admin.dashboard',['page'=>'manage-products']) }}"
                                                   class="btn btn-outline-primary btn-sm rounded-pill px-3">

                                                    <i class="fa-solid fa-pen me-1"></i>
                                                    Manage

                                                </a>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="6"
                                                class="text-center py-5">

                                                <i class="fa-solid fa-box-open fa-2x text-muted mb-3"></i>

                                                <h5 class="fw-bold">
                                                    No Products Found
                                                </h5>

                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>



             {{-- ================================================= --}}
{{-- WEBSITE VISITORS --}}
{{-- ================================================= --}}

@if(request('page') == 'website-visitors')

    <div class="container-fluid">

        {{-- PAGE HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-1">
                    Website Visitors
                </h3>

                <p class="text-muted mb-0">
                    Monitor unique visitors using IP address
                </p>
            </div>

            <div class="px-4 py-2 rounded-pill"
                 style="background-color:#f0f8e8; color:#8cc63f;">

                <i class="fa-solid fa-globe me-2"></i>

                Live Visitor Tracking

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- TOTAL VISITORS CARD --}}
        {{-- ================================================= --}}

        <div class="row g-4 mb-4">

            <div class="col-xl-4 col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body p-4">

                        <div class="d-flex align-items-center">

                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                 style="
                                    width:60px;
                                    height:60px;
                                    background-color:#f0f8e8;
                                    color:#8cc63f;
                                 ">

                                <i class="fa-solid fa-users fa-lg"></i>

                            </div>

                            <div>

                                <small class="text-muted">
                                    Total Unique Visitors
                                </small>

                                <h2 class="fw-bold mb-0 mt-1">
                                    {{ $totalVisitors }}
                                </h2>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- TODAY'S VISITORS --}}

            <div class="col-xl-4 col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body p-4">

                        <div class="d-flex align-items-center">

                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                 style="
                                    width:60px;
                                    height:60px;
                                    background-color:#eef7ff;
                                    color:#4a90e2;
                                 ">

                                <i class="fa-solid fa-calendar-day fa-lg"></i>

                            </div>

                            <div>

                                <small class="text-muted">
                                    Today's Visitors
                                </small>

                                <h2 class="fw-bold mb-0 mt-1">
                                    {{ $todayVisitors ?? 0 }}
                                </h2>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- LAST VISIT --}}

            <div class="col-xl-4 col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body p-4">

                        <div class="d-flex align-items-center">

                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                 style="
                                    width:60px;
                                    height:60px;
                                    background-color:#fff7e8;
                                    color:#e9b36a;
                                 ">

                                <i class="fa-solid fa-clock fa-lg"></i>

                            </div>

                            <div>

                                <small class="text-muted">
                                    Latest Visit
                                </small>

                                <h6 class="fw-bold mb-0 mt-2">
                                    {{ $latestVisitor ?? 'No visits yet' }}
                                </h6>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- VISITOR INFORMATION --}}
        {{-- ================================================= --}}

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-header bg-white border-0 p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h5 class="fw-bold mb-1">
                            Visitor Information
                        </h5>

                        <small class="text-muted">
                            Unique IP addresses that visited your website
                        </small>

                    </div>

                    <span class="badge rounded-pill px-3 py-2"
                          style="background-color:#f0f8e8;color:#8cc63f;">

                        {{ $totalVisitors }} Visitors

                    </span>

                </div>

            </div>


            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead style="background-color:#f8fbf5;">

                            <tr>

                                <th class="px-4 py-3">
                                    #
                                </th>

                                <th>
                                    IP Address
                                </th>

                                <th>
                                    First Visit
                                </th>

                                <th>
                                    Last Visit
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($visitors ?? [] as $visitor)

                                <tr>

                                    <td class="px-4 fw-semibold">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>

                                        <span class="badge rounded-pill px-3 py-2"
                                              style="background-color:#f0f8e8;color:#5f8f24;">

                                            <i class="fa-solid fa-location-dot me-1"></i>

                                            {{ $visitor->ip_address }}

                                        </span>

                                    </td>

                                    <td>

                                        <small class="text-muted">

                                            {{ $visitor->created_at
                                                ? $visitor->created_at->format('d M Y, h:i A')
                                                : '-' }}

                                        </small>

                                    </td>

                                    <td>

                                        <small class="text-muted">

                                            {{ $visitor->updated_at
                                                ? $visitor->updated_at->format('d M Y, h:i A')
                                                : '-' }}

                                        </small>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="4"
                                        class="text-center py-5">

                                        <div class="mb-3">

                                            <i class="fa-solid fa-users-slash fa-2x text-muted"></i>

                                        </div>

                                        <h6 class="fw-bold">
                                            No visitors yet
                                        </h6>

                                        <p class="text-muted mb-0">
                                            Visitor information will appear here when someone visits your website.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endif

{{-- ================================================= --}}
{{-- USER MANAGEMENT --}}
{{-- ================================================= --}}

@elseif(request('page') == 'user-management')

    <div class="container-fluid">

        {{-- ================================================= --}}
        {{-- PAGE HEADER --}}
        {{-- ================================================= --}}

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-1">
                    User Management
                </h3>

                <p class="text-muted mb-0">
                    Manage users, admins and page access permissions
                </p>
            </div>

            <button type="button"
                    class="btn text-white rounded-pill px-4 fw-semibold"
                    style="background-color:#8cc63f;"
                    data-bs-toggle="modal"
                    data-bs-target="#addAdminModal">

                <i class="fa-solid fa-user-plus me-2"></i>

                Add New Admin

            </button>

        </div>


        {{-- ================================================= --}}
        {{-- SUCCESS MESSAGE --}}
        {{-- ================================================= --}}

        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm"
                 role="alert">

                <i class="fa-solid fa-circle-check me-2"></i>

                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- ================================================= --}}
        {{-- ERROR MESSAGE --}}
        {{-- ================================================= --}}

        @if(session('error'))

            <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm"
                 role="alert">

                <i class="fa-solid fa-circle-exclamation me-2"></i>

                {{ session('error') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- ================================================= --}}
        {{-- VALIDATION ERRORS --}}
        {{-- ================================================= --}}

        @if($errors->any())

            <div class="alert alert-danger rounded-4 border-0 shadow-sm">

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


        {{-- ================================================= --}}
        {{-- STAT CARDS --}}
        {{-- ================================================= --}}

        <div class="row g-4 mb-4">

            {{-- TOTAL USERS --}}
            <div class="col-md-4">

                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">

                    <div class="d-flex align-items-center">

                        <div class="rounded-circle p-3 me-3"
                             style="background:#f0f8e8;color:#8cc63f;">

                            <i class="fa-solid fa-users fa-lg"></i>

                        </div>

                        <div>

                            <small class="text-muted">
                                Total Users
                            </small>

                            <h3 class="fw-bold mb-0">
                                {{ $users->count() }}
                            </h3>

                        </div>

                    </div>

                </div>

            </div>


            {{-- TOTAL ADMINS --}}
            <div class="col-md-4">

                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">

                    <div class="d-flex align-items-center">

                        <div class="rounded-circle p-3 me-3"
                             style="background:#fff5e8;color:#e9b36a;">

                            <i class="fa-solid fa-user-shield fa-lg"></i>

                        </div>

                        <div>

                            <small class="text-muted">
                                Total Admins
                            </small>

                            <h3 class="fw-bold mb-0">
                                {{ $admins->count() }}
                            </h3>

                        </div>

                    </div>

                </div>

            </div>


            {{-- TOTAL ACCOUNTS --}}
            <div class="col-md-4">

                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">

                    <div class="d-flex align-items-center">

                        <div class="rounded-circle p-3 me-3"
                             style="background:#eef5ff;color:#4d7cff;">

                            <i class="fa-solid fa-user-group fa-lg"></i>

                        </div>

                        <div>

                            <small class="text-muted">
                                Total Accounts
                            </small>

                            <h3 class="fw-bold mb-0">

                                {{
                                    $users->count()
                                    +
                                    $admins->count()
                                }}

                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- ADMIN LIST --}}
        {{-- ================================================= --}}

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h5 class="fw-bold mb-1">
                            Administrators
                        </h5>

                        <p class="text-muted small mb-0">
                            Manage admin accounts and their page access
                        </p>

                    </div>

                </div>


                @if($admins->count() > 0)

                    <div class="table-responsive">

                        <table class="table align-middle mb-0">

                            <thead>

                                <tr>

                                    <th>
                                        Name
                                    </th>

                                    <th>
                                        Email
                                    </th>

                                    <th>
                                        Phone
                                    </th>

                                    <th>
                                        Role
                                    </th>

                                    <th>
                                        Permissions
                                    </th>

                                    <th>
                                        Action
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($admins as $admin)

                                    @php

                                        $adminPermissions = $admin->permissions;

                                        if (!is_array($adminPermissions)) {
                                            $adminPermissions = [];
                                        }

                                    @endphp


                                    <tr>

                                        {{-- NAME --}}
                                        <td>

                                            <div class="d-flex align-items-center">

                                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                                     style="
                                                        width:40px;
                                                        height:40px;
                                                        background:#f0f8e8;
                                                        color:#8cc63f;
                                                     ">

                                                    <i class="fa-solid fa-user-shield"></i>

                                                </div>

                                                <div>

                                                    <div class="fw-semibold">

                                                        {{ $admin->name }}

                                                    </div>

                                                    <small class="text-muted">

                                                        Admin Account

                                                    </small>

                                                </div>

                                            </div>

                                        </td>


                                        {{-- EMAIL --}}
                                        <td>

                                            {{ $admin->email }}

                                        </td>


                                        {{-- PHONE --}}
                                        <td>

                                            {{ $admin->phone ?? 'Not Added' }}

                                        </td>


                                        {{-- ROLE --}}
                                        <td>

                                            @if(($admin->role ?? 'admin') === 'superadmin')

                                                <span class="badge rounded-pill px-3 py-2"
                                                      style="
                                                        background:#fff0d9;
                                                        color:#c47d13;
                                                      ">

                                                    <i class="fa-solid fa-crown me-1"></i>

                                                    Super Admin

                                                </span>

                                            @else

                                                <span class="badge rounded-pill px-3 py-2"
                                                      style="
                                                        background:#f0f8e8;
                                                        color:#6da52d;
                                                      ">

                                                    Admin

                                                </span>

                                            @endif

                                        </td>


                                        {{-- PERMISSIONS --}}
                                        <td>

                                            @if(($admin->role ?? 'admin') === 'superadmin')

                                                <span class="badge rounded-pill px-3 py-2"
                                                      style="
                                                        background:#fff0d9;
                                                        color:#c47d13;
                                                      ">

                                                    All Pages

                                                </span>

                                            @else

                                                <span class="badge bg-light text-dark border rounded-pill px-3 py-2">

                                                    {{ count($adminPermissions) }}

                                                    Pages

                                                </span>

                                            @endif

                                        </td>


                                        {{-- ACTION --}}
                                        <td>

                                            @if(($admin->role ?? 'admin') !== 'superadmin')

                                                <button type="button"
                                                        class="btn btn-sm rounded-pill px-3 text-white"
                                                        style="background:#8cc63f;"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#permissionModal{{ $admin->id }}">

                                                    <i class="fa-solid fa-key me-1"></i>

                                                    Manage Access

                                                </button>

                                            @else

                                                <span class="text-muted small">

                                                    Full Access

                                                </span>

                                            @endif

                                        </td>

                                    </tr>


                                    {{-- ================================================= --}}
                                    {{-- PERMISSION MODAL --}}
                                    {{-- ================================================= --}}

                                    @if(($admin->role ?? 'admin') !== 'superadmin')

                                        <div class="modal fade"
                                             id="permissionModal{{ $admin->id }}"
                                             tabindex="-1"
                                             aria-hidden="true">

                                            <div class="modal-dialog modal-lg modal-dialog-centered">

                                                <div class="modal-content border-0 rounded-4 shadow">

                                                    <div class="modal-header border-0">

                                                        <div>

                                                            <h5 class="fw-bold mb-1">

                                                                Manage Access

                                                            </h5>

                                                            <small class="text-muted">

                                                                {{ $admin->name }}
                                                                —
                                                                {{ $admin->email }}

                                                            </small>

                                                        </div>

                                                        <button type="button"
                                                                class="btn-close"
                                                                data-bs-dismiss="modal">
                                                        </button>

                                                    </div>


                                                    <form method="POST"
                                                          action="{{ route('admin.user-management.permissions.update', $admin->id) }}">

                                                        @csrf

                                                        @method('PUT')


                                                        <div class="modal-body">

                                                            <p class="text-muted small mb-4">

                                                                Select the dashboard pages this administrator can access.

                                                            </p>


                                                            <div class="row g-3">


                                                                {{-- DASHBOARD --}}
                                                                <div class="col-md-6">

                                                                    <div class="border rounded-4 p-3">

                                                                        <div class="form-check">

                                                                            <input class="form-check-input"
                                                                                   type="checkbox"
                                                                                   name="permissions[]"
                                                                                   value="dashboard"
                                                                                   id="dashboard{{ $admin->id }}"
                                                                                   {{ in_array('dashboard', $adminPermissions) ? 'checked' : '' }}>

                                                                            <label class="form-check-label fw-semibold"
                                                                                   for="dashboard{{ $admin->id }}">

                                                                                <i class="fa-solid fa-house me-2"
                                                                                   style="color:#8cc63f;"></i>

                                                                                Dashboard

                                                                            </label>

                                                                        </div>

                                                                    </div>

                                                                </div>


                                                                {{-- PRODUCTS --}}
                                                                <div class="col-md-6">

                                                                    <div class="border rounded-4 p-3">

                                                                        <div class="form-check">

                                                                            <input class="form-check-input"
                                                                                   type="checkbox"
                                                                                   name="permissions[]"
                                                                                   value="products"
                                                                                   id="products{{ $admin->id }}"
                                                                                   {{ in_array('products', $adminPermissions) ? 'checked' : '' }}>

                                                                            <label class="form-check-label fw-semibold"
                                                                                   for="products{{ $admin->id }}">

                                                                                <i class="fa-solid fa-box me-2"
                                                                                   style="color:#8cc63f;"></i>

                                                                                Products

                                                                            </label>

                                                                        </div>

                                                                    </div>

                                                                </div>


                                                                {{-- CATEGORIES --}}
                                                                <div class="col-md-6">

                                                                    <div class="border rounded-4 p-3">

                                                                        <div class="form-check">

                                                                            <input class="form-check-input"
                                                                                   type="checkbox"
                                                                                   name="permissions[]"
                                                                                   value="categories"
                                                                                   id="categories{{ $admin->id }}"
                                                                                   {{ in_array('categories', $adminPermissions) ? 'checked' : '' }}>

                                                                            <label class="form-check-label fw-semibold"
                                                                                   for="categories{{ $admin->id }}">

                                                                                <i class="fa-solid fa-layer-group me-2"
                                                                                   style="color:#8cc63f;"></i>

                                                                                Categories

                                                                            </label>

                                                                        </div>

                                                                    </div>

                                                                </div>


                                                                {{-- STOCK --}}
                                                                <div class="col-md-6">

                                                                    <div class="border rounded-4 p-3">

                                                                        <div class="form-check">

                                                                            <input class="form-check-input"
                                                                                   type="checkbox"
                                                                                   name="permissions[]"
                                                                                   value="stock-management"
                                                                                   id="stock{{ $admin->id }}"
                                                                                   {{ in_array('stock-management', $adminPermissions) ? 'checked' : '' }}>

                                                                            <label class="form-check-label fw-semibold"
                                                                                   for="stock{{ $admin->id }}">

                                                                                <i class="fa-solid fa-boxes-stacked me-2"
                                                                                   style="color:#8cc63f;"></i>

                                                                                Stock Management

                                                                            </label>

                                                                        </div>

                                                                    </div>

                                                                </div>


                                                                {{-- ORDERS --}}
                                                                <div class="col-md-6">

                                                                    <div class="border rounded-4 p-3">

                                                                        <div class="form-check">

                                                                            <input class="form-check-input"
                                                                                   type="checkbox"
                                                                                   name="permissions[]"
                                                                                   value="view-orders"
                                                                                   id="orders{{ $admin->id }}"
                                                                                   {{ in_array('view-orders', $adminPermissions) ? 'checked' : '' }}>

                                                                            <label class="form-check-label fw-semibold"
                                                                                   for="orders{{ $admin->id }}">

                                                                                <i class="fa-solid fa-cart-shopping me-2"
                                                                                   style="color:#8cc63f;"></i>

                                                                                View Orders

                                                                            </label>

                                                                        </div>

                                                                    </div>

                                                                </div>


                                                                {{-- COUPONS --}}
                                                                <div class="col-md-6">

                                                                    <div class="border rounded-4 p-3">

                                                                        <div class="form-check">

                                                                            <input class="form-check-input"
                                                                                   type="checkbox"
                                                                                   name="permissions[]"
                                                                                   value="coupons"
                                                                                   id="coupons{{ $admin->id }}"
                                                                                   {{ in_array('coupons', $adminPermissions) ? 'checked' : '' }}>

                                                                            <label class="form-check-label fw-semibold"
                                                                                   for="coupons{{ $admin->id }}">

                                                                                <i class="fa-solid fa-ticket me-2"
                                                                                   style="color:#8cc63f;"></i>

                                                                                Coupons

                                                                            </label>

                                                                        </div>

                                                                    </div>

                                                                </div>


                                                                {{-- WEBSITE VISITORS --}}
                                                                <div class="col-md-6">

                                                                    <div class="border rounded-4 p-3">

                                                                        <div class="form-check">

                                                                            <input class="form-check-input"
                                                                                   type="checkbox"
                                                                                   name="permissions[]"
                                                                                   value="website-visitors"
                                                                                   id="visitors{{ $admin->id }}"
                                                                                   {{ in_array('website-visitors', $adminPermissions) ? 'checked' : '' }}>

                                                                            <label class="form-check-label fw-semibold"
                                                                                   for="visitors{{ $admin->id }}">

                                                                                <i class="fa-solid fa-users me-2"
                                                                                   style="color:#8cc63f;"></i>

                                                                                Website Visitors

                                                                            </label>

                                                                        </div>

                                                                    </div>

                                                                </div>


                                                                {{-- REPORTS --}}
                                                                <div class="col-md-6">

                                                                    <div class="border rounded-4 p-3">

                                                                        <div class="form-check">

                                                                            <input class="form-check-input"
                                                                                   type="checkbox"
                                                                                   name="permissions[]"
                                                                                   value="reports"
                                                                                   id="reports{{ $admin->id }}"
                                                                                   {{ in_array('reports', $adminPermissions) ? 'checked' : '' }}>

                                                                            <label class="form-check-label fw-semibold"
                                                                                   for="reports{{ $admin->id }}">

                                                                                <i class="fa-solid fa-chart-line me-2"
                                                                                   style="color:#8cc63f;"></i>

                                                                                Reports

                                                                            </label>

                                                                        </div>

                                                                    </div>

                                                                </div>


                                                                {{-- SETTINGS --}}
                                                                <div class="col-md-6">

                                                                    <div class="border rounded-4 p-3">

                                                                        <div class="form-check">

                                                                            <input class="form-check-input"
                                                                                   type="checkbox"
                                                                                   name="permissions[]"
                                                                                   value="settings"
                                                                                   id="settings{{ $admin->id }}"
                                                                                   {{ in_array('settings', $adminPermissions) ? 'checked' : '' }}>

                                                                            <label class="form-check-label fw-semibold"
                                                                                   for="settings{{ $admin->id }}">

                                                                                <i class="fa-solid fa-gear me-2"
                                                                                   style="color:#8cc63f;"></i>

                                                                                Settings

                                                                            </label>

                                                                        </div>

                                                                    </div>

                                                                </div>


                                                                {{-- USER MANAGEMENT --}}
                                                                <div class="col-md-6">

                                                                    <div class="border rounded-4 p-3">

                                                                        <div class="form-check">

                                                                            <input class="form-check-input"
                                                                                   type="checkbox"
                                                                                   name="permissions[]"
                                                                                   value="user-management"
                                                                                   id="users{{ $admin->id }}"
                                                                                   {{ in_array('user-management', $adminPermissions) ? 'checked' : '' }}>

                                                                            <label class="form-check-label fw-semibold"
                                                                                   for="users{{ $admin->id }}">

                                                                                <i class="fa-solid fa-user-shield me-2"
                                                                                   style="color:#8cc63f;"></i>

                                                                                User Management

                                                                            </label>

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>


                                                        <div class="modal-footer border-0">

                                                            <button type="button"
                                                                    class="btn btn-light rounded-pill px-4"
                                                                    data-bs-dismiss="modal">

                                                                Cancel

                                                            </button>

                                                            <button type="submit"
                                                                    class="btn text-white rounded-pill px-4"
                                                                    style="background:#8cc63f;">

                                                                <i class="fa-solid fa-save me-2"></i>

                                                                Save Permissions

                                                            </button>

                                                        </div>

                                                    </form>

                                                </div>

                                            </div>

                                        </div>

                                    @endif

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="text-center py-5">

                        <i class="fa-solid fa-user-shield fa-3x text-muted mb-3"></i>

                        <h5 class="fw-bold">
                            No Admin Accounts
                        </h5>

                        <p class="text-muted mb-0">
                            Create a new admin account using the button above.
                        </p>

                    </div>

                @endif

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- NORMAL USERS --}}
        {{-- ================================================= --}}

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-1">
                    Registered Users
                </h5>

                <p class="text-muted small mb-4">
                    Customers registered on your website
                </p>


                @if($users->count() > 0)

                    <div class="table-responsive">

                        <table class="table align-middle">

                            <thead>

                                <tr>

                                    <th>
                                        Name
                                    </th>

                                    <th>
                                        Email
                                    </th>

                                    <th>
                                        Phone
                                    </th>

                                    <th>
                                        Registered
                                    </th>

                                    <th>
                                        Role
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($users as $user)

                                    <tr>

                                        <td class="fw-semibold">
                                            {{ $user->name }}
                                        </td>

                                        <td>
                                            {{ $user->email }}
                                        </td>

                                        <td>
                                            {{ $user->phone ?? 'Not Added' }}
                                        </td>

                                        <td>

                                            {{
                                                $user->created_at
                                                ? $user->created_at->format('d-m-Y')
                                                : '-'
                                            }}

                                        </td>

                                        <td>

                                            <span class="badge bg-light text-dark border rounded-pill px-3 py-2">

                                                {{ ucfirst($user->role ?? 'user') }}

                                            </span>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="text-center py-4">

                        <i class="fa-solid fa-users fa-2x text-muted mb-2"></i>

                        <p class="text-muted mb-0">
                            No registered users found.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- ADD NEW ADMIN MODAL --}}
    {{-- ================================================= --}}

    <div class="modal fade"
         id="addAdminModal"
         tabindex="-1"
         aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content border-0 rounded-4 shadow">

                <div class="modal-header border-0">

                    <div>

                        <h5 class="fw-bold mb-1">
                            Add New Admin
                        </h5>

                        <small class="text-muted">
                            Create an administrator and assign page access
                        </small>

                    </div>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>


                <form method="POST"
                      action="{{ route('admin.user-management.admin.store') }}">

                    @csrf


                    <div class="modal-body">

                        <div class="row g-3">


                            {{-- NAME --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Full Name
                                </label>

                                <input type="text"
                                       name="name"
                                       class="form-control rounded-3"
                                       value="{{ old('name') }}"
                                       required>

                            </div>


                            {{-- EMAIL --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Email
                                </label>

                                <input type="email"
                                       name="email"
                                       class="form-control rounded-3"
                                       value="{{ old('email') }}"
                                       required>

                            </div>


                            {{-- PHONE --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Phone
                                </label>

                                <input type="text"
                                       name="phone"
                                       class="form-control rounded-3"
                                       value="{{ old('phone') }}">

                            </div>


                            {{-- PASSWORD --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Password
                                </label>

                                <input type="password"
                                       name="password"
                                       class="form-control rounded-3"
                                       required>

                            </div>


                            {{-- CONFIRM PASSWORD --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Confirm Password
                                </label>

                                <input type="password"
                                       name="password_confirmation"
                                       class="form-control rounded-3"
                                       required>

                            </div>


                            {{-- PAGE ACCESS --}}
                            <div class="col-12">

                                <label class="form-label fw-semibold">
                                    Page Access
                                </label>

                                <div class="row g-2">


                                    @php

                                        $availablePermissions = [

                                            'dashboard' =>
                                                'Dashboard',

                                            'products' =>
                                                'Products',

                                            'categories' =>
                                                'Categories',

                                            'stock-management' =>
                                                'Stock Management',

                                            'view-orders' =>
                                                'View Orders',

                                            'coupons' =>
                                                'Coupons',

                                            'website-visitors' =>
                                                'Website Visitors',

                                            'reports' =>
                                                'Reports',

                                            'settings' =>
                                                'Settings',

                                            'user-management' =>
                                                'User Management',

                                        ];

                                    @endphp


                                    @foreach($availablePermissions as $key => $label)

                                        <div class="col-md-6">

                                            <div class="form-check border rounded-3 p-3">

                                                <input class="form-check-input ms-0 me-2"
                                                       type="checkbox"
                                                       name="permissions[]"
                                                       value="{{ $key }}"
                                                       id="new{{ $key }}">

                                                <label class="form-check-label fw-semibold"
                                                       for="new{{ $key }}">

                                                    {{ $label }}

                                                </label>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="modal-footer border-0">

                        <button type="button"
                                class="btn btn-light rounded-pill px-4"
                                data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button type="submit"
                                class="btn text-white rounded-pill px-4"
                                style="background:#8cc63f;">

                            <i class="fa-solid fa-user-plus me-2"></i>

                            Create Admin

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
{{-- ================================================= --}}
{{-- SETTINGS --}}
{{-- ================================================= --}}

@elseif(request('page') == 'settings')

    <div class="container-fluid">

        {{-- PAGE HEADER --}}
        <div class="mb-4">

            <div class="d-flex align-items-center">

                <div class="d-flex align-items-center justify-content-center rounded-3 me-3"
                     style="
                        width:50px;
                        height:50px;
                        background:#f4f9e9;
                     ">

                    <i class="fa-solid fa-gear fs-4"
                       style="color:#8cc63f;"></i>

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


        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))

            <div class="alert alert-success border-0 shadow-sm rounded-4">

                <i class="fa-solid fa-circle-check me-2"></i>

                <strong>Success!</strong>

                {{ session('success') }}

            </div>

        @endif


        {{-- VALIDATION ERRORS --}}
        @if($errors->any())

            <div class="alert alert-danger border-0 shadow-sm rounded-4">

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

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-4 p-lg-5">

                        <div class="mb-4">

                            <span class="badge rounded-pill text-white px-3 py-2"
                                  style="
                                    background:#8cc63f;
                                    font-size:10px;
                                    letter-spacing:1px;
                                  ">

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


                        {{-- ================================================= --}}
                        {{-- UPI FORM --}}
                        {{-- ================================================= --}}

                        <form action="{{ route('admin.settings.update') }}"
                              method="POST">

                            @csrf


                            {{-- UPI ID --}}
                            <div class="mb-4">

                                <label class="form-label fw-semibold">
                                    UPI ID
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-white">

                                        <i class="fa-solid fa-at"
                                           style="color:#8cc63f;"></i>

                                    </span>

                                    <input type="text"
                                           name="upi_id"
                                           class="form-control form-control-lg"
                                           placeholder="example@upi"
                                           value="{{ old('upi_id', $setting->upi_id ?? '') }}"
                                           required>

                                </div>

                                <small class="text-muted">
                                    Example: classicglasses@upi
                                </small>

                            </div>


                            {{-- MERCHANT NAME --}}
                            <div class="mb-4">

                                <label class="form-label fw-semibold">
                                    Store / Merchant Name
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-white">

                                        <i class="fa-solid fa-store"
                                           style="color:#e9b36a;"></i>

                                    </span>

                                    <input type="text"
                                           name="merchant_name"
                                           class="form-control form-control-lg"
                                           placeholder="Classic Glasses Store"
                                           value="{{ old('merchant_name', $setting->merchant_name ?? '') }}"
                                           required>

                                </div>

                            </div>


                            {{-- INFO BOX --}}
                            <div class="rounded-4 p-3 mb-4"
                                 style="
                                    background:#fffaf3;
                                    border:1px solid #f0ddbf;
                                 ">

                                <div class="d-flex">

                                    <i class="fa-solid fa-circle-info me-3 mt-1"
                                       style="color:#e9b36a;"></i>

                                    <div>

                                        <strong>
                                            Automatic QR Payment
                                        </strong>

                                        <p class="small text-muted mb-0 mt-1">

                                            This UPI ID will automatically
                                            be used to create the QR code
                                            on the customer checkout page.

                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- SAVE BUTTON --}}
                            <button type="submit"
                                    class="btn w-100 rounded-pill py-3 fw-bold text-white"
                                    style="background:#8cc63f;">

                                <i class="fa-solid fa-save me-2"></i>

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

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body p-4">

                        <div class="text-center">

                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                                 style="
                                    width:70px;
                                    height:70px;
                                    background:#f4f9e9;
                                 ">

                                <i class="fa-solid fa-qrcode fs-2"
                                   style="color:#8cc63f;"></i>

                            </div>

                            <h5 class="fw-bold">
                                UPI QR Preview
                            </h5>

                            <p class="text-muted small">
                                QR will be generated automatically
                                during checkout.
                            </p>

                        </div>


                        <div class="rounded-4 p-4 mt-4"
                             style="
                                background:#fafafa;
                                border:1px solid #eeeeee;
                             ">

                            <div class="text-center">

                                <div class="d-flex align-items-center justify-content-center mx-auto rounded-3"
                                     style="
                                        width:180px;
                                        height:180px;
                                        background:white;
                                        border:2px dashed #dce9c2;
                                     ">

                                    <i class="fa-solid fa-qrcode"
                                       style="
                                        font-size:80px;
                                        color:#8cc63f;
                                       "></i>

                                </div>


                                <div class="mt-4">

                                    <p class="text-muted small mb-1">
                                        Current UPI ID
                                    </p>

                                    <h6 class="fw-bold">

                                        {{ $setting->upi_id ?? 'Not configured' }}

                                    </h6>

                                </div>


                                <div class="mt-3">

                                    <p class="text-muted small mb-1">
                                        Merchant
                                    </p>

                                    <h6 class="fw-bold">

                                        {{ $setting->merchant_name ?? 'Not configured' }}

                                    </h6>

                                </div>

                            </div>

                        </div>


                        <div class="d-flex align-items-center mt-4">

                            <i class="fa-solid fa-shield-halved me-2"
                               style="color:#8cc63f;"></i>

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
{{-- ================================================= --}}
{{-- VIEW ORDERS --}}
{{-- ================================================= --}}

@elseif(request('page') == 'view-orders')

    {{-- ================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ================================================= --}}

    <div class="mb-4">

        <span
            class="text-uppercase fw-bold px-3 py-1 rounded-pill text-white d-inline-block mb-2"
            style="background-color:#8cc63f;font-size:.7rem;"
        >
            ORDERS
        </span>

        <h2 class="fw-bold text-dark mb-1">
            View Orders
        </h2>

        <p class="text-muted mb-0">
            Manage customer orders and update order status.
        </p>

    </div>



    {{-- ================================================= --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ================================================= --}}

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm">

            <i class="fa-solid fa-circle-check me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif



    {{-- ================================================= --}}
    {{-- ERROR MESSAGE --}}
    {{-- ================================================= --}}

    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm">

            <i class="fa-solid fa-circle-exclamation me-2"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif



    {{-- ================================================= --}}
    {{-- ORDERS CARD --}}
    {{-- ================================================= --}}

    <div class="card border-0 rounded-4 shadow-sm bg-white">

        <div class="card-body p-4">

            <div class="table-responsive">

                <table class="table align-middle">

                    {{-- ================================================= --}}
                    {{-- TABLE HEADER --}}
                    {{-- ================================================= --}}

                    <thead>

                        <tr>

                            <th>
                                Order ID
                            </th>

                            <th>
                                Customer
                            </th>

                            <th>
                                Product
                            </th>

                            <th>
                                Qty
                            </th>

                            <th>
                                Total
                            </th>

                            <th>
                                Date
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Update
                            </th>

                            <th>
                                Bill
                            </th>

                        </tr>

                    </thead>



                    {{-- ================================================= --}}
                    {{-- TABLE BODY --}}
                    {{-- ================================================= --}}

                    <tbody>

                        @forelse($orders as $order)

                            @if($order->items->count() > 0)

                                @foreach($order->items as $index => $item)

                                    <tr>

                                        {{-- ================================================= --}}
                                        {{-- ORDER ID --}}
                                        {{-- ================================================= --}}

                                        <td>

                                            <strong>
                                                #{{ $order->id }}
                                            </strong>

                                        </td>



                                        {{-- ================================================= --}}
                                        {{-- CUSTOMER --}}
                                        {{-- ================================================= --}}

                                        <td>

                                            <div class="fw-semibold">

                                                {{ $order->name ?? ($order->user->name ?? 'Guest') }}

                                            </div>

                                            <small class="text-muted">

                                                {{ $order->email ?? ($order->user->email ?? '') }}

                                            </small>

                                        </td>



                                        {{-- ================================================= --}}
                                        {{-- PRODUCT --}}
                                        {{-- ================================================= --}}

                                        <td>

                                            {{ $item->product_name }}

                                        </td>



                                        {{-- ================================================= --}}
                                        {{-- QUANTITY --}}
                                        {{-- ================================================= --}}

                                        <td>

                                            {{ $item->quantity }}

                                        </td>



                                        {{-- ================================================= --}}
                                        {{-- TOTAL --}}
                                        {{-- ================================================= --}}

                                        <td>

                                            @if($index == 0)

                                                <strong class="text-success">

                                                    ₹{{ number_format($order->total_amount, 2) }}

                                                </strong>


                                                {{-- COUPON DISCOUNT --}}

                                                @php

                                                    $originalTotal =
                                                        $order->items->sum('total');

                                                    $finalTotal =
                                                        (float) $order->total_amount;

                                                    $couponDiscount =
                                                        $originalTotal - $finalTotal;

                                                @endphp


                                                @if($couponDiscount > 0)

                                                    <br>

                                                    <small class="text-success">

                                                        Coupon Discount:
                                                        -₹{{ number_format($couponDiscount, 2) }}

                                                    </small>

                                                @endif

                                            @else

                                                <span class="text-muted">
                                                    —
                                                </span>

                                            @endif

                                        </td>



                                        {{-- ================================================= --}}
                                        {{-- DATE --}}
                                        {{-- ================================================= --}}

                                        <td>

                                            {{ $order->created_at->format('d M Y') }}

                                        </td>



                                        {{-- ================================================= --}}
                                        {{-- STATUS --}}
                                        {{-- ================================================= --}}

                                        <td>

                                            <span
                                                class="badge rounded-pill px-3 py-2
                                                @if($order->status == 'Pending')
                                                    bg-warning text-dark
                                                @elseif($order->status == 'Processing')
                                                    bg-info text-dark
                                                @elseif($order->status == 'Shipped')
                                                    bg-primary
                                                @elseif($order->status == 'Delivered')
                                                    bg-success
                                                @elseif($order->status == 'Cancelled')
                                                    bg-danger
                                                @else
                                                    bg-secondary
                                                @endif"
                                            >

                                                {{ $order->status }}

                                            </span>

                                        </td>



                                        {{-- ================================================= --}}
                                        {{-- UPDATE STATUS --}}
                                        {{-- ================================================= --}}

                                        <td>

                                            <form
                                                action="{{ route('admin.orders.update', $order->id) }}"
                                                method="POST"
                                            >

                                                @csrf

                                                @method('PUT')

                                                <select
                                                    name="status"
                                                    class="form-select form-select-sm"
                                                    onchange="this.form.submit()"
                                                >

                                                    @foreach([
                                                        'Pending',
                                                        'Processing',
                                                        'Shipped',
                                                        'Delivered',
                                                        'Cancelled'
                                                    ] as $status)

                                                        <option
                                                            value="{{ $status }}"
                                                            {{ $order->status == $status ? 'selected' : '' }}
                                                        >

                                                            {{ $status }}

                                                        </option>

                                                    @endforeach

                                                </select>

                                            </form>

                                        </td>



                                        {{-- ================================================= --}}
                                        {{-- BILL --}}
                                        {{-- ================================================= --}}

                                        <td>

                                            @if($order->status == 'Delivered')

                                                <div class="d-flex flex-column gap-2">

                                                    {{-- VIEW BILL --}}

                                                    <a
                                                        href="{{ route('admin.orders.bill', $order->id) }}"
                                                        target="_blank"
                                                        class="btn btn-sm btn-outline-success rounded-pill px-3"
                                                    >

                                                        <i class="fa-solid fa-file-invoice me-1"></i>

                                                        View Bill

                                                    </a>


                                                    {{-- DOWNLOAD PDF --}}

                                                    <a
                                                        href="{{ route('admin.orders.bill.pdf', $order->id) }}"
                                                        class="btn btn-sm text-white rounded-pill px-3"
                                                        style="background-color:#8cc63f;"
                                                    >

                                                        <i class="fa-solid fa-file-pdf me-1"></i>

                                                        Download PDF

                                                    </a>

                                                </div>

                                            @else

                                                <span class="text-muted small">

                                                    Bill after Delivery

                                                </span>

                                            @endif

                                        </td>

                                    </tr>

                                @endforeach

                            @endif

                        @empty

                            {{-- ================================================= --}}
                            {{-- NO ORDERS --}}
                            {{-- ================================================= --}}

                            <tr>

                                <td
                                    colspan="9"
                                    class="text-center text-muted py-5"
                                >

                                    <i class="fa-solid fa-box-open fa-2x mb-3 d-block"></i>

                                    No orders found.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

{{-- =========================================================
     REPORTS
========================================================= --}}

@elseif(request('page') == 'reports')

@php

    /*
    |--------------------------------------------------------------------------
    | DATE FILTER VALUES
    |--------------------------------------------------------------------------
    */

    $dateFrom = request('date_from');
    $dateTo   = request('date_to');

    $hasDateFilter = $dateFrom || $dateTo;


    /*
    |--------------------------------------------------------------------------
    | REPORT SUMMARY
    |--------------------------------------------------------------------------
    */

    $reportTotalProducts = isset($products)
        ? $products->count()
        : 0;


    $reportTotalUsers = $totalUsers
        ?? (isset($users) ? $users->count() : 0);


    $reportTotalStock = isset($products)
        ? $products->sum(function ($product) {

            return (int) ($product->stock ?? 0);

        })
        : 0;


    $reportTotalOrders = isset($orders)
        ? $orders->count()
        : 0;


    $reportActiveOrders = $activeOrders ?? 0;


    /*
    |--------------------------------------------------------------------------
    | STOCK STATUS
    |--------------------------------------------------------------------------
    */

    $reportLowStock = isset($products)

        ? $products->filter(function ($product) {

            $stock = (int) ($product->stock ?? 0);

            return $stock > 0 && $stock <= 5;

        })->count()

        : 0;


    $reportOutOfStock = isset($products)

        ? $products->filter(function ($product) {

            return (int) ($product->stock ?? 0) === 0;

        })->count()

        : 0;


    $reportInStock = isset($products)

        ? $products->filter(function ($product) {

            return (int) ($product->stock ?? 0) > 5;

        })->count()

        : 0;


    /*
    |--------------------------------------------------------------------------
    | TOTAL SALES
    |--------------------------------------------------------------------------
    */

    $reportTotalSales = 0;


    if (isset($orders)) {

        foreach ($orders as $order) {

            if (
                strtolower($order->status ?? '') === 'cancelled'
            ) {
                continue;
            }


            if (
                isset($order->items)
                && $order->items
                && $order->items->count() > 0
            ) {

                foreach ($order->items as $item) {

                    $reportTotalSales += (float) (

                        $item->total

                        ??

                        (
                            ($item->price ?? 0)
                            *
                            ($item->quantity ?? 0)
                        )

                    );

                }

            } else {

                $reportTotalSales += (float) (

                    $order->total_amount
                    ??
                    $order->total
                    ??
                    0

                );

            }

        }

    }

@endphp


{{-- =========================================================
     REPORT HEADER
========================================================= --}}

<div class="mb-4">

    <span
        class="text-uppercase fw-bold px-3 py-1 rounded-pill text-white d-inline-block mb-2"
        style="background-color:#8cc63f;font-size:.7rem;"
    >
        REPORTS
    </span>


    <h2 class="fw-bold text-dark mb-1">

        Store Reports

    </h2>


    <p class="text-muted mb-0">

        View, filter and download complete store reports.

    </p>

</div>


{{-- =========================================================
     DATE FILTER
========================================================= --}}

<div class="card border-0 rounded-4 shadow-sm bg-white mb-4">

    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>

                <h5 class="fw-bold mb-1">

                    <i
                        class="fa-solid fa-calendar-days me-2"
                        style="color:#8cc63f;"
                    ></i>

                    Report Date Filter

                </h5>


                <small class="text-muted">

                    Filter all reports by registration, product and order date.

                </small>

            </div>


            {{-- CLEAR FILTER --}}

            @if($hasDateFilter)

                <a
                    href="{{ route('admin.dashboard', ['page' => 'reports']) }}"
                    class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                >

                    <i class="fa-solid fa-xmark me-1"></i>

                    Clear Filter

                </a>

            @endif

        </div>


        {{-- FILTER FORM --}}

        <form
            action="{{ route('admin.dashboard') }}"
            method="GET"
            class="row g-3 align-items-end"
        >

            <input
                type="hidden"
                name="page"
                value="reports"
            >


            {{-- FROM DATE --}}

            <div class="col-md-4">

                <label class="form-label fw-semibold">

                    From Date

                </label>


                <input
                    type="date"
                    name="date_from"
                    value="{{ $dateFrom }}"
                    class="form-control"
                >

            </div>


            {{-- TO DATE --}}

            <div class="col-md-4">

                <label class="form-label fw-semibold">

                    To Date

                </label>


                <input
                    type="date"
                    name="date_to"
                    value="{{ $dateTo }}"
                    class="form-control"
                >

            </div>


            {{-- APPLY --}}

            <div class="col-md-4">

                <button
                    type="submit"
                    class="btn text-white w-100 rounded-pill"
                    style="background-color:#8cc63f;"
                >

                    <i class="fa-solid fa-filter me-1"></i>

                    Apply Date Filter

                </button>

            </div>

        </form>


        {{-- ACTIVE FILTER MESSAGE --}}

        @if($hasDateFilter)

            <div class="alert alert-success mt-3 mb-0 rounded-4">

                <i class="fa-solid fa-circle-check me-2"></i>

                <strong>Filter Applied:</strong>

                @if($dateFrom && $dateTo)

                    {{ \Carbon\Carbon::parse($dateFrom)->format('d-m-Y') }}

                    to

                    {{ \Carbon\Carbon::parse($dateTo)->format('d-m-Y') }}

                @elseif($dateFrom)

                    From
                    {{ \Carbon\Carbon::parse($dateFrom)->format('d-m-Y') }}

                @elseif($dateTo)

                    Up to
                    {{ \Carbon\Carbon::parse($dateTo)->format('d-m-Y') }}

                @endif

                <span class="ms-2">

                    Only matching records are displayed.

                </span>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     REPORT SUMMARY CARDS
========================================================= --}}

<div class="row g-4 mb-4">


    {{-- =====================================================
         USER REPORT
    ====================================================== --}}

    <div class="col-md-6 col-xl-4">

        <div class="card border-0 rounded-4 shadow-sm bg-white h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <div
                            class="rounded-circle d-flex align-items-center justify-content-center mb-3"
                            style="
                                width:55px;
                                height:55px;
                                background:#f0f8e5;
                            "
                        >

                            <i
                                class="fa-solid fa-users fs-4"
                                style="color:#8cc63f;"
                            ></i>

                        </div>


                        <h5 class="fw-bold mb-1">

                            User Report

                        </h5>


                        <small class="text-muted">

                            Registered user information

                        </small>

                    </div>


                    <span
                        class="badge rounded-pill px-3 py-2"
                        style="background:#8cc63f;"
                    >

                        {{ $reportTotalUsers }}

                    </span>

                </div>


                <div class="d-flex gap-2 flex-wrap mt-4">


                    {{-- SHOW --}}

                    <button
                        type="button"
                        onclick="showReport('userReport')"
                        class="btn btn-sm btn-outline-dark rounded-pill px-3"
                    >

                        <i class="fa-solid fa-eye me-1"></i>

                        Show

                    </button>


                    {{-- EXCEL --}}

                    <a
                        href="{{ route('admin.reports.excel', [
                            'report_type' => 'users',
                            'date_from' => $dateFrom,
                            'date_to' => $dateTo
                        ]) }}"
                        class="btn btn-sm text-white rounded-pill px-3"
                        style="background:#198754;"
                    >

                        <i class="fa-solid fa-file-excel me-1"></i>

                        Excel

                    </a>


                    {{-- PDF --}}

                    <a
                        href="{{ route('admin.reports.pdf', [
                            'report_type' => 'users',
                            'date_from' => $dateFrom,
                            'date_to' => $dateTo
                        ]) }}"
                        class="btn btn-sm text-white rounded-pill px-3"
                        style="background:#dc3545;"
                    >

                        <i class="fa-solid fa-file-pdf me-1"></i>

                        PDF

                    </a>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         PRODUCT REPORT
    ====================================================== --}}

    <div class="col-md-6 col-xl-4">

        <div class="card border-0 rounded-4 shadow-sm bg-white h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <div
                            class="rounded-circle d-flex align-items-center justify-content-center mb-3"
                            style="
                                width:55px;
                                height:55px;
                                background:#f0f8e5;
                            "
                        >

                            <i
                                class="fa-solid fa-box-open fs-4"
                                style="color:#8cc63f;"
                            ></i>

                        </div>


                        <h5 class="fw-bold mb-1">

                            Product Report

                        </h5>


                        <small class="text-muted">

                            Complete product catalog

                        </small>

                    </div>


                    <span
                        class="badge rounded-pill px-3 py-2"
                        style="background:#8cc63f;"
                    >

                        {{ $reportTotalProducts }}

                    </span>

                </div>


                <div class="d-flex gap-2 flex-wrap mt-4">

                    <button
                        type="button"
                        onclick="showReport('productReport')"
                        class="btn btn-sm btn-outline-dark rounded-pill px-3"
                    >

                        <i class="fa-solid fa-eye me-1"></i>

                        Show

                    </button>


                    <a
                        href="{{ route('admin.reports.excel', [
                            'report_type' => 'products',
                            'date_from' => $dateFrom,
                            'date_to' => $dateTo
                        ]) }}"
                        class="btn btn-sm text-white rounded-pill px-3"
                        style="background:#198754;"
                    >

                        <i class="fa-solid fa-file-excel me-1"></i>

                        Excel

                    </a>


                    <a
                        href="{{ route('admin.reports.pdf', [
                            'report_type' => 'products',
                            'date_from' => $dateFrom,
                            'date_to' => $dateTo
                        ]) }}"
                        class="btn btn-sm text-white rounded-pill px-3"
                        style="background:#dc3545;"
                    >

                        <i class="fa-solid fa-file-pdf me-1"></i>

                        PDF

                    </a>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         STOCK REPORT
    ====================================================== --}}

    <div class="col-md-6 col-xl-4">

        <div class="card border-0 rounded-4 shadow-sm bg-white h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <div
                            class="rounded-circle d-flex align-items-center justify-content-center mb-3"
                            style="
                                width:55px;
                                height:55px;
                                background:#f0f8e5;
                            "
                        >

                            <i
                                class="fa-solid fa-boxes-stacked fs-4"
                                style="color:#8cc63f;"
                            ></i>

                        </div>


                        <h5 class="fw-bold mb-1">

                            Stock Report

                        </h5>


                        <small class="text-muted">

                            Inventory and stock status

                        </small>

                    </div>


                    <span
                        class="badge rounded-pill px-3 py-2"
                        style="background:#8cc63f;"
                    >

                        {{ $reportTotalStock }}

                    </span>

                </div>


                <div class="d-flex gap-2 flex-wrap mt-4">

                    <button
                        type="button"
                        onclick="showReport('stockReport')"
                        class="btn btn-sm btn-outline-dark rounded-pill px-3"
                    >

                        <i class="fa-solid fa-eye me-1"></i>

                        Show

                    </button>


                    <a
                        href="{{ route('admin.reports.excel', [
                            'report_type' => 'stock',
                            'date_from' => $dateFrom,
                            'date_to' => $dateTo
                        ]) }}"
                        class="btn btn-sm text-white rounded-pill px-3"
                        style="background:#198754;"
                    >

                        <i class="fa-solid fa-file-excel me-1"></i>

                        Excel

                    </a>


                    <a
                        href="{{ route('admin.reports.pdf', [
                            'report_type' => 'stock',
                            'date_from' => $dateFrom,
                            'date_to' => $dateTo
                        ]) }}"
                        class="btn btn-sm text-white rounded-pill px-3"
                        style="background:#dc3545;"
                    >

                        <i class="fa-solid fa-file-pdf me-1"></i>

                        PDF

                    </a>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         ORDER REPORT
    ====================================================== --}}

    <div class="col-md-6 col-xl-4">

        <div class="card border-0 rounded-4 shadow-sm bg-white h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <div
                            class="rounded-circle d-flex align-items-center justify-content-center mb-3"
                            style="
                                width:55px;
                                height:55px;
                                background:#f0f8e5;
                            "
                        >

                            <i
                                class="fa-solid fa-cart-shopping fs-4"
                                style="color:#8cc63f;"
                            ></i>

                        </div>


                        <h5 class="fw-bold mb-1">

                            Order Report

                        </h5>


                        <small class="text-muted">

                            Complete customer order details

                        </small>

                    </div>


                    <span
                        class="badge rounded-pill px-3 py-2"
                        style="background:#8cc63f;"
                    >

                        {{ $reportTotalOrders }}

                    </span>

                </div>


                <div class="d-flex gap-2 flex-wrap mt-4">

                    <button
                        type="button"
                        onclick="showReport('orderReport')"
                        class="btn btn-sm btn-outline-dark rounded-pill px-3"
                    >

                        <i class="fa-solid fa-eye me-1"></i>

                        Show

                    </button>


                    <a
                        href="{{ route('admin.reports.excel', [
                            'report_type' => 'orders',
                            'date_from' => $dateFrom,
                            'date_to' => $dateTo
                        ]) }}"
                        class="btn btn-sm text-white rounded-pill px-3"
                        style="background:#198754;"
                    >

                        <i class="fa-solid fa-file-excel me-1"></i>

                        Excel

                    </a>


                    <a
                        href="{{ route('admin.reports.pdf', [
                            'report_type' => 'orders',
                            'date_from' => $dateFrom,
                            'date_to' => $dateTo
                        ]) }}"
                        class="btn btn-sm text-white rounded-pill px-3"
                        style="background:#dc3545;"
                    >

                        <i class="fa-solid fa-file-pdf me-1"></i>

                        PDF

                    </a>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         BILL REPORT
    ====================================================== --}}

    <div class="col-md-6 col-xl-4">

        <div class="card border-0 rounded-4 shadow-sm bg-white h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <div
                            class="rounded-circle d-flex align-items-center justify-content-center mb-3"
                            style="
                                width:55px;
                                height:55px;
                                background:#f0f8e5;
                            "
                        >

                            <i
                                class="fa-solid fa-file-invoice fs-4"
                                style="color:#8cc63f;"
                            ></i>

                        </div>


                        <h5 class="fw-bold mb-1">

                            Bill Report

                        </h5>


                        <small class="text-muted">

                            Customer billing information

                        </small>

                    </div>


                    <span
                        class="badge rounded-pill px-3 py-2"
                        style="background:#8cc63f;"
                    >

                        {{ $reportTotalOrders }}

                    </span>

                </div>


                <div class="d-flex gap-2 flex-wrap mt-4">

                    <button
                        type="button"
                        onclick="showReport('billReport')"
                        class="btn btn-sm btn-outline-dark rounded-pill px-3"
                    >

                        <i class="fa-solid fa-eye me-1"></i>

                        Show

                    </button>


                    <a
                        href="{{ route('admin.reports.excel', [
                            'report_type' => 'bills',
                            'date_from' => $dateFrom,
                            'date_to' => $dateTo
                        ]) }}"
                        class="btn btn-sm text-white rounded-pill px-3"
                        style="background:#198754;"
                    >

                        <i class="fa-solid fa-file-excel me-1"></i>

                        Excel

                    </a>


                    <a
                        href="{{ route('admin.reports.pdf', [
                            'report_type' => 'bills',
                            'date_from' => $dateFrom,
                            'date_to' => $dateTo
                        ]) }}"
                        class="btn btn-sm text-white rounded-pill px-3"
                        style="background:#dc3545;"
                    >

                        <i class="fa-solid fa-file-pdf me-1"></i>

                        PDF

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     REPORT DISPLAY AREA
========================================================= --}}

<div id="reportArea">


    {{-- WELCOME --}}

    <div
        id="reportWelcome"
        class="card border-0 rounded-4 shadow-sm bg-white"
    >

        <div class="card-body text-center py-5">

            <i
                class="fa-solid fa-chart-column fa-3x mb-3"
                style="color:#8cc63f;"
            ></i>


            <h4 class="fw-bold">

                Select a Report

            </h4>


            <p class="text-muted mb-0">

                Click Show on any report to view detailed information.

            </p>

        </div>

    </div>


    {{-- =====================================================
         USER REPORT
    ====================================================== --}}

    <div
        id="userReport"
        class="report-section"
        style="display:none;"
    >

        <div class="card border-0 rounded-4 shadow-sm bg-white">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h5 class="fw-bold mb-1">

                            <i
                                class="fa-solid fa-users me-2"
                                style="color:#8cc63f;"
                            ></i>

                            User Report

                        </h5>


                        <small class="text-muted">

                            Registered users matching selected date range.

                        </small>

                    </div>


                    <span
                        class="badge rounded-pill px-3 py-2"
                        style="background:#8cc63f;"
                    >

                        {{ $reportTotalUsers }} Users

                    </span>

                </div>


                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th>#</th>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registered Date</th>
                                <th>Registered Time</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($users ?? [] as $user)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>


                                    <td>
                                        #{{ $user->id }}
                                    </td>


                                    <td>

                                        <strong>
                                            {{ $user->name }}
                                        </strong>

                                    </td>


                                    <td>
                                        {{ $user->email }}
                                    </td>


                                    <td>

                                        {{ $user->created_at
                                            ? \Carbon\Carbon::parse($user->created_at)->format('d-m-Y')
                                            : '-'
                                        }}

                                    </td>


                                    <td>

                                        {{ $user->created_at
                                            ? \Carbon\Carbon::parse($user->created_at)->format('h:i A')
                                            : '-'
                                        }}

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="text-center py-4 text-muted"
                                    >

                                        No users found for selected date range.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         PRODUCT REPORT
    ====================================================== --}}

    <div
        id="productReport"
        class="report-section"
        style="display:none;"
    >

        <div class="card border-0 rounded-4 shadow-sm bg-white">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h5 class="fw-bold mb-1">

                            <i
                                class="fa-solid fa-box-open me-2"
                                style="color:#8cc63f;"
                            ></i>

                            Product Report

                        </h5>


                        <small class="text-muted">

                            Products matching selected date range.

                        </small>

                    </div>


                    <span
                        class="badge rounded-pill px-3 py-2"
                        style="background:#8cc63f;"
                    >

                        {{ $reportTotalProducts }} Products

                    </span>

                </div>


                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th>#</th>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Created Date</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($products ?? [] as $product)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>


                                    <td>
                                        #{{ $product->id }}
                                    </td>


                                    <td>

                                        <strong>
                                            {{ $product->name }}
                                        </strong>

                                    </td>


                                    <td>
                                        {{ $product->category ?? '-' }}
                                    </td>


                                    <td>

                                        <strong style="color:#8cc63f;">

                                            ₹{{ number_format(
                                                (float) ($product->price ?? 0),
                                                2
                                            ) }}

                                        </strong>

                                    </td>


                                    <td>
                                        {{ (int) ($product->stock ?? 0) }}
                                    </td>


                                    <td>

                                        {{ $product->created_at
                                            ? \Carbon\Carbon::parse($product->created_at)->format('d-m-Y')
                                            : '-'
                                        }}

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        class="text-center py-4 text-muted"
                                    >

                                        No products found for selected date range.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         STOCK REPORT
    ====================================================== --}}

    <div
        id="stockReport"
        class="report-section"
        style="display:none;"
    >

        <div class="card border-0 rounded-4 shadow-sm bg-white">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h5 class="fw-bold mb-1">

                            <i
                                class="fa-solid fa-boxes-stacked me-2"
                                style="color:#8cc63f;"
                            ></i>

                            Stock Report

                        </h5>


                        <small class="text-muted">

                            Stock of products matching selected date range.

                        </small>

                    </div>


                    <span
                        class="badge rounded-pill px-3 py-2"
                        style="background:#8cc63f;"
                    >

                        {{ $reportTotalStock }} Units

                    </span>

                </div>


                {{-- STOCK SUMMARY --}}

                <div class="row g-3 mb-4">

                    <div class="col-md-4">

                        <div class="border rounded-4 p-3">

                            <small class="text-muted">
                                In Stock
                            </small>

                            <h4 class="fw-bold text-success mb-0">
                                {{ $reportInStock }}
                            </h4>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="border rounded-4 p-3">

                            <small class="text-muted">
                                Low Stock
                            </small>

                            <h4 class="fw-bold text-warning mb-0">
                                {{ $reportLowStock }}
                            </h4>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="border rounded-4 p-3">

                            <small class="text-muted">
                                Out of Stock
                            </small>

                            <h4 class="fw-bold text-danger mb-0">
                                {{ $reportOutOfStock }}
                            </h4>

                        </div>

                    </div>

                </div>


                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th>#</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Created Date</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($products ?? [] as $product)

                                @php

                                    $stock = (int) ($product->stock ?? 0);

                                @endphp


                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>


                                    <td>

                                        <strong>
                                            {{ $product->name }}
                                        </strong>

                                    </td>


                                    <td>
                                        {{ $product->category ?? '-' }}
                                    </td>


                                    <td>

                                        ₹{{ number_format(
                                            (float) ($product->price ?? 0),
                                            2
                                        ) }}

                                    </td>


                                    <td>
                                        {{ $stock }}
                                    </td>


                                    <td>

                                        @if($stock === 0)

                                            <span class="badge bg-danger rounded-pill px-3 py-2">
                                                Out of Stock
                                            </span>

                                        @elseif($stock <= 5)

                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                                Low Stock
                                            </span>

                                        @else

                                            <span class="badge bg-success rounded-pill px-3 py-2">
                                                In Stock
                                            </span>

                                        @endif

                                    </td>


                                    <td>

                                        {{ $product->created_at
                                            ? \Carbon\Carbon::parse($product->created_at)->format('d-m-Y')
                                            : '-'
                                        }}

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        class="text-center py-4 text-muted"
                                    >

                                        No stock data found for selected date range.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         ORDER REPORT
    ====================================================== --}}

    <div
        id="orderReport"
        class="report-section"
        style="display:none;"
    >

        <div class="card border-0 rounded-4 shadow-sm bg-white">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h5 class="fw-bold mb-1">

                            <i
                                class="fa-solid fa-cart-shopping me-2"
                                style="color:#8cc63f;"
                            ></i>

                            Order Report

                        </h5>


                        <small class="text-muted">

                            Orders matching selected date range.

                        </small>

                    </div>


                    <span
                        class="badge rounded-pill px-3 py-2"
                        style="background:#8cc63f;"
                    >

                        {{ $reportTotalOrders }} Orders

                    </span>

                </div>


                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th>#</th>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th>Status</th>

                            </tr>

                        </thead>


                        <tbody>

                            @php
                                $orderRow = 0;
                            @endphp


                            @forelse($orders ?? [] as $order)

                                @if(isset($order->items) && $order->items->count() > 0)

                                    @foreach($order->items as $item)

                                        @php
                                            $orderRow++;
                                        @endphp


                                        <tr>

                                            <td>
                                                {{ $orderRow }}
                                            </td>


                                            <td>
                                                #{{ $order->id }}
                                            </td>


                                            <td>

                                                <strong>

                                                    {{ $order->name
                                                        ?? ($order->user->name ?? 'Guest')
                                                    }}

                                                </strong>

                                                <br>

                                                <small class="text-muted">

                                                    {{ $order->email
                                                        ?? ($order->user->email ?? '')
                                                    }}

                                                </small>

                                            </td>


                                            <td>

                                                {{ $item->product_name
                                                    ?? ($item->product->name ?? 'Product')
                                                }}

                                            </td>


                                            <td>
                                                {{ $item->quantity ?? 0 }}
                                            </td>


                                            <td>

                                                <strong>

                                                    ₹{{ number_format(
                                                        (float) (
                                                            $item->total
                                                            ??
                                                            (
                                                                ($item->price ?? 0)
                                                                *
                                                                ($item->quantity ?? 0)
                                                            )
                                                        ),
                                                        2
                                                    ) }}

                                                </strong>

                                            </td>


                                            <td>

                                                {{ $order->created_at
                                                    ? $order->created_at->format('d-m-Y')
                                                    : '-'
                                                }}

                                            </td>


                                            <td>

                                                @if($order->status === 'Pending')

                                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                                        Pending
                                                    </span>

                                                @elseif($order->status === 'Processing')

                                                    <span class="badge bg-info text-dark rounded-pill px-3 py-2">
                                                        Processing
                                                    </span>

                                                @elseif($order->status === 'Shipped')

                                                    <span class="badge bg-primary rounded-pill px-3 py-2">
                                                        Shipped
                                                    </span>

                                                @elseif($order->status === 'Delivered')

                                                    <span class="badge bg-success rounded-pill px-3 py-2">
                                                        Delivered
                                                    </span>

                                                @elseif($order->status === 'Cancelled')

                                                    <span class="badge bg-danger rounded-pill px-3 py-2">
                                                        Cancelled
                                                    </span>

                                                @else

                                                    <span class="badge bg-secondary rounded-pill px-3 py-2">
                                                        {{ $order->status ?? 'Unknown' }}
                                                    </span>

                                                @endif

                                            </td>

                                        </tr>

                                    @endforeach

                                @else

                                    @php
                                        $orderRow++;
                                    @endphp


                                    <tr>

                                        <td>
                                            {{ $orderRow }}
                                        </td>


                                        <td>
                                            #{{ $order->id }}
                                        </td>


                                        <td>

                                            <strong>

                                                {{ $order->name
                                                    ?? ($order->user->name ?? 'Guest')
                                                }}

                                            </strong>

                                        </td>


                                        <td>
                                            -
                                        </td>


                                        <td>
                                            -
                                        </td>


                                        <td>

                                            ₹{{ number_format(
                                                (float) (
                                                    $order->total_amount
                                                    ??
                                                    $order->total
                                                    ??
                                                    0
                                                ),
                                                2
                                            ) }}

                                        </td>


                                        <td>

                                            {{ $order->created_at
                                                ? $order->created_at->format('d-m-Y')
                                                : '-'
                                            }}

                                        </td>


                                        <td>

                                            {{ $order->status ?? 'Unknown' }}

                                        </td>

                                    </tr>

                                @endif

                            @empty

                                <tr>

                                    <td
                                        colspan="8"
                                        class="text-center py-4 text-muted"
                                    >

                                        No orders found for selected date range.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         BILL REPORT
    ====================================================== --}}

    <div
        id="billReport"
        class="report-section"
        style="display:none;"
    >

        <div class="card border-0 rounded-4 shadow-sm bg-white">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h5 class="fw-bold mb-1">

                            <i
                                class="fa-solid fa-file-invoice me-2"
                                style="color:#8cc63f;"
                            ></i>

                            Bill Report

                        </h5>


                        <small class="text-muted">

                            Bills matching selected date range.

                        </small>

                    </div>


                    <span
                        class="badge rounded-pill px-3 py-2"
                        style="background:#8cc63f;"
                    >

                        {{ $reportTotalOrders }} Bills

                    </span>

                </div>


                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th>#</th>
                                <th>Bill / Order ID</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>Date</th>
                                <th>Status</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($orders ?? [] as $order)

                                @php

                                    $billAmount = (float) (

                                        $order->total_amount
                                        ??
                                        $order->total
                                        ??
                                        0

                                    );

                                @endphp


                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>


                                    <td>

                                        <strong>
                                            #{{ $order->id }}
                                        </strong>

                                    </td>


                                    <td>

                                        {{ $order->name
                                            ?? ($order->user->name ?? 'Guest')
                                        }}

                                    </td>


                                    <td>

                                        {{ $order->email
                                            ?? ($order->user->email ?? '-')
                                        }}

                                    </td>


                                    <td>

                                        {{ $order->mobile
                                            ?? $order->phone
                                            ?? '-'
                                        }}

                                    </td>


                                    <td>

                                        <strong style="color:#8cc63f;">

                                            ₹{{ number_format(
                                                $billAmount,
                                                2
                                            ) }}

                                        </strong>

                                    </td>


                                    <td>

                                        {{ $order->payment_method
                                            ?? $order->payment
                                            ?? 'N/A'
                                        }}

                                    </td>


                                    <td>

                                        {{ $order->created_at
                                            ? $order->created_at->format('d-m-Y')
                                            : '-'
                                        }}

                                    </td>


                                    <td>

                                        @if($order->status === 'Cancelled')

                                            <span class="badge bg-danger rounded-pill px-3 py-2">
                                                Cancelled
                                            </span>

                                        @elseif($order->status === 'Delivered')

                                            <span class="badge bg-success rounded-pill px-3 py-2">
                                                Delivered
                                            </span>

                                        @elseif($order->status === 'Pending')

                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                                Pending
                                            </span>

                                        @else

                                            <span class="badge bg-secondary rounded-pill px-3 py-2">

                                                {{ $order->status ?? 'Unknown' }}

                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="9"
                                        class="text-center py-4 text-muted"
                                    >

                                        No bills found for selected date range.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     REPORT JAVASCRIPT
========================================================= --}}

<script>

    function showReport(reportId)
    {

        /*
        |--------------------------------------------------------------------------
        | Hide all report sections
        |--------------------------------------------------------------------------
        */

        const reports =
            document.querySelectorAll('.report-section');


        reports.forEach(function(report)
        {

            report.style.display = 'none';

        });


        /*
        |--------------------------------------------------------------------------
        | Hide welcome
        |--------------------------------------------------------------------------
        */

        const welcome =
            document.getElementById('reportWelcome');


        if (welcome)
        {

            welcome.style.display = 'none';

        }


        /*
        |--------------------------------------------------------------------------
        | Show selected report
        |--------------------------------------------------------------------------
        */

        const selectedReport =
            document.getElementById(reportId);


        if (selectedReport)
        {

            selectedReport.style.display = 'block';


            setTimeout(function()
            {

                selectedReport.scrollIntoView({

                    behavior: 'smooth',

                    block: 'start'

                });

            }, 100);

        }

    }

</script>
{{-- ========================================================= --}}
{{-- CUSTOMER ENQUIRIES - USER WISE CONVERSATION UI --}}
{{-- ========================================================= --}}

@elseif(request('page') == 'enquiries')

<style>

    /* =========================================================
       ENQUIRY PAGE
    ========================================================= */

    .enquiry-page {
        background: #f8faf5;
        min-height: calc(100vh - 80px);
    }

    /* HEADER */

    .enquiry-header {
        background: linear-gradient(
            135deg,
            #ffffff,
            #f5f9ec
        );
        border: 1px solid #e7eddc;
        border-radius: 22px;
        padding: 24px;
        box-shadow: 0 8px 25px rgba(0,0,0,.05);
    }

    .enquiry-title-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: #eef7e5;
        color: #8cc63f;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
    }

    /* SEARCH */

    .enquiry-search {
        position: relative;
    }

    .enquiry-search i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #8cc63f;
        z-index: 2;
    }

    .enquiry-search input {
        padding-left: 45px;
        height: 46px;
        border: 1px solid #e5eadc;
        border-radius: 14px;
        background: #ffffff;
        box-shadow: none;
    }

    .enquiry-search input:focus {
        border-color: #8cc63f;
        box-shadow: 0 0 0 3px rgba(140,198,63,.10);
    }


    /* =========================================================
       SUMMARY CARDS
    ========================================================= */

    .summary-card {
        background: #ffffff;
        border: 1px solid #edf0e8;
        border-radius: 18px;
        padding: 18px;
        height: 100%;
        transition: .2s ease;
    }

    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,.06);
    }

    .summary-icon {
        width: 44px;
        height: 44px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
    }


    /* =========================================================
       CUSTOMER CARD
    ========================================================= */

    .customer-card {
        background: #ffffff;
        border: 1px solid #e8ece2;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 18px rgba(0,0,0,.045);
        transition: .25s ease;
    }

    .customer-card:hover {
        box-shadow: 0 10px 28px rgba(0,0,0,.08);
    }

    .customer-card.unread-customer {
        border-left: 5px solid #8cc63f;
    }

    .customer-header {
        padding: 20px;
        cursor: pointer;
        background: #ffffff;
    }

    .customer-header:hover {
        background: #fbfdf8;
    }


    /* AVATAR */

    .customer-avatar {
        width: 50px;
        height: 50px;
        min-width: 50px;
        border-radius: 16px;
        background: linear-gradient(
            135deg,
            #8cc63f,
            #a9d85c
        );
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 19px;
        box-shadow: 0 5px 12px rgba(140,198,63,.20);
    }


    /* CUSTOMER INFO */

    .customer-name {
        font-size: 16px;
        font-weight: 700;
        color: #222;
    }

    .customer-email {
        font-size: 12px;
        color: #8a8f84;
    }


    /* COUNT */

    .message-count {
        background: #f1f7e9;
        color: #6d982f;
        border: 1px solid #dfebca;
        padding: 6px 11px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }


    /* =========================================================
       CONVERSATION AREA
    ========================================================= */

    .conversation-area {
        background: #f8faf6;
        border-top: 1px solid #edf0e9;
        padding: 20px;
    }

    .conversation-item {
        background: #ffffff;
        border: 1px solid #e8ece3;
        border-radius: 17px;
        margin-bottom: 14px;
        overflow: hidden;
    }

    .conversation-item:last-child {
        margin-bottom: 0;
    }


    /* ENQUIRY TOP */

    .conversation-top {
        padding: 16px 18px;
        cursor: pointer;
    }

    .conversation-top:hover {
        background: #fcfdfb;
    }

    .subject-text {
        font-size: 14px;
        font-weight: 700;
        color: #252525;
    }

    .date-text {
        font-size: 11px;
        color: #999;
    }


    /* STATUS */

    .status-pending {
        background: #fff4d6;
        color: #996d00;
        border: 1px solid #f4dfa4;
    }

    .status-replied {
        background: #edf8e5;
        color: #5d8c29;
        border: 1px solid #d9e9c5;
    }

    .status-closed {
        background: #eeeeee;
        color: #666;
    }

    .status-badge {
        border-radius: 50px;
        padding: 5px 10px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }


    /* =========================================================
       MESSAGE AREA
    ========================================================= */

    .message-box {
        padding: 17px;
        background: #ffffff;
        border-top: 1px solid #f0f1ed;
    }

    .customer-message {
        background: #f5f7f2;
        border-radius: 14px;
        padding: 14px 16px;
        border-left: 4px solid #8cc63f;
    }

    .admin-message {
        background: #eef7e7;
        border-radius: 14px;
        padding: 14px 16px;
        border-left: 4px solid #8cc63f;
        margin-top: 12px;
    }

    .message-label {
        font-size: 11px;
        font-weight: 700;
        color: #555;
        margin-bottom: 5px;
    }

    .message-text {
        font-size: 13px;
        color: #555;
        line-height: 1.6;
        white-space: pre-line;
        margin: 0;
    }


    /* =========================================================
       REPLY BOX
    ========================================================= */

    .reply-box {
        background: #ffffff;
        border-top: 1px solid #edf0e8;
        padding: 17px;
    }

    .reply-box textarea {
        resize: vertical;
        min-height: 85px;
        border-radius: 13px;
        border: 1px solid #e2e7dc;
        background: #fafcf8;
        font-size: 13px;
    }

    .reply-box textarea:focus {
        border-color: #8cc63f;
        box-shadow: 0 0 0 3px rgba(140,198,63,.10);
        background: #ffffff;
    }

    .reply-button {
        background: #8cc63f;
        border: none;
        color: #ffffff;
        border-radius: 50px;
        padding: 9px 18px;
        font-size: 12px;
        font-weight: 700;
    }

    .reply-button:hover {
        background: #78ae31;
        color: #ffffff;
    }


    /* =========================================================
       EMPTY
    ========================================================= */

    .empty-enquiry {
        background: #ffffff;
        border: 1px solid #e8ece2;
        border-radius: 22px;
        padding: 60px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 75px;
        height: 75px;
        border-radius: 50%;
        background: #f1f8e8;
        color: #8cc63f;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
        font-size: 30px;
    }


    /* =========================================================
       MOBILE
    ========================================================= */

    @media(max-width:768px) {

        .enquiry-header {
            padding: 17px;
        }

        .customer-header {
            padding: 15px;
        }

        .conversation-area {
            padding: 12px;
        }

        .conversation-top {
            padding: 14px;
        }

        .reply-box,
        .message-box {
            padding: 14px;
        }

        .customer-avatar {
            width: 44px;
            height: 44px;
            min-width: 44px;
            font-size: 16px;
        }

        .customer-name {
            font-size: 14px;
        }

        .message-count {
            font-size: 9px;
        }
    }

</style>


<div class="container-fluid py-4 enquiry-page">


    {{-- ===================================================== --}}
    {{-- PAGE HEADER --}}
    {{-- ===================================================== --}}

    <div class="enquiry-header mb-4">

        <div class="row align-items-center g-3">

            <div class="col-lg-7">

                <div class="d-flex align-items-center">

                    <div class="enquiry-title-icon me-3">

                        <i class="fa-solid fa-comments"></i>

                    </div>

                    <div>

                        <h3 class="fw-bold mb-1 text-dark">

                            Customer Messages

                        </h3>

                        <p class="text-muted small mb-0">

                            View and reply to customers in one place.

                        </p>

                    </div>

                </div>

            </div>


            <div class="col-lg-5">

                <div class="enquiry-search">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input
                        type="text"
                        id="customerSearch"
                        class="form-control"
                        placeholder="Search customer, email or subject..."
                        onkeyup="searchCustomers()"
                    >

                </div>

            </div>

        </div>

    </div>



    {{-- ===================================================== --}}
    {{-- SUCCESS --}}
    {{-- ===================================================== --}}

    @if(session('success'))

        <div class="alert alert-success border-0 rounded-4 shadow-sm">

            <i class="fa-solid fa-circle-check me-2"></i>

            {{ session('success') }}

        </div>

    @endif



    {{-- ===================================================== --}}
    {{-- ERROR --}}
    {{-- ===================================================== --}}

    @if(session('error'))

        <div class="alert alert-danger border-0 rounded-4 shadow-sm">

            <i class="fa-solid fa-circle-exclamation me-2"></i>

            {{ session('error') }}

        </div>

    @endif



    {{-- ===================================================== --}}
    {{-- VALIDATION --}}
    {{-- ===================================================== --}}

    @if($errors->any())

        <div class="alert alert-danger border-0 rounded-4 shadow-sm">

            <strong>

                <i class="fa-solid fa-triangle-exclamation me-2"></i>

                Please fix the following:

            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif



    {{-- ===================================================== --}}
    {{-- SUMMARY --}}
    {{-- ===================================================== --}}

    @php

        $totalCount = $enquiries->count();

        $pendingCount =
            $pendingEnquiries
            ?? $enquiries->where('status', 'pending')->count();

        $repliedCount =
            $enquiries->where('status', 'replied')->count();

        $unreadCount =
            $unreadEnquiries
            ?? $enquiries->where('admin_read', false)->count();

        /*
        |--------------------------------------------------------------------------
        | GROUP CUSTOMER WISE
        |--------------------------------------------------------------------------
        */

        $groupedEnquiries = $enquiries->groupBy(function($enquiry) {

            if ($enquiry->user_id) {

                return 'user_'.$enquiry->user_id;

            }

            return 'email_'.strtolower(
                trim($enquiry->email ?? 'unknown')
            );

        });

    @endphp


    <div class="row g-3 mb-4">


        {{-- TOTAL --}}

        <div class="col-6 col-lg-3">

            <div class="summary-card">

                <div class="d-flex align-items-center">

                    <div
                        class="summary-icon me-3"
                        style="
                            background:#eef7e5;
                            color:#8cc63f;
                        "
                    >

                        <i class="fa-solid fa-envelope"></i>

                    </div>

                    <div>

                        <small class="text-muted d-block">

                            Total

                        </small>

                        <h4 class="fw-bold mb-0">

                            {{ $totalCount }}

                        </h4>

                    </div>

                </div>

            </div>

        </div>


        {{-- PENDING --}}

        <div class="col-6 col-lg-3">

            <div class="summary-card">

                <div class="d-flex align-items-center">

                    <div
                        class="summary-icon me-3"
                        style="
                            background:#fff4d8;
                            color:#d89a16;
                        "
                    >

                        <i class="fa-solid fa-clock"></i>

                    </div>

                    <div>

                        <small class="text-muted d-block">

                            Pending

                        </small>

                        <h4 class="fw-bold mb-0">

                            {{ $pendingCount }}

                        </h4>

                    </div>

                </div>

            </div>

        </div>


        {{-- REPLIED --}}

        <div class="col-6 col-lg-3">

            <div class="summary-card">

                <div class="d-flex align-items-center">

                    <div
                        class="summary-icon me-3"
                        style="
                            background:#edf8e5;
                            color:#65a22b;
                        "
                    >

                        <i class="fa-solid fa-reply"></i>

                    </div>

                    <div>

                        <small class="text-muted d-block">

                            Replied

                        </small>

                        <h4 class="fw-bold mb-0">

                            {{ $repliedCount }}

                        </h4>

                    </div>

                </div>

            </div>

        </div>


        {{-- UNREAD --}}

        <div class="col-6 col-lg-3">

            <div class="summary-card">

                <div class="d-flex align-items-center">

                    <div
                        class="summary-icon me-3"
                        style="
                            background:#fff0f0;
                            color:#dc3545;
                        "
                    >

                        <i class="fa-solid fa-bell"></i>

                    </div>

                    <div>

                        <small class="text-muted d-block">

                            Unread

                        </small>

                        <h4 class="fw-bold mb-0">

                            {{ $unreadCount }}

                        </h4>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- ===================================================== --}}
    {{-- CUSTOMER CONVERSATIONS --}}
    {{-- ===================================================== --}}

    <div id="customerList">


        @forelse($groupedEnquiries as $customerKey => $customerEnquiries)


            @php

                /*
                |--------------------------------------------------------------------------
                | CUSTOMER BASIC DETAILS
                |--------------------------------------------------------------------------
                */

                $firstEnquiry = $customerEnquiries->first();

                $customerName =
                    $firstEnquiry->name
                    ?? optional($firstEnquiry->user)->name
                    ?? 'Customer';

                $customerEmail =
                    $firstEnquiry->email
                    ?? optional($firstEnquiry->user)->email
                    ?? '';

                $initial =
                    strtoupper(
                        substr(
                            trim($customerName),
                            0,
                            1
                        )
                    );

                $customerUnread =
                    $customerEnquiries
                        ->where('admin_read', false)
                        ->count();

                $customerPending =
                    $customerEnquiries
                        ->where('status', 'pending')
                        ->count();

                $latestEnquiry =
                    $customerEnquiries
                        ->sortByDesc('created_at')
                        ->first();

            @endphp


            {{-- ================================================= --}}
            {{-- CUSTOMER CARD --}}
            {{-- ================================================= --}}

            <div
                class="
                    customer-card
                    mb-3
                    customer-item
                    {{ $customerUnread > 0 ? 'unread-customer' : '' }}
                "
                data-search="
                    {{ strtolower(
                        $customerName.' '.
                        $customerEmail.' '.
                        $customerEnquiries->pluck('subject')->implode(' ')
                    ) }}
                "
            >


                {{-- ============================================= --}}
                {{-- CUSTOMER HEADER --}}
                {{-- ============================================= --}}

                <div
                    class="customer-header"
                    data-bs-toggle="collapse"
                    data-bs-target="#customer_{{ md5($customerKey) }}"
                    aria-expanded="false"
                >

                    <div class="d-flex align-items-center gap-3">


                        {{-- AVATAR --}}

                        <div class="customer-avatar">

                            {{ $initial }}

                        </div>


                        {{-- DETAILS --}}

                        <div class="flex-grow-1">

                            <div class="d-flex align-items-center gap-2 flex-wrap">

                                <span class="customer-name">

                                    {{ $customerName }}

                                </span>


                                @if($customerUnread > 0)

                                    <span
                                        class="badge rounded-pill text-white"
                                        style="
                                            background:#8cc63f;
                                            font-size:9px;
                                        "
                                    >

                                        {{ $customerUnread }} New

                                    </span>

                                @endif

                            </div>


                            <div class="customer-email">

                                <i class="fa-regular fa-envelope me-1"></i>

                                {{ $customerEmail }}

                            </div>

                        </div>


                        {{-- RIGHT SIDE --}}

                        <div class="d-flex align-items-center gap-2">


                            <span class="message-count">

                                <i class="fa-solid fa-message me-1"></i>

                                {{ $customerEnquiries->count() }}

                            </span>


                            @if($customerPending > 0)

                                <span
                                    class="badge rounded-pill bg-warning text-dark"
                                    style="font-size:9px;"
                                >

                                    {{ $customerPending }} Pending

                                </span>

                            @endif


                            <i
                                class="fa-solid fa-chevron-down text-muted ms-1"
                            ></i>

                        </div>

                    </div>


                    {{-- LATEST SUBJECT --}}

                    @if($latestEnquiry)

                        <div
                            class="mt-3 pt-3 border-top"
                            style="border-color:#f0f2ec !important;"
                        >

                            <div
                                class="d-flex
                                       justify-content-between
                                       align-items-center
                                       gap-2"
                            >

                                <div
                                    class="text-muted small text-truncate"
                                    style="max-width:75%;"
                                >

                                    <i
                                        class="fa-regular fa-comment-dots me-1"
                                        style="color:#8cc63f;"
                                    ></i>

                                    {{ $latestEnquiry->subject }}

                                </div>


                                <small class="text-muted">

                                    @if($latestEnquiry->created_at)

                                        {{ $latestEnquiry->created_at->diffForHumans() }}

                                    @endif

                                </small>

                            </div>

                        </div>

                    @endif

                </div>



                {{-- ================================================= --}}
                {{-- CUSTOMER CONVERSATIONS --}}
                {{-- ================================================= --}}

                <div
                    id="customer_{{ md5($customerKey) }}"
                    class="collapse"
                >

                    <div class="conversation-area">


                        @foreach(
                            $customerEnquiries->sortByDesc('created_at')
                            as $enquiry
                        )


                            {{-- ========================================= --}}
                            {{-- SINGLE ENQUIRY --}}
                            {{-- ========================================= --}}

                            <div class="conversation-item">


                                {{-- ===================================== --}}
                                {{-- ENQUIRY HEADER --}}
                                {{-- ===================================== --}}

                                <div
                                    class="conversation-top"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#enquiry_{{ $enquiry->id }}"
                                    aria-expanded="false"
                                >

                                    <div
                                        class="d-flex
                                               justify-content-between
                                               align-items-center
                                               gap-3"
                                    >

                                        <div class="flex-grow-1">

                                            <div
                                                class="subject-text
                                                       text-truncate"
                                            >

                                                <i
                                                    class="fa-regular
                                                           fa-envelope
                                                           me-2"
                                                    style="
                                                        color:#8cc63f;
                                                    "
                                                ></i>

                                                {{ $enquiry->subject }}

                                            </div>


                                            <div class="date-text mt-1">

                                                <i
                                                    class="fa-regular
                                                           fa-calendar
                                                           me-1"
                                                ></i>

                                                @if($enquiry->created_at)

                                                    {{ $enquiry->created_at->format('d M Y, h:i A') }}

                                                @endif

                                            </div>

                                        </div>


                                        <div
                                            class="d-flex
                                                   align-items-center
                                                   gap-2"
                                        >


                                            {{-- STATUS --}}

                                            @if($enquiry->status === 'pending')

                                                <span
                                                    class="
                                                        status-badge
                                                        status-pending
                                                    "
                                                >

                                                    <i
                                                        class="fa-solid
                                                               fa-clock
                                                               me-1"
                                                    ></i>

                                                    Pending

                                                </span>

                                            @elseif($enquiry->status === 'replied')

                                                <span
                                                    class="
                                                        status-badge
                                                        status-replied
                                                    "
                                                >

                                                    <i
                                                        class="fa-solid
                                                               fa-check
                                                               me-1"
                                                    ></i>

                                                    Replied

                                                </span>

                                            @else

                                                <span
                                                    class="
                                                        status-badge
                                                        status-closed
                                                    "
                                                >

                                                    Closed

                                                </span>

                                            @endif


                                            {{-- NEW --}}

                                            @if(!$enquiry->admin_read)

                                                <span
                                                    class="badge rounded-pill"
                                                    style="
                                                        background:#fff0f0;
                                                        color:#dc3545;
                                                        font-size:9px;
                                                    "
                                                >

                                                    NEW

                                                </span>

                                            @endif


                                            <i
                                                class="
                                                    fa-solid
                                                    fa-chevron-down
                                                    text-muted
                                                "
                                            ></i>

                                        </div>

                                    </div>

                                </div>



                                {{-- ===================================== --}}
                                {{-- MESSAGE + REPLY --}}
                                {{-- ===================================== --}}

                                <div
                                    id="enquiry_{{ $enquiry->id }}"
                                    class="collapse"
                                >


                                    {{-- MESSAGE --}}

                                    <div class="message-box">


                                        <div class="customer-message">

                                            <div class="message-label">

                                                <i
                                                    class="fa-solid
                                                           fa-user
                                                           me-1"
                                                    style="
                                                        color:#8cc63f;
                                                    "
                                                ></i>

                                                Customer Message

                                            </div>


                                            <p class="message-text">

                                                {{ $enquiry->message }}

                                            </p>

                                        </div>



                                        {{-- ADMIN REPLY --}}

                                        @if(!empty($enquiry->reply))

                                            <div class="admin-message">

                                                <div class="message-label">

                                                    <i
                                                        class="fa-solid
                                                               fa-reply
                                                               me-1"
                                                        style="
                                                            color:#6ea72d;
                                                        "
                                                    ></i>

                                                    Your Reply

                                                </div>


                                                <p class="message-text">

                                                    {{ $enquiry->reply }}

                                                </p>


                                                @if(
                                                    isset($enquiry->replied_at)
                                                    && $enquiry->replied_at
                                                )

                                                    <div
                                                        class="
                                                            small
                                                            text-muted
                                                            mt-2
                                                        "
                                                    >

                                                        <i
                                                            class="
                                                                fa-regular
                                                                fa-clock
                                                                me-1
                                                            "
                                                        ></i>

                                                        {{ \Carbon\Carbon::parse(
                                                            $enquiry->replied_at
                                                        )->format(
                                                            'd M Y, h:i A'
                                                        ) }}

                                                    </div>

                                                @endif

                                            </div>

                                        @endif

                                    </div>



                                    {{-- ================================= --}}
                                    {{-- REPLY FORM --}}
                                    {{-- ================================= --}}

                                    <div class="reply-box">


                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'admin.enquiries.reply',
                                                $enquiry->id
                                            ) }}"
                                        >

                                            @csrf


                                            <div
                                                class="
                                                    d-flex
                                                    align-items-center
                                                    justify-content-between
                                                    mb-2
                                                "
                                            >

                                                <label
                                                    class="
                                                        small
                                                        fw-bold
                                                        text-dark
                                                        mb-0
                                                    "
                                                >

                                                    <i
                                                        class="
                                                            fa-solid
                                                            fa-pen-to-square
                                                            me-1
                                                        "
                                                        style="
                                                            color:#8cc63f;
                                                        "
                                                    ></i>

                                                    {{ $enquiry->reply
                                                        ? 'Update Reply'
                                                        : 'Reply to Customer'
                                                    }}

                                                </label>


                                                @if(!$enquiry->admin_read)

                                                    <span
                                                        class="
                                                            small
                                                            text-danger
                                                        "
                                                    >

                                                        <i
                                                            class="
                                                                fa-solid
                                                                fa-circle
                                                                me-1
                                                            "
                                                            style="
                                                                font-size:6px;
                                                            "
                                                        ></i>

                                                        Unread

                                                    </span>

                                                @endif

                                            </div>


                                            <textarea
                                                name="reply"
                                                class="form-control"
                                                placeholder="Write your reply here..."
                                                required
                                            >{{ old(
                                                'reply',
                                                $enquiry->reply ?? ''
                                            ) }}</textarea>


                                            <div
                                                class="
                                                    d-flex
                                                    flex-wrap
                                                    justify-content-between
                                                    align-items-center
                                                    gap-2
                                                    mt-3
                                                "
                                            >


                                                {{-- MARK READ --}}

                                                <div>

                                                    @if(!$enquiry->admin_read)

                                                        <button
                                                            type="button"
                                                            onclick="
                                                                markEnquiryAsRead(
                                                                    {{ $enquiry->id }},
                                                                    this
                                                                )
                                                            "
                                                            class="
                                                                btn
                                                                btn-sm
                                                                btn-outline-secondary
                                                                rounded-pill
                                                                px-3
                                                            "
                                                        >

                                                            <i
                                                                class="
                                                                    fa-solid
                                                                    fa-check-double
                                                                    me-1
                                                                "
                                                            ></i>

                                                            Mark Read

                                                        </button>

                                                    @else

                                                        <span
                                                            class="
                                                                small
                                                                text-success
                                                            "
                                                        >

                                                            <i
                                                                class="
                                                                    fa-solid
                                                                    fa-check-double
                                                                    me-1
                                                            "
                                                            ></i>

                                                            Read

                                                        </span>

                                                    @endif

                                                </div>



                                                {{-- SEND REPLY --}}

                                                <button
                                                    type="submit"
                                                    class="reply-button"
                                                >

                                                    <i
                                                        class="
                                                            fa-solid
                                                            fa-paper-plane
                                                            me-2
                                                        "
                                                    ></i>

                                                    {{ $enquiry->reply
                                                        ? 'Update Reply'
                                                        : 'Send Reply'
                                                    }}

                                                </button>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                            </div>


                        @endforeach

                    </div>

                </div>

            </div>


        @empty


            {{-- ================================================= --}}
            {{-- EMPTY --}}
            {{-- ================================================= --}}

            <div class="empty-enquiry">

                <div class="empty-icon mb-4">

                    <i class="fa-solid fa-envelope-open-text"></i>

                </div>


                <h5 class="fw-bold text-dark">

                    No Customer Messages

                </h5>


                <p class="text-muted small mb-0">

                    Customer enquiries will appear here when customers
                    contact your store.

                </p>

            </div>

        @endforelse


    </div>


    {{-- SEARCH EMPTY --}}

    <div
        id="searchEmpty"
        class="empty-enquiry mt-3"
        style="display:none;"
    >

        <div class="empty-icon mb-4">

            <i class="fa-solid fa-magnifying-glass"></i>

        </div>

        <h5 class="fw-bold">

            No Customer Found

        </h5>

        <p class="text-muted small mb-0">

            Try searching with another customer name, email or subject.

        </p>

    </div>


</div>



{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>


/* =============================================================
   SEARCH CUSTOMERS
============================================================= */

function searchCustomers()
{

    const input =
        document.getElementById('customerSearch');

    const searchValue =
        input.value.toLowerCase().trim();

    const customers =
        document.querySelectorAll('.customer-item');

    let visibleCount = 0;


    customers.forEach(function(customer)
    {

        const searchableText =
            customer.getAttribute('data-search')
            || '';

        if(
            searchableText
                .toLowerCase()
                .includes(searchValue)
        )
        {

            customer.style.display = '';

            visibleCount++;

        }
        else
        {

            customer.style.display = 'none';

        }

    });


    const empty =
        document.getElementById('searchEmpty');


    if(empty)
    {

        if(
            visibleCount === 0
            && searchValue !== ''
        )
        {

            empty.style.display = 'block';

        }
        else
        {

            empty.style.display = 'none';

        }

    }

}



/* =============================================================
   MARK ENQUIRY AS READ
============================================================= */

function markEnquiryAsRead(
    enquiryId,
    button
)
{

    if(!enquiryId || !button)
    {
        return;
    }


    button.disabled = true;


    const originalHTML =
        button.innerHTML;


    button.innerHTML =
        '<i class="fa-solid fa-spinner fa-spin me-1"></i> Saving...';


    fetch(
        "{{ url('/admin/enquiry') }}/"
        + enquiryId
        + "/read",
        {

            method: "POST",

            headers:
            {

                "X-CSRF-TOKEN":
                    "{{ csrf_token() }}",

                "Accept":
                    "application/json",

                "Content-Type":
                    "application/json",

                "X-Requested-With":
                    "XMLHttpRequest"

            },

            body:
                JSON.stringify({})

        }
    )


    .then(function(response)
    {

        return response.json();

    })


    .then(function(data)
    {

        if(data.success)
        {

            /*
            |-----------------------------------------------------
            | Update button immediately
            |-----------------------------------------------------
            */

            button.outerHTML = `

                <span class="small text-success">

                    <i
                        class="fa-solid
                               fa-check-double
                               me-1"
                    ></i>

                    Read

                </span>

            `;


            /*
            |-----------------------------------------------------
            | Remove NEW badge from this enquiry
            |-----------------------------------------------------
            */

            const enquiryCard =
                button.closest('.conversation-item');


            if(enquiryCard)
            {

                const newBadge =
                    enquiryCard.querySelector(
                        '.badge'
                    );


                if(
                    newBadge
                    &&
                    newBadge.innerText
                        .trim()
                        .toUpperCase()
                        === 'NEW'
                )
                {

                    newBadge.remove();

                }

            }


            /*
            |-----------------------------------------------------
            | Update customer green border if no unread remains
            |-----------------------------------------------------
            */

            setTimeout(function()
            {

                location.reload();

            }, 500);

        }
        else
        {

            button.disabled = false;

            button.innerHTML =
                originalHTML;


            alert(
                data.message
                ||
                'Unable to mark enquiry as read.'
            );

        }

    })


    .catch(function(error)
    {

        console.error(
            'Mark enquiry read error:',
            error
        );


        button.disabled = false;

        button.innerHTML =
            originalHTML;


        alert(
            'Something went wrong. Please try again.'
        );

    });

}


</script>


    {{-- ================================================= --}}
    {{-- COUPON MANAGEMENT --}}
    {{-- ================================================= --}}
@elseif(request('page') == 'coupons')
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h3 class="fw-bold mb-1">

                    <i class="fas fa-ticket-alt me-2"></i>

                    Coupon Management

                </h3>

                <p class="text-muted mb-0">

                    Create and manage discount coupons

                </p>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- SUCCESS MESSAGE --}}
        {{-- ================================================= --}}

        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show rounded-3">

                <i class="fas fa-check-circle me-2"></i>

                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- ================================================= --}}
        {{-- ERROR MESSAGE --}}
        {{-- ================================================= --}}

        @if($errors->any())

            <div class="alert alert-danger rounded-3">

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
            {{-- ADD COUPON --}}
            {{-- ================================================= --}}

            <div class="col-lg-5">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-header bg-dark text-white rounded-top-4 p-4">

                        <h5 class="mb-1 fw-bold">

                            <i class="fas fa-plus-circle me-2"></i>

                            Add New Coupon

                        </h5>

                        <small class="text-white-50">

                            Create a discount coupon

                        </small>

                    </div>


                    <div class="card-body p-4">

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
                                       class="form-control"
                                       placeholder="Example: SAVE10"
                                       value="{{ old('code') }}"
                                       style="text-transform: uppercase;"
                                       required>

                            </div>


                            {{-- DISCOUNT TYPE --}}

                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    Discount Type

                                </label>

                                <select name="discount_type"
                                        class="form-select"
                                        required>

                                    <option value="percentage"
                                            {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>

                                        Percentage (%)

                                    </option>

                                    <option value="fixed"
                                            {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>

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
                                       class="form-control"
                                       placeholder="Example: 10"
                                       value="{{ old('discount_value') }}"
                                       min="0.01"
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
                                           class="form-control"
                                           value="{{ old('start_date') }}">

                                </div>


                                {{-- EXPIRY DATE --}}

                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-semibold">

                                        Expiry Date

                                    </label>

                                    <input type="date"
                                           name="expiry_date"
                                           class="form-control"
                                           value="{{ old('expiry_date') }}">

                                </div>

                            </div>


                            {{-- USAGE LIMIT --}}

                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    Usage Limit

                                </label>

                                <input type="number"
                                       name="usage_limit"
                                       class="form-control"
                                       placeholder="Example: 100"
                                       value="{{ old('usage_limit') }}"
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
                                        class="form-select">

                                    <option value="1"
                                            {{ old('status', '1') == '1' ? 'selected' : '' }}>

                                        Active

                                    </option>

                                    <option value="0"
                                            {{ old('status') == '0' ? 'selected' : '' }}>

                                        Inactive

                                    </option>

                                </select>

                            </div>


                            {{-- BUTTON --}}

                            <button type="submit"
                                    class="btn btn-dark w-100 py-2">

                                <i class="fas fa-plus me-2"></i>

                                Create Coupon

                            </button>

                        </form>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- COUPON LIST --}}
            {{-- ================================================= --}}

            <div class="col-lg-7">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-header bg-white border-0 p-4">

                        <h5 class="fw-bold mb-1">

                            <i class="fas fa-list me-2"></i>

                            Created Coupons

                        </h5>

                        <p class="text-muted small mb-0">

                            All coupons created by admin

                        </p>

                    </div>


                    <div class="card-body p-4">


                        @if(isset($coupons) && $coupons->count() > 0)

                            <div class="table-responsive">

                                <table class="table align-middle">

                                    <thead>

                                        <tr>

                                            <th>Code</th>

                                            <th>Discount</th>

                                            <th>Validity</th>

                                            <th>Usage</th>

                                            <th>Status</th>

                                        </tr>

                                    </thead>


                                    <tbody>

                                        @foreach($coupons as $coupon)

                                            <tr>


                                                {{-- CODE --}}

                                                <td>

                                                    <span class="fw-bold">

                                                        {{ $coupon->code }}

                                                    </span>

                                                </td>


                                                {{-- DISCOUNT --}}

                                                <td>

                                                    @if($coupon->discount_type == 'percentage')

                                                        <span class="badge bg-primary">

                                                            {{ $coupon->discount_value }}%

                                                        </span>

                                                    @else

                                                        <span class="badge bg-success">

                                                            ₹{{ number_format($coupon->discount_value, 2) }}

                                                        </span>

                                                    @endif

                                                </td>


                                                {{-- VALIDITY --}}

                                                <td>

                                                    <small>

                                                        @if($coupon->start_date)

                                                            {{ \Carbon\Carbon::parse($coupon->start_date)->format('d M Y') }}

                                                        @else

                                                            No Start Date

                                                        @endif

                                                        <br>

                                                        <span class="text-muted">

                                                            to

                                                        </span>

                                                        <br>

                                                        @if($coupon->expiry_date)

                                                            {{ \Carbon\Carbon::parse($coupon->expiry_date)->format('d M Y') }}

                                                        @else

                                                            No Expiry

                                                        @endif

                                                    </small>

                                                </td>


                                                {{-- USAGE --}}

                                                <td>

                                                    {{ $coupon->used_count ?? 0 }}

                                                    /

                                                    @if($coupon->usage_limit)

                                                        {{ $coupon->usage_limit }}

                                                    @else

                                                        ∞

                                                    @endif

                                                </td>


                                                {{-- STATUS --}}

                                                <td>

                                                    @if($coupon->status)

                                                        <span class="badge bg-success">

                                                            Active

                                                        </span>

                                                    @else

                                                        <span class="badge bg-secondary">

                                                            Inactive

                                                        </span>

                                                    @endif

                                                </td>


                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                        @else

                            <div class="text-center py-5">

                                <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>

                                <h5 class="fw-bold">

                                    No Coupons Created

                                </h5>

                                <p class="text-muted mb-0">

                                    Create your first coupon using the form.

                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            </div>


        </div>


        {{-- ================================================= --}}
        {{-- COUPON INFORMATION --}}
        {{-- ================================================= --}}

        <div class="card border-0 shadow-sm rounded-4 mt-4">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-3">

                    <i class="fas fa-info-circle me-2"></i>

                    Coupon Information

                </h5>


                <div class="row g-3">

                    <div class="col-md-4">

                        <div class="border rounded-3 p-3">

                            <small class="text-muted">

                                Percentage Example

                            </small>

                            <div class="fw-bold mt-1">

                                SAVE10 = 10% OFF

                            </div>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="border rounded-3 p-3">

                            <small class="text-muted">

                                Fixed Example

                            </small>

                            <div class="fw-bold mt-1">

                                FLAT100 = ₹100 OFF

                            </div>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="border rounded-3 p-3">

                            <small class="text-muted">

                                Usage

                            </small>

                            <div class="fw-bold mt-1">

                                Limited / Unlimited

                            </div>

                        </div>

                    </div>

                </div>


                <div class="alert alert-light border mt-4 mb-0">

                    <i class="fas fa-lightbulb me-2"></i>

                    <strong>Tip:</strong>

                    Use simple codes like

                    <strong>SAVE10</strong>,

                    <strong>WELCOME20</strong>

                    or

                    <strong>FLAT100</strong>.

                </div>

            </div>

        </div>

    </div>
    {{-- ================================================= --}}
{{-- CREATED COUPONS --}}
{{-- ================================================= --}}

<div class="card border-0 shadow-sm rounded-4 mt-4">

    {{-- HEADER --}}
    <div class="card-header bg-dark text-white border-0 rounded-top-4 p-4">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h5 class="fw-bold mb-1">
                    <i class="fas fa-ticket-alt me-2"></i>
                    Created Coupons
                </h5>

                <small class="text-white-50">
                    View, edit and delete your coupons
                </small>

            </div>

            <span class="badge bg-light text-dark">
                {{ isset($coupons) ? $coupons->count() : 0 }}
                Coupons
            </span>

        </div>

    </div>


    {{-- BODY --}}
    <div class="card-body p-4">

        @if(isset($coupons) && $coupons->count() > 0)

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th>
                                Code
                            </th>

                            <th>
                                Discount
                            </th>

                            <th>
                                Validity
                            </th>

                            <th>
                                Usage
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-center">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($coupons as $coupon)

                            <tr>

                                {{-- CODE --}}
                                <td>

                                    <span class="fw-bold fs-6">
                                        {{ $coupon->code }}
                                    </span>

                                </td>


                                {{-- DISCOUNT --}}
                                <td>

                                    @if($coupon->discount_type == 'percentage')

                                        <span class="badge bg-primary rounded-pill px-3 py-2">

                                            {{ number_format($coupon->discount_value, 2) }}%

                                        </span>

                                    @else

                                        <span class="badge bg-success rounded-pill px-3 py-2">

                                            ₹{{ number_format($coupon->discount_value, 2) }}

                                        </span>

                                    @endif

                                </td>


                                {{-- VALIDITY --}}
                                <td>

                                    <small>

                                        @if($coupon->start_date)

                                            {{ \Carbon\Carbon::parse($coupon->start_date)->format('d M Y') }}

                                        @else

                                            <span class="text-muted">
                                                No Start Date
                                            </span>

                                        @endif

                                        <span class="text-muted mx-1">
                                            to
                                        </span>

                                        @if($coupon->expiry_date)

                                            {{ \Carbon\Carbon::parse($coupon->expiry_date)->format('d M Y') }}

                                        @else

                                            <span class="text-muted">
                                                No Expiry
                                            </span>

                                        @endif

                                    </small>

                                </td>


                                {{-- USAGE --}}
                                <td>

                                    <span class="fw-semibold">

                                        {{ $coupon->used_count ?? 0 }}

                                        /

                                        @if($coupon->usage_limit)

                                            {{ $coupon->usage_limit }}

                                        @else

                                            ∞

                                        @endif

                                    </span>

                                </td>


                                {{-- STATUS --}}
                                <td>

                                    @if($coupon->status)

                                        <span class="badge bg-success rounded-pill px-3 py-2">

                                            Active

                                        </span>

                                    @else

                                        <span class="badge bg-secondary rounded-pill px-3 py-2">

                                            Inactive

                                        </span>

                                    @endif

                                </td>


                                {{-- ACTION --}}
                                <td>

                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- EDIT BUTTON --}}
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-warning"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editCoupon{{ $coupon->id }}"
                                            title="Edit Coupon">

                                            <i class="fas fa-edit"></i>

                                        </button>


                                        {{-- DELETE BUTTON --}}
                                        <form
                                            action="{{ route('admin.coupons.destroy', $coupon->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this coupon?');">

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Delete Coupon">

                                                <i class="fas fa-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            {{-- NO COUPON --}}
            <div class="text-center py-5">

                <div class="mb-3">

                    <i class="fas fa-ticket-alt fa-3x text-muted"></i>

                </div>

                <h5 class="fw-bold">
                    No Coupons Created
                </h5>

                <p class="text-muted mb-0">

                    Create your first coupon using the form above.

                </p>

            </div>

        @endif

    </div>

</div>



{{-- ================================================= --}}
{{-- EDIT COUPON MODALS --}}
{{-- IMPORTANT: MODALS ARE OUTSIDE TABLE --}}
{{-- ================================================= --}}

@if(isset($coupons) && $coupons->count() > 0)

    @foreach($coupons as $coupon)

        <div
            class="modal fade"
            id="editCoupon{{ $coupon->id }}"
            tabindex="-1"
            aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content rounded-4 border-0 shadow">


                    {{-- MODAL HEADER --}}
                    <div class="modal-header bg-dark text-white">

                        <h5 class="modal-title">

                            <i class="fas fa-edit me-2"></i>

                            Edit Coupon

                        </h5>

                        <button
                            type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal">
                        </button>

                    </div>


                    {{-- FORM --}}
                    <form
                        action="{{ route('admin.coupons.update', $coupon->id) }}"
                        method="POST">

                        @csrf

                        @method('PUT')


                        <div class="modal-body p-4">


                            {{-- CODE --}}
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Coupon Code
                                </label>

                                <input
                                    type="text"
                                    name="code"
                                    class="form-control"
                                    value="{{ $coupon->code }}"
                                    style="text-transform: uppercase;"
                                    required>

                            </div>


                            {{-- DISCOUNT TYPE --}}
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Discount Type
                                </label>

                                <select
                                    name="discount_type"
                                    class="form-select"
                                    required>

                                    <option
                                        value="percentage"
                                        {{ $coupon->discount_type == 'percentage' ? 'selected' : '' }}>

                                        Percentage (%)

                                    </option>

                                    <option
                                        value="fixed"
                                        {{ $coupon->discount_type == 'fixed' ? 'selected' : '' }}>

                                        Fixed Amount (₹)

                                    </option>

                                </select>

                            </div>


                            {{-- DISCOUNT VALUE --}}
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Discount Value
                                </label>

                                <input
                                    type="number"
                                    name="discount_value"
                                    class="form-control"
                                    value="{{ $coupon->discount_value }}"
                                    min="0.01"
                                    step="0.01"
                                    required>

                            </div>


                            {{-- DATES --}}
                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-semibold">
                                        Start Date
                                    </label>

                                    <input
                                        type="date"
                                        name="start_date"
                                        class="form-control"
                                        value="{{ $coupon->start_date ? \Carbon\Carbon::parse($coupon->start_date)->format('Y-m-d') : '' }}">

                                </div>


                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-semibold">
                                        Expiry Date
                                    </label>

                                    <input
                                        type="date"
                                        name="expiry_date"
                                        class="form-control"
                                        value="{{ $coupon->expiry_date ? \Carbon\Carbon::parse($coupon->expiry_date)->format('Y-m-d') : '' }}">

                                </div>

                            </div>


                            {{-- USAGE LIMIT --}}
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Usage Limit
                                </label>

                                <input
                                    type="number"
                                    name="usage_limit"
                                    class="form-control"
                                    value="{{ $coupon->usage_limit }}"
                                    min="1">

                                <small class="text-muted">

                                    Leave empty for unlimited usage.

                                </small>

                            </div>


                            {{-- STATUS --}}
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Status
                                </label>

                                <select
                                    name="status"
                                    class="form-select">

                                    <option
                                        value="1"
                                        {{ $coupon->status == 1 ? 'selected' : '' }}>

                                        Active

                                    </option>

                                    <option
                                        value="0"
                                        {{ $coupon->status == 0 ? 'selected' : '' }}>

                                        Inactive

                                    </option>

                                </select>

                            </div>

                        </div>


                        {{-- MODAL FOOTER --}}
                        <div class="modal-footer">

                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">

                                Cancel

                            </button>


                            <button
                                type="submit"
                                class="btn btn-dark">

                                <i class="fas fa-save me-2"></i>

                                Update Coupon

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    @endforeach



                </tbody>

            </table>

        </div>

    @else

        <div class="text-center py-5">

            <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>

            <h5 class="fw-bold">
                No Coupons Created
            </h5>

            <p class="text-muted mb-0">
                Create your first coupon using the form.
            </p>

        </div>

    @endif


    
{{-- ================================================= --}}
{{-- WEBSITE VISITORS --}}
{{-- ================================================= --}}

@elseif(request('page') == 'website-visitors')

<div class="container-fluid">

    {{-- ================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ================================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Website Visitors
            </h3>

            <p class="text-muted mb-0">
                Monitor unique visitors and their latest visits
            </p>

        </div>

        <div class="px-4 py-2 rounded-pill"
             style="background-color:#f0f8e8;color:#8cc63f;">

            <i class="fa-solid fa-globe me-2"></i>

            Live Visitor Tracking

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- VISITOR STATISTICS --}}
    {{-- ================================================= --}}

    <div class="row g-4 mb-4">


        {{-- ================================================= --}}
        {{-- TOTAL UNIQUE VISITORS --}}
        {{-- ================================================= --}}

        <div class="col-xl-4 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center">

                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                             style="
                                width:60px;
                                height:60px;
                                background-color:#f0f8e8;
                                color:#8cc63f;
                             ">

                            <i class="fa-solid fa-users fa-lg"></i>

                        </div>

                        <div>

                            <small class="text-muted">
                                Total Unique Visitors
                            </small>

                            <h2 class="fw-bold mb-0 mt-1">
                                {{ $totalVisitors }}
                            </h2>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- TODAY'S VISITORS --}}
        {{-- ================================================= --}}

        <div class="col-xl-4 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center">

                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                             style="
                                width:60px;
                                height:60px;
                                background-color:#eef7ff;
                                color:#4a90e2;
                             ">

                            <i class="fa-solid fa-calendar-day fa-lg"></i>

                        </div>

                        <div>

                            <small class="text-muted">
                                Today's Visitors
                            </small>

                            <h2 class="fw-bold mb-0 mt-1">
                                {{ $todayVisitors }}
                            </h2>

                            <small class="text-muted">
                                Unique visitors today
                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- LATEST VISIT --}}
        {{-- ================================================= --}}

        <div class="col-xl-4 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center">

                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                             style="
                                width:60px;
                                height:60px;
                                background-color:#fff7e8;
                                color:#e9b36a;
                             ">

                            <i class="fa-solid fa-clock fa-lg"></i>

                        </div>

                        <div>

                            <small class="text-muted">
                                Latest Visit
                            </small>

                            <h6 class="fw-bold mb-0 mt-2">

                                @if($latestVisitor && $latestVisitor->updated_at)

                                    {{ $latestVisitor->updated_at->timezone('Asia/Kolkata')->format('d M Y, h:i A') }}

                                @else

                                    No visits yet

                                @endif

                            </h6>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- TODAY'S WEBSITE ACTIVITY --}}
    {{-- ================================================= --}}

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h5 class="fw-bold mb-1">
                        Today's Website Activity
                    </h5>

                    <p class="text-muted mb-0">
                        Unique visitors who visited your website today
                    </p>

                </div>

                <div class="text-center">

                    <div class="fw-bold fs-3"
                         style="color:#8cc63f;">

                        {{ $todayVisitors }}

                    </div>

                    <small class="text-muted">
                        Today's Visits
                    </small>

                </div>

            </div>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- VISITOR INFORMATION --}}
    {{-- ================================================= --}}

    <div class="card border-0 shadow-sm rounded-4">


        {{-- ================================================= --}}
        {{-- TABLE HEADER --}}
        {{-- ================================================= --}}

        <div class="card-header bg-white border-0 p-4">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h5 class="fw-bold mb-1">
                        Visitor Information
                    </h5>

                    <small class="text-muted">
                        Unique IP addresses and their visit activity
                    </small>

                </div>

                <span class="badge rounded-pill px-3 py-2"
                      style="
                        background-color:#f0f8e8;
                        color:#8cc63f;
                      ">

                    {{ $totalVisitors }} Visitors

                </span>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- TABLE --}}
        {{-- ================================================= --}}

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead style="background-color:#f8fbf5;">

                        <tr>

                            <th class="px-4 py-3">
                                #
                            </th>

                            <th>
                                IP Address
                            </th>

                            <th>
                                First Visit
                            </th>

                            <th>
                                Last Visit
                            </th>

                            <th>
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($visitors as $visitor)

                            <tr>

                                {{-- ================================================= --}}
                                {{-- NUMBER --}}
                                {{-- ================================================= --}}

                                <td class="px-4 fw-semibold">

                                    {{ $loop->iteration }}

                                </td>


                                {{-- ================================================= --}}
                                {{-- IP ADDRESS --}}
                                {{-- ================================================= --}}

                                <td>

                                    <span class="badge rounded-pill px-3 py-2"
                                          style="
                                            background-color:#f0f8e8;
                                            color:#5f8f24;
                                          ">

                                        <i class="fa-solid fa-location-dot me-1"></i>

                                        {{ $visitor->ip_address }}

                                    </span>

                                </td>


                                {{-- ================================================= --}}
                                {{-- FIRST VISIT --}}
                                {{-- ================================================= --}}

                                <td>

                                    @if($visitor->created_at)

                                        <small class="text-muted">

                                           {{ $visitor->created_at->timezone('Asia/Kolkata')->format('d M Y, h:i A') }}

                                        </small>

                                    @else

                                        <small class="text-muted">
                                            -
                                        </small>

                                    @endif

                                </td>


                                {{-- ================================================= --}}
                                {{-- LAST VISIT --}}
                                {{-- ================================================= --}}

                                <td>

                                    @if($visitor->updated_at)

                                        <small class="text-muted">

                                            {{ $visitor->updated_at->timezone('Asia/Kolkata')->format('d M Y, h:i A') }}

                                        </small>

                                    @else

                                        <small class="text-muted">
                                            -
                                        </small>

                                    @endif

                                </td>


                                {{-- ================================================= --}}
                                {{-- STATUS --}}
                                {{-- ================================================= --}}

                                <td>

                                    @if(
                                        $visitor->updated_at &&
                                        $visitor->updated_at->format('Y-m-d') === now()->format('Y-m-d')
                                    )

                                        <span class="badge rounded-pill px-3 py-2"
                                              style="
                                                background-color:#e8f7df;
                                                color:#5f8f24;
                                              ">

                                            <i class="fa-solid fa-circle me-1"
                                               style="font-size:7px;"></i>

                                            Today

                                        </span>

                                    @else

                                        <span class="badge rounded-pill px-3 py-2 bg-light text-muted">

                                            Previous Visit

                                        </span>

                                    @endif

                                </td>

                            </tr>


                        @empty

                            {{-- ================================================= --}}
                            {{-- NO VISITORS --}}
                            {{-- ================================================= --}}

                            <tr>

                                <td colspan="5"
                                    class="text-center py-5">

                                    <div class="mb-3">

                                        <i class="fa-solid fa-users-slash fa-2x text-muted"></i>

                                    </div>

                                    <h6 class="fw-bold">
                                        No visitors yet
                                    </h6>

                                    <p class="text-muted mb-0">

                                        Visitor information will appear here
                                        when someone visits your website.

                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

{{-- ================================================= --}}
{{-- TWO FACTOR AUTHENTICATION --}}
{{-- ================================================= --}}

@elseif(request('page') == 'two-factor')

<div class="container-fluid py-4">

    {{-- ================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ================================================= --}}

    <div class="mb-4">

        <h3 class="fw-bold mb-1">
            <i class="fa-solid fa-shield-halved me-2"
               style="color:#8cc63f;"></i>

            Two-Factor Authentication
        </h3>

        <p class="text-muted mb-0">
            Manage two-factor authentication for your admin account.
        </p>

    </div>


    {{-- ================================================= --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ================================================= --}}

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show rounded-4"
             role="alert">

            <i class="fa-solid fa-circle-check me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ================================================= --}}
    {{-- ERROR MESSAGE --}}
    {{-- ================================================= --}}

    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show rounded-4"
             role="alert">

            <i class="fa-solid fa-circle-exclamation me-2"></i>

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ================================================= --}}
    {{-- MAIN CARD --}}
    {{-- ================================================= --}}

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">


            {{-- ================================================= --}}
            {{-- GOOGLE AUTHENTICATOR HEADER --}}
            {{-- ================================================= --}}

            <div class="d-flex align-items-center mb-4">

                <div class="rounded-circle
                            d-flex
                            align-items-center
                            justify-content-center
                            me-3"
                     style="width:60px;
                            height:60px;
                            background-color:rgba(140,198,63,.15);">

                    <i class="fa-solid fa-shield-halved fs-4"
                       style="color:#8cc63f;">
                    </i>

                </div>


                <div>

                    <h5 class="fw-bold mb-1">
                        Google Authenticator
                    </h5>

                    <p class="text-muted mb-0">
                        Control OTP verification for admin login.
                    </p>

                </div>

            </div>


            <hr class="mb-4">


            {{-- ================================================= --}}
            {{-- ACTIVE --}}
            {{-- ================================================= --}}

            @if($twoFactorEnabled)

                <div class="mb-3">

                    <span class="badge bg-success rounded-pill px-3 py-2">

                        <i class="fa-solid fa-circle-check me-1"></i>

                        Active

                    </span>

                </div>


                <div class="alert alert-success rounded-4">

                    <i class="fa-solid fa-lock me-2"></i>

                    Two-factor authentication is currently
                    <strong>enabled</strong>.

                    <br>

                    Your admin account requires a
                    6-digit Google Authenticator code during login.

                </div>


                {{-- DISABLE --}}

                <form method="POST"
                      action="{{ route('admin.2fa.disable') }}">

                    @csrf

                    <button type="submit"
                            class="btn btn-danger rounded-pill px-4">

                        <i class="fa-solid fa-toggle-off me-2"></i>

                        Disable Two-Factor Authentication

                    </button>

                </form>


            @else


                {{-- ================================================= --}}
                {{-- DISABLED --}}
                {{-- ================================================= --}}

                <div class="mb-3">

                    <span class="badge bg-secondary rounded-pill px-3 py-2">

                        <i class="fa-solid fa-circle-xmark me-1"></i>

                        Disabled

                    </span>

                </div>


                <div class="alert alert-warning rounded-4 mb-4">

                    <i class="fa-solid fa-triangle-exclamation me-2"></i>

                    Two-factor authentication is currently
                    <strong>disabled</strong>.

                    <br>

                    Enable it to protect your admin account
                    with Google Authenticator.

                </div>


                {{-- ================================================= --}}
                {{-- ENABLE BUTTON --}}
                {{-- ================================================= --}}

                <form method="POST"
                      action="{{ route('admin.2fa.enable') }}">

                    @csrf

                    <button type="submit"
                            class="btn text-white rounded-pill px-4 py-2 fw-semibold"
                            style="background-color:#8cc63f;">

                        <i class="fa-solid fa-toggle-on me-2"></i>

                        Enable Two-Factor Authentication

                    </button>

                </form>


            @endif


        </div>

    </div>

</div>
{{-- ================================================= --}}
{{-- BACKUP --}}
{{-- ================================================= --}}

@elseif(request('page') == 'backup')

<div class="container-fluid py-4">

    {{-- ================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ================================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                <i class="fas fa-database me-2"></i>

                Database Backup

            </h3>

            <p class="text-muted mb-0">

                Download or restore your website database.

            </p>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ================================================= --}}

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show rounded-3">

            <i class="fas fa-circle-check me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ================================================= --}}
    {{-- ERROR MESSAGE --}}
    {{-- ================================================= --}}

    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show rounded-3">

            <i class="fas fa-circle-exclamation me-2"></i>

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ================================================= --}}
    {{-- BACKUP OPTIONS --}}
    {{-- ================================================= --}}

    <div class="row g-4">


        {{-- ================================================= --}}
        {{-- SQL BACKUP --}}
        {{-- ================================================= --}}

        <div class="col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4 text-center">

                    <div class="mb-3">

                        <i class="fas fa-database fa-3x text-primary"></i>

                    </div>


                    <h4 class="fw-bold">

                        SQL Database Backup

                    </h4>


                    <p class="text-muted">

                        Download the complete database
                        in SQL format.

                    </p>


                    <div class="mb-3">

                        <span class="badge bg-primary-subtle text-primary px-3 py-2">

                            .sql

                        </span>

                    </div>


                    {{-- DOWNLOAD SQL --}}

                    <a href="{{ route('admin.backup.sql') }}"
                       class="btn btn-primary px-4 rounded-pill">

                        <i class="fas fa-download me-2"></i>

                        Download SQL Backup

                    </a>

                </div>

            </div>

        </div>



        {{-- ================================================= --}}
        {{-- JSON BACKUP --}}
        {{-- ================================================= --}}

        <div class="col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4 text-center">

                    <div class="mb-3">

                        <i class="fas fa-file-code fa-3x text-success"></i>

                    </div>


                    <h4 class="fw-bold">

                        JSON Database Backup

                    </h4>


                    <p class="text-muted">

                        Download the database data
                        in JSON format.

                    </p>


                    <div class="mb-3">

                        <span class="badge bg-success-subtle text-success px-3 py-2">

                            .json

                        </span>

                    </div>


                    {{-- DOWNLOAD JSON --}}

                    <a href="{{ route('admin.backup.json') }}"
                       class="btn btn-success px-4 rounded-pill">

                        <i class="fas fa-download me-2"></i>

                        Download JSON Backup

                    </a>

                </div>

            </div>

        </div>



        {{-- ================================================= --}}
        {{-- RESTORE SQL --}}
        {{-- ================================================= --}}

        <div class="col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4 text-center">

                    <div class="mb-3">

                        <i class="fas fa-file-import fa-3x text-danger"></i>

                    </div>


                    <h4 class="fw-bold">

                        Import SQL Backup

                    </h4>


                    <p class="text-muted">

                        Upload a previously downloaded
                        SQL database backup and restore it.

                    </p>


                    <form
                        action="{{ route('admin.backup.restore.sql') }}"
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf


                        {{-- SQL FILE --}}

                        <div class="mb-3 text-start">

                            <label class="form-label fw-semibold">

                                Select SQL Backup File

                            </label>


                            <input
                                type="file"
                                name="sql_file"
                                class="form-control"
                                accept=".sql,.txt"
                                required>

                        </div>


                        {{-- RESTORE BUTTON --}}

                        <button
                            type="submit"
                            class="btn btn-danger px-4 rounded-pill"
                            onclick="return confirm('Are you sure you want to restore this SQL backup? Existing database data may be replaced.')">

                            <i class="fas fa-upload me-2"></i>

                            Import / Restore SQL

                        </button>

                    </form>

                </div>

            </div>

        </div>



        {{-- ================================================= --}}
        {{-- RESTORE JSON --}}
        {{-- ================================================= --}}

        <div class="col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4 text-center">

                    <div class="mb-3">

                        <i class="fas fa-file-import fa-3x text-warning"></i>

                    </div>


                    <h4 class="fw-bold">

                        Import JSON Backup

                    </h4>


                    <p class="text-muted">

                        Upload a previously downloaded
                        JSON database backup and restore it.

                    </p>


                    <form
                        action="{{ route('admin.backup.restore.json') }}"
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf


                        {{-- JSON FILE --}}

                        <div class="mb-3 text-start">

                            <label class="form-label fw-semibold">

                                Select JSON Backup File

                            </label>


                            <input
                                type="file"
                                name="json_file"
                                class="form-control"
                                accept=".json,.txt"
                                required>

                        </div>


                        {{-- RESTORE BUTTON --}}

                        <button
                            type="submit"
                            class="btn btn-warning px-4 rounded-pill"
                            onclick="return confirm('Are you sure you want to restore this JSON backup? Existing table data may be replaced.')">

                            <i class="fas fa-upload me-2"></i>

                            Import / Restore JSON

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>



    {{-- ================================================= --}}
    {{-- WARNING --}}
    {{-- ================================================= --}}

    <div class="alert alert-warning rounded-4 mt-4">

        <div class="d-flex align-items-start">

            <i class="fas fa-triangle-exclamation fs-4 me-3 mt-1"></i>

            <div>

                <strong>Important:</strong>

                Restore करण्यापूर्वी current database चा
                backup download करून ठेवा.

                <br>

                Restore केल्यावर existing database/table data
                replace होऊ शकतो.

            </div>

        </div>

    </div>

</div>


{{-- ================================================= --}}
{{-- SHIPPING CHARGES --}}
{{-- ================================================= --}}

@elseif(request('page') == 'shipping-charges')

@php
    /*
    |--------------------------------------------------------------------------
    | GET LATEST SHIPPING SETTINGS
    |--------------------------------------------------------------------------
    | Database मधून latest saved shipping settings घेणार.
    | त्यामुळे Admin ने value बदलली की तीच value इथे दिसेल.
    */

    $shippingData = \App\Models\ShippingSetting::latest('id')->first();

    /*
    |--------------------------------------------------------------------------
    | DEFAULT VALUES
    |--------------------------------------------------------------------------
    | फक्त database मध्ये कोणताही record नसल्यास वापरले जातील.
    */

    $currentShippingCharge = $shippingData
        ? $shippingData->shipping_charge
        : 100;

    $currentFreeShippingAmount = $shippingData
        ? $shippingData->free_shipping_amount
        : 2000;
@endphp


<div class="container-fluid py-4">

    {{-- ================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ================================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                <i class="fa-solid fa-truck-fast me-2"
                   style="color:#8cc63f;"></i>

                Shipping Charges

            </h3>

            <p class="text-muted mb-0">

                Manage shipping charges for customer orders.

            </p>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ================================================= --}}

    @if(session('shipping_success'))

        <div class="alert alert-success alert-dismissible fade show rounded-3">

            <i class="fa-solid fa-circle-check me-2"></i>

            {{ session('shipping_success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ================================================= --}}
    {{-- ERROR MESSAGE --}}
    {{-- ================================================= --}}

    @if(session('shipping_error'))

        <div class="alert alert-danger alert-dismissible fade show rounded-3">

            <i class="fa-solid fa-circle-exclamation me-2"></i>

            {{ session('shipping_error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ================================================= --}}
    {{-- VALIDATION ERRORS --}}
    {{-- ================================================= --}}

    @if($errors->any())

        <div class="alert alert-danger rounded-3">

            <div class="fw-bold mb-2">

                <i class="fa-solid fa-circle-exclamation me-2"></i>

                Please correct the following:

            </div>

            @foreach($errors->all() as $error)

                <div class="mb-1">

                    <i class="fa-solid fa-angle-right me-2"></i>

                    {{ $error }}

                </div>

            @endforeach

        </div>

    @endif


    {{-- ================================================= --}}
    {{-- SHIPPING FORM --}}
    {{-- ================================================= --}}

    <form
        id="shippingForm"
        action="{{ route('admin.shipping.update') }}"
        method="POST"
    >

        @csrf


        <div class="row g-4">


            {{-- ================================================= --}}
            {{-- STANDARD SHIPPING --}}
            {{-- ================================================= --}}

            <div class="col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body p-4">


                        {{-- HEADER --}}

                        <div class="d-flex align-items-center mb-4">

                            <div
                                class="rounded-circle d-flex
                                       align-items-center
                                       justify-content-center me-3"
                                style="
                                    width:50px;
                                    height:50px;
                                    background:rgba(140,198,63,.15);
                                "
                            >

                                <i
                                    class="fa-solid fa-truck-fast fs-5"
                                    style="color:#8cc63f;"
                                ></i>

                            </div>


                            <div>

                                <h5 class="fw-bold mb-0">

                                    Standard Shipping

                                </h5>

                                <small class="text-muted">

                                    Default delivery charge

                                </small>

                            </div>

                        </div>


                        {{-- SHIPPING CHARGE --}}

                        <label
                            for="shipping_charge"
                            class="form-label fw-semibold"
                        >

                            Shipping Charge (₹)

                        </label>


                        <div class="input-group mb-2">

                            <span class="input-group-text">

                                ₹

                            </span>


                            <input
                                type="number"
                                name="shipping_charge"
                                id="shipping_charge"
                                class="form-control"
                                min="0"
                                step="0.01"

                                value="{{ old('shipping_charge', $currentShippingCharge) }}"

                                placeholder="Enter shipping charge"

                                required
                            >

                        </div>


                        <small class="text-muted">

                            This amount will be added to eligible customer orders.

                        </small>

                    </div>

                </div>

            </div>



            {{-- ================================================= --}}
            {{-- FREE SHIPPING --}}
            {{-- ================================================= --}}

            <div class="col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body p-4">


                        {{-- HEADER --}}

                        <div class="d-flex align-items-center mb-4">

                            <div
                                class="rounded-circle d-flex
                                       align-items-center
                                       justify-content-center me-3"
                                style="
                                    width:50px;
                                    height:50px;
                                    background:rgba(25,135,84,.10);
                                "
                            >

                                <i
                                    class="fa-solid fa-gift fs-5 text-success"
                                ></i>

                            </div>


                            <div>

                                <h5 class="fw-bold mb-0">

                                    Free Shipping

                                </h5>

                                <small class="text-muted">

                                    Minimum order amount

                                </small>

                            </div>

                        </div>


                        {{-- FREE SHIPPING AMOUNT --}}

                        <label
                            for="free_shipping_amount"
                            class="form-label fw-semibold"
                        >

                            Free Shipping Above (₹)

                        </label>


                        <div class="input-group mb-2">

                            <span class="input-group-text">

                                ₹

                            </span>


                            <input
                                type="number"
                                name="free_shipping_amount"
                                id="free_shipping_amount"
                                class="form-control"
                                min="0"
                                step="0.01"

                                value="{{ old('free_shipping_amount', $currentFreeShippingAmount) }}"

                                placeholder="Enter minimum amount"

                                required
                            >

                        </div>


                        <small class="text-muted">

                            Orders equal to or above this amount get free shipping.

                        </small>

                    </div>

                </div>

            </div>


        </div>



        {{-- ================================================= --}}
        {{-- SAVE CONFIGURATION --}}
        {{-- ================================================= --}}

        <div class="card border-0 shadow-sm rounded-4 mt-4">

            <div class="card-body p-4">

                <div
                    class="d-flex
                           justify-content-between
                           align-items-center
                           flex-wrap
                           gap-3"
                >


                    <div>

                        <h6 class="fw-bold mb-1">

                            Shipping Configuration

                        </h6>

                        <small class="text-muted">

                            Changes will apply to customer checkout.

                        </small>

                    </div>


                    {{-- SAVE BUTTON --}}

                    <button
                        type="submit"
                        class="btn rounded-pill px-4
                               fw-semibold text-white"
                        style="background:#8cc63f;"
                    >

                        <i class="fa-solid fa-save me-2"></i>

                        Save Changes

                    </button>


                </div>

            </div>

        </div>


    </form>

</div>

{{-- ================================================= --}}
{{-- DASHBOARD OVERVIEW --}}
{{-- ================================================= --}}

@else

{{-- ================================================= --}}
{{-- PREMIUM SOFT GREEN DASHBOARD HERO --}}
{{-- ================================================= --}}

<div class="position-relative overflow-hidden rounded-4 mb-4 shadow-sm"
     style="background:linear-gradient(135deg,#ffffff 0%,#f9fbf7 55%,#f1f6eb 100%);
            border:1px solid #e4eadc;">

{{-- ================================================= --}}
{{-- SOFT BACKGROUND GLOW --}}
{{-- ================================================= --}}

<div class="position-absolute top-0 end-0"
     style="width:190px;
            height:190px;
            background:rgba(140,198,63,.10);
            border-radius:50%;
            filter:blur(45px);
            transform:translate(35%,-40%);">
</div>


<div class="position-absolute bottom-0 start-0"
     style="width:130px;
            height:130px;
            background:rgba(140,198,63,.06);
            border-radius:50%;
            filter:blur(35px);
            transform:translate(-35%,40%);">
</div>


{{-- ================================================= --}}
{{-- DECORATIVE ICON --}}
{{-- ================================================= --}}

<div class="position-absolute d-none d-md-flex align-items-center justify-content-center rounded-circle"
     style="right:105px;
            top:50%;
            transform:translateY(-50%);
            width:105px;
            height:105px;
            background:rgba(140,198,63,.07);
            border:1px solid rgba(140,198,63,.16);">

    <div class="d-flex align-items-center justify-content-center rounded-circle"
         style="width:72px;
                height:72px;
                background:#ffffff;
                border:1px solid #e5ecd9;
                box-shadow:0 8px 22px rgba(60,80,40,.08);">

        <i class="fa-solid fa-chart-line"
           style="font-size:27px;
                  color:#8cc63f;">
        </i>

    </div>

</div>


{{-- ================================================= --}}
{{-- MAIN CONTENT --}}
{{-- ================================================= --}}

<div class="position-relative px-4 py-3 px-lg-5"
     style="z-index:2;">

    <div class="d-flex justify-content-between align-items-center">


        {{-- ================================================= --}}
        {{-- LEFT CONTENT --}}
        {{-- ================================================= --}}

        <div>


            {{-- PREMIUM BADGE --}}
            <div class="d-inline-flex align-items-center px-3 py-1 rounded-pill mb-2"
                 style="background:rgba(140,198,63,.10);
                        border:1px solid rgba(140,198,63,.22);">

                <span class="rounded-circle me-2"
                      style="width:7px;
                             height:7px;
                             background:#8cc63f;
                             box-shadow:0 0 8px rgba(140,198,63,.55);">
                </span>

                <span class="fw-bold text-uppercase"
                      style="font-size:.63rem;
                             letter-spacing:1.3px;
                             color:#668f2e;">

                    Admin Dashboard

                </span>

            </div>


            {{-- ================================================= --}}
            {{-- HEADING --}}
            {{-- ================================================= --}}

            <h1 class="fw-bold text-dark mb-1"
                style="font-size:clamp(1.7rem,3vw,2.4rem);
                       letter-spacing:-.9px;">

                Dashboard

                <span style="color:#78ad35;">
                    Overview
                </span>

            </h1>


            {{-- ================================================= --}}
            {{-- DESCRIPTION --}}
            {{-- ================================================= --}}

            <p class="text-secondary small mb-0"
               style="max-width:610px;
                      line-height:1.6;">

                Manage your store, monitor performance and
                keep track of your latest business activity.

            </p>

        </div>


        {{-- ================================================= --}}
        {{-- MOBILE/RIGHT ICON --}}
        {{-- ================================================= --}}

        <div class="d-none d-md-flex align-items-center justify-content-center rounded-4"
             style="width:62px;
                    height:62px;
                    background:#ffffff;
                    border:1px solid #e2e8dc;
                    box-shadow:0 7px 20px rgba(50,70,35,.07);">

            <i class="fa-solid fa-chart-pie"
               style="font-size:24px;
                      color:#8cc63f;">
            </i>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- STATUS ITEMS --}}
    {{-- ================================================= --}}

    <div class="d-flex flex-wrap gap-2 mt-3">


        {{-- STORE ACTIVE --}}
        <div class="d-flex align-items-center gap-2 px-3 py-1 rounded-3 bg-white"
             style="border:1px solid #e5eadf;
                    box-shadow:0 2px 7px rgba(0,0,0,.025);">

            <span class="rounded-circle"
                  style="width:7px;
                         height:7px;
                         background:#8cc63f;
                         box-shadow:0 0 6px rgba(140,198,63,.5);">
            </span>

            <span class="small fw-semibold text-dark">
                Store Active
            </span>

        </div>


        {{-- PERFORMANCE --}}
        <div class="d-flex align-items-center gap-2 px-3 py-1 rounded-3 bg-white"
             style="border:1px solid #e5eadf;
                    box-shadow:0 2px 7px rgba(0,0,0,.025);">

            <i class="fa-solid fa-chart-simple"
               style="font-size:12px;
                      color:#8cc63f;">
            </i>

            <span class="small text-secondary">
                Performance Analytics
            </span>

        </div>


        {{-- SECURITY --}}
        <div class="d-flex align-items-center gap-2 px-3 py-1 rounded-3 bg-white"
             style="border:1px solid #e5eadf;
                    box-shadow:0 2px 7px rgba(0,0,0,.025);">

            <i class="fa-solid fa-shield-halved"
               style="font-size:12px;
                      color:#6f8f45;">
            </i>

            <span class="small text-secondary">
                Secure Admin Panel
            </span>

        </div>


        {{-- LIVE --}}
        <div class="d-flex align-items-center gap-2 px-3 py-1 rounded-3"
             style="background:#f5f9ef;
                    border:1px solid #e1ebd2;">

            <i class="fa-solid fa-circle-check"
               style="font-size:12px;
                      color:#8cc63f;">
            </i>

            <span class="small fw-semibold"
                  style="color:#668f2e;">

                Live Monitoring

            </span>

        </div>

    </div>

</div>


</div>

{{-- ================================================= --}}
{{-- TOTAL REVENUE CALCULATION --}}
{{-- ================================================= --}}

@php

    $totalRevenue = $orders
        ->where('status', '!=', 'cancelled')
        ->sum('total_amount');

@endphp


{{-- ================================================= --}}
{{-- STATS --}}
{{-- ================================================= --}}

<div class="row g-4 mb-5">


    {{-- TOTAL PRODUCTS --}}
    <div class="col-sm-6 col-lg">

        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 h-100 position-relative overflow-hidden">

            <div class="d-flex justify-content-between align-items-start">

                <div>

                    <span class="text-muted text-uppercase small fw-semibold">
                        Total Products
                    </span>

                    <h3 class="fw-bold mt-2 mb-1">
                        {{ $totalProducts }}
                    </h3>

                    <small class="text-muted">
                        Products in catalog
                    </small>

                </div>

                <div class="rounded-4 d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background-color:rgba(140,198,63,.12);">

                    <i class="fa-solid fa-box"
                       style="color:#8cc63f;font-size:20px;"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- TOTAL USERS --}}
    <div class="col-sm-6 col-lg">

        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 h-100">

            <div class="d-flex justify-content-between align-items-start">

                <div>

                    <span class="text-muted text-uppercase small fw-semibold">
                        Total Users
                    </span>

                    <h3 class="fw-bold mt-2 mb-1">
                        {{ $totalUsers }}
                    </h3>

                    <small class="text-muted">
                        Registered customers
                    </small>

                </div>

                <div class="rounded-4 d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background-color:rgba(233,179,106,.15);">

                    <i class="fa-solid fa-users"
                       style="color:#e9b36a;font-size:20px;"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- CATEGORIES --}}
    <div class="col-sm-6 col-lg">

        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 h-100">

            <div class="d-flex justify-content-between align-items-start">

                <div>

                    <span class="text-muted text-uppercase small fw-semibold">
                        Categories
                    </span>

                    <h3 class="fw-bold mt-2 mb-1">
                        {{ $categories->count() }}
                    </h3>

                    <small class="text-muted">
                        Product categories
                    </small>

                </div>

                <div class="rounded-4 d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background-color:rgba(140,198,63,.12);">

                    <i class="fa-solid fa-layer-group"
                       style="color:#8cc63f;font-size:20px;"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- ACTIVE ORDERS --}}
    <div class="col-sm-6 col-lg">

        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 h-100">

            <div class="d-flex justify-content-between align-items-start">

                <div>

                    <span class="text-muted text-uppercase small fw-semibold">
                        Active Orders
                    </span>

                    <h3 class="fw-bold mt-2 mb-1">
                        {{ $activeOrders }}
                    </h3>

                    <small class="text-muted">
                        Orders in progress
                    </small>

                </div>

                <div class="rounded-4 d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background-color:rgba(233,179,106,.15);">

                    <i class="fa-solid fa-cart-shopping"
                       style="color:#e9b36a;font-size:20px;"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- TOTAL REVENUE --}}
    <div class="col-sm-6 col-lg">

        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 h-100">

            <div class="d-flex justify-content-between align-items-start">

                <div>

                    <span class="text-muted text-uppercase small fw-semibold">
                        Total Revenue
                    </span>

                    <h3 class="fw-bold mt-2 mb-1">
                        ₹{{ number_format($totalRevenue, 2) }}
                    </h3>

                    <small class="text-muted">
                        Excluding cancelled orders
                    </small>

                </div>

                <div class="rounded-4 d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background-color:rgba(140,198,63,.12);">

                    <i class="fa-solid fa-indian-rupee-sign"
                       style="color:#8cc63f;font-size:20px;"></i>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ================================================= --}}
{{-- CHART DATA --}}
{{-- ================================================= --}}

@php

    $monthlyRevenue = [];

    $monthlyOrders = [];

    for ($month = 1; $month <= 12; $month++) {

        $monthlyRevenue[] = $orders
            ->filter(function ($order) use ($month) {

                return $order->created_at
                    && $order->created_at->month == $month
                    && $order->status != 'cancelled';

            })
            ->sum('total_amount');


        $monthlyOrders[] = $orders
            ->filter(function ($order) use ($month) {

                return $order->created_at
                    && $order->created_at->month == $month;

            })
            ->count();

    }

@endphp


{{-- ================================================= --}}
{{-- CHARTS --}}
{{-- ================================================= --}}

<div class="row g-4 mb-5">


    {{-- ================================================= --}}
    {{-- REVENUE CHART --}}
    {{-- ================================================= --}}

    <div class="col-lg-7">

        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 h-100">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <div class="d-flex align-items-center gap-2">

                        <h5 class="fw-bold mb-0">
                            Revenue Overview
                        </h5>

                        <span class="badge rounded-pill"
                              style="background-color:rgba(140,198,63,.12);color:#8cc63f;">
                            LIVE DATA
                        </span>

                    </div>

                    <small class="text-muted">
                        Monthly revenue performance
                    </small>

                </div>

                <div class="rounded-4 d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background-color:rgba(140,198,63,.12);">

                    <i class="fa-solid fa-chart-line"
                       style="color:#8cc63f;font-size:20px;"></i>

                </div>

            </div>

            <div style="height:300px;">

                <canvas id="revenueChart"></canvas>

            </div>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- ORDERS CHART --}}
    {{-- ================================================= --}}

    <div class="col-lg-5">

        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 h-100">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <div class="d-flex align-items-center gap-2">

                        <h5 class="fw-bold mb-0">
                            Orders Overview
                        </h5>

                        <span class="badge rounded-pill"
                              style="background-color:rgba(233,179,106,.15);color:#c4873a;">
                            ACTIVITY
                        </span>

                    </div>

                    <small class="text-muted">
                        Monthly order activity
                    </small>

                </div>

                <div class="rounded-4 d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background-color:rgba(233,179,106,.15);">

                    <i class="fa-solid fa-cart-shopping"
                       style="color:#e9b36a;font-size:19px;"></i>

                </div>

            </div>

            <div style="height:300px;">

                <canvas id="ordersChart"></canvas>

            </div>

        </div>

    </div>

</div>


{{-- ================================================= --}}
{{-- CHART.JS --}}
{{-- ================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    document.addEventListener('DOMContentLoaded', function () {


        /* ================================================= */
        /* MONTH LABELS */
        /* ================================================= */

        const monthLabels = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ];


        /* ================================================= */
        /* REVENUE DATA */
        /* ================================================= */

        const revenueData = [
            {{ implode(',', $monthlyRevenue) }}
        ];


        /* ================================================= */
        /* ORDER DATA */
        /* ================================================= */

        const orderData = [
            {{ implode(',', $monthlyOrders) }}
        ];


        /* ================================================= */
        /* REVENUE CHART */
        /* ================================================= */

        const revenueCanvas =
            document.getElementById('revenueChart');


        if (revenueCanvas) {

            const revenueContext =
                revenueCanvas.getContext('2d');


            const revenueGradient =
                revenueContext.createLinearGradient(
                    0,
                    0,
                    0,
                    300
                );


            revenueGradient.addColorStop(
                0,
                'rgba(140,198,63,.30)'
            );


            revenueGradient.addColorStop(
                1,
                'rgba(140,198,63,.02)'
            );


            new Chart(
                revenueCanvas,
                {

                    type: 'line',

                    data: {

                        labels: monthLabels,

                        datasets: [{

                            label: 'Revenue',

                            data: revenueData,

                            borderColor: '#8cc63f',

                            backgroundColor:
                                revenueGradient,

                            borderWidth: 3,

                            tension: .45,

                            fill: true,

                            pointRadius: 4,

                            pointHoverRadius: 7,

                            pointBorderWidth: 2,

                            pointBackgroundColor: '#ffffff',

                            pointBorderColor: '#8cc63f'

                        }]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        interaction: {

                            intersect: false,

                            mode: 'index'

                        },

                        plugins: {

                            legend: {

                                display: false

                            },

                            tooltip: {

                                backgroundColor: '#17200f',

                                titleColor: '#ffffff',

                                bodyColor: '#ffffff',

                                padding: 12,

                                cornerRadius: 10,

                                displayColors: false,

                                callbacks: {

                                    label: function(context) {

                                        return ' ₹' +
                                            Number(context.raw)
                                                .toLocaleString('en-IN');

                                    }

                                }

                            }

                        },

                        scales: {

                            x: {

                                grid: {

                                    display: false

                                },

                                ticks: {

                                    color: '#6c757d'

                                }

                            },

                            y: {

                                beginAtZero: true,

                                grid: {

                                    color:
                                        'rgba(0,0,0,.05)'

                                },

                                ticks: {

                                    color: '#6c757d',

                                    callback: function(value) {

                                        return '₹' +
                                            Number(value)
                                                .toLocaleString('en-IN');

                                    }

                                }

                            }

                        }

                    }

                }
            );

        }


        /* ================================================= */
        /* ORDERS CHART */
        /* ================================================= */

        const ordersCanvas =
            document.getElementById('ordersChart');


        if (ordersCanvas) {

            new Chart(
                ordersCanvas,
                {

                    type: 'bar',

                    data: {

                        labels: monthLabels,

                        datasets: [{

                            label: 'Orders',

                            data: orderData,

                            backgroundColor:
                                'rgba(233,179,106,.75)',

                            borderColor:
                                '#e9b36a',

                            borderWidth: 1,

                            borderRadius: 8,

                            borderSkipped: false,

                            barThickness: 18

                        }]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        plugins: {

                            legend: {

                                display: false

                            },

                            tooltip: {

                                backgroundColor: '#17200f',

                                titleColor: '#ffffff',

                                bodyColor: '#ffffff',

                                padding: 12,

                                cornerRadius: 10,

                                displayColors: false,

                                callbacks: {

                                    label: function(context) {

                                        return ' Orders: ' +
                                            context.raw;

                                    }

                                }

                            }

                        },

                        scales: {

                            x: {

                                grid: {

                                    display: false

                                },

                                ticks: {

                                    color: '#6c757d'

                                }

                            },

                            y: {

                                beginAtZero: true,

                                grid: {

                                    color:
                                        'rgba(0,0,0,.05)'

                                },

                                ticks: {

                                    precision: 0,

                                    color: '#6c757d'

                                }

                            }

                        }

                    }

                }
            );

        }

    });

</script>



{{-- ================================================= --}}
{{-- QUICK ACTIONS --}}
{{-- ================================================= --}}

<div class="card border-0 rounded-4 shadow-sm bg-white p-4">

    <h5 class="fw-bold mb-4">
        Quick Actions
    </h5>

    <div class="d-flex flex-wrap gap-3">

        {{-- ADD PRODUCT --}}
        <a href="{{ route('admin.dashboard',['page'=>'add-product']) }}"
           class="btn text-white rounded-pill px-4 py-2 fw-bold"
           style="background-color:#8cc63f;">

            <i class="fa-solid fa-plus me-1"></i>
            Add New Product

        </a>


        {{-- MANAGE PRODUCTS --}}
        <a href="{{ route('admin.dashboard',['page'=>'manage-products']) }}"
           class="btn btn-light border rounded-pill px-4 py-2">

            <i class="fa-solid fa-list me-1"></i>
            Manage Products

        </a>


        {{-- CATEGORIES --}}
        <a href="{{ route('admin.dashboard',['page'=>'categories']) }}"
           class="btn btn-light border rounded-pill px-4 py-2">

            <i class="fa-solid fa-layer-group me-1"></i>
            Categories

        </a>


        {{-- STOCK MANAGEMENT --}}
        <a href="{{ route('admin.dashboard',['page'=>'stock-management']) }}"
           class="btn btn-light border rounded-pill px-4 py-2">

            <i class="fa-solid fa-boxes-stacked me-1"></i>
            Stock Management

        </a>


        {{-- VIEW ORDERS --}}
        <a href="{{ route('admin.dashboard',['page'=>'view-orders']) }}"
           class="btn btn-light border rounded-pill px-4 py-2">

            <i class="fa-solid fa-cart-shopping me-1"></i>
            View Orders

        </a>


        {{-- ENQUIRIES --}}
        <a href="{{ route('admin.dashboard',['page'=>'enquiries']) }}"
           class="btn btn-light border rounded-pill px-4 py-2">

            <i class="fa-solid fa-envelope me-1"></i>
            Enquiries

        </a>


        {{-- COUPONS --}}
        <a href="{{ route('admin.dashboard',['page'=>'coupons']) }}"
           class="btn btn-light border rounded-pill px-4 py-2">

            <i class="fa-solid fa-ticket me-1"></i>
            Coupons

        </a>


        {{-- WEBSITE VISITORS --}}
        <a href="{{ route('admin.dashboard',['page'=>'website-visitors']) }}"
           class="btn btn-light border rounded-pill px-4 py-2">

            <i class="fa-solid fa-users me-1"></i>
            Website Visitors

        </a>


        {{-- REPORTS --}}
        <a href="{{ route('admin.dashboard',['page'=>'reports']) }}"
           class="btn btn-light border rounded-pill px-4 py-2">

            <i class="fa-solid fa-chart-line me-1"></i>
            Reports

        </a>


        {{-- USER MANAGEMENT --}}
        <a href="{{ route('admin.dashboard',['page'=>'user-management']) }}"
           class="btn btn-light border rounded-pill px-4 py-2">

            <i class="fa-solid fa-user-gear me-1"></i>
            User Management

        </a>


        {{-- SETTINGS --}}
        <a href="{{ route('admin.dashboard',['page'=>'settings']) }}"
           class="btn btn-light border rounded-pill px-4 py-2">

            <i class="fa-solid fa-gear me-1"></i>
            Settings

        </a>


        {{-- SHIPPING CHARGES --}}
        <a href="{{ route('admin.dashboard',['page'=>'shipping-charges']) }}"
           class="btn btn-light border rounded-pill px-4 py-2">

            <i class="fa-solid fa-truck-fast me-1"></i>
            Shipping Charges

        </a>


        {{-- TWO FACTOR AUTHENTICATION --}}
        <a href="{{ route('admin.dashboard',['page'=>'two-factor']) }}"
           class="btn btn-light border rounded-pill px-4 py-2">

            <i class="fa-solid fa-shield-halved me-1"></i>
            Two-Factor Authentication

        </a>


        {{-- EXPORT --}}
        <a href="{{ route('admin.backup') }}"
           class="btn btn-light border rounded-pill px-4 py-2">

            <i class="fa-solid fa-file-export me-1"></i>
            Export

        </a>

    </div>

</div>
@endif
</script>
{{-- ========================================================= --}}
{{-- NEW ORDER NOTIFICATION --}}
{{-- ========================================================= --}}

@if(isset($newOrderCount) && $newOrderCount > 0)

    <div id="orderNotification"
         class="position-fixed top-0 end-0 p-3"
         style="
            z-index:9999;
            width:380px;
            max-width:95%;
         ">

        <div class="alert alert-success shadow-lg border-0 rounded-4 mb-0">

            <div class="d-flex align-items-start">

                {{-- ICON --}}

                <div class="me-3">

                    <div class="bg-success text-white rounded-circle
                                d-flex align-items-center justify-content-center"
                         style="
                            width:50px;
                            height:50px;
                         ">

                        <i class="fa-solid fa-bell fa-lg"></i>

                    </div>

                </div>


                {{-- MESSAGE --}}

                <div class="flex-grow-1">

                    <h5 class="fw-bold mb-1">

                        New Order Received!

                    </h5>

                    <p class="mb-2 small">

                        You have

                        <strong>
                            {{ $newOrderCount }}
                        </strong>

                        new order(s).

                    </p>


                    {{-- VIEW ORDERS --}}

                    <a href="{{ route('admin.dashboard', [
                                'page' => 'view-orders'
                            ]) }}"
                       class="btn btn-success btn-sm rounded-pill">

                        <i class="fa-solid fa-eye me-1"></i>

                        View Orders

                    </a>

                </div>


                {{-- CLOSE BUTTON --}}

                <button type="button"
                        class="btn-close"
                        onclick="closeOrderNotification()">
                </button>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- ORDER SOUND --}}
    {{-- ========================================================= --}}

    <audio id="orderSound" preload="auto">

        <source
            src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3"
            type="audio/mpeg">

    </audio>


    <script>

        document.addEventListener(
            "DOMContentLoaded",
            function () {

                // ==========================================
                // PLAY SOUND
                // ==========================================

                const sound =
                    document.getElementById("orderSound");

                if (sound) {

                    sound.volume = 1.0;

                    sound.play().catch(function () {

                        console.log(
                            "Browser blocked automatic sound."
                        );

                    });

                }


                // ==========================================
                // MARK NOTIFICATION AS SEEN
                // ==========================================

                fetch(
                    "{{ route('admin.orders.notifications.seen') }}",
                    {

                        method: "POST",

                        headers: {

                            "X-CSRF-TOKEN":
                                "{{ csrf_token() }}",

                            "Accept":
                                "application/json"

                        }

                    }
                );


                // ==========================================
                // AUTO CLOSE AFTER 5 SECONDS
                // ==========================================

                setTimeout(
                    function () {

                        closeOrderNotification();

                    },
                    5000
                );

            });


        // ==============================================
        // CLOSE NOTIFICATION
        // ==============================================

        function closeOrderNotification() {

            const notification =
                document.getElementById(
                    "orderNotification"
                );

            if (notification) {

                notification.style.transition =
                    "opacity 0.5s ease";

                notification.style.opacity = "0";


                setTimeout(
                    function () {

                        notification.remove();

                    },
                    500
                );

            }

        }

    </script>
{{-- ========================================================= --}}
{{-- ADMIN ENQUIRY NOTIFICATION POPUP --}}
{{-- ========================================================= --}}

<div id="enquiryPopup"
     style="
        display:none;
        position:fixed;
        top:90px;
        right:25px;
        width:390px;
        max-width:calc(100% - 30px);
        z-index:999999;
     ">

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

        {{-- HEADER --}}
        <div class="p-3 text-white d-flex justify-content-between align-items-center"
             style="background:#8cc63f;">

            <div>

                <div class="fw-bold">

                    <i class="fa-solid fa-bell me-2"></i>

                    New Enquiry

                    <span id="enquiryNotificationBadge"
                          class="badge bg-danger ms-2"
                          style="display:none;">
                        0
                    </span>

                </div>

                <small>
                    New customer message received
                </small>

            </div>


            <button type="button"
                    onclick="hideEnquiryPopup()"
                    class="btn btn-sm text-white border-0">

                <i class="fa-solid fa-xmark fs-5"></i>

            </button>

        </div>


        {{-- CONTENT --}}
        <div id="enquiryPopupContent"
             class="p-4 bg-white">
        </div>


        {{-- FOOTER --}}
        <div class="p-3 border-top bg-white text-center">

            <a href="{{ route('admin.dashboard', ['page' => 'enquiries']) }}"
               class="btn rounded-pill px-4 text-white"
               style="background:#8cc63f;">

                <i class="fa-solid fa-envelope-open me-1"></i>

                View Enquiries

            </a>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>

(function () {

    "use strict";


    console.log(
        "🔔 ADMIN ENQUIRY NOTIFICATION STARTED"
    );


    // ========================================================
    // VARIABLES
    // ========================================================

    let lastKnownIds = [];

    let firstCheck = true;

    let checking = false;

    let popupTimer = null;


    // ========================================================
    // AUDIO VARIABLES
    // ========================================================

    let audioContext = null;

    let audioUnlocked = false;


    // ========================================================
    // ELEMENTS
    // ========================================================

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


    // ========================================================
    // CHECK ELEMENTS
    // ========================================================

    console.log(
        "Popup element:",
        popup
    );


    console.log(
        "Popup content:",
        popupContent
    );


    console.log(
        "🔊 Audio system: Browser generated sound"
    );


    // ========================================================
    // CREATE AUDIO CONTEXT
    // ========================================================

    function createAudioContext()
    {

        if (audioContext)
        {
            return audioContext;
        }


        const AudioContext =
            window.AudioContext ||
            window.webkitAudioContext;


        if (!AudioContext)
        {

            console.error(
                "❌ Web Audio API not supported"
            );

            return null;

        }


        audioContext =
            new AudioContext();


        return audioContext;

    }


    // ========================================================
    // UNLOCK SOUND
    // ========================================================

    function unlockSound()
    {

        const ctx =
            createAudioContext();


        if (!ctx)
        {
            return;
        }


        if (
            ctx.state ===
            "suspended"
        )
        {

            ctx.resume()
                .then(function ()
                {

                    audioUnlocked =
                        true;


                    console.log(
                        "🔊 Notification sound unlocked"
                    );

                })
                .catch(function (error)
                {

                    console.log(
                        "❌ Audio unlock error:",
                        error
                    );

                });

        }
        else
        {

            audioUnlocked =
                true;


            console.log(
                "🔊 Notification sound ready"
            );

        }

    }


    // ========================================================
    // BROWSER USER INTERACTION
    // ========================================================

    document.addEventListener(
        "click",
        unlockSound,
        {
            once: true
        }
    );


    document.addEventListener(
        "touchstart",
        unlockSound,
        {
            once: true
        }
    );


    document.addEventListener(
        "keydown",
        unlockSound,
        {
            once: true
        }
    );


    // ========================================================
    // PROFESSIONAL NOTIFICATION SOUND
    // ========================================================

    window.playSound =
        function ()
        {

            console.log(
                "🔊 PLAYING PROFESSIONAL NOTIFICATION SOUND"
            );


            const ctx =
                createAudioContext();


            if (!ctx)
            {
                return;
            }


            // ------------------------------------------------
            // Resume audio
            // ------------------------------------------------

            if (
                ctx.state ===
                "suspended"
            )
            {

                ctx.resume();

            }


            const now =
                ctx.currentTime;


            // =================================================
            // FIRST TONE
            // =================================================

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


            gain1.gain.setValueAtTime(
                0.001,
                now
            );


            gain1.gain.linearRampToValueAtTime(
                0.28,
                now + 0.03
            );


            gain1.gain.exponentialRampToValueAtTime(
                0.001,
                now + 0.30
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
                now + 0.32
            );


            // =================================================
            // SECOND TONE
            // =================================================

            const oscillator2 =
                ctx.createOscillator();


            const gain2 =
                ctx.createGain();


            oscillator2.type =
                "sine";


            oscillator2.frequency.setValueAtTime(
                1174,
                now + 0.17
            );


            gain2.gain.setValueAtTime(
                0.001,
                now + 0.17
            );


            gain2.gain.linearRampToValueAtTime(
                0.23,
                now + 0.21
            );


            gain2.gain.exponentialRampToValueAtTime(
                0.001,
                now + 0.52
            );


            oscillator2.connect(
                gain2
            );


            gain2.connect(
                ctx.destination
            );


            oscillator2.start(
                now + 0.17
            );


            oscillator2.stop(
                now + 0.54
            );


            // =================================================
            // SMALL THIRD TONE
            // =================================================

            const oscillator3 =
                ctx.createOscillator();


            const gain3 =
                ctx.createGain();


            oscillator3.type =
                "sine";


            oscillator3.frequency.setValueAtTime(
                1320,
                now + 0.34
            );


            gain3.gain.setValueAtTime(
                0.001,
                now + 0.34
            );


            gain3.gain.linearRampToValueAtTime(
                0.12,
                now + 0.37
            );


            gain3.gain.exponentialRampToValueAtTime(
                0.001,
                now + 0.62
            );


            oscillator3.connect(
                gain3
            );


            gain3.connect(
                ctx.destination
            );


            oscillator3.start(
                now + 0.34
            );


            oscillator3.stop(
                now + 0.64
            );


            console.log(
                "✅ Professional notification sound played"
            );

        };


    // ========================================================
    // ESCAPE TEXT
    // ========================================================

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


    // ========================================================
    // SHOW POPUP
    // ========================================================

    window.showEnquiryPopup =
        function (enquiry)
        {

            console.log(
                "🚨 SHOW POPUP:",
                enquiry
            );


            if (!popup)
            {

                console.error(
                    "❌ enquiryPopup NOT FOUND"
                );

                return;

            }


            if (!popupContent)
            {

                console.error(
                    "❌ enquiryPopupContent NOT FOUND"
                );

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


            // =================================================
            // POPUP CONTENT
            // =================================================

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

                        <i class="fa-solid fa-user"></i>

                    </div>


                    <div
                        class="flex-grow-1"
                        style="min-width:0;"
                    >

                        <div
                            class="fw-bold fs-5 text-dark"
                            style="word-break:break-word;"
                        >

                            ${name}

                        </div>


                        <div
                            class="small text-muted"
                            style="word-break:break-word;"
                        >

                            <i class="fa-solid fa-envelope me-1"></i>

                            ${email}

                        </div>


                        <div
                            class="mt-3 fw-bold text-dark"
                            style="word-break:break-word;"
                        >

                            <i class="fa-solid fa-pen me-1"></i>

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


                        <div class="small text-muted mt-2">

                            <i class="fa-regular fa-clock me-1"></i>

                            ${createdAt}

                        </div>

                    </div>

                </div>

            `;


            // =================================================
            // SHOW POPUP
            // =================================================

            popup.style.display =
                "block";


            popup.style.opacity =
                "1";


            popup.style.transform =
                "translateX(0)";


            console.log(
                "✅ POPUP DISPLAYED"
            );


            // =================================================
            // 🔊 PLAY SOUND
            // =================================================

            playSound();


            // =================================================
            // AUTO HIDE
            // =================================================

            clearTimeout(
                popupTimer
            );


            popupTimer =
                setTimeout(
                    function ()
                    {

                        hideEnquiryPopup();

                    },
                    15000
                );

        };


    // ========================================================
    // HIDE POPUP
    // ========================================================

    window.hideEnquiryPopup =
        function ()
        {

            if (!popup)
            {
                return;
            }


            popup.style.display =
                "none";


        };


    // ========================================================
    // UPDATE BADGE
    // ========================================================

    function updateBadge(count)
    {

        if (!badge)
        {
            return;
        }


        if (count > 0)
        {

            badge.style.display =
                "inline-block";


            badge.textContent =
                count;

        }
        else
        {

            badge.style.display =
                "none";

        }

    }


    // ========================================================
    // CHECK API
    // ========================================================

    function checkEnquiry()
    {

        if (checking)
        {
            return;
        }


        checking = true;


        console.log(
            "🔍 Checking notification API..."
        );


        fetch(
            "{{ route('admin.enquiry.notification') }}",
            {
                method: "GET",

                headers:
                {
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
            function (response)
            {

                console.log(
                    "API STATUS:",
                    response.status
                );


                if (!response.ok)
                {

                    throw new Error(
                        "HTTP " +
                        response.status
                    );

                }


                return response.json();

            }
        )


        .then(
            function (data)
            {

                console.log(
                    "📩 API DATA:",
                    data
                );


                // =================================================
                // SUCCESS
                // =================================================

                if (!data.success)
                {

                    console.log(
                        "API success false"
                    );


                    firstCheck =
                        false;


                    return;

                }


                // =================================================
                // ENQUIRIES
                // =================================================

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


                console.log(
                    "Unread count:",
                    count
                );


                updateBadge(
                    count
                );


                // =================================================
                // GET IDS
                // =================================================

                const currentIds =
                    enquiries
                        .map(
                            function (item)
                            {

                                return Number(
                                    item.id
                                );

                            }
                        )
                        .filter(
                            function (id)
                            {

                                return !isNaN(
                                    id
                                );

                            }
                        );


                console.log(
                    "Current IDs:",
                    currentIds
                );


                console.log(
                    "Last IDs:",
                    lastKnownIds
                );


                // =================================================
                // FIRST LOAD
                // =================================================

                if (firstCheck)
                {

                    console.log(
                        "🚀 FIRST DASHBOARD CHECK"
                    );


                    /*
                    | Dashboard open करताना
                    | unread enquiry असेल तर
                    | popup + sound
                    */

                    if (
                        enquiries.length > 0
                    )
                    {

                        console.log(
                            "📢 Existing unread enquiry found"
                        );


                        window.showEnquiryPopup(
                            enquiries[0]
                        );

                    }


                    /*
                    | Existing IDs save
                    */

                    lastKnownIds =
                        currentIds;


                    firstCheck =
                        false;


                    return;

                }


                // =================================================
                // FIND NEW IDS
                // =================================================

                const newEnquiries =
                    enquiries.filter(
                        function (item)
                        {

                            const id =
                                Number(
                                    item.id
                                );


                            return (
                                !lastKnownIds.includes(
                                    id
                                )
                            );

                        }
                    );


                console.log(
                    "🆕 NEW ENQUIRIES:",
                    newEnquiries
                );


                // =================================================
                // NEW ENQUIRY
                // =================================================

                if (
                    newEnquiries.length > 0
                )
                {

                    /*
                    | Latest new enquiry
                    */

                    const latest =
                        newEnquiries[0];


                    console.log(
                        "🔔 NEW ENQUIRY FOUND:",
                        latest
                    );


                    /*
                    | SHOW POPUP
                    |
                    | showEnquiryPopup()
                    | automatically sound play करतो
                    */

                    window.showEnquiryPopup(
                        latest
                    );


                    /*
                    | Browser title
                    */

                    document.title =
                        "🔔 New Enquiry";


                    setTimeout(
                        function ()
                        {

                            document.title =
                                "Admin Dashboard";

                        },
                        5000
                    );

                }


                // =================================================
                // SAVE CURRENT IDS
                // =================================================

                lastKnownIds =
                    currentIds;

            }
        )


        .catch(
            function (error)
            {

                console.error(
                    "❌ NOTIFICATION ERROR:",
                    error
                );

            }
        )


        .finally(
            function ()
            {

                checking =
                    false;

            }
        );

    }


    // ========================================================
    // START
    // ========================================================

    function startNotificationSystem()
    {

        console.log(
            "🚀 Starting enquiry notification..."
        );


        /*
        | First check immediately
        */

        checkEnquiry();


        /*
        | Then every 3 seconds
        */

        setInterval(
            function ()
            {

                checkEnquiry();

            },
            3000
        );

    }


    // ========================================================
    // DOM READY
    // ========================================================

    if (
        document.readyState ===
        "loading"
    )
    {

        document.addEventListener(
            "DOMContentLoaded",
            startNotificationSystem
        );

    }
    else
    {

        startNotificationSystem();

    }


})();

</script>
<script>
    // ==========================================
    // 🔊 PROFESSIONAL NOTIFICATION SOUND
    // ==========================================

    let audioContext = null;
    let audioUnlocked = false;

    function unlockNotificationSound() {

        if (audioUnlocked) return;

        const AudioContext = window.AudioContext || window.webkitAudioContext;

        if (!AudioContext) return;

        audioContext = new AudioContext();

        audioContext.resume().then(() => {
            audioUnlocked = true;
            console.log("🔊 Notification sound ready");
        }).catch(error => {
            console.log("Audio unlock failed:", error);
        });
    }


    // Browser मध्ये पहिल्या click नंतर sound enable
    document.addEventListener("click", function () {
        unlockNotificationSound();
    }, { once: true });


    // ==========================================
    // 🔔 PLAY NOTIFICATION SOUND
    // ==========================================

    function playNotificationSound() {

        const AudioContext = window.AudioContext || window.webkitAudioContext;

        if (!AudioContext) return;

        if (!audioContext) {
            audioContext = new AudioContext();
        }

        if (audioContext.state === "suspended") {
            audioContext.resume();
        }

        const now = audioContext.currentTime;


        // First tone
        const oscillator1 = audioContext.createOscillator();
        const gain1 = audioContext.createGain();

        oscillator1.type = "sine";
        oscillator1.frequency.setValueAtTime(880, now);

        gain1.gain.setValueAtTime(0.001, now);
        gain1.gain.linearRampToValueAtTime(0.25, now + 0.03);
        gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.28);

        oscillator1.connect(gain1);
        gain1.connect(audioContext.destination);

        oscillator1.start(now);
        oscillator1.stop(now + 0.3);


        // Second tone
        const oscillator2 = audioContext.createOscillator();
        const gain2 = audioContext.createGain();

        oscillator2.type = "sine";
        oscillator2.frequency.setValueAtTime(1174, now + 0.18);

        gain2.gain.setValueAtTime(0.001, now + 0.18);
        gain2.gain.linearRampToValueAtTime(0.20, now + 0.21);
        gain2.gain.exponentialRampToValueAtTime(0.001, now + 0.50);

        oscillator2.connect(gain2);
        gain2.connect(audioContext.destination);

        oscillator2.start(now + 0.18);
        oscillator2.stop(now + 0.52);
    }
</script>
@endif
@endsection