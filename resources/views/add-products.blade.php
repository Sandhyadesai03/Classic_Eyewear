<div class="container-fluid bg-light min-vh-100 py-5">

    {{-- ================= PAGE TITLE ================= --}}
    <div class="text-center mb-4">

        <span class="text-uppercase fw-bold px-3 py-2 rounded-pill text-white d-inline-block mb-2"
              style="background-color:#8cc63f; font-size:0.75rem; letter-spacing:1px;">

            <i class="fa-solid fa-box-open me-2"></i>
            Product Management

        </span>

        <h1 class="fw-bold text-dark mb-2">

            <i class="fa-solid fa-plus-circle me-2"
               style="color:#8cc63f;"></i>

            Add Products

        </h1>

        <p class="text-muted mb-0">
            Add a new product to your eyewear catalog.
        </p>

    </div>


    <div class="row justify-content-center">

        <div class="col-xl-8 col-lg-9 col-md-11">

            {{-- ================= MAIN CARD ================= --}}
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">


                {{-- ================= HEADER ================= --}}
                <div class="p-4 p-md-5 text-white"
                     style="background-color:#8cc63f;">

                    <div class="d-flex align-items-center">

                        <div class="bg-white text-success rounded-circle d-flex align-items-center justify-content-center me-3"
                             style="width:55px;height:55px;">

                            <i class="fa-solid fa-plus fa-lg"></i>

                        </div>

                        <div>

                            <h3 class="fw-bold mb-1">
                                Add New Product
                            </h3>

                            <p class="mb-0 opacity-75">
                                Add a new product to your eyewear catalog.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- ================= FORM BODY ================= --}}
                <div class="card-body p-4 p-md-5 bg-white">

                    <form action="{{ url('/add-products') }}"
                          method="POST"
                          enctype="multipart/form-data"
                          id="addProductForm">

                        @csrf


                        <div class="row g-4">


                            {{-- ================= PRODUCT NAME ================= --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">

                                    <i class="fa-solid fa-tag me-2"
                                       style="color:#8cc63f;"></i>

                                    Product Name

                                </label>

                                <input type="text"
                                       name="name"
                                       class="form-control form-control-lg rounded-3"
                                       placeholder="Enter product name"
                                       value="{{ old('name') }}"
                                       required>

                            </div>


                            {{-- ================= CATEGORY ================= --}}
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


                            {{-- ================= PRICE ================= --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">

                                    <i class="fa-solid fa-indian-rupee-sign me-2"
                                       style="color:#8cc63f;"></i>

                                    Price

                                </label>

                                <input type="number"
                                       name="price"
                                       step="0.01"
                                       min="0"
                                       class="form-control form-control-lg rounded-3"
                                       placeholder="Enter price"
                                       value="{{ old('price') }}"
                                       required>

                            </div>


                            {{-- ================= STOCK ================= --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">

                                    <i class="fa-solid fa-boxes-stacked me-2"
                                       style="color:#8cc63f;"></i>

                                    Stock Quantity

                                </label>

                                <input type="number"
                                       name="stock"
                                       min="0"
                                       class="form-control form-control-lg rounded-3"
                                       placeholder="Enter stock quantity"
                                       value="{{ old('stock', 0) }}"
                                       required>

                                <small class="text-muted">

                                    Enter the number of products available in stock.

                                </small>

                            </div>


                            {{-- ================================================= --}}
                            {{-- PRODUCT IMAGE --}}
                            {{-- ================================================= --}}
                            <div class="col-12">

                                <label class="form-label fw-semibold">

                                    <i class="fa-solid fa-image me-2"
                                       style="color:#8cc63f;"></i>

                                    Product Image

                                </label>


                                {{-- FILE INPUT --}}

                                <input type="file"
                                       name="image"
                                       id="productImage"
                                       class="form-control form-control-lg rounded-3"
                                       accept="image/jpeg,image/jpg,image/png,image/webp">


                                <small class="text-muted d-block mt-2">

                                    <i class="fa-solid fa-circle-info me-1"></i>

                                    JPG, JPEG, PNG or WEBP | Maximum 2MB

                                </small>


                                {{-- ================================================= --}}
                                {{-- IMAGE PREVIEW BOX --}}
                                {{-- ================================================= --}}

                                <div id="imagePreviewContainer"
                                     class="mt-4 d-none">

                                    <div class="card border-0 shadow-sm rounded-4">

                                        <div class="card-body text-center p-4">


                                            {{-- PREVIEW TITLE --}}

                                            <h6 class="fw-bold mb-3">

                                                <i class="fa-solid fa-eye me-2"
                                                   style="color:#8cc63f;"></i>

                                                Image Preview

                                            </h6>


                                            {{-- IMAGE --}}

                                            <div class="d-flex justify-content-center">

                                                <img id="imagePreview"
                                                     src=""
                                                     alt="Product Preview"
                                                     class="rounded-4 border shadow-sm"
                                                     style="
                                                        width:220px;
                                                        height:220px;
                                                        object-fit:cover;
                                                        display:block;
                                                     ">

                                            </div>


                                            {{-- FILE NAME --}}

                                            <div class="mt-3">

                                                <span class="badge bg-light text-dark border px-3 py-2"
                                                      id="imageFileName">

                                                    No image selected

                                                </span>

                                            </div>


                                            {{-- REMOVE IMAGE --}}

                                            <button type="button"
                                                    id="removeImageBtn"
                                                    class="btn btn-outline-danger btn-sm rounded-pill px-3 mt-3">

                                                <i class="fa-solid fa-trash me-1"></i>

                                                Remove Image

                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- ================= DESCRIPTION ================= --}}
                            <div class="col-12">

                                <label class="form-label fw-semibold">

                                    <i class="fa-solid fa-align-left me-2"
                                       style="color:#8cc63f;"></i>

                                    Product Description

                                </label>

                                <textarea name="description"
                                          rows="5"
                                          class="form-control rounded-3"
                                          placeholder="Enter product description..."
                                          required>{{ old('description') }}</textarea>

                            </div>


                            {{-- ================= ERRORS ================= --}}

                            @if($errors->any())

                                <div class="col-12">

                                    <div class="alert alert-danger rounded-3">

                                        <div class="fw-bold mb-2">

                                            <i class="fa-solid fa-circle-exclamation me-2"></i>

                                            Please fix the following:

                                        </div>

                                        <ul class="mb-0">

                                            @foreach($errors->all() as $error)

                                                <li>
                                                    {{ $error }}
                                                </li>

                                            @endforeach

                                        </ul>

                                    </div>

                                </div>

                            @endif


                            {{-- ================= SUCCESS ================= --}}

                            @if(session('success'))

                                <div class="col-12">

                                    <div class="alert alert-success rounded-3">

                                        <i class="fa-solid fa-circle-check me-2"></i>

                                        {{ session('success') }}

                                    </div>

                                </div>

                            @endif


                            {{-- ================= BUTTONS ================= --}}

                            <div class="col-12">

                                <div class="d-flex justify-content-end align-items-center flex-wrap gap-3 pt-2">


                                    {{-- RESET --}}

                                    <button type="reset"
                                            id="resetProductForm"
                                            class="btn btn-outline-secondary rounded-pill px-4 py-2">

                                        <i class="fa-solid fa-rotate-left me-2"></i>

                                        Reset

                                    </button>


                                    {{-- ADD PRODUCT --}}

                                    <button type="submit"
                                            class="btn text-white rounded-pill px-4 py-2 fw-bold shadow-sm"
                                            style="background-color:#8cc63f;">

                                        <i class="fa-solid fa-plus me-2"></i>

                                        Add Product

                                    </button>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>


            {{-- ================= INFORMATION ================= --}}

            <div class="text-center mt-4">

                <p class="text-muted small mb-0">

                    <i class="fa-solid fa-circle-info me-1"
                       style="color:#8cc63f;"></i>

                    After adding a product, it will automatically appear on the Products page.

                </p>

            </div>

        </div>

    </div>

</div>


{{-- ============================================================= --}}
{{-- IMAGE PREVIEW JAVASCRIPT --}}
{{-- ============================================================= --}}

<script>

(function () {

    function initializeProductImagePreview() {

        const imageInput =
            document.getElementById('productImage');

        const previewContainer =
            document.getElementById('imagePreviewContainer');

        const preview =
            document.getElementById('imagePreview');

        const fileName =
            document.getElementById('imageFileName');

        const removeButton =
            document.getElementById('removeImageBtn');

        const resetButton =
            document.getElementById('resetProductForm');


        // If elements are not available, stop

        if (
            !imageInput ||
            !previewContainer ||
            !preview ||
            !fileName
        ) {
            return;
        }


        // IMAGE SELECT

        imageInput.onchange = function () {

            const file = this.files && this.files[0];


            // No file

            if (!file) {

                preview.src = '';

                previewContainer.classList.add('d-none');

                fileName.textContent =
                    'No image selected';

                return;
            }


            // Check image type

            if (!file.type.startsWith('image/')) {

                alert('Please select a valid image file.');

                imageInput.value = '';

                preview.src = '';

                previewContainer.classList.add('d-none');

                return;
            }


            // Check file size - 2MB

            if (file.size > 2 * 1024 * 1024) {

                alert('Image size must be less than 2MB.');

                imageInput.value = '';

                preview.src = '';

                previewContainer.classList.add('d-none');

                return;
            }


            // Show file name

            fileName.textContent = file.name;


            // Create preview

            const reader = new FileReader();


            reader.onload = function (event) {

                preview.src = event.target.result;

                previewContainer.classList.remove('d-none');

            };


            reader.readAsDataURL(file);

        };


        // REMOVE IMAGE

        if (removeButton) {

            removeButton.onclick = function () {

                imageInput.value = '';

                preview.src = '';

                fileName.textContent =
                    'No image selected';

                previewContainer.classList.add('d-none');

            };

        }


        // RESET FORM

        if (resetButton) {

            resetButton.onclick = function () {

                setTimeout(function () {

                    imageInput.value = '';

                    preview.src = '';

                    fileName.textContent =
                        'No image selected';

                    previewContainer.classList.add('d-none');

                }, 50);

            };

        }

    }


    // Initialize when page loads

    if (document.readyState === 'loading') {

        document.addEventListener(
            'DOMContentLoaded',
            initializeProductImagePreview
        );

    } else {

        initializeProductImagePreview();

    }


    // Extra support if dashboard content is dynamically loaded

    setTimeout(
        initializeProductImagePreview,
        300
    );

    setTimeout(
        initializeProductImagePreview,
        1000
    );

})();

</script>