{{-- ========================================================= --}}
{{-- MANAGE PRODUCTS --}}
{{-- ========================================================= --}}

<div class="container-fluid py-4">

    {{-- ========================================================= --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ========================================================= --}}

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show shadow-sm">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- ERROR MESSAGE --}}
    {{-- ========================================================= --}}

    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show shadow-sm">

            <i class="bi bi-exclamation-circle-fill me-2"></i>

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- VALIDATION ERRORS --}}
    {{-- ========================================================= --}}

    @if($errors->any())

        <div class="alert alert-danger shadow-sm">

            <strong>
                Please fix the following errors:
            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Manage Products
            </h3>

            <p class="text-muted mb-0">
                All Products
            </p>

        </div>


        <a href="{{ route('admin.dashboard', ['page' => 'add-product']) }}"
           class="btn btn-primary">

            <i class="bi bi-plus-lg me-2"></i>

            Add Product

        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- PRODUCT TABLE --}}
    {{-- ========================================================= --}}

    @if($products->count() > 0)

        <div class="card border-0 shadow-sm">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        {{-- ================================================= --}}
                        {{-- TABLE HEADER --}}
                        {{-- ================================================= --}}

                        <thead class="table-light">

                            <tr>

                                <th class="px-3 py-3">
                                    #
                                </th>

                                <th class="py-3">
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
                                    Description
                                </th>

                                <th class="py-3 text-center">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        {{-- ================================================= --}}
                        {{-- TABLE BODY --}}
                        {{-- ================================================= --}}

                        <tbody>

                            @foreach($products as $product)

                                {{-- ============================================= --}}
                                {{-- PRODUCT ROW --}}
                                {{-- ============================================= --}}

                                <tr>

                                    {{-- ID --}}

                                    <td class="px-3">

                                        <span class="text-muted">
                                            #{{ $product->id }}
                                        </span>

                                    </td>


                                    {{-- PRODUCT IMAGE + NAME --}}

                                    <td>

                                        <div class="d-flex align-items-center gap-3">

                                            @if($product->image)

                                                <img src="{{ asset('product-images/' . $product->image) }}"
                                                     alt="{{ $product->name }}"
                                                     class="rounded"
                                                     style="
                                                        width:55px;
                                                        height:55px;
                                                        object-fit:cover;
                                                     ">

                                            @else

                                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                     style="
                                                        width:55px;
                                                        height:55px;
                                                     ">

                                                    <i class="bi bi-image text-muted"></i>

                                                </div>

                                            @endif


                                            <div>

                                                <div class="fw-semibold">
                                                    {{ $product->name }}
                                                </div>

                                                <small class="text-muted">
                                                    Product
                                                </small>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- CATEGORY --}}

                                    <td>

                                        <span class="badge bg-secondary">

                                            {{ $product->category }}

                                        </span>

                                    </td>


                                    {{-- PRICE --}}

                                    <td>

                                        <span class="fw-semibold text-success">

                                            ₹{{ number_format($product->price, 2) }}

                                        </span>

                                    </td>


                                    {{-- STOCK --}}

                                    <td>

                                        @if($product->stock > 0)

                                            <span class="badge bg-success">

                                                {{ $product->stock }}

                                            </span>

                                        @else

                                            <span class="badge bg-danger">

                                                Out of Stock

                                            </span>

                                        @endif

                                    </td>


                                    {{-- DESCRIPTION --}}

                                    <td style="min-width:220px;">

                                        <span class="text-muted">

                                            {{ \Illuminate\Support\Str::limit($product->description, 70) }}

                                        </span>

                                    </td>


                                    {{-- ACTIONS --}}

                                    <td>

                                        <div class="d-flex justify-content-center gap-2">

                                            {{-- EDIT --}}

                                            <button type="button"
                                                    class="btn btn-sm btn-primary"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#editProduct{{ $product->id }}"
                                                    title="Edit Product">

                                                <i class="bi bi-pencil-square"></i>

                                            </button>


                                            {{-- DELETE --}}

                                            <form action="{{ route('products.destroy', $product->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this product?');">

                                                @csrf

                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        title="Delete Product">

                                                    <i class="bi bi-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>


                                {{-- ================================================= --}}
                                {{-- INLINE EDIT ROW --}}
                                {{-- ================================================= --}}

                                <tr>

                                    <td colspan="7" class="p-0">

                                        <div class="collapse"
                                             id="editProduct{{ $product->id }}">

                                            <div class="bg-light border-top border-bottom p-4">

                                                {{-- EDIT HEADER --}}

                                                <div class="d-flex justify-content-between align-items-center mb-4">

                                                    <div>

                                                        <h5 class="fw-bold mb-1">

                                                            <i class="bi bi-pencil-square me-2"></i>

                                                            Edit Product

                                                        </h5>

                                                        <small class="text-muted">

                                                            Update
                                                            {{ $product->name }}

                                                        </small>

                                                    </div>


                                                    <button type="button"
                                                            class="btn-close"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#editProduct{{ $product->id }}">
                                                    </button>

                                                </div>


                                                {{-- EDIT FORM --}}

                                                <form action="{{ route('products.update', $product->id) }}"
                                                      method="POST"
                                                      enctype="multipart/form-data">

                                                    @csrf

                                                    @method('PUT')


                                                    <div class="row g-3">


                                                        {{-- NAME --}}

                                                        <div class="col-md-4">

                                                            <label class="form-label fw-semibold">

                                                                Product Name

                                                            </label>

                                                            <input type="text"
                                                                   name="name"
                                                                   value="{{ $product->name }}"
                                                                   class="form-control"
                                                                   required>

                                                        </div>


                                                        {{-- CATEGORY --}}

                                                        <div class="col-md-4">

                                                            <label class="form-label fw-semibold">

                                                                Category

                                                            </label>

                                                            <input type="text"
                                                                   name="category"
                                                                   value="{{ $product->category }}"
                                                                   class="form-control"
                                                                   required>

                                                        </div>


                                                        {{-- PRICE --}}

                                                        <div class="col-md-2">

                                                            <label class="form-label fw-semibold">

                                                                Price

                                                            </label>

                                                            <input type="number"
                                                                   name="price"
                                                                   value="{{ $product->price }}"
                                                                   class="form-control"
                                                                   step="0.01"
                                                                   min="0"
                                                                   required>

                                                        </div>


                                                        {{-- STOCK --}}

                                                        <div class="col-md-2">

                                                            <label class="form-label fw-semibold">

                                                                Stock

                                                            </label>

                                                            <input type="number"
                                                                   name="stock"
                                                                   value="{{ $product->stock }}"
                                                                   class="form-control"
                                                                   min="0"
                                                                   required>

                                                        </div>


                                                        {{-- DESCRIPTION --}}

                                                        <div class="col-md-8">

                                                            <label class="form-label fw-semibold">

                                                                Description

                                                            </label>

                                                            <textarea name="description"
                                                                      rows="3"
                                                                      class="form-control"
                                                                      required>{{ $product->description }}</textarea>

                                                        </div>


                                                        {{-- IMAGE --}}

                                                        <div class="col-md-4">

                                                            <label class="form-label fw-semibold">

                                                                Change Image

                                                            </label>

                                                            <input type="file"
                                                                   name="image"
                                                                   class="form-control"
                                                                   accept=".jpg,.jpeg,.png,.webp">


                                                            @if($product->image)

                                                                <div class="mt-2 d-flex align-items-center gap-2">

                                                                    <small class="text-muted">
                                                                        Current:
                                                                    </small>

                                                                    <img src="{{ asset('product-images/' . $product->image) }}"
                                                                         alt="{{ $product->name }}"
                                                                         class="rounded"
                                                                         style="
                                                                            width:50px;
                                                                            height:50px;
                                                                            object-fit:cover;
                                                                         ">

                                                                </div>

                                                            @endif

                                                        </div>


                                                        {{-- BUTTONS --}}

                                                        <div class="col-12">

                                                            <div class="d-flex gap-2">

                                                                {{-- UPDATE --}}

                                                                <button type="submit"
                                                                        class="btn btn-success px-4">

                                                                    <i class="bi bi-check-lg me-2"></i>

                                                                    Update Product

                                                                </button>


                                                                {{-- CANCEL --}}

                                                                <button type="button"
                                                                        class="btn btn-secondary px-4"
                                                                        data-bs-toggle="collapse"
                                                                        data-bs-target="#editProduct{{ $product->id }}">

                                                                    <i class="bi bi-x-lg me-2"></i>

                                                                    Cancel

                                                                </button>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </form>

                                            </div>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    @else

        {{-- ========================================================= --}}
        {{-- NO PRODUCTS --}}
        {{-- ========================================================= --}}

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center py-5">

                <i class="bi bi-box-seam display-3 text-muted"></i>

                <h4 class="fw-bold mt-3">
                    No Products Found
                </h4>

                <p class="text-muted">
                    Add your first product to manage it here.
                </p>

                <a href="{{ route('admin.dashboard', ['page' => 'add-product']) }}"
                   class="btn btn-primary">

                    <i class="bi bi-plus-lg me-2"></i>

                    Add Product

                </a>

            </div>

        </div>

    @endif

</div>