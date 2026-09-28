@extends('layout')

@section('title', 'blog')

@section('content')

<!-- Full-Width Attractive Hero Section -->
<section class="position-relative text-white py-5 overflow-hidden" style="background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTSsbB2B9tfMQP9bsGhU-f3tOvTfoBsgr1HBuBCajvYyQ&s=10') center/cover no-repeat; min-height: 480px; display: flex; align-items: center;">
    <!-- Dark Gradient Overlay for High Contrast and Modern Look -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to right, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.4) 100%);"></div>
    
    <div class="container position-relative z-1 py-5">
        <div class="row">
            <div class="col-lg-7 text-start">
                <span class="text-uppercase fw-bold tracking-widest px-3 py-1 rounded-pill text-white mb-3 d-inline-block shadow-sm" style="background-color: #8cc63f; font-size: 0.75rem; letter-spacing: 2px;">Our Journal & Insights</span>
                <h1 class="fw-bold display-3 mb-3 text-white">Latest Tips & Modern Updates</h1>
                <p class="text-light fs-6 mb-4" style="max-width: 550px; opacity: 0.9;">Discover expert advice on eye health, trending eyewear styles, and professional insights into modern vision collections.</p>
                <div class="d-flex gap-3">
                    <a href="#blog-grid" class="btn text-white rounded-pill px-4 py-2 text-uppercase fw-semibold small tracking-widest shadow" style="background-color: #8cc63f;">Explore Articles</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Grid Section (Clean White Theme & Enhanced Cards) -->
<section id="blog-grid" class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark display-6 mb-2">Explore All Articles</h2>
            <p class="text-muted small">Stay informed with our latest guides and professional updates</p>
        </div>

        <div class="row g-4">
            
            <!-- Blog Post 1 -->
            <div class="col-md-4">
                <div class="card border-0 rounded-4 shadow-sm overflow-hidden h-100 bg-white border">
                    <div class="position-relative overflow-hidden" style="height: 220px;">
                        <img src="https://hop.sg/wp-content/uploads/2025/03/Digital-Eye-Strain-Man-Scrubbing-His-Eyes-After-Prolonged-Screen-Time.png" alt="Blog Post" class="w-100 h-100 object-fit-cover transition-transform">
                        <span class="badge position-absolute top-0 start-0 m-3 text-white fw-bold shadow-sm" style="background-color: #8cc63f; font-size: 0.65rem;">EYE HEALTH</span>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="text-muted small mb-2"><i class="fa-regular fa-calendar-days me-1 text-success"></i> August 10, 2026</div>
                        <h4 class="fw-bold fs-6 text-dark mb-2">Roles of the Eye Vision in Modern Digital Era</h4>
                        <p class="text-muted small mb-4 flex-grow-1">Discover key details on preserving pristine visual health while spending prolonged hours in front of screens.</p>
                        <a href="#" class="text-dark fw-bold text-uppercase small text-decoration-none d-flex align-items-center gap-2 mt-auto" style="font-size: 0.75rem;">
                            Read Article <i class="fa-solid fa-arrow-right" style="color: #8cc63f;"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Blog Post 2 -->
            <div class="col-md-4">
                <div class="card border-0 rounded-4 shadow-sm overflow-hidden h-100 bg-white border">
                    <div class="position-relative overflow-hidden" style="height: 220px;">
                        <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=600&q=80" alt="Blog Post" class="w-100 h-100 object-fit-cover transition-transform">
                        <span class="badge position-absolute top-0 start-0 m-3 text-white fw-bold shadow-sm" style="background-color: #8cc63f; font-size: 0.65rem;">STYLE GUIDE</span>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="text-muted small mb-2"><i class="fa-regular fa-calendar-days me-1 text-success"></i> August 08, 2026</div>
                        <h4 class="fw-bold fs-6 text-dark mb-2">How to Choose the Right Frame for Your Face Shape</h4>
                        <p class="text-muted small mb-4 flex-grow-1">A comprehensive styling guide to finding frames that seamlessly highlight your best facial structures.</p>
                        <a href="#" class="text-dark fw-bold text-uppercase small text-decoration-none d-flex align-items-center gap-2 mt-auto" style="font-size: 0.75rem;">
                            Read Article <i class="fa-solid fa-arrow-right" style="color: #8cc63f;"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Blog Post 3 -->
            <div class="col-md-4">
                <div class="card border-0 rounded-4 shadow-sm overflow-hidden h-100 bg-white border">
                    <div class="position-relative overflow-hidden" style="height: 220px;">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQtW3k0k67ZA-RLN-x1uIcj8MvniRG3sA8PeVdX_EOdz4UHxIqr73rf7N3&s=10" alt="Blog Post" class="w-100 h-100 object-fit-cover transition-transform">
                        <span class="badge position-absolute top-0 start-0 m-3 text-white fw-bold shadow-sm" style="background-color: #8cc63f; font-size: 0.65rem;">TECHNOLOGY</span>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="text-muted small mb-2"><i class="fa-regular fa-calendar-days me-1 text-success"></i> August 05, 2026</div>
                        <h4 class="fw-bold fs-6 text-dark mb-2">The Rise of AI-Powered Smart Glasses</h4>
                        <p class="text-muted small mb-4 flex-grow-1">Exploring how modern technology and lightweight materials are revolutionizing everyday eyewear functionality.</p>
                        <a href="#" class="text-dark fw-bold text-uppercase small text-decoration-none d-flex align-items-center gap-2 mt-auto" style="font-size: 0.75rem;">
                            Read Article <i class="fa-solid fa-arrow-right" style="color: #8cc63f;"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Blog Post 4 -->
            <div class="col-md-4">
                <div class="card border-0 rounded-4 shadow-sm overflow-hidden h-100 bg-white border">
                    <div class="position-relative overflow-hidden" style="height: 220px;">
                        <img src="https://images.unsplash.com/photo-1574258495973-f010dfbb5371?auto=format&fit=crop&w=600&q=80" alt="Blog Post" class="w-100 h-100 object-fit-cover transition-transform">
                        <span class="badge position-absolute top-0 start-0 m-3 text-white fw-bold shadow-sm" style="background-color: #8cc63f; font-size: 0.65rem;">COMMUNITY</span>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="text-muted small mb-2"><i class="fa-regular fa-calendar-days me-1 text-success"></i> August 01, 2026</div>
                        <h4 class="fw-bold fs-6 text-dark mb-2">Inside The See Vision Club Community</h4>
                        <p class="text-muted small mb-4 flex-grow-1">Take a look at what perks, free eye exams, and private events are waiting for our loyal members.</p>
                        <a href="#" class="text-dark fw-bold text-uppercase small text-decoration-none d-flex align-items-center gap-2 mt-auto" style="font-size: 0.75rem;">
                            Read Article <i class="fa-solid fa-arrow-right" style="color: #8cc63f;"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Blog Post 5 -->
            <div class="col-md-4">
                <div class="card border-0 rounded-4 shadow-sm overflow-hidden h-100 bg-white border">
                    <div class="position-relative overflow-hidden" style="height: 220px;">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSanSQeYxW5DkB0K3o4YeOzK1n5rh5pTkmINyYiRyGL9w&s=10" alt="Blog Post" class="w-100 h-100 object-fit-cover transition-transform">
                        <span class="badge position-absolute top-0 start-0 m-3 text-white fw-bold shadow-sm" style="background-color: #8cc63f; font-size: 0.65rem;">TRENDS</span>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="text-muted small mb-2"><i class="fa-regular fa-calendar-days me-1 text-success"></i> July 28, 2026</div>
                        <h4 class="fw-bold fs-6 text-dark mb-2">Top 5 Eyewear Trends Dominating This Year</h4>
                        <p class="text-muted small mb-4 flex-grow-1">From vintage browlines to oversized crystal silhouettes, see which frames are turning heads.</p>
                        <a href="#" class="text-dark fw-bold text-uppercase small text-decoration-none d-flex align-items-center gap-2 mt-auto" style="font-size: 0.75rem;">
                            Read Article <i class="fa-solid fa-arrow-right" style="color: #8cc63f;"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Blog Post 6 -->
            <div class="col-md-4">
                <div class="card border-0 rounded-4 shadow-sm overflow-hidden h-100 bg-white border">
                    <div class="position-relative overflow-hidden" style="height: 220px;">
                        <img src="https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=600&q=80" alt="Blog Post" class="w-100 h-100 object-fit-cover transition-transform">
                        <span class="badge position-absolute top-0 start-0 m-3 text-white fw-bold shadow-sm" style="background-color: #8cc63f; font-size: 0.65rem;">CARE</span>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="text-muted small mb-2"><i class="fa-regular fa-calendar-days me-1 text-success"></i> July 24, 2026</div>
                        <h4 class="fw-bold fs-6 text-dark mb-2">Proper Maintenance for Long-Lasting Lenses</h4>
                        <p class="text-muted small mb-4 flex-grow-1">Simple daily habits and cleaning techniques to prevent scratches and keep your vision crystal clear.</p>
                        <a href="#" class="text-dark fw-bold text-uppercase small text-decoration-none d-flex align-items-center gap-2 mt-auto" style="font-size: 0.75rem;">
                            Read Article <i class="fa-solid fa-arrow-right" style="color: #8cc63f;"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection