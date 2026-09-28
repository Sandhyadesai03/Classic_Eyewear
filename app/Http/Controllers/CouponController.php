<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\CartItem;

class CouponController extends Controller
{
    // ====================================================
    // ADMIN - CREATE COUPON
    // ====================================================

    public function store(Request $request)
    {
        // ADMIN LOGIN CHECK
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // VALIDATION
        $request->validate([

            'code' => [
                'required',
                'string',
                'max:50',
                'unique:coupons,code',
            ],

            'discount_type' => [
                'required',
                'in:percentage,fixed',
            ],

            'discount_value' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'start_date' => [
                'nullable',
                'date',
            ],

            'expiry_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],

            'usage_limit' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'status' => [
                'required',
                'boolean',
            ],

        ]);

        // ====================================================
        // PERCENTAGE LIMIT
        // ====================================================

        if (
            $request->discount_type === 'percentage' &&
            $request->discount_value > 100
        ) {

            return redirect()
                ->route('admin.dashboard', [
                    'page' => 'coupons'
                ])
                ->withErrors([
                    'discount_value' =>
                        'Percentage discount cannot be greater than 100%.'
                ])
                ->withInput();
        }

        // ====================================================
        // NORMALIZE CODE
        // ====================================================

        $code = strtoupper(
            trim($request->code)
        );

        // ====================================================
        // CREATE COUPON
        // ====================================================

        Coupon::create([

            'code' =>
                $code,

            'discount_type' =>
                $request->discount_type,

            'discount_value' =>
                $request->discount_value,

            'start_date' =>
                $request->start_date ?: null,

            'expiry_date' =>
                $request->expiry_date ?: null,

            'usage_limit' =>
                $request->usage_limit ?: null,

            'used_count' =>
                0,

            'status' =>
                (int) $request->status,

        ]);

        // ====================================================
        // REDIRECT
        // ====================================================

        return redirect()
            ->route('admin.dashboard', [
                'page' => 'coupons'
            ])
            ->with(
                'success',
                'Coupon ' . $code . ' created successfully!'
            );
    }


    // ====================================================
    // ADMIN - UPDATE COUPON
    // ====================================================

    public function update(Request $request, $id)
    {
        // ADMIN LOGIN CHECK
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // FIND COUPON
        $coupon = Coupon::findOrFail($id);

        // VALIDATION
        $request->validate([

            'code' => [
                'required',
                'string',
                'max:50',
                'unique:coupons,code,' . $coupon->id,
            ],

            'discount_type' => [
                'required',
                'in:percentage,fixed',
            ],

            'discount_value' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'start_date' => [
                'nullable',
                'date',
            ],

            'expiry_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],

            'usage_limit' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'status' => [
                'required',
                'boolean',
            ],

        ]);

        // ====================================================
        // PERCENTAGE LIMIT
        // ====================================================

        if (
            $request->discount_type === 'percentage' &&
            $request->discount_value > 100
        ) {

            return redirect()
                ->route('admin.dashboard', [
                    'page' => 'coupons'
                ])
                ->withErrors([
                    'discount_value' =>
                        'Percentage discount cannot be greater than 100%.'
                ])
                ->withInput();
        }

        // ====================================================
        // NORMALIZE CODE
        // ====================================================

        $code = strtoupper(
            trim($request->code)
        );

        // ====================================================
        // UPDATE COUPON
        // ====================================================

        $coupon->code =
            $code;

        $coupon->discount_type =
            $request->discount_type;

        $coupon->discount_value =
            $request->discount_value;

        $coupon->start_date =
            $request->start_date ?: null;

        $coupon->expiry_date =
            $request->expiry_date ?: null;

        $coupon->usage_limit =
            $request->usage_limit ?: null;

        $coupon->status =
            (int) $request->status;

        // SAVE
        $coupon->save();

        // ====================================================
        // CLEAR CURRENT USER COUPON SESSION
        // ====================================================

        if (
            session('coupon_id') &&
            session('coupon_id') == $coupon->id
        ) {

            session()->forget([
                'coupon_code',
                'coupon_discount',
                'coupon_id',
            ]);
        }

        // ====================================================
        // REDIRECT
        // ====================================================

        return redirect()
            ->route('admin.dashboard', [
                'page' => 'coupons'
            ])
            ->with(
                'success',
                'Coupon ' . $code . ' updated successfully!'
            );
    }


    // ====================================================
    // ADMIN - DELETE COUPON
    // ====================================================

    public function destroy($id)
    {
        // ADMIN LOGIN CHECK
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // FIND COUPON
        $coupon = Coupon::findOrFail($id);

        // ====================================================
        // CLEAR SESSION IF APPLIED
        // ====================================================

        if (
            session('coupon_id') &&
            session('coupon_id') == $coupon->id
        ) {

            session()->forget([
                'coupon_code',
                'coupon_discount',
                'coupon_id',
            ]);
        }

        // ====================================================
        // DELETE
        // ====================================================

        $coupon->delete();

        // ====================================================
        // REDIRECT
        // ====================================================

        return redirect()
            ->route('admin.dashboard', [
                'page' => 'coupons'
            ])
            ->with(
                'success',
                'Coupon deleted successfully!'
            );
    }


