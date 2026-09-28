<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    // ====================================================
    // TWO FACTOR SETTINGS PAGE
    // ====================================================

    public function settings()
    {
        // ------------------------------------------------
        // ADMIN LOGIN CHECK
        // ------------------------------------------------

        if (session('admin_logged_in') !== true) {

            return redirect()
                ->route('admin.login')
                ->with(
                    'admin_error',
                    'Please login first.'
                );
        }

        // ------------------------------------------------
        // GET 2FA STATUS
        // ------------------------------------------------

        $twoFactorEnabled = false;

        // ------------------------------------------------
        // SUPERADMIN
        // ------------------------------------------------

        if (
            session('admin_role') === 'superadmin' &&
            session('admin_id') == 0
        ) {

            $twoFactorEnabled = session(
                'superadmin_2fa_enabled',
                false
            );

        } else {

            // ------------------------------------------------
            // NORMAL ADMIN
            // ------------------------------------------------

            $admin = User::find(
                session('admin_id')
            );

            if (!$admin) {

                session()->flush();

                return redirect()
                    ->route('admin.login')
                    ->with(
                        'admin_error',
                        'Admin account not found.'
                    );
            }

            $twoFactorEnabled =
                !empty($admin->google2fa_secret);
        }

        // ------------------------------------------------
        // RETURN SETTINGS PAGE
        // ------------------------------------------------

        return view(
            'dashboard',
            [
                'twoFactorEnabled' => $twoFactorEnabled
            ]
        );
    }


    // ====================================================
    // ENABLE TWO FACTOR
    // ====================================================

    public function enable()
    {
        // ------------------------------------------------
        // ADMIN LOGIN CHECK
        // ------------------------------------------------

        if (session('admin_logged_in') !== true) {

            return redirect()
                ->route('admin.login')
                ->with(
                    'admin_error',
                    'Please login first.'
                );
        }

        $google2fa = new Google2FA();

        // ------------------------------------------------
        // SUPERADMIN
        // ------------------------------------------------

        if (
            session('admin_role') === 'superadmin' &&
            session('admin_id') == 0
        ) {

            // Generate secret if not already available

            $secret = session(
                'superadmin_2fa_secret'
            );

            if (!$secret) {

                $secret =
                    $google2fa->generateSecretKey();

                session([
                    'superadmin_2fa_secret' =>
                        $secret
                ]);
            }

            // Do NOT activate yet.
            // Activate only after OTP verification.

            session([
                'superadmin_2fa_enabled' =>
                    false,

                'superadmin_2fa_setup_started' =>
                    true,

                'admin_2fa_verified' =>
                    false,
            ]);

            return redirect()
                ->route('admin.2fa.setup');
        }


        // ------------------------------------------------
        // NORMAL ADMIN
        // ------------------------------------------------

        $admin = User::find(
            session('admin_id')
        );

        if (!$admin) {

            session()->flush();

            return redirect()
                ->route('admin.login')
                ->with(
                    'admin_error',
                    'Admin account not found.'
                );
        }

        // Generate secret only if missing

        if (!$admin->google2fa_secret) {

            $admin->google2fa_secret =
                $google2fa->generateSecretKey();

            $admin->save();
        }

        // Setup is not active until OTP verified

        session([
            'admin_2fa_setup_started' =>
                true,

            'admin_2fa_verified' =>
                false,
        ]);

        return redirect()
            ->route('admin.2fa.setup');
    }


    // ====================================================
    // SHOW 2FA SETUP / QR CODE PAGE
    // ====================================================

    public function setup()
    {
        // ------------------------------------------------
        // ADMIN LOGIN CHECK
        // ------------------------------------------------

        if (session('admin_logged_in') !== true) {

            return redirect()
                ->route('admin.login')
                ->with(
                    'admin_error',
                    'Please login first.'
                );
        }

        $google2fa = new Google2FA();

        // ------------------------------------------------
        // SUPERADMIN
        // ------------------------------------------------

        if (
            session('admin_role') === 'superadmin' &&
            session('admin_id') == 0
        ) {

            // Make sure setup was started

            if (
                !session(
                    'superadmin_2fa_setup_started',
                    false
                )
            ) {

                return redirect()
                    ->route('admin.2fa.settings');
            }

            $secret = session(
                'superadmin_2fa_secret'
            );

            // Generate secret if missing

            if (!$secret) {

                $secret =
                    $google2fa->generateSecretKey();

                session([
                    'superadmin_2fa_secret' =>
                        $secret
                ]);
            }

            $email = session(
                'admin_email',
                'admin@seemy.com'
            );

            $name = session(
                'admin_name',
                'Super Admin'
            );

            // ------------------------------------------------
            // QR CODE
            // ------------------------------------------------

            $qrCodeUrl =
                $google2fa->getQRCodeUrl(
                    'Classic Eyewear',
                    $email,
                    $secret
                );

            return view(
                'admin-2fa-setup',
                compact(
                    'secret',
                    'qrCodeUrl',
                    'name',
                    'email'
                )
            );
        }


        // ------------------------------------------------
        // NORMAL ADMIN
        // ------------------------------------------------

        $admin = User::find(
            session('admin_id')
        );

        if (!$admin) {

            session()->flush();

            return redirect()
                ->route('admin.login')
                ->with(
                    'admin_error',
                    'Admin account not found.'
                );
        }

        // Only open scanner after Enable

        if (
            !session(
                'admin_2fa_setup_started',
                false
            )
        ) {

            return redirect()
                ->route('admin.2fa.settings');
        }

        // ------------------------------------------------
        // GENERATE SECRET
        // ------------------------------------------------

        if (!$admin->google2fa_secret) {

            $admin->google2fa_secret =
                $google2fa->generateSecretKey();

            $admin->save();
        }

        $secret =
            $admin->google2fa_secret;

        // ------------------------------------------------
        // QR CODE
        // ------------------------------------------------

        $qrCodeUrl =
            $google2fa->getQRCodeUrl(
                'Classic Eyewear',
                $admin->email,
                $secret
            );

        $name =
            $admin->name;

        $email =
            $admin->email;

        return view(
            'admin-2fa-setup',
            compact(
                'admin',
                'secret',
                'qrCodeUrl',
                'name',
                'email'
            )
        );
    }


    // ====================================================
    // VERIFY 2FA SETUP
    // ====================================================

    public function verifySetup(
        Request $request
    ) {

        // ------------------------------------------------
        // ADMIN LOGIN CHECK
        // ------------------------------------------------

        if (
            session('admin_logged_in') !== true
        ) {

            return redirect()
                ->route('admin.login');
        }

        // ------------------------------------------------
        // VALIDATION
        // ------------------------------------------------

        $request->validate([
            'otp' =>
                'required|digits:6',
        ]);

        $google2fa =
            new Google2FA();

        // ------------------------------------------------
        // SUPERADMIN
        // ------------------------------------------------

        if (
            session('admin_role') === 'superadmin' &&
            session('admin_id') == 0
        ) {

            $secret =
                session(
                    'superadmin_2fa_secret'
                );

            if (!$secret) {

                return redirect()
                    ->route(
                        'admin.2fa.settings'
                    )
                    ->with(
                        'error',
                        '2FA secret not found. Please try again.'
                    );
            }

            // ------------------------------------------------
            // VERIFY OTP
            // ------------------------------------------------

            $valid =
                $google2fa->verifyKey(
                    $secret,
                    $request->otp
                );

            if (!$valid) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Invalid OTP. Please enter the correct Google Authenticator code.'
                    );
            }

            // ------------------------------------------------
            // ACTIVATE 2FA
            // ------------------------------------------------

            session([
                'superadmin_2fa_enabled' =>
                    true,

                'superadmin_2fa_setup_started' =>
                    false,

                'admin_2fa_verified' =>
                    true,
            ]);

            return redirect()
                ->route(
                    'admin.dashboard'
                )
                ->with(
                    'success',
                    'Two-factor authentication enabled successfully!'
                );
        }


        // ------------------------------------------------
        // NORMAL ADMIN
        // ------------------------------------------------

        $admin =
            User::find(
                session('admin_id')
            );

        if (!$admin) {

            session()->flush();

            return redirect()
                ->route('admin.login')
                ->with(
                    'admin_error',
                    'Admin account not found.'
                );
        }

        // ------------------------------------------------
        // SECRET CHECK
        // ------------------------------------------------

        if (!$admin->google2fa_secret) {

            return redirect()
                ->route(
                    'admin.2fa.settings'
                )
                ->with(
                    'error',
                    '2FA secret was not generated.'
                );
        }

        // ------------------------------------------------
        // VERIFY OTP
        // ------------------------------------------------

        $valid =
            $google2fa->verifyKey(
                $admin->google2fa_secret,
                $request->otp
            );

        if (!$valid) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Invalid OTP. Please enter the correct Google Authenticator code.'
                );
        }

        // ------------------------------------------------
        // SETUP SUCCESS
        // ------------------------------------------------

        session([
            'admin_2fa_setup_started' =>
                false,

            'admin_2fa_verified' =>
                true,
        ]);

        return redirect()
            ->route(
                'admin.dashboard'
            )
            ->with(
                'success',
                'Two-factor authentication enabled successfully!'
            );
    }


    // ====================================================
    // SHOW LOGIN OTP PAGE
    // ====================================================

    public function verify()
    {
        // ------------------------------------------------
        // ADMIN LOGIN CHECK
        // ------------------------------------------------

        if (
            session('admin_logged_in') !== true
        ) {

            return redirect()
                ->route('admin.login');
        }

        // ------------------------------------------------
        // ALREADY VERIFIED
        // ------------------------------------------------

        if (
            session('admin_2fa_verified') === true
        ) {

            return redirect()
                ->route(
                    'admin.dashboard'
                );
        }

        return view(
            'admin-2fa-verify'
        );
    }


    // ====================================================
    // VERIFY LOGIN OTP
    // ====================================================

    public function verifyLogin(
        Request $request
    ) {

        // ------------------------------------------------
        // ADMIN LOGIN CHECK
        // ------------------------------------------------

        if (
            session('admin_logged_in') !== true
        ) {

            return redirect()
                ->route('admin.login');
        }

        // ------------------------------------------------
        // VALIDATION
        // ------------------------------------------------

        $request->validate([
            'otp' =>
                'required|digits:6',
        ]);

        $google2fa =
            new Google2FA();

        // ------------------------------------------------
        // SUPERADMIN
        // ------------------------------------------------

        if (
            session('admin_role') === 'superadmin' &&
            session('admin_id') == 0
        ) {

            $secret =
                session(
                    'superadmin_2fa_secret'
                );

            $enabled =
                session(
                    'superadmin_2fa_enabled',
                    false
                );

            if (
                !$enabled ||
                !$secret
            ) {

                return redirect()
                    ->route(
                        'admin.2fa.settings'
                    )
                    ->with(
                        'error',
                        'Two-factor authentication is not configured.'
                    );
            }

            // ------------------------------------------------
            // VERIFY OTP
            // ------------------------------------------------

            $valid =
                $google2fa->verifyKey(
                    $secret,
                    $request->otp
                );

            if (!$valid) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Invalid OTP. Please enter the correct Google Authenticator code.'
                    );
            }

            // ------------------------------------------------
            // SUCCESS
            // ------------------------------------------------

            session([
                'admin_2fa_verified' =>
                    true,
            ]);

            return redirect()
                ->route(
                    'admin.dashboard'
                )
                ->with(
                    'success',
                    'Two-factor authentication successful!'
                );
        }


        // ------------------------------------------------
        // NORMAL ADMIN
        // ------------------------------------------------

        $admin =
            User::find(
                session('admin_id')
            );

        if (!$admin) {

            session()->flush();

            return redirect()
                ->route('admin.login')
                ->with(
                    'admin_error',
                    'Admin account not found.'
                );
        }

        // ------------------------------------------------
        // SECRET CHECK
        // ------------------------------------------------

        if (!$admin->google2fa_secret) {

            return redirect()
                ->route(
                    'admin.2fa.settings'
                )
                ->with(
                    'error',
                    'Two-factor authentication is not configured.'
                );
        }

        // ------------------------------------------------
        // VERIFY OTP
        // ------------------------------------------------

        $valid =
            $google2fa->verifyKey(
                $admin->google2fa_secret,
                $request->otp
            );

        if (!$valid) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Invalid OTP. Please enter the correct Google Authenticator code.'
                );
        }

        // ------------------------------------------------
        // LOGIN SUCCESS
        // ------------------------------------------------

        session([
            'admin_2fa_verified' =>
                true,
        ]);

        return redirect()
            ->route(
                'admin.dashboard'
            )
            ->with(
                'success',
                'Two-factor authentication successful!'
            );
    }


    // ====================================================
    // DISABLE TWO FACTOR
    // ====================================================

    public function disable(
        Request $request
    ) {

        // ------------------------------------------------
        // ADMIN LOGIN CHECK
        // ------------------------------------------------

        if (
            session('admin_logged_in') !== true
        ) {

            return redirect()
                ->route('admin.login');
        }

        // ------------------------------------------------
        // SUPERADMIN
        // ------------------------------------------------

        if (
            session('admin_role') === 'superadmin' &&
            session('admin_id') == 0
        ) {

            session([
                'superadmin_2fa_enabled' =>
                    false,

                'superadmin_2fa_setup_started' =>
                    false,

                'admin_2fa_verified' =>
                    true,
            ]);

            return redirect()
                ->route(
                    'admin.2fa.settings'
                )
                ->with(
                    'success',
                    'Two-factor authentication disabled successfully.'
                );
        }


        // ------------------------------------------------
        // NORMAL ADMIN
        // ------------------------------------------------

        $admin =
            User::find(
                session('admin_id')
            );

        if (!$admin) {

            session()->flush();

            return redirect()
                ->route('admin.login');
        }

        // ------------------------------------------------
        // REMOVE SECRET
        // ------------------------------------------------

        $admin->google2fa_secret = null;
        $admin->save();

        // ------------------------------------------------
        // CLEAR 2FA SESSION
        // ------------------------------------------------

        session([
            'admin_2fa_verified' =>
                true,

            'admin_2fa_setup_started' =>
                false,
        ]);

        return redirect()
            ->route(
                'admin.2fa.settings'
            )
            ->with(
                'success',
                'Two-factor authentication disabled successfully.'
            );
    }
}