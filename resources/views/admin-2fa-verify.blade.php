```blade
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Verify Two-Factor Authentication</title>

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
         style="max-width: 450px; width: 100%;">


        <div class="card-body p-4 p-md-5 text-center">


            {{-- ================================================= --}}
            {{-- ICON --}}
            {{-- ================================================= --}}

            <div class="mb-4">

                <div
                    class="bg-dark text-white rounded-circle
                           mx-auto d-flex align-items-center
                           justify-content-center"
                    style="width:75px;height:75px;"
                >

                    <i class="fa-solid fa-mobile-screen-button fs-3"></i>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- TITLE --}}
            {{-- ================================================= --}}

            <h2 class="fw-bold mb-2">

                Two-Factor Authentication

            </h2>


            <p class="text-muted mb-4">

                Enter the 6-digit verification code
                from your Google Authenticator app.

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
            {{-- ADMIN INFORMATION --}}
            {{-- ================================================= --}}

            @if(session('admin_name'))

                <div class="alert alert-light border text-start mb-4">

                    <div class="fw-semibold">

                        <i class="fa-solid fa-user me-2"></i>

                        {{ session('admin_name') }}

                    </div>


                    @if(session('admin_email'))

                        <div class="small text-muted mt-1">

                            {{ session('admin_email') }}

                        </div>

                    @endif

                </div>

            @endif


            {{-- ================================================= --}}
            {{-- OTP FORM --}}
            {{-- ================================================= --}}

            <form
                action="{{ route('admin.2fa.verify.login') }}"
                method="POST"
            >

                @csrf


                <div class="mb-3">

                    <input
                        type="text"
                        name="otp"
                        id="otp"
                        class="form-control form-control-lg
                               text-center fw-bold"
                        placeholder="000000"
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
                {{-- OTP VALIDATION ERROR --}}
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

                    <i class="fa-solid fa-shield-halved me-2"></i>

                    Verify OTP

                </button>

            </form>


            {{-- ================================================= --}}
            {{-- SECURITY MESSAGE --}}
            {{-- ================================================= --}}

            <div class="mt-4">

                <small class="text-muted">

                    <i class="fa-solid fa-lock me-1"></i>

                    Secured by Google Authenticator

                </small>

            </div>


            {{-- ================================================= --}}
            {{-- INFORMATION --}}
            {{-- ================================================= --}}

            <div class="mt-2">

                <small class="text-muted">

                    Your verification code changes every 30 seconds.

                </small>

            </div>


        </div>

    </div>

</div>


{{-- ================================================= --}}
{{-- OTP INPUT SCRIPT --}}
{{-- ================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const otpInput = document.getElementById('otp');

    if (otpInput) {

        otpInput.addEventListener('input', function () {

            // फक्त numbers allow
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
