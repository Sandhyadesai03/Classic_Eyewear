@extends('layout')

@section('title', 'Home')

@section('content')

{{-- =========================================================
     SPLIT HERO BANNER SECTION (CLASSIC STYLE)
========================================================= --}}
<section class="position-relative bg-white overflow-hidden border-bottom">
    <div class="row g-0 align-items-center">
        
        {{-- LEFT SPLIT: EYE VISION CHECK CARD OVERLAY --}}
        <div class="col-lg-6 position-relative bg-light min-vh-75 d-flex align-items-center justify-content-center p-5" style="background: url('https://images.unsplash.com/photo-1574258495973-f010dfbb5371?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat;">
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-25"></div>
            
            {{-- Eye Chart Floating White Box --}}
            <div class="card border-0 shadow-lg p-5 text-center position-relative z-1 bg-white rounded-0" style="max-width: 420px; width: 100%;">
                <h1 class="fw-bold tracking-widest text-dark display-3 mb-1" style="letter-spacing: 8px;">T</h1>
                <h2 class="fw-bold tracking-widest text-dark display-5 mb-1" style="letter-spacing: 12px;">E Y E</h2>
                <h3 class="fw-bold tracking-widest text-dark fs-2 mb-4" style="letter-spacing: 8px;">VISION</h3>
                <p class="text-uppercase tracking-widest fw-bold text-muted small mb-4" style="letter-spacing: 4px;">C H E C K</p>
                <a href="{{ url('/book-exam') }}" class="text-dark text-decoration-none fw-bold small pb-1 border-bottom border-dark d-inline-block tracking-widest" style="letter-spacing: 2px;">
                    BOOK NOW
                </a>
            </div>
        </div>

        {{-- RIGHT SPLIT: MODEL VISION BANNER --}}
        <div class="col-lg-6 position-relative text-white min-vh-75 d-flex align-items-center p-5" style="background: url('https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat;">
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
            
            <div class="container position-relative z-1 py-5 px-lg-5">
                <span class="text-uppercase text-white-50 small tracking-widest d-block mb-2" style="letter-spacing: 3px;">Classic Premium</span>
                <h2 class="display-4 fw-bold text-white mb-3">VISION YOU DESERVE</h2>
                <p class="text-white-50 fs-6 mb-4">Offering you the best service possible with precise optics and artisan frames.</p>
                <a href="{{ url('/shop') }}" class="btn btn-outline-light rounded-0 px-4 py-2 text-uppercase fw-semibold small tracking-widest">
                    View More
                </a>
            </div>
        </div>

    </div>
</section>