    // ====================================================
    // APPLY COUPON
    // ====================================================

    public function apply(Request $request)
    {
        // ====================================================
        // USER LOGIN CHECK
        // ====================================================

        if (!auth()->check()) {

            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Please login before applying a coupon.'
                );
        }

        // ====================================================
        // VALIDATION
        // ====================================================

        $request->validate([
            'coupon_code' =>
                'required|string|max:50',
        ]);

        // ====================================================
        // NORMALIZE CODE
        // ====================================================

        $code = strtoupper(
            trim($request->coupon_code)
        );

        // ====================================================
        // FIND COUPON
        // ====================================================

        $coupon = Coupon::where(
                'code',
                $code
            )
            ->where(
                'status',
                1
            )
            ->first();

        // ====================================================
        // COUPON NOT FOUND
        // ====================================================

        if (!$coupon) {

            return redirect()
                ->route('checkout')
                ->with(
                    'coupon_error',
                    'Invalid or inactive coupon code.'
                );
        }

        // ====================================================
        // START DATE CHECK
        // ====================================================

        if ($coupon->start_date) {

            try {

                $startDate = Carbon::parse(
                    $coupon->start_date
                );

                if (
                    now()->startOfDay()->lt(
                        $startDate->startOfDay()
                    )
                ) {

                    return redirect()
                        ->route('checkout')
                        ->with(
                            'coupon_error',
                            'This coupon is not active yet.'
                        );
                }

            } catch (\Exception $e) {

                return redirect()
                    ->route('checkout')
                    ->with(
                        'coupon_error',
                        'Invalid coupon start date.'
                    );
            }
        }

        // ====================================================
        // EXPIRY DATE CHECK
        // ====================================================

        if ($coupon->expiry_date) {

            try {

                $expiryDate = Carbon::parse(
                    $coupon->expiry_date
                );

                if (
                    now()->startOfDay()->gt(
                        $expiryDate->endOfDay()
                    )
                ) {

                    return redirect()
                        ->route('checkout')
                        ->with(
                            'coupon_error',
                            'This coupon has expired.'
                        );
                }

            } catch (\Exception $e) {

                return redirect()
                    ->route('checkout')
                    ->with(
                        'coupon_error',
                        'Invalid coupon expiry date.'
                    );
            }
        }

        // ====================================================
        // USAGE LIMIT CHECK
        // ====================================================

        if (
            $coupon->usage_limit !== null &&
            $coupon->used_count >= $coupon->usage_limit
        ) {

            return redirect()
                ->route('checkout')
                ->with(
                    'coupon_error',
                    'This coupon usage limit has been reached.'
                );
        }

        // ====================================================
        // GET CART
        // ====================================================

        $cartItems = CartItem::with('product')
            ->where(
                'user_id',
                auth()->id()
            )
            ->get();

        // ====================================================
        // CALCULATE SUBTOTAL
        // ====================================================

        $subtotal = 0;

        foreach ($cartItems as $item) {

            if ($item->product) {

                $subtotal +=
                    $item->product->price *
                    $item->quantity;
            }
        }

        // ====================================================
        // EMPTY CART
        // ====================================================

        if ($subtotal <= 0) {

            return redirect()
                ->route('checkout')
                ->with(
                    'coupon_error',
                    'Your cart is empty.'
                );
        }

        // ====================================================
        // CALCULATE DISCOUNT
        // ====================================================

        if (
            $coupon->discount_type === 'percentage'
        ) {

            $discount =
                (
                    $subtotal *
                    $coupon->discount_value
                ) / 100;

        } else {

            $discount =
                $coupon->discount_value;
        }

        // ====================================================
        // DISCOUNT LIMIT
        // ====================================================

        if ($discount > $subtotal) {
            $discount = $subtotal;
        }

        // ====================================================
        // PREVENT NEGATIVE DISCOUNT
        // ====================================================

        if ($discount < 0) {
            $discount = 0;
        }

        // ====================================================
        // ROUND DISCOUNT
        // ====================================================

        $discount = round(
            $discount,
            2
        );

        // ====================================================
        // SAVE COUPON SESSION
        // ====================================================

        session([
            'coupon_code' =>
                $coupon->code,

            'coupon_discount' =>
                $discount,

            'coupon_id' =>
                $coupon->id,
        ]);

        // ====================================================
        // SUCCESS
        // ====================================================

        return redirect()
            ->route('checkout')
            ->with(
                'coupon_success',

                'Coupon ' .
                $coupon->code .
                ' applied successfully! You saved ₹' .
                number_format(
                    $discount,
                    2
                )
            );
    }


    // ====================================================
    // REMOVE COUPON
    // ====================================================

    public function remove()
    {
        session()->forget([

            'coupon_code',

            'coupon_discount',

            'coupon_id',

        ]);

        return redirect()
            ->route('checkout')
            ->with(
                'coupon_success',
                'Coupon removed successfully.'
            );
    }
}