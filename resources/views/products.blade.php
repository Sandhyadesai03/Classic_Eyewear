@extends('layout')

@section('title', 'Our Products')

@section('content')

{{-- ========================================================= --}}
{{-- HERO BANNER --}}
{{-- ========================================================= --}}

<div class="container-fluid px-0 mb-5">

    <div class="position-relative overflow-hidden text-white"
         style="min-height:550px; background-color:#1a252f;">

        <div class="position-absolute top-0 start-0 w-100 h-100">

            <img
                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSf4aUkrGJvGggNbk7hxyrhLd8IyZO48ZVTfN45lX5xUQ&s=10"
                alt="Eyewear Collection Banner"
                class="w-100 h-100"
                style="object-fit:cover; object-position:center;"
            >

            <div
                class="position-absolute top-0 start-0 w-100 h-100"
                style="
                    background:linear-gradient(
                        to right,
                        rgba(0,0,0,0.85) 0%,
                        rgba(0,0,0,0.6) 60%,
                        rgba(0,0,0,0.3) 100%
                    );
                "
            ></div>

        </div>


        {{-- HERO CONTENT --}}

        <div
            class="container position-relative py-5"
            style="
                z-index:2;
                min-height:550px;
                display:flex;
                align-items:center;
            "
        >

            <div class="row w-100 align-items-center py-5">

                <div class="col-lg-7 text-center text-lg-start">

                    <span
                        class="badge rounded-pill px-3 py-2 mb-3 shadow-sm text-white"
                        style="
                            background-color:#8cc63f;
                            font-weight:700;
                            letter-spacing:0.8px;
                        "
                    >

                        <i class="fa-solid fa-glasses me-2"></i>

                        PREMIUM EYEWEAR COLLECTION

                    </span>


                    <h1
                        class="display-3 fw-bolder mb-3 lh-sm text-white"
                        style="letter-spacing:-0.5px;"
                    >

                        See The World

                        <span style="color:#8cc63f;">
                            Clearly.
                        </span>

                    </h1>


                    <p
                        class="lead text-white fw-bold mb-4 mx-auto mx-lg-0"
                        style="
                            max-width:550px;
                            text-shadow:0 2px 4px rgba(0,0,0,0.5);
                        "
                    >

                        Discover stylish frames, sunglasses and smart glasses
                        designed to match your personality and lifestyle with absolute precision.

                    </p>


                    <div
                        class="d-flex justify-content-center justify-content-lg-start gap-3 flex-wrap"
                    >

                        <a
                            href="#products"
                            class="btn text-white rounded-pill px-4 py-3 fw-bolder shadow"
                            style="
                                background-color:#8cc63f;
                                transition:all 0.3s ease;
                                letter-spacing:0.5px;
                            "
                        >

                            EXPLORE COLLECTION

                            <i class="fa-solid fa-arrow-down ms-2"></i>

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- PRODUCT SECTION --}}
{{-- ========================================================= --}}