{{-- =========================================================
     BROWSE OUR PRODUCTS SECTION
========================================================= --}}
<section class="py-5 bg-white">
    <div class="container text-center py-4">
        <h2 class="fw-bold text-dark display-6 mb-2 tracking-wide">BROWSE OUR PRODUCTS</h2>
        <p class="text-muted small mb-5">Explore our new summer collection</p>

        <div class="row g-4 justify-content-center">
            
            {{-- Product 1 --}}
            <div class="col-md-4">
                <div class="card border-0 bg-transparent text-center h-100 position-relative">
                    <span class="position-absolute top-0 start-50 translate-middle-x badge bg-dark rounded-circle p-3 text-white fw-bold shadow-sm" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; z-index: 2;">sale</span>
                    <div class="bg-light p-4 rounded-4 mb-3 position-relative overflow-hidden" style="min-height: 280px; display: flex; align-items: center; justify-content: center;">
                        <img src="https://images.unsplash.com/photo-1574258495973-f010dfbb5371?auto=format&fit=crop&w=500&q=80" alt="Metal Lennons" class="img-fluid object-fit-contain" style="max-height: 200px;">
                    </div>
                    <h5 class="fw-bold text-dark mb-1 text-uppercase small tracking-widest">METAL LENNON'S</h5>
                    <p class="text-muted small mb-2" style="font-size: 0.75rem;">Cat-Eye / Luxury</p>
                    <div class="text-dark fw-bold small">
                        <span class="text-muted text-decoration-line-through me-2">$199.00</span> $175.00
                    </div>
                </div>
            </div>

            {{-- Product 2 --}}
            <div class="col-md-4">
                <div class="card border-0 bg-transparent text-center h-100">
                    <div class="bg-light p-4 rounded-4 mb-3 position-relative overflow-hidden" style="min-height: 280px; display: flex; align-items: center; justify-content: center;">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSbutqSY01wBHI0L_zLBMGhSAnKAs-6E8QR2HctWv11AA&s" alt="Cat Eyewear" class="img-fluid object-fit-contain" style="max-height: 200px;">
                    </div>
                    <h5 class="fw-bold text-dark mb-1 text-uppercase small tracking-widest">CAT EYEWEAR</h5>
                    <p class="text-muted small mb-2" style="font-size: 0.75rem;">Cat-Eye / Luxury</p>
                    <div class="text-dark fw-bold small">$199.00</div>
                </div>
            </div>

            {{-- Product 3 --}}
            <div class="col-md-4">
                <div class="card border-0 bg-transparent text-center h-100">
                    <div class="bg-light p-4 rounded-4 mb-3 position-relative overflow-hidden" style="min-height: 280px; display: flex; align-items: center; justify-content: center;">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSX0lmaFfYSlR3qUGN1fUzIYvUveOkwlZkRyOPydqplAQ&s=10" alt="Designed Glasses" class="img-fluid object-fit-contain" style="max-height: 200px;">
                    </div>
                    <h5 class="fw-bold text-dark mb-1 text-uppercase small tracking-widest">DESIGNED GLASSES</h5>
                    <p class="text-muted small mb-2" style="font-size: 0.75rem;">Cat-Eye / Luxury</p>
                    <div class="text-dark fw-bold small">$211.00</div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- =========================================================
     BLUE LIGHT OPTICAL LENS FEATURE SECTION
========================================================= --}}
<section class="py-5 bg-white border-top">
    <div class="row g-0 align-items-center">
        
        {{-- Left: Model & Insert Frame Image --}}
        <div class="col-lg-6 position-relative bg-light min-vh-75 d-flex align-items-center justify-content-center p-5" style="background: url('https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat;">
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-10"></div>
            
            <div class="card border-0 shadow-lg p-4 bg-white rounded-0 position-relative z-1 text-center" style="max-width: 385px; width: 100%;">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRylYcNrLtMlzmjSUADKsxL4SUL2KFZAn0NiMFgn4IZeQ&s" alt="Frames Showcase" class="img-fluid object-fit-contain mb-3" style="max-height: 180px;">
                <h4 class="fw-bold tracking-widest text-dark" style="letter-spacing: 4px;">C L A S S I C</h4>
                <p class="text-muted small text-uppercase tracking-widest mb-0" style="font-size: 0.6rem; letter-spacing: 3px;">OPTICAL</p>
            </div>
        </div>

        {{-- Right: Text Details & Feature Bullet Points --}}
        <div class="col-lg-6 p-5 p-lg-5 bg-white">
            <div class="px-lg-5">
                <h2 class="display-6 fw-bold text-dark mb-2">BLUE LIGHT OPTICAL LENS</h2>
                <p class="text-muted small mb-4">Lorem ipsum dolore amet, vivid vel risus sit</p>

                <div class="d-flex align-items-start gap-3 mb-4">
                    <div class="text-dark fs-4"><i class="fa-solid fa-sun"></i></div>
                    <div>
                        <h6 class="fw-bold text-dark text-uppercase small mb-1 tracking-widest">CRAS SODALES ODIO NON LIBERO TINCIDUNT AMET</h6>
                        <p class="text-muted small mb-0">Lorem ipsum dolor sit amet, consectetur sit do</p>
                    </div>
                </div>

                <div class="d-flex align-items-start gap-3 mb-4">
                    <div class="text-dark fs-4"><i class="fa-solid fa-leaf"></i></div>
                    <div>
                        <h6 class="fw-bold text-dark text-uppercase small mb-1 tracking-widest">AMET LOREM IPSUM SODALES ODIO VIVID SIT MOR</h6>
                        <p class="text-muted small mb-0">Lorem ipsum dolor sit amet, consectetur del sint</p>
                    </div>
                </div>

                <a href="{{ url('/shop') }}" class="btn btn-outline-dark rounded-0 px-4 py-2 text-uppercase fw-semibold small tracking-widest mt-3">
                    View More
                </a>
            </div>
        </div>

    </div>
