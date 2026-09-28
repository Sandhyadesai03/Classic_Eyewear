@extends('layout')

@section('title', $product->name)

@section('content')

<div class="container py-5">

    {{-- ================================================= --}}
    {{-- BACK BUTTON --}}
    {{-- ================================================= --}}

    <div class="mb-4">

        <a href="{{ route('products.index') }}"
           class="btn btn-light rounded-pill px-4"
           style="
                border:1px solid #d4e8b8;
                color:#5f8f22;
           ">

            <i class="fa-solid fa-arrow-left me-2"></i>

            Back to Products

        </a>

    </div>


    {{-- ================================================= --}}
    {{-- PRODUCT DETAILS --}}
    {{-- ================================================= --}}

    <div class="card shadow-sm rounded-4 overflow-hidden"
         style="
            border:2px solid #d4e8b8 !important;
            box-shadow:0 8px 25px rgba(140,198,63,0.10) !important;
         ">

        <div class="card-body p-4 p-lg-5">

            <div class="row g-5">


                {{-- ================================================= --}}
                {{-- LEFT SIDE - IMAGES --}}
                {{-- ================================================= --}}

                <div class="col-lg-6">

                    {{-- MAIN IMAGE --}}

                    <div class="bg-light rounded-4 overflow-hidden mb-3"
                         style="
                            height:500px;
                            border:1px solid #dcebc5;
                            background-color:#fbfdf8 !important;
                         ">

                        @if($product->images->count() > 0)

                            <img id="mainProductImage"
                                 src="{{ asset('product-images/' . $product->images->first()->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-100 h-100"
                                 style="
                                    object-fit:contain;
                                    background:white;
                                    transition:opacity .2s ease;
                                 ">

                        @elseif($product->image)

                            <img id="mainProductImage"
                                 src="{{ asset('product-images/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-100 h-100"
                                 style="
                                    object-fit:contain;
                                    background:white;
                                    transition:opacity .2s ease;
                                 ">

                        @else

                            <div class="w-100 h-100 d-flex align-items-center justify-content-center">

                                <i class="fa-solid fa-image fa-5x text-muted"></i>

                            </div>

                        @endif

                    </div>


                    {{-- ================================================= --}}
                    {{-- IMAGE THUMBNAILS --}}
                    {{-- ================================================= --}}

                    @if($product->images->count() > 0)

                        <div class="d-flex gap-3 overflow-auto pb-2">

                            @foreach($product->images as $productImage)

                                <button type="button"
                                        onclick="changeMainImage(
                                            '{{ asset('product-images/' . $productImage->image) }}'
                                        )"
                                        class="btn p-0 bg-white rounded-3 shadow-sm flex-shrink-0"
                                        style="
                                            width:90px;
                                            height:90px;
                                            overflow:hidden;
                                            border:2px solid #d4e8b8 !important;
                                        ">

                                    <img src="{{ asset('product-images/' . $productImage->image) }}"
                                         alt="{{ $product->name }}"
                                         class="w-100 h-100"
                                         style="object-fit:cover;">

                                </button>

                            @endforeach

                        </div>

                    @elseif($product->image)

                        <div class="d-flex gap-3">

                            <div class="rounded-3 overflow-hidden"
                                 style="
                                    width:90px;
                                    height:90px;
                                    border:2px solid #d4e8b8;
                                 ">

                                <img src="{{ asset('product-images/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-100 h-100"
                                     style="object-fit:cover;">

                            </div>

                        </div>

                    @endif

                </div>


                {{-- ================================================= --}}
                {{-- RIGHT SIDE - PRODUCT INFORMATION --}}
                {{-- ================================================= --}}

                <div class="col-lg-6">

                    {{-- CATEGORY --}}

                    <span class="badge rounded-pill px-3 py-2 mb-3"
                          style="
                            background-color:#8cc63f;
                            border:1px solid #78ad32;
                          ">

                        {{ $product->category }}

                    </span>


                    {{-- PRODUCT NAME --}}

                    <h1 class="fw-bold display-6 text-dark mb-3">

                        {{ $product->name }}

                    </h1>


                    {{-- ================================================= --}}
                    {{-- ACTUAL PRODUCT RATING --}}
                    {{-- ================================================= --}}

                    @php
                        $reviewCount = $product->reviews->count();

                        $averageRating = $reviewCount > 0
                            ? round($product->reviews->avg('rating'), 1)
                            : 0;
                    @endphp

                    <div class="mb-3">

                        @if($reviewCount > 0)

                            @for($i = 1; $i <= 5; $i++)

                                @if($i <= round($averageRating))

                                    <i class="fa-solid fa-star"
                                       style="color:#ffc107;"></i>

                                @else

                                    <i class="fa-regular fa-star"
                                       style="color:#ffc107;"></i>

                                @endif

                            @endfor

                            <span class="fw-semibold ms-2">

                                {{ number_format($averageRating, 1) }}

                            </span>

                            <small class="text-muted ms-1">

                                ({{ $reviewCount }}
                                {{ $reviewCount == 1 ? 'Review' : 'Reviews' }})

                            </small>

                        @else

                            <span class="text-muted small">

                                No reviews yet

                            </span>

                        @endif

                    </div>


                    {{-- PRICE --}}

                    <h2 class="fw-bold mb-4"
                        style="color:#8cc63f;">

                        ₹{{ number_format($product->price, 2) }}

                    </h2>


                    {{-- DESCRIPTION --}}

                    <div class="py-4 mb-4"
                         style="
                            border-top:1px solid #d4e8b8;
                            border-bottom:1px solid #d4e8b8;
                         ">

                        <h5 class="fw-bold mb-3">

                            Product Description

                        </h5>

                        <p class="text-muted mb-0"
                           style="line-height:1.8;">

                            {{ $product->description }}

                        </p>

                    </div>


                    {{-- STOCK --}}

                    @if($product->stock > 0)

                        <div class="mb-4">

                            <span class="badge rounded-pill px-3 py-2"
                                  style="
                                    background-color:#eef7df;
                                    color:#5f8f22;
                                    border:1px solid #d4e8b8;
                                  ">

                                <i class="fa-solid fa-box me-2"></i>

                                In Stock: {{ $product->stock }}

                            </span>

                        </div>

                    @else

                        <div class="mb-4">

                            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">

                                <i class="fa-solid fa-box-open me-2"></i>

                                Out of Stock

                            </span>

                        </div>

                    @endif


                    {{-- ================================================= --}}
                    {{-- ADD TO CART --}}
                    {{-- ================================================= --}}

                    @if($product->stock > 0)

                        @if(Auth::check())

                            <form action="{{ route('cart.add', $product->id) }}"
                                  method="POST">

                                @csrf

                                <button type="submit"
                                        class="btn text-white rounded-pill fw-bold px-5 py-3 shadow-sm"
                                        style="
                                            background-color:#8cc63f;
                                            border:1px solid #78ad32;
                                        ">

                                    <i class="fa-solid fa-cart-shopping me-2"></i>

                                    Add to Cart

                                </button>

                            </form>

                        @else

                            <a href="{{ route('login') }}"
                               class="btn text-white rounded-pill fw-bold px-5 py-3 shadow-sm"
                               style="
                                    background-color:#8cc63f;
                                    border:1px solid #78ad32;
                               ">

                                <i class="fa-solid fa-right-to-bracket me-2"></i>

                                Login to Add Cart

                            </a>

                        @endif

                    @else

                        <button type="button"
                                class="btn btn-secondary rounded-pill fw-bold px-5 py-3"
                                disabled>

                            <i class="fa-solid fa-ban me-2"></i>

                            Out of Stock

                        </button>

                    @endif

                </div>

            </div>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- CUSTOMER REVIEWS --}}
    {{-- ================================================= --}}

    <div class="card mt-5 shadow-sm rounded-4"
         style="
            border:2px solid #d4e8b8 !important;
            box-shadow:0 8px 25px rgba(140,198,63,0.08) !important;
         ">

        <div class="card-body p-4 p-lg-5">

            {{-- REVIEW HEADING --}}

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                <div>

                    <span class="badge rounded-pill px-3 py-2 mb-2"
                          style="
                            background-color:#eef7df;
                            color:#5f8f22;
                            border:1px solid #d4e8b8;
                          ">

                        <i class="fa-solid fa-comments me-1"></i>

                        Customer Feedback

                    </span>

                    <h3 class="fw-bold mb-1">

                        Customer Reviews

                    </h3>

                    <p class="text-muted mb-0">

                        See what our customers say about this product.

                    </p>

                </div>


                {{-- AVERAGE RATING --}}

                @if($reviewCount > 0)

                    <div class="text-center px-4 py-3 rounded-4"
                         style="
                            background-color:#f8fbf3;
                            border:1px solid #d4e8b8;
                         ">

                        <h3 class="fw-bold mb-0"
                            style="color:#5f8f22;">

                            {{ number_format($averageRating, 1) }}

                        </h3>

                        <div>

                            @for($i = 1; $i <= 5; $i++)

                                @if($i <= round($averageRating))

                                    <i class="fa-solid fa-star"
                                       style="color:#ffc107;"></i>

                                @else

                                    <i class="fa-regular fa-star"
                                       style="color:#ffc107;"></i>

                                @endif

                            @endfor

                        </div>

                        <small class="text-muted">

                            {{ $reviewCount }}
                            {{ $reviewCount == 1 ? 'Review' : 'Reviews' }}

                        </small>

                    </div>

                @endif

            </div>


            {{-- ================================================= --}}
            {{-- SUCCESS MESSAGE --}}
            {{-- ================================================= --}}

            @if(session('success'))

                <div class="alert alert-success rounded-3 border-0 shadow-sm">

                    <i class="fa-solid fa-circle-check me-2"></i>

                    {{ session('success') }}

                </div>

            @endif


            {{-- ================================================= --}}
            {{-- ERROR MESSAGE --}}
            {{-- ================================================= --}}

            @if(session('error'))

                <div class="alert alert-danger rounded-3 border-0 shadow-sm">

                    <i class="fa-solid fa-circle-exclamation me-2"></i>

                    {{ session('error') }}

                </div>

            @endif


            <div class="row g-4">


                {{-- ================================================= --}}
                {{-- EXISTING REVIEWS --}}
                {{-- ================================================= --}}

                <div class="col-lg-7">

                    @if($reviewCount > 0)

                        @foreach($product->reviews->sortByDesc('created_at') as $review)

                            <div class="p-4 mb-3 rounded-4"
                                 style="
                                    background-color:#fbfdf8;
                                    border:1px solid #dcebc5;
                                 ">

                                <div class="d-flex justify-content-between align-items-start gap-3">

                                    <div>

                                        <h6 class="fw-bold mb-1">

                                            <i class="fa-solid fa-circle-user me-2"
                                               style="color:#8cc63f;"></i>

                                            {{ $review->user->name ?? 'Customer' }}

                                        </h6>

                                        <small class="text-muted">

                                            {{ $review->created_at->format('d M Y') }}

                                        </small>

                                    </div>


                                    {{-- USER RATING --}}

                                    <div class="text-nowrap">

                                        @for($i = 1; $i <= 5; $i++)

                                            @if($i <= $review->rating)

                                                <i class="fa-solid fa-star"
                                                   style="color:#ffc107;"></i>

                                            @else

                                                <i class="fa-regular fa-star"
                                                   style="color:#ffc107;"></i>

                                            @endif

                                        @endfor

                                    </div>

                                </div>


                                @if($review->review)

                                    <p class="text-muted mb-0 mt-3"
                                       style="line-height:1.7;">

                                        "{{ $review->review }}"

                                    </p>

                                @endif

                            </div>

                        @endforeach

                    @else

                        <div class="text-center py-5 rounded-4"
                             style="
                                background-color:#fbfdf8;
                                border:1px dashed #c9dfa8;
                             ">

                            <i class="fa-regular fa-comment-dots fa-3x mb-3"
                               style="color:#8cc63f;"></i>

                            <h5 class="fw-bold">

                                No Reviews Yet

                            </h5>

                            <p class="text-muted mb-0">

                                Be the first customer to review this product.

                            </p>

                        </div>

                    @endif

                </div>


                {{-- ================================================= --}}
                {{-- WRITE REVIEW --}}
                {{-- ================================================= --}}

                <div class="col-lg-5">

                    <div class="rounded-4 p-4"
                         style="
                            background-color:#f8fbf3;
                            border:1px solid #d4e8b8;
                         ">

                        <h5 class="fw-bold mb-1">

                            Write a Review

                        </h5>

                        <p class="text-muted small mb-4">

                            Share your experience with this product.

                        </p>


                        @if(Auth::check())

                            {{-- CHECK PURCHASE --}}

                            @php

                                $hasPurchased = \App\Models\OrderItem::where(
                                    'product_id',
                                    $product->id
                                )
                                ->whereHas('order', function($query) {

                                    $query->where(
                                        'user_id',
                                        auth()->id()
                                    )
                                    ->whereIn('status', [
                                        'Pending',
                                        'Processing',
                                        'Shipped',
                                        'Delivered'
                                    ]);

                                })
                                ->exists();

                                $alreadyReviewed = $product->reviews
                                    ->where('user_id', auth()->id())
                                    ->count() > 0;

                            @endphp


                            @if($hasPurchased && !$alreadyReviewed)

                                <form action="{{ route('products.review', $product->id) }}"
                                      method="POST">

                                    @csrf


                                    {{-- STAR RATING --}}

                                    <label class="form-label fw-semibold">

                                        Your Rating

                                    </label>

                                    <div class="mb-4">

                                        <div class="d-flex gap-2">

                                            @for($i = 1; $i <= 5; $i++)

                                                <button
                                                    type="button"
                                                    class="rating-star btn p-0"
                                                    data-rating="{{ $i }}"
                                                    onclick="selectRating({{ $i }})"
                                                    style="
                                                        font-size:30px;
                                                        color:#d6d6d6;
                                                        border:0;
                                                        background:transparent;
                                                    ">

                                                    <i class="fa-solid fa-star"></i>

                                                </button>

                                            @endfor

                                        </div>

                                        <input type="hidden"
                                               name="rating"
                                               id="selectedRating"
                                               value=""
                                               required>

                                        <small id="ratingText"
                                               class="text-muted">

                                            Select your rating

                                        </small>

                                    </div>


                                    {{-- REVIEW TEXT --}}

                                    <div class="mb-4">

                                        <label class="form-label fw-semibold">

                                            Your Review

                                        </label>

                                        <textarea
                                            name="review"
                                            rows="5"
                                            class="form-control rounded-3"
                                            placeholder="Write your experience with this product..."
                                            style="border:1px solid #d4e8b8;"></textarea>

                                    </div>


                                    {{-- SUBMIT --}}

                                    <button type="submit"
                                            class="btn text-white rounded-pill fw-bold px-4 py-2"
                                            style="
                                                background-color:#8cc63f;
                                                border:1px solid #78ad32;
                                            ">

                                        <i class="fa-solid fa-paper-plane me-2"></i>

                                        Submit Review

                                    </button>

                                </form>


                            @elseif($alreadyReviewed)

                                <div class="text-center py-4">

                                    <i class="fa-solid fa-circle-check fa-2x mb-3"
                                       style="color:#8cc63f;"></i>

                                    <h6 class="fw-bold">

                                        Thank You for Your Review!

                                    </h6>

                                    <p class="text-muted small mb-0">

                                        You have already reviewed this product.

                                    </p>

                                </div>


                            @else

                                <div class="text-center py-4">

                                    <i class="fa-solid fa-lock fa-2x mb-3"
                                       style="color:#8cc63f;"></i>

                                    <h6 class="fw-bold">

                                        Purchase Required

                                    </h6>

                                    <p class="text-muted small mb-0">

                                        Only customers who purchased this product
                                        can submit a review.

                                    </p>

                                </div>

                            @endif


                        @else

                            {{-- NOT LOGGED IN --}}

                            <div class="text-center py-4">

                                <i class="fa-solid fa-user-lock fa-2x mb-3"
                                   style="color:#8cc63f;"></i>

                                <h6 class="fw-bold">

                                    Login to Review

                                </h6>

                                <p class="text-muted small mb-3">

                                    Please login and purchase this product
                                    before submitting a review.

                                </p>

                                <a href="{{ route('login') }}"
                                   class="btn text-white rounded-pill px-4"
                                   style="background-color:#8cc63f;">

                                    <i class="fa-solid fa-right-to-bracket me-2"></i>

                                    Login

                                </a>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ================================================= --}}
{{-- IMAGE CHANGE + RATING SCRIPT --}}
{{-- ================================================= --}}

<script>

function changeMainImage(imageUrl)
{
    const mainImage =
        document.getElementById('mainProductImage');

    if (mainImage) {

        mainImage.style.opacity = '0';

        setTimeout(function() {

            mainImage.src = imageUrl;

            mainImage.onload = function() {

                mainImage.style.opacity = '1';

            };

        }, 150);

    }
}


// ====================================================
// SELECT RATING
// ====================================================

function selectRating(rating)
{
    const stars =
        document.querySelectorAll('.rating-star');

    const ratingInput =
        document.getElementById('selectedRating');

    const ratingText =
        document.getElementById('ratingText');

    if (ratingInput) {

        ratingInput.value = rating;

    }

    stars.forEach(function(star, index) {

        const starNumber = index + 1;

        if (starNumber <= rating) {

            star.style.color = '#ffc107';

        } else {

            star.style.color = '#d6d6d6';

        }

    });


    if (ratingText) {

        const ratingNames = {
            1: 'Poor',
            2: 'Fair',
            3: 'Good',
            4: 'Very Good',
            5: 'Excellent'
        };

        ratingText.innerText =
            rating + ' Star - ' + ratingNames[rating];

        ratingText.style.color = '#5f8f22';

    }

}

</script>

@endsection