<div class="container py-5" id="products">


    {{-- ===================================================== --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ===================================================== --}}

    @if(session('success'))

        <div
            class="alert alert-success alert-dismissible fade show rounded-3 mb-4 shadow-sm border-0"
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



    {{-- ===================================================== --}}
    {{-- ERROR MESSAGE --}}
    {{-- ===================================================== --}}

    @if(session('error'))

        <div
            class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 shadow-sm border-0"
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



    {{-- ===================================================== --}}
    {{-- SECTION HEADING --}}
    {{-- ===================================================== --}}

    <div class="text-center mb-4">

        <span
            class="text-uppercase fw-bold small px-3 py-1 rounded-pill d-inline-block mb-2"
            style="
                color:#8cc63f;
                background-color:#f3f9e9;
                letter-spacing:2px;
            "
        >

            Our Collection

        </span>


        <h2 class="fw-bold display-6 mt-2 mb-2">

            Find Your Perfect Pair

        </h2>


        <p
            class="text-muted mx-auto"
            style="max-width:650px;"
        >

            Explore our carefully selected eyewear collection.
            Stylish designs, comfortable frames and premium quality
            for every occasion.

        </p>

    </div>



    {{-- ===================================================== --}}
    {{-- CATEGORY FILTER --}}
    {{-- ===================================================== --}}

    <div class="d-flex justify-content-center flex-wrap gap-2 mb-5">


        {{-- ALL --}}

        <button
            type="button"
            class="category-filter-btn active"
            data-category="all"
            onclick="filterProducts('all', this)"
            style="
                border:1px solid #8cc63f;
                background-color:#8cc63f;
                color:white;
                border-radius:50px;
                padding:10px 24px;
                font-weight:600;
                cursor:pointer;
            "
        >

            <i class="fa-solid fa-border-all me-2"></i>

            All

        </button>



        {{-- OPTICAL FRAME --}}

        <button
            type="button"
            class="category-filter-btn"
            data-category="Optical Frame"
            onclick="filterProducts('Optical Frame', this)"
            style="
                border:1px solid #dce9c2;
                background-color:#f5f9ec;
                color:#333;
                border-radius:50px;
                padding:10px 24px;
                font-weight:600;
                cursor:pointer;
            "
        >

            <i
                class="fa-solid fa-glasses me-2"
                style="color:#8cc63f;"
            ></i>

            Optical Frame

        </button>



        {{-- SUNGLASSES --}}

        <button
            type="button"
            class="category-filter-btn"
            data-category="Sunglasses"
            onclick="filterProducts('Sunglasses', this)"
            style="
                border:1px solid #dce9c2;
                background-color:#f5f9ec;
                color:#333;
                border-radius:50px;
                padding:10px 24px;
                font-weight:600;
                cursor:pointer;
            "
        >

            <i
                class="fa-solid fa-sun me-2"
                style="color:#e9b36a;"
            ></i>

            Sunglasses

        </button>



        {{-- SMART GLASSES --}}

        <button
            type="button"
            class="category-filter-btn"
            data-category="Smart Glasses"
            onclick="filterProducts('Smart Glasses', this)"
            style="
                border:1px solid #dce9c2;
                background-color:#f5f9ec;
                color:#333;
                border-radius:50px;
                padding:10px 24px;
                font-weight:600;
                cursor:pointer;
            "
        >

            <i
                class="fa-solid fa-microchip me-2"
                style="color:#8cc63f;"
            ></i>

            Smart Glasses

        </button>

    </div>



    {{-- ===================================================== --}}
    {{-- PRODUCTS GRID --}}
    {{-- ===================================================== --}}

    <div class="row g-4" id="productsGrid">

        @forelse($products as $product)

            <div
                class="col-12 col-sm-6 col-lg-4 col-xl-3 product-item"
                data-category="{{ trim($product->category) }}"
            >

                <div
                    class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden product-card"
                    style="
                        transition:transform 0.3s ease,
                        box-shadow 0.3s ease;
                    "
                >


                    {{-- ================================================= --}}
                    {{-- PRODUCT IMAGES --}}
                    {{-- ================================================= --}}

                    <div
                        class="position-relative bg-light overflow-hidden"
                        style="padding:15px;"
                    >


                        {{-- ================================================= --}}
                        {{-- MAIN PRODUCT IMAGE --}}
                        {{-- ================================================= --}}

                        <a
                            href="{{ route('products.show', $product->id) }}"
                            class="text-decoration-none d-block"
                        >

                            <div
                                class="position-relative bg-white rounded-3 overflow-hidden"
                                style="height:280px;"
                            >

                                {{-- MAIN IMAGE --}}

                                @if($product->image)

                                    <img
                                        id="mainProductImage{{ $product->id }}"
                                        src="{{ asset('product-images/' . $product->image) }}"
                                        alt="{{ $product->name }}"
                                        class="w-100 h-100"
                                        style="
                                            object-fit:contain;
                                            transition:opacity 0.2s ease;
                                        "
                                    >

                                @elseif($product->images->count() > 0)

                                    {{-- MULTIPLE IMAGE SUPPORT --}}

                                    <img
                                        id="mainProductImage{{ $product->id }}"
                                        src="{{ asset('product-images/' . $product->images->first()->image) }}"
                                        alt="{{ $product->name }}"
                                        class="w-100 h-100"
                                        style="
                                            object-fit:contain;
                                            transition:opacity 0.2s ease;
                                        "
                                    >

                                @else

                                    <div
                                        class="w-100 h-100 d-flex align-items-center justify-content-center"
                                    >

                                        <i class="fa-solid fa-image fa-3x text-muted"></i>

                                    </div>

                                @endif


                                {{-- CATEGORY --}}

                                <span
                                    class="position-absolute top-0 start-0 m-3 badge rounded-pill px-3 py-2 shadow-sm"
                                    style="
                                        background-color:#8cc63f;
                                        font-weight:500;
                                    "
                                >

                                    {{ $product->category }}

                                </span>


                                {{-- OUT OF STOCK OVERLAY --}}

                                @if($product->stock <= 0)

                                    <div
                                        class="position-absolute top-0 end-0 m-3"
                                    >

                                        <span
                                            class="badge rounded-pill px-3 py-2 shadow-sm"
                                            style="
                                                background-color:#dc3545;
                                                color:#fff;
                                                font-size:12px;
                                            "
                                        >

                                            <i class="fa-solid fa-box-open me-1"></i>

                                            Out of Stock

                                        </span>

                                    </div>

                                @endif

                            </div>

                        </a>



                        {{-- ================================================= --}}
                        {{-- THUMBNAIL IMAGES --}}
                        {{-- ================================================= --}}

                        @if($product->images->count() > 0)

                            <div
                                class="d-flex gap-2 mt-3 pb-1 justify-content-start"
                            >

                                @foreach($product->images->take(5) as $productImage)

                                    <button
                                        type="button"
                                        class="border-0 bg-white p-0 rounded-2 overflow-hidden flex-shrink-0 shadow-sm"
                                        onclick="changeProductImage(
                                            {{ $product->id }},
                                            '{{ asset('product-images/' . $productImage->image) }}'
                                        )"
                                        style="
                                            width:45px;
                                            height:45px;
                                            cursor:pointer;
                                        "
                                    >

                                        <img
                                            src="{{ asset('product-images/' . $productImage->image) }}"
                                            alt="{{ $product->name }}"
                                            class="w-100 h-100"
                                            style="object-fit:cover;"
                                        >

                                    </button>

                                @endforeach

                            </div>

                        @elseif($product->image)

                            {{-- OLD / SINGLE IMAGE PRODUCT --}}

                            <div class="d-flex gap-2 mt-3">

                                <button
                                    type="button"
                                    class="border rounded-2 overflow-hidden shadow-sm bg-white p-0"
                                    onclick="changeProductImage(
                                        {{ $product->id }},
                                        '{{ asset('product-images/' . $product->image) }}'
                                    )"
                                    style="
                                        width:45px;
                                        height:45px;
                                        cursor:pointer;
                                    "
                                >

                                    <img
                                        src="{{ asset('product-images/' . $product->image) }}"
                                        alt="{{ $product->name }}"
                                        class="w-100 h-100"
                                        style="object-fit:cover;"
                                    >

                                </button>

                            </div>

                        @endif

                    </div>



                    {{-- ================================================= --}}
                    {{-- PRODUCT DETAILS --}}
                    {{-- ================================================= --}}

                    <div class="card-body p-4 d-flex flex-column">


                        {{-- PRODUCT NAME --}}

                        <h5 class="fw-bold mb-2">

                            <a
                                href="{{ route('products.show', $product->id) }}"
                                class="text-dark text-decoration-none"
                            >

                                {{ $product->name }}

                            </a>

                        </h5>



                        {{-- PRICE --}}

                        <h5
                            class="fw-bold mb-2"
                            style="color:#8cc63f;"
                        >

                            ₹{{ number_format($product->price, 2) }}

                        </h5>



                        {{-- ================================================= --}}
                        {{-- STOCK STATUS --}}
                        {{-- IMPORTANT:
                             STOCK QUANTITY IS NOT DISPLAYED
                        {{-- ================================================= --}}

                        @if($product->stock <= 0)

                            <span
                                class="badge bg-danger-subtle text-danger rounded-pill align-self-start mb-2 px-3 py-2 fw-normal"
                            >

                                <i class="fa-solid fa-box-open me-1"></i>

                                Out of Stock

                            </span>

                        @else

                            {{-- IN STOCK STATUS --}}
                            <span
                                class="badge bg-success-subtle text-success rounded-pill align-self-start mb-2 px-3 py-2 fw-normal"
                            >

                                <i class="fa-solid fa-circle-check me-1"></i>

                                In Stock

                            </span>

                        @endif



                        {{-- DESCRIPTION --}}

                        <p
                            class="text-muted small mb-4"
                            style="
                                display:-webkit-box;
                                -webkit-line-clamp:2;
                                -webkit-box-orient:vertical;
                                overflow:hidden;
                            "
                        >

                            {{ $product->description }}

                        </p>



                        {{-- ================================================= --}}
                        {{-- VIEW DETAILS --}}
                        {{-- ================================================= --}}

                        <div class="mb-2">

                            <a
                                href="{{ route('products.show', $product->id) }}"
                                class="btn btn-light border w-100 rounded-pill fw-semibold py-2"
                            >

                                <i
                                    class="fa-solid fa-eye me-2"
                                    style="color:#8cc63f;"
                                ></i>

                                View Details

                            </a>

                        </div>



                        {{-- ================================================= --}}
                        {{-- ADD TO CART --}}
                        {{-- ================================================= --}}

                        <div class="mt-2">

                            @if($product->stock > 0)

                                @if(Auth::check())

                                    <form
                                        action="{{ route('cart.add', $product->id) }}"
                                        method="POST"
                                    >

                                        @csrf

                                        <button
                                            type="submit"
                                            class="btn w-100 text-white rounded-pill fw-bold py-2 shadow-sm"
                                            style="
                                                background-color:#8cc63f;
                                                transition:all 0.2s ease;
                                            "
                                        >

                                            <i class="fa-solid fa-cart-shopping me-2"></i>

                                            Add to Cart

                                        </button>

                                    </form>

                                @else

                                    <a
                                        href="{{ route('login') }}"
                                        class="btn w-100 text-white rounded-pill fw-bold py-2 shadow-sm"
                                        style="background-color:#8cc63f;"
                                    >

                                        <i class="fa-solid fa-right-to-bracket me-2"></i>

                                        Login to Add Cart

                                    </a>

                                @endif

                            @else

                                <button
                                    type="button"
                                    class="btn btn-secondary w-100 rounded-pill fw-bold py-2"
                                    disabled
                                >

                                    <i class="fa-solid fa-ban me-2"></i>

                                    Out of Stock

                                </button>

                            @endif

                        </div>

                    </div>

                </div>

            </div>


        @empty


            {{-- ================================================= --}}
            {{-- NO PRODUCTS --}}
            {{-- ================================================= --}}

            <div class="col-12">

                <div class="text-center py-5">

                    <div class="mb-4">

                        <div
                            class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm"
                            style="
                                width:120px;
                                height:120px;
                            "
                        >

                            <i class="fa-solid fa-box-open fa-3x text-muted"></i>

                        </div>

                    </div>


                    <h4 class="fw-bold">

                        No Products Available

                    </h4>


                    <p class="text-muted">

                        Our latest eyewear collection will appear here soon.

                    </p>

                </div>

            </div>

        @endforelse



        {{-- ================================================= --}}
        {{-- NO FILTERED PRODUCTS --}}
        {{-- ================================================= --}}

        <div
            id="noFilteredProducts"
            class="col-12 d-none"
        >

            <div class="text-center py-5">

                <div class="mb-4">

                    <div
                        class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm"
                        style="
                            width:120px;
                            height:120px;
                        "
                    >

                        <i class="fa-solid fa-glasses fa-3x text-muted"></i>

                    </div>

                </div>


                <h4 class="fw-bold">

                    No Products Available

                </h4>


                <p class="text-muted">

                    No products found in this category.

                </p>

            </div>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- WHY CHOOSE US --}}
{{-- ========================================================= --}}

<div class="container pb-5">

    <div
        class="rounded-4 p-4 p-md-5 shadow-sm border border-white"
        style="background-color:#f3f9e9;"
    >

        <div class="row g-4 text-center">


            {{-- PREMIUM QUALITY --}}

            <div class="col-md-4">

                <div
                    class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm"
                    style="
                        width:70px;
                        height:70px;
                    "
                >

                    <i
                        class="fa-solid fa-gem fa-lg"
                        style="color:#8cc63f;"
                    ></i>

                </div>


                <h5 class="fw-bold mb-2">

                    Premium Quality

                </h5>


                <p class="small text-muted mb-0">

                    Carefully selected quality eyewear built for durability and elegance.

                </p>

            </div>



            {{-- FAST DELIVERY --}}

            <div class="col-md-4">

                <div
                    class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm"
                    style="
                        width:70px;
                        height:70px;
                    "
                >

                    <i
                        class="fa-solid fa-truck-fast fa-lg"
                        style="color:#8cc63f;"
                    ></i>

                </div>


                <h5 class="fw-bold mb-2">

                    Fast Delivery

                </h5>


                <p class="small text-muted mb-0">

                    Quick, safe, and reliable doorstep delivery across the country.

                </p>

            </div>



            {{-- CUSTOMER SUPPORT --}}

            <div class="col-md-4">

                <div
                    class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm"
                    style="
                        width:70px;
                        height:70px;
                    "
                >

                    <i
                        class="fa-solid fa-headset fa-lg"
                        style="color:#8cc63f;"
                    ></i>

                </div>


                <h5 class="fw-bold mb-2">

                    Customer Support

                </h5>


                <p class="small text-muted mb-0">

                    Dedicated support team ready to assist you whenever you need us.

                </p>

            </div>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- CATEGORY FILTER + IMAGE SWITCH SCRIPT --}}
{{-- ========================================================= --}}

<script>

function filterProducts(category, clickedButton)
{

    const products =
        document.querySelectorAll('.product-item');

    const noProductsMessage =
        document.getElementById('noFilteredProducts');

    let visibleProducts = 0;


    // ====================================================
    // ACTIVE BUTTON
    // ====================================================

    document.querySelectorAll('.category-filter-btn').forEach(function(button) {

        button.style.backgroundColor = '#f5f9ec';
        button.style.color = '#333';
        button.style.borderColor = '#dce9c2';

    });


    clickedButton.style.backgroundColor = '#8cc63f';
    clickedButton.style.color = '#ffffff';
    clickedButton.style.borderColor = '#8cc63f';


    // ====================================================
    // FILTER PRODUCTS
    // ====================================================

    products.forEach(function(product) {

        const productCategory =
            product.getAttribute('data-category');


        if (
            category === 'all' ||
            productCategory.toLowerCase() === category.toLowerCase()
        ) {

            product.classList.remove('d-none');

            visibleProducts++;

        } else {

            product.classList.add('d-none');

        }

    });


    // ====================================================
    // NO PRODUCT MESSAGE
    // ====================================================

    if (visibleProducts === 0) {

        noProductsMessage.classList.remove('d-none');

    } else {

        noProductsMessage.classList.add('d-none');

    }

}



// ====================================================
// CHANGE PRODUCT IMAGE
// ====================================================

function changeProductImage(productId, imageUrl)
{

    const mainImage =
        document.getElementById('mainProductImage' + productId);


    if (mainImage) {

        mainImage.style.opacity = '0.4';


        setTimeout(function() {

            mainImage.src = imageUrl;

            mainImage.style.opacity = '1';

        }, 120);

    }

}



// ====================================================
// PRODUCT CARD HOVER EFFECT
// ====================================================

document.addEventListener('DOMContentLoaded', function() {

    const cards =
        document.querySelectorAll('.product-card');


    cards.forEach(function(card) {

        card.addEventListener('mouseenter', function() {

            card.style.transform = 'translateY(-6px)';

            card.style.boxShadow =
                '0 12px 30px rgba(0,0,0,0.12)';

        });


        card.addEventListener('mouseleave', function() {

            card.style.transform = 'translateY(0)';

            card.style.boxShadow =
                '0 4px 12px rgba(0,0,0,0.08)';

        });

    });

});

</script>


@endsection