</section>

{{-- =========================================================
     TRENDY MEN'S EYEGLASSES & BLOG POSTS SECTION
========================================================= --}}
<section class="py-5 bg-white border-top">
    <div class="container py-4">
        <div class="row g-4">
            
            {{-- Blog Post 1 --}}
            <div class="col-md-4">
                <div class="card border-0 bg-transparent h-100">
                    <div class="rounded-4 overflow-hidden mb-3 shadow-sm" style="height: 320px;">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQFPUN4Breh1NKPKlmz3tA7T_KnvVqvdkzuj4nWmmEUyA&s=10" alt="Trendy Men's Eyeglasses" class="w-100 h-100 object-fit-cover">
                    </div>
                    <span class="text-muted small text-uppercase tracking-widest d-block mb-1" style="font-size: 0.7rem;">JUL 30, STYLE / VISION</span>
                    <h5 class="fw-bold text-dark mb-2 text-uppercase fs-6 tracking-wide">TRENDY MEN'S EYEGLASSES</h5>
                    <p class="text-muted small mb-0">Convallis convallis tellus id interdum velit laoreet id. Aenean pharetra magna ac placerat</p>
                </div>
            </div>

            {{-- Blog Post 2 --}}
            <div class="col-md-4">
                <div class="card border-0 bg-transparent h-100">
                    <div class="rounded-4 overflow-hidden mb-3 shadow-sm bg-light d-flex align-items-center justify-content-center p-2" style="height: 320px;">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRsjOYFD4DHKhV-jWv1iOy4HuUUS5TdoVN9z6Syd3dVag&s=10" alt="Frames That Suit You" class="img-fluid object-fit-cover w-100 h-100 rounded-3">
                    </div>
                    <span class="text-muted small text-uppercase tracking-widest d-block mb-1" style="font-size: 0.7rem;">JUL 30, STYLE / VISION</span>
                    <h5 class="fw-bold text-dark mb-2 text-uppercase fs-6 tracking-wide">FRAMES THAT SUIT YOU</h5>
                    <p class="text-muted small mb-0">Convallis convallis tellus id interdum velit laoreet id. Aenean pharetra magna ac placerat</p>
                </div>
            </div>

            {{-- Blog Post 3 --}}
            <div class="col-md-4">
                <div class="card border-0 bg-transparent h-100">
                    <div class="rounded-4 overflow-hidden mb-3 shadow-sm" style="height: 320px;">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTg15mfRYCds6lQ84GcEnwUq9iYX2up8CwA-fSZcDwlsg&s=10" alt="Style Your Own Glasses" class="w-100 h-100 object-fit-cover">
                    </div>
                    <span class="text-muted small text-uppercase tracking-widest d-block mb-1" style="font-size: 0.7rem;">JUL 30, STYLE / VISION</span>
                    <h5 class="fw-bold text-dark mb-2 text-uppercase fs-6 tracking-wide">STYLE YOUR OWN GLASSES</h5>
                    <p class="text-muted small mb-0">Convallis convallis tellus id interdum velit laoreet id. Aenean pharetra magna ac placerat</p>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection