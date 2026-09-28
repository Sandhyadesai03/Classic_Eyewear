@extends('layout')

@section('title', 'Admin - Enquiries')

@section('content')

<div class="container-fluid py-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Customer Enquiries
            </h3>

            <p class="text-muted small mb-0">
                Manage customer enquiries and replies.
            </p>
        </div>

        <div>
            <span class="badge rounded-pill px-3 py-2"
                  style="background-color:#8cc63f;">
                {{ $enquiries->count() }} Enquiries
            </span>
        </div>

    </div>


    <!-- Success Message -->
    @if(session('success'))

        <div class="alert alert-success rounded-4 border-0 shadow-sm">

            <i class="fa-solid fa-circle-check me-2"></i>

            {{ session('success') }}

        </div>

    @endif


    <!-- Enquiries -->

    @forelse($enquiries as $enquiry)

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body p-4">

                <!-- Customer Details -->

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <h5 class="fw-bold mb-1">
                            {{ $enquiry->subject }}
                        </h5>

                        <p class="text-muted small mb-0">

                            <i class="fa-solid fa-user me-1"></i>

                            {{ $enquiry->name }}

                            &nbsp; | &nbsp;

                            <i class="fa-solid fa-envelope me-1"></i>

                            {{ $enquiry->email }}

                        </p>

                    </div>


                    <!-- Status -->

                    @if($enquiry->status == 'pending')

                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2">

                            <i class="fa-solid fa-clock me-1"></i>

                            Pending

                        </span>

                    @elseif($enquiry->status == 'replied')

                        <span class="badge bg-success rounded-pill px-3 py-2">

                            <i class="fa-solid fa-check me-1"></i>

                            Replied

                        </span>

                    @else

                        <span class="badge bg-secondary rounded-pill px-3 py-2">

                            Closed

                        </span>

                    @endif

                </div>


                <hr>


                <!-- Customer Message -->

                <div class="bg-light rounded-4 p-3 mb-3">

                    <h6 class="fw-bold">

                        <i class="fa-solid fa-message me-2"></i>

                        Customer Message

                    </h6>

                    <p class="text-muted small mb-0">

                        {{ $enquiry->message }}

                    </p>

                </div>


                <!-- Admin Reply -->

                @if($enquiry->reply)

                    <div class="p-3 rounded-4 mb-3"
                         style="background-color:#f1f8e8;border-left:5px solid #8cc63f;">

                        <h6 class="fw-bold">

                            <i class="fa-solid fa-reply me-2"></i>

                            Admin Reply

                        </h6>

                        <p class="small mb-0">

                            {{ $enquiry->reply }}

                        </p>

                    </div>

                @endif


                <!-- Reply Form -->

                <form method="POST"
                      action="{{ route('admin.enquiries.reply', $enquiry->id) }}">

                    @csrf

                    <div class="mb-3">

                        <label class="form-label fw-semibold small">

                            Write Reply

                        </label>

                        <textarea
                            name="reply"
                            rows="4"
                            class="form-control bg-light border-0 rounded-4"
                            placeholder="Write your reply here..."
                            required>{{ $enquiry->reply }}</textarea>

                    </div>


                    <button type="submit"
                            class="btn text-white rounded-pill px-4 fw-bold"
                            style="background-color:#8cc63f;">

                        <i class="fa-solid fa-paper-plane me-2"></i>

                        Send Reply

                    </button>

                </form>


                <!-- Date -->

                <div class="text-muted small mt-3">

                    <i class="fa-regular fa-calendar me-1"></i>

                    Submitted:

                    {{ $enquiry->created_at->format('d M Y, h:i A') }}

                </div>

            </div>

        </div>

    @empty

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body text-center py-5">

                <i class="fa-solid fa-envelope-open-text fs-1 text-muted mb-3"></i>

                <h5 class="fw-bold">
                    No Enquiries Yet
                </h5>

                <p class="text-muted small">
                    Customer enquiries will appear here.
                </p>

            </div>

        </div>

    @endforelse

</div>

@endsection