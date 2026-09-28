```blade
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Two-Factor Authentication Setup</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
    >

</head>


<body class="bg-light">


<div class="container min-vh-100 d-flex align-items-center justify-content-center py-4">

    <div class="card border-0 shadow-lg rounded-4"
         style="max-width: 520px; width: 100%;">

        <div class="card-body p-4 p-md-5 text-center">


            {{-- ================================================= --}}
            {{-- ICON --}}
            {{-- ================================================= --}}

            <div class="mb-3">

                <div
                    class="bg-dark text-white rounded-circle
                           mx-auto d-flex align-items-center
                           justify-content-center"
                    style="width:70px;height:70px;"
                >

                    <i class="fa-solid fa-shield-halved fs-3"></i>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- TITLE --}}
            {{-- ================================================= --}}

            <h2 class="fw-bold mb-2">
                Set Up Two-Factor Authentication
            </h2>

            <p class="text-muted mb-4">
                Protect your admin account with Google Authenticator.
            </p>


            {{-- ================================================= --}}
            {{-- ERROR MESSAGE --}}
            {{-- ================================================= --}}

            @if(session('error'))

                <div class="alert alert-danger text-start">

                    <i class="fa-solid fa-circle-exclamation me-2"></i>

                    {{ session('error') }}

                </div>

            @endif


            {{-- ================================================= --}}
            {{-- SUCCESS MESSAGE --}}
            {{-- ================================================= --}}

            @if(session('success'))

                <div class="alert alert-success text-start">

                    <i class="fa-solid fa-circle-check me-2"></i>

                    {{ session('success') }}

                </div>

            @endif


            {{-- ================================================= --}}
            {{-- CURRENT ADMIN --}}
            {{-- ================================================= --}}

            @if(isset($name))

                <div class="alert alert-light border text-start mb-4">

                    <div class="fw-semibold">

                        <i class="fa-solid fa-user me-2"></i>

                        {{ $name }}

                    </div>

                    @if(isset($email))

                        <div class="small text-muted mt-1">

                            {{ $email }}

                        </div>

                    @endif

                </div>

            @endif


            {{-- ================================================= --}}
            {{-- STEP 1 --}}
            {{-- ================================================= --}}

            <div class="mb-4">

                <h5 class="fw-bold mb-2">

                    <span class="badge bg-dark rounded-circle">
                        1
                    </span>

                    Scan QR Code

                </h5>


                <p class="text-muted small mb-3">

                    Open Google Authenticator on your phone
                    and scan the QR code below.

                </p>


                {{-- ================================================= --}}
                {{-- QR CODE --}}
                {{-- ================================================= --}}

                <div
                    class="bg-white border rounded-3 p-3
                           d-inline-block shadow-sm"
                >

                    <img
                        src="https://quickchart.io/qr?text={{ urlencode($qrCodeUrl) }}&size=220"
                        alt="Google Authenticator QR Code"
                        width="220"
                        height="220"
                        class="img-fluid"
                    >

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- SECRET KEY --}}
            {{-- ================================================= --}}

            <div class="mb-4">

                <p class="fw-semibold mb-2">

                    Can't scan the QR code?

                </p>


                <p class="text-muted small mb-2">

                    Enter this secret key manually
                    in Google Authenticator.

                </p>


                <div class="alert alert-secondary mb-0">

                    <strong class="text-break">

                        {{ $secret }}

                    </strong>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- STEP 2 --}}
            {{-- ================================================= --}}

            <div class="mb-3">

                <h5 class="fw-bold mb-2">

                    <span class="badge bg-dark rounded-circle">
                        2
                    </span>

                    Enter Verification Code

                </h5>


                <p class="text-muted small">

                    After scanning the QR code,
                    enter the 6-digit code shown
                    in Google Authenticator.

                </p>

            </div>


            {{-- ================================================= --}}
            {{-- OTP FORM --}}
            {{-- ================================================= --}}

            <form
                action="{{ route('admin.2fa.setup.verify') }}"
                method="POST"
            >

                @csrf


                <div class="mb-3">

                    <input
                        type="text"
                        name="otp"
                        class="form-control form-control-lg
                               text-center fw-bold"
                        placeholder="Enter 6-digit OTP"
                        maxlength="6"
                        minlength="6"
                        inputmode="numeric"
                        pattern="[0-9]{6}"
                        autocomplete="one-time-code"
                        required
                        autofocus
                    >

                </div>


                {{-- ================================================= --}}
                {{-- VALIDATION ERROR --}}
                {{-- ================================================= --}}

                @error('otp')

                    <div class="text-danger small mb-3">

                        {{ $message }}

                    </div>

                @enderror


                {{-- ================================================= --}}
                {{-- VERIFY BUTTON --}}
                {{-- ================================================= --}}

                <button
                    type="submit"
                    class="btn btn-dark btn-lg w-100"
                >

                    <i class="fa-solid fa-check me-2"></i>

                    Verify & Continue

                </button>

            </form>


            {{-- ================================================= --}}
            {{-- INFORMATION --}}
            {{-- ================================================= --}}

            <div class="mt-4">

                <small class="text-muted">

                    <i class="fa-solid fa-lock me-1"></i>

                    After successful verification,
                    Two-Factor Authentication will be enabled.

                </small>

            </div>


        </div>

    </div>

</div>


{{-- ================================================= --}}
{{-- ONLY NUMBERS ALLOWED IN OTP --}}
{{-- ================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const otpInput = document.querySelector('input[name="otp"]');

    if (otpInput) {

        otpInput.addEventListener('input', function () {

            this.value = this.value
                .replace(/[^0-9]/g, '')
                .slice(0, 6);

        });

    }

});

</script>


</body>

</html>
```
