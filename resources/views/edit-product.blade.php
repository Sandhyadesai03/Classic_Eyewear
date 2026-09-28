@extends('layout')

@section('title', 'Edit Product')

@section('content')

<div class="container-fluid bg-light min-vh-100 py-5">

```
{{-- ================= PAGE TITLE ================= --}}
<div class="container mb-4">

    <div class="text-center">

        <span class="text-uppercase fw-bold px-3 py-2 rounded-pill text-white d-inline-block mb-2"
              style="background-color:#8cc63f; font-size:0.75rem; letter-spacing:1px;">

            <i class="fa-solid fa-box-open me-2"></i>
            Product Management

        </span>

        <h1 class="fw-bold text-dark mb-2">

            <i class="fa-solid fa-pen-to-square me-2"
               style="color:#8cc63f;"></i>

            Edit Product

        </h1>

        <p class="text-muted mb-0">
            Update your product information and stock.
        </p>

    </div>

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

                        <i class="fa-solid fa-pen-to-square fa-lg"></i>

                    </div>

                    <div>

                        <h3 class="fw-bold mb-1">
                            Update Product
                        </h3>

                        <p class="mb-0 opacity-75">
                            Edit the details of your selected product.
                        </p>

                    </div>

                </div>

            </div>


            {{-- ================= FORM BODY ================= --}}

            <div class="card-body p-4 p-md-5 bg-white">

                <form action="{{ route('products.update', $product->id) }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    @method('PUT')

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
                                   value="{{ old('name', $product->name) }}"
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

                                <option value="Optical Frame"
                                    {{ old('category', $product->category) == 'Optical Frame' ? 'selected' : '' }}>

                                    Optical Frame

                                </option>

                                <option value="Sunglasses"
                                    {{ old('category', $product->category) == 'Sunglasses' ? 'selected' : '' }}>

                                    Sunglasses

                                </option>

                                <option value="Smart Glasses"
                                    {{ old('category', $product->category) == 'Smart Glasses' ? 'selected' : '' }}>

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
                                   value="{{ old('price', $product->price) }}"
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
                                   value="{{ old('stock', $product->stock) }}"
                                   required>

                            <small class="text-muted">
                                Update the available stock quantity.
                            </small>

                        </div>


                        {{-- ================= CURRENT IMAGE ================= --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                <i class="fa-solid fa-image me-2"
                                   style="color:#8cc63f;"></i>

                                Current Product Image

                            </label>

                            @if($product->image)

                                <div class="mb-3">

                                    <img src="{{ asset('product-images/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="rounded-3 border shadow-sm"
                                         style="width:180px;height:180px;object-fit:cover;">

                                </div>

                            @else

                                <div class="alert alert-secondary rounded-3">

                                    No image available.

                                </div>

                            @endif

                        </div>


                        {{-- ================= NEW IMAGE ================= --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                <i class="fa-solid fa-camera me-2"
                                   style="color:#8cc63f;"></i>

                                Change Product Image

                            </label>

                            <input type="file"
                                   name="image"
                                   id="productImage"
                                   class="form-control form-control-lg rounded-3"
                                   accept="image/jpeg,image/jpg,image/png,image/webp">

                            <small class="text-muted">

                                Leave empty if you want to keep the current image.

                            </small>


                            {{-- NEW IMAGE PREVIEW --}}

                            <div id="imagePreviewContainer"
                                 class="mt-3 d-none">

                                <p class="fw-semibold mb-2">
                                    New Image Preview
                                </p>

                                <img id="imagePreview"
                                     src=""
                                     alt="New Product Preview"
                                     class="rounded-3 border shadow-sm"
                                     style="width:180px;height:180px;object-fit:cover;">

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
                                      required>{{ old('description', $product->description) }}</textarea>

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

                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pt-2">

                                <a href="{{ route('admin.dashboard', ['page' => 'manage-products']) }}"
                                   class="btn btn-outline-secondary rounded-pill px-4 py-2">

                                    <i class="fa-solid fa-arrow-left me-2"></i>

                                    Back to Manage Catalog

                                </a>


                                <button type="submit"
                                        class="btn text-white rounded-pill px-4 py-2 fw-bold shadow-sm"
                                        style="background-color:#8cc63f;">

                                    <i class="fa-solid fa-floppy-disk me-2"></i>

                                    Update Product

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

                Update the product details and click Update Product to save changes.

            </p>

        </div>

    </div>

</div>
```

</div>

{{-- ================= IMAGE PREVIEW SCRIPT ================= --}}

<script>

document.getElementById('productImage').addEventListener('change', function(event) {

    const file = event.target.files[0];

    const previewContainer =
        document.getElementById('imagePreviewContainer');

    const preview =
        document.getElementById('imagePreview');


    if (file) {

        const reader = new FileReader();

        reader.onload = function(e) {

            preview.src = e.target.result;

            previewContainer.classList.remove('d-none');

        };

        reader.readAsDataURL(file);

    } else {

        preview.src = '';

        previewContainer.classList.add('d-none');

    }

});

</script>

@endsection
