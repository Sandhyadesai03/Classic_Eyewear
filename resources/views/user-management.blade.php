@extends('layout')

@section('title', 'User Management')

@section('content')

<div class="container-fluid py-4 bg-light min-vh-100">

    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="mb-4">

            <h2 class="fw-bold mb-1">
                <i class="fas fa-users me-2 text-success"></i>
                User Management
            </h2>

            <p class="text-muted mb-0">
                Manage users and control their page access.
            </p>

        </div>


        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show">

                <i class="fas fa-check-circle me-2"></i>

                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- USERS TABLE --}}
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-dark">

                            <tr>

                                <th>#</th>

                                <th>User</th>

                                <th>Email</th>

                                <th>Phone</th>

                                <th>Role</th>

                                <th>Access</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($users as $index => $user)

                            <tr>

                                {{-- NUMBER --}}
                                <td>
                                    {{ $index + 1 }}
                                </td>


                                {{-- USER --}}
                                <td>

                                    <div class="d-flex align-items-center">

                                        <div class="bg-success text-white
                                                    rounded-circle
                                                    d-flex
                                                    align-items-center
                                                    justify-content-center
                                                    me-3"
                                             style="width:42px;height:42px;">

                                            {{ strtoupper(substr($user->first_name ?? $user->name, 0, 1)) }}

                                        </div>

                                        <div>

                                            <div class="fw-bold">

                                                {{ $user->name }}

                                            </div>

                                            <small class="text-muted">

                                                User ID: {{ $user->id }}

                                            </small>

                                        </div>

                                    </div>

                                </td>


                                {{-- EMAIL --}}
                                <td>

                                    {{ $user->email }}

                                </td>


                                {{-- PHONE --}}
                                <td>

                                    {{ $user->phone ?? 'N/A' }}

                                </td>


                                {{-- ROLE --}}
                                <td>

                                    @if($user->role === 'admin')

                                        <span class="badge bg-danger px-3 py-2">

                                            <i class="fas fa-user-shield me-1"></i>

                                            Admin

                                        </span>

                                    @else

                                        <span class="badge bg-primary px-3 py-2">

                                            <i class="fas fa-user me-1"></i>

                                            User

                                        </span>

                                    @endif

                                </td>


                                {{-- ACCESS --}}
                                <td>

                                    <button type="button"
                                            class="btn btn-success btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#accessModal{{ $user->id }}">

                                        <i class="fas fa-user-lock me-1"></i>

                                        Manage Access

                                    </button>

                                </td>

                            </tr>


                            {{-- ================================================= --}}
                            {{-- ACCESS MODAL --}}
                            {{-- ================================================= --}}

                            <div class="modal fade"
                                 id="accessModal{{ $user->id }}"
                                 tabindex="-1">

                                <div class="modal-dialog modal-dialog-centered">

                                    <div class="modal-content border-0 shadow rounded-4">


                                        {{-- MODAL HEADER --}}
                                        <div class="modal-header bg-dark text-white">

                                            <div>

                                                <h5 class="modal-title fw-bold">

                                                    <i class="fas fa-user-shield me-2"></i>

                                                    Manage Access

                                                </h5>

                                                <small class="text-white-50">

                                                    {{ $user->name }}

                                                </small>

                                            </div>


                                            <button type="button"
                                                    class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal">
                                            </button>

                                        </div>


                                        {{-- FORM --}}
                                        <form method="POST"
                                              action="{{ route('admin.user-management.permissions', $user->id) }}">

                                            @csrf

                                            @method('PUT')


                                            <div class="modal-body p-4">

                                                {{-- ROLE --}}
                                                <h6 class="fw-bold mb-3">
                                                    Select Role
                                                </h6>


                                                <div class="mb-4">

                                                    <div class="form-check mb-2">

                                                        <input class="form-check-input"
                                                               type="radio"
                                                               name="role"
                                                               value="user"
                                                               id="userRole{{ $user->id }}"
                                                               checked>

                                                        <label class="form-check-label"
                                                               for="userRole{{ $user->id }}">

                                                            <i class="fas fa-user me-2"></i>

                                                            User

                                                        </label>

                                                    </div>


                                                    <div class="form-check">

                                                        <input class="form-check-input"
                                                               type="radio"
                                                               name="role"
                                                               value="admin"
                                                               id="adminRole{{ $user->id }}">

                                                        <label class="form-check-label"
                                                               for="adminRole{{ $user->id }}">

                                                            <i class="fas fa-user-shield me-2"></i>

                                                            Admin

                                                        </label>

                                                    </div>

                                                </div>


                                                {{-- PAGE ACCESS --}}
                                                <h6 class="fw-bold mb-3">
                                                    Page Access
                                                </h6>


                                                {{-- DASHBOARD --}}
                                                <div class="form-check border rounded-3 p-3 mb-2">

                                                    <input class="form-check-input ms-0 me-3"
                                                           type="checkbox"
                                                           name="permissions[]"
                                                           value="dashboard"
                                                           id="dashboard{{ $user->id }}">

                                                    <label class="form-check-label fw-semibold"
                                                           for="dashboard{{ $user->id }}">

                                                        <i class="fas fa-chart-line text-success me-2"></i>

                                                        Dashboard

                                                    </label>

                                                </div>


                                                {{-- PRODUCTS --}}
                                                <div class="form-check border rounded-3 p-3 mb-2">

                                                    <input class="form-check-input ms-0 me-3"
                                                           type="checkbox"
                                                           name="permissions[]"
                                                           value="products"
                                                           id="products{{ $user->id }}">

                                                    <label class="form-check-label fw-semibold"
                                                           for="products{{ $user->id }}">

                                                        <i class="fas fa-glasses text-success me-2"></i>

                                                        Products

                                                    </label>

                                                </div>


                                                {{-- STOCK --}}
                                                <div class="form-check border rounded-3 p-3 mb-2">

                                                    <input class="form-check-input ms-0 me-3"
                                                           type="checkbox"
                                                           name="permissions[]"
                                                           value="stock"
                                                           id="stock{{ $user->id }}">

                                                    <label class="form-check-label fw-semibold"
                                                           for="stock{{ $user->id }}">

                                                        <i class="fas fa-boxes-stacked text-success me-2"></i>

                                                        Stock Management

                                                    </label>

                                                </div>


                                                {{-- ORDERS --}}
                                                <div class="form-check border rounded-3 p-3 mb-2">

                                                    <input class="form-check-input ms-0 me-3"
                                                           type="checkbox"
                                                           name="permissions[]"
                                                           value="orders"
                                                           id="orders{{ $user->id }}">

                                                    <label class="form-check-label fw-semibold"
                                                           for="orders{{ $user->id }}">

                                                        <i class="fas fa-shopping-bag text-success me-2"></i>

                                                        Orders

                                                    </label>

                                                </div>


                                                {{-- USER MANAGEMENT --}}
                                                <div class="form-check border rounded-3 p-3 mb-2">

                                                    <input class="form-check-input ms-0 me-3"
                                                           type="checkbox"
                                                           name="permissions[]"
                                                           value="users"
                                                           id="users{{ $user->id }}">

                                                    <label class="form-check-label fw-semibold"
                                                           for="users{{ $user->id }}">

                                                        <i class="fas fa-users text-success me-2"></i>

                                                        User Management

                                                    </label>

                                                </div>


                                                {{-- REPORTS --}}
                                                <div class="form-check border rounded-3 p-3 mb-2">

                                                    <input class="form-check-input ms-0 me-3"
                                                           type="checkbox"
                                                           name="permissions[]"
                                                           value="reports"
                                                           id="reports{{ $user->id }}">

                                                    <label class="form-check-label fw-semibold"
                                                           for="reports{{ $user->id }}">

                                                        <i class="fas fa-chart-pie text-success me-2"></i>

                                                        Reports

                                                    </label>

                                                </div>

                                            </div>


                                            {{-- FOOTER --}}
                                            <div class="modal-footer">

                                                <button type="button"
                                                        class="btn btn-light"
                                                        data-bs-dismiss="modal">

                                                    Cancel

                                                </button>

                                                <button type="submit"
                                                        class="btn btn-success">

                                                    <i class="fas fa-save me-2"></i>

                                                    Save Access

                                                </button>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                            </div>

                            @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center py-5">

                                    <i class="fas fa-users fa-2x text-muted mb-3"></i>

                                    <p class="text-muted mb-0">
                                        No users found.
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

</div>

@endsection