<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderNotification;
use App\Models\Review;
use App\Models\OrderItem;
use App\Models\Setting;
use App\Models\Coupon;
use App\Models\Visitor;
use App\Models\Enquiry;
use App\Models\ShippingSetting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{


 // ====================================================
// ADMIN LOGIN PAGE
// ====================================================

public function dashboard()
{
    // /admin उघडल्यावर Admin Login page दाखवायचा
    return view('admin');
}


// ====================================================
// ADMIN LOGIN
// ====================================================

public function adminLogin(Request $request)
{
    // ====================================================
    // VALIDATION
    // ====================================================

    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);


    // ====================================================
    // NORMALIZE EMAIL
    // ====================================================

    $email = strtolower(
        trim($validated['email'])
    );


    // ====================================================
    // SUPERADMIN LOGIN
    // ====================================================

    if (
        $email === 'admin@seemy.com' &&
        $validated['password'] === 'admin123'
    ) {

        // ------------------------------------------------
        // REGENERATE SESSION
        // ------------------------------------------------

        $request->session()->regenerate();


        // ------------------------------------------------
        // SUPERADMIN PERMISSIONS
        // ------------------------------------------------

        $permissions = [
            'dashboard',
            'products',
            'categories',
            'stock-management',
            'view-orders',
            'enquiries',
            'coupons',
            'website-visitors',
            'reports',
            'settings',
            'user-management',
            'shipping',
            'shipping-charges',
        ];


        // ------------------------------------------------
        // CREATE 2FA SECRET ONLY ONCE
        // ------------------------------------------------

        if (!session()->has('superadmin_2fa_secret')) {

            $google2fa =
                new \PragmaRX\Google2FA\Google2FA();

            session([
                'superadmin_2fa_secret' =>
                    $google2fa->generateSecretKey()
            ]);
        }


        // ------------------------------------------------
        // CHECK WHETHER SUPERADMIN 2FA IS ENABLED
        // ------------------------------------------------

        $twoFactorEnabled =
            session(
                'superadmin_2fa_enabled',
                false
            );


        // ------------------------------------------------
        // SUPERADMIN SESSION
        // ------------------------------------------------

        session([

            'admin_logged_in' =>
                true,

            'admin_2fa_verified' =>
                !$twoFactorEnabled,

            'admin_id' =>
                0,

            'admin_name' =>
                'Super Admin',

            'admin_email' =>
                'admin@seemy.com',

            'admin_role' =>
                'superadmin',

            'admin_permissions' =>
                $permissions,

            'admin_user' => [

                'id' =>
                    0,

                'name' =>
                    'Super Admin',

                'email' =>
                    'admin@seemy.com',

                'role' =>
                    'superadmin',

                'permissions' =>
                    $permissions,

            ],

        ]);


        // ------------------------------------------------
        // 2FA ACTIVE
        // ------------------------------------------------

        if ($twoFactorEnabled) {

            return redirect()
                ->route('admin.2fa.verify');
        }


        // ------------------------------------------------
        // 2FA DISABLED
        // ------------------------------------------------

        return redirect()
            ->route('admin.dashboard');
    }


    // ====================================================
    // NORMAL DATABASE ADMIN LOGIN
    // ====================================================

    $admin = User::where(
        'email',
        $email
    )
    ->where(
        'is_admin',
        1
    )
    ->first();


    // ====================================================
    // ADMIN NOT FOUND
    // ====================================================

    if (!$admin) {

        return back()
            ->withInput(
                $request->only('email')
            )
            ->with(
                'admin_error',
                'Invalid admin email or password.'
            );
    }


    // ====================================================
    // PASSWORD CHECK
    // ====================================================

    if (
        !Hash::check(
            $validated['password'],
            $admin->password
        )
    ) {

        return back()
            ->withInput(
                $request->only('email')
            )
            ->with(
                'admin_error',
                'Invalid admin email or password.'
            );
    }


    // ====================================================
    // GET ADMIN ROLE
    // ====================================================

    $adminRole =
        $admin->role ?? 'admin';


    // ====================================================
    // GET ADMIN PERMISSIONS
    // ====================================================

    $permissions =
        $admin->permissions ?? [];


    // ====================================================
    // CONVERT JSON TO ARRAY
    // ====================================================

    if (is_string($permissions)) {

        $decoded =
            json_decode(
                $permissions,
                true
            );

        $permissions =
            is_array($decoded)
                ? $decoded
                : [];
    }


    if (!is_array($permissions)) {

        $permissions = [];
    }


    // ====================================================
    // DATABASE SUPERADMIN
    // ====================================================

    if ($adminRole === 'superadmin') {

        $permissions = [
            'dashboard',
            'products',
            'categories',
            'stock-management',
            'view-orders',
            'enquiries',
            'coupons',
            'website-visitors',
            'reports',
            'settings',
            'user-management',
            'shipping',
            'shipping-charges',
        ];
    }


    // ====================================================
    // REGENERATE SESSION
    // ====================================================

    $request->session()->regenerate();


    // ====================================================
    // CHECK 2FA STATUS
    // ====================================================

    $twoFactorEnabled =
        !empty(
            $admin->google2fa_secret
        );


    // ====================================================
    // NORMAL ADMIN SESSION
    // ====================================================

    session([

        'admin_logged_in' =>
            true,

        'admin_2fa_verified' =>
            !$twoFactorEnabled,

        'admin_id' =>
            $admin->id,

        'admin_name' =>
            $admin->name,

        'admin_email' =>
            $admin->email,

        'admin_role' =>
            $adminRole,

        'admin_permissions' =>
            $permissions,

        'admin_user' => [

            'id' =>
                $admin->id,

            'name' =>
                $admin->name,

            'email' =>
                $admin->email,

            'role' =>
                $adminRole,

            'permissions' =>
                $permissions,

        ],

    ]);


    // ====================================================
    // 2FA ACTIVE
    // ====================================================

    if ($twoFactorEnabled) {

        return redirect()
            ->route('admin.2fa.verify');
    }


    // ====================================================
    // 2FA DISABLED
    // ====================================================

    return redirect()
        ->route('admin.dashboard');
}
// ====================================================
// UPDATE SHIPPING CHARGES
// ====================================================

public function updateShippingCharges(Request $request)
{
    // ====================================================
    // ADMIN LOGIN CHECK
    // ====================================================

    if (session('admin_logged_in') !== true) {

        return redirect()
            ->route('admin.login')
            ->with(
                'admin_error',
                'Please login to access admin dashboard.'
            );
    }


    // ====================================================
    // VALIDATION
    // ====================================================

    $request->validate([
        'shipping_charge' => 'required|numeric|min:0',
        'free_shipping_amount' => 'required|numeric|min:0',
    ]);


    // ====================================================
    // GET SHIPPING SETTINGS
    // ====================================================

    $shipping = ShippingSetting::latest('id')->first();


    // ====================================================
    // CREATE IF NOT EXISTS
    // ====================================================

    if (!$shipping) {

        $shipping = new ShippingSetting();
    }


    // ====================================================
    // UPDATE VALUES
    // ====================================================

    $shipping->shipping_charge =
        $request->shipping_charge;

    $shipping->free_shipping_amount =
        $request->free_shipping_amount;


    // ====================================================
    // SAVE
    // ====================================================

    $shipping->save();


    // ====================================================
    // REDIRECT
    // ====================================================

    return redirect()
        ->route(
            'admin.dashboard',
            [
                'page' => 'shipping-charges'
            ]
        )
        ->with(
            'success',
            'Shipping charges updated successfully.'
        );
}



// ====================================================
// ADMIN DASHBOARD
// ====================================================

public function adminDashboard(Request $request)
{
    // ====================================================
    // ADMIN LOGIN CHECK
    // ====================================================

    if (session('admin_logged_in') !== true) {
        return redirect()
            ->route('admin.login')
            ->with(
                'admin_error',
                'Please login to access admin dashboard.'
            );
    }

    // ====================================================
    // CURRENT PAGE
    // ====================================================

    $page = $request->query('page', 'dashboard');

    // ====================================================
    // SHIPPING PAGE NAME FIX
    // ====================================================

    if ($page === 'shipping') {
        $page = 'shipping-charges';
    }

    // ====================================================
    // TWO FACTOR PAGE
    // ====================================================

    $isTwoFactorPage = $page === 'two-factor';

    // ====================================================
    // 2FA VERIFICATION CHECK
    // ====================================================

    if (
        !$isTwoFactorPage &&
        session('admin_2fa_verified') !== true
    ) {
        return redirect()
            ->route('admin.2fa.verify')
            ->with(
                'error',
                'Please complete two-factor authentication first.'
            );
    }

    // ====================================================
    // GET ADMIN ROLE
    // ====================================================

    $adminRole = session('admin_role', 'admin');

    // ====================================================
    // GET PERMISSIONS
    // ====================================================

    $permissions = session('admin_permissions', []);

    // ====================================================
    // CONVERT JSON TO ARRAY
    // ====================================================

    if (is_string($permissions)) {

        $decoded = json_decode($permissions, true);

        $permissions = is_array($decoded)
            ? $decoded
            : [];
    }

    if (!is_array($permissions)) {
        $permissions = [];
    }

    // ====================================================
    // SUPERADMIN FULL ACCESS
    // ====================================================

    if ($adminRole === 'superadmin') {

        $permissions = [
            'dashboard',
            'products',
            'categories',
            'stock-management',
            'view-orders',
            'enquiries',
            'coupons',
            'website-visitors',
            'reports',
            'settings',
            'user-management',
            'shipping',
            'shipping-charges',
        ];

        session([
            'admin_permissions' => $permissions
        ]);
    }

    // ====================================================
    // PAGE PERMISSION CHECK
    // ====================================================

    if ($page === 'two-factor') {

        if (
            $adminRole !== 'superadmin' &&
            !in_array('settings', $permissions)
        ) {

            return redirect()
                ->route('admin.dashboard')
                ->with(
                    'error',
                    'You are not authorized to access Two-Factor Authentication.'
                );
        }

    } else {

        if (
            $adminRole !== 'superadmin' &&
            !in_array($page, $permissions)
        ) {

            // ------------------------------------------------
            // ADMIN HAS SOME PERMISSION
            // ------------------------------------------------

            if (!empty($permissions)) {

                return redirect()
                    ->route(
                        'admin.dashboard',
                        [
                            'page' => $permissions[0]
                        ]
                    )
                    ->with(
                        'error',
                        'You are not authorized to access this page.'
                    );
            }

            // ------------------------------------------------
            // NO PERMISSION
            // ------------------------------------------------

            session()->forget([
                'admin_logged_in',
                'admin_2fa_verified',
                'admin_id',
                'admin_name',
                'admin_email',
                'admin_role',
                'admin_permissions',
                'admin_user',
            ]);

            return redirect()
                ->route('admin.login')
                ->with(
                    'admin_error',
                    'You do not have access to any admin page.'
                );
        }
    }

    // ====================================================
    // TWO FACTOR ENABLED STATUS
    // ====================================================

    if ($adminRole === 'superadmin') {

        $twoFactorEnabled = session(
            'superadmin_2fa_enabled',
            false
        );

    } else {

        $adminId = session('admin_id');

        $currentAdmin = User::find($adminId);

        $twoFactorEnabled =
            $currentAdmin &&
            !empty($currentAdmin->google2fa_secret);
    }



    // ====================================================
    // SHIPPING SETTINGS
    // ====================================================

    $shipping = ShippingSetting::latest('id')->first();

    // ====================================================
    // CREATE DEFAULT SHIPPING SETTINGS
    // ====================================================

    if (!$shipping) {

        $shipping = new ShippingSetting();

        $shipping->shipping_charge = 100;
        $shipping->free_shipping_amount = 2000;

        $shipping->save();
    }

    // ====================================================
    // DASHBOARD SUMMARY
    // ====================================================

    // ----------------------------------------------------
    // TOTAL PRODUCTS
    // ----------------------------------------------------

    $totalProducts = Product::count();

    // ----------------------------------------------------
    // TOTAL USERS
    // ----------------------------------------------------

    $totalUsers = User::where(
        'is_admin',
        0
    )->count();

    // ----------------------------------------------------
    // ACTIVE ORDERS
    // ----------------------------------------------------

    $activeOrders = Order::whereIn(
        'status',
        [
            'Pending',
            'Processing',
            'Confirmed',
            'Shipped'
        ]
    )->count();

    // ====================================================
    // RECENT ORDERS
    // ====================================================

    $recentOrders = Order::with([
        'user',
        'items.product'
    ])
    ->latest('created_at')
    ->take(10)
    ->get();

    // ====================================================
    // DATE FILTERS
    // ====================================================

    $dateFrom = $request->query('date_from');
    $dateTo = $request->query('date_to');

    // ====================================================
    // CLEAN DATE VALUES
    // ====================================================

    $dateFrom = $dateFrom
        ? trim($dateFrom)
        : null;

    $dateTo = $dateTo
        ? trim($dateTo)
        : null;

    // ====================================================
    // INVALID DATE RANGE
    // ====================================================

    $invalidDateRange = false;

    // ====================================================
    // VALIDATE DATE FORMAT
    // ====================================================

    if (
        $dateFrom &&
        !preg_match(
            '/^\d{4}-\d{2}-\d{2}$/',
            $dateFrom
        )
    ) {
        $dateFrom = null;
        $invalidDateRange = true;
    }

    if (
        $dateTo &&
        !preg_match(
            '/^\d{4}-\d{2}-\d{2}$/',
            $dateTo
        )
    ) {
        $dateTo = null;
        $invalidDateRange = true;
    }

    // ====================================================
    // CHECK DATE RANGE
    // ====================================================

    $fromDate = null;
    $toDate = null;

    if (
        $dateFrom &&
        $dateTo &&
        !$invalidDateRange
    ) {

        try {

            $fromDate =
                \Carbon\Carbon::createFromFormat(
                    'Y-m-d',
                    $dateFrom
                )->startOfDay();

            $toDate =
                \Carbon\Carbon::createFromFormat(
                    'Y-m-d',
                    $dateTo
                )->endOfDay();

            if (
                $fromDate->greaterThan($toDate)
            ) {
                $invalidDateRange = true;
            }

        } catch (\Exception $e) {

            $invalidDateRange = true;
        }
    }

    // ====================================================
    // USERS
    // ====================================================

    $usersQuery = User::where(
        'is_admin',
        0
    );

    if ($invalidDateRange) {

        $usersQuery->whereRaw('1 = 0');

    } else {

        if ($dateFrom) {

            $usersQuery->where(
                'created_at',
                '>=',
                \Carbon\Carbon::parse(
                    $dateFrom
                )->startOfDay()
            );
        }

        if ($dateTo) {

            $usersQuery->where(
                'created_at',
                '<=',
                \Carbon\Carbon::parse(
                    $dateTo
                )->endOfDay()
            );
        }
    }

    $users = $usersQuery
        ->latest('created_at')
        ->get();

    // ====================================================
    // ADMINS
    // ====================================================

    $admins = User::where(
        'is_admin',
        1
    )
    ->latest('created_at')
    ->get();

    // ====================================================
    // PRODUCTS
    // ====================================================

    $productsQuery = Product::query();

    if ($invalidDateRange) {

        $productsQuery->whereRaw('1 = 0');

    } else {

        if ($dateFrom) {

            $productsQuery->where(
                'created_at',
                '>=',
                \Carbon\Carbon::parse(
                    $dateFrom
                )->startOfDay()
            );
        }

        if ($dateTo) {

            $productsQuery->where(
                'created_at',
                '<=',
                \Carbon\Carbon::parse(
                    $dateTo
                )->endOfDay()
            );
        }
    }

    $products = $productsQuery
        ->latest('created_at')
        ->get();

    // ====================================================
    // CATEGORIES
    // ====================================================

    $categories = Product::select(
        'category'
    )
    ->whereNotNull('category')
    ->where('category', '!=', '')
    ->distinct()
    ->orderBy('category')
    ->pluck('category');

    // ====================================================
    // WEBSITE VISITORS
    // ====================================================

    $totalVisitors = 0;
    $todayVisitors = 0;
    $latestVisitor = null;
    $visitors = collect();

    try {

        // ------------------------------------------------
        // TOTAL UNIQUE VISITORS
        // ------------------------------------------------

        $totalVisitors =
            Visitor::distinct(
                'ip_address'
            )->count(
                'ip_address'
            );

        // ------------------------------------------------
        // TODAY UNIQUE VISITORS
        // ------------------------------------------------

        $todayVisitors =
            Visitor::whereDate(
                'created_at',
                today()
            )
            ->distinct(
                'ip_address'
            )
            ->count(
                'ip_address'
            );

        // ------------------------------------------------
        // LATEST VISITOR
        // ------------------------------------------------

        $latestVisitor =
            Visitor::latest(
                'created_at'
            )->first();

        // ------------------------------------------------
        // ALL VISITORS
        // ------------------------------------------------

        $visitors =
            Visitor::orderBy(
                'created_at',
                'desc'
            )->get();

    } catch (\Throwable $e) {

        $totalVisitors = 0;
        $todayVisitors = 0;
        $latestVisitor = null;
        $visitors = collect();
    }

    // ====================================================
    // ALL ORDERS WITH DATE FILTER
    // ====================================================

    $ordersQuery = Order::with([
        'user',
        'items.product'
    ]);

    if ($invalidDateRange) {

        $ordersQuery->whereRaw('1 = 0');

    } else {

        if ($dateFrom) {

            $ordersQuery->where(
                'created_at',
                '>=',
                \Carbon\Carbon::parse(
                    $dateFrom
                )->startOfDay()
            );
        }

        if ($dateTo) {

            $ordersQuery->where(
                'created_at',
                '<=',
                \Carbon\Carbon::parse(
                    $dateTo
                )->endOfDay()
            );
        }
    }

    $orders = $ordersQuery
        ->latest('created_at')
        ->get();

    // ====================================================
    // COUPONS
    // ====================================================

    $coupons = Coupon::latest()->get();

    // ====================================================
    // ENQUIRIES
    // ====================================================

    $enquiries = collect();

    try {

        $enquiries = \App\Models\Enquiry::with('user')
            ->latest('created_at')
            ->get();

    } catch (\Throwable $e) {

        $enquiries = collect();
    }

    // ====================================================
    // PENDING ENQUIRIES
    // ====================================================

    $pendingEnquiries = 0;

    try {

        $pendingEnquiries =
            \App\Models\Enquiry::where(
                'status',
                'pending'
            )->count();

    } catch (\Throwable $e) {

        $pendingEnquiries = 0;
    }

    // ====================================================
    // UNREAD ENQUIRIES
    // ====================================================

    $unreadEnquiries = 0;

    try {

        $unreadEnquiries =
            \App\Models\Enquiry::where(
                'admin_read',
                false
            )->count();

    } catch (\Throwable $e) {

        $unreadEnquiries = 0;
    }

    // ====================================================
    // ADMIN NOTIFICATION COUNT
    // ====================================================

    $enquiryNotificationCount =
        $pendingEnquiries;

    // ====================================================
    // NEW ORDER NOTIFICATION
    // ====================================================

    $lastSeenOrderId = session(
        'last_seen_order_id',
        0
    );

    $newOrders = Order::with('user')
        ->where(
            'id',
            '>',
            $lastSeenOrderId
        )
        ->where(
            'status',
            'Pending'
        )
        ->latest('created_at')
        ->get();

    $newOrderNotificationCount =
        $newOrders->count();

    // ====================================================
    // LATEST ORDER ID
    // ====================================================

    $latestOrderId =
        Order::max('id');

    // ====================================================
    // SETTINGS
    // ====================================================

    $setting = Setting::first();

    // ====================================================
    // FINAL DASHBOARD VIEW
    // ====================================================

    return view(
        'dashboard',
        compact(

            // ------------------------------------------------
            // CURRENT PAGE
            // ------------------------------------------------

            'page',

            // ------------------------------------------------
            // DASHBOARD SUMMARY
            // ------------------------------------------------

            'totalProducts',
            'totalUsers',
            'activeOrders',

            // ------------------------------------------------
            // WEBSITE VISITORS
            // ------------------------------------------------

            'totalVisitors',
            'todayVisitors',
            'latestVisitor',
            'visitors',

            // ------------------------------------------------
            // ORDERS
            // ------------------------------------------------

            'orders',
            'recentOrders',
            'newOrders',
            'newOrderNotificationCount',
            'latestOrderId',

            // ------------------------------------------------
            // PRODUCTS
            // ------------------------------------------------

            'products',

            // ------------------------------------------------
            // CATEGORIES
            // ------------------------------------------------

            'categories',

            // ------------------------------------------------
            // USERS
            // ------------------------------------------------

            'users',
            'admins',

            // ------------------------------------------------
            // SHIPPING
            // ------------------------------------------------

            'shipping',

            // ------------------------------------------------
            // 2FA
            // ------------------------------------------------

            'twoFactorEnabled',

            // ------------------------------------------------
            // COUPONS
            // ------------------------------------------------

            'coupons',

            // ------------------------------------------------
            // ENQUIRIES
            // ------------------------------------------------

            'enquiries',
            'pendingEnquiries',
            'unreadEnquiries',
            'enquiryNotificationCount',

            // ------------------------------------------------
            // SETTINGS
            // ------------------------------------------------

            'setting',

            // ------------------------------------------------
            // DATE FILTERS
            // ------------------------------------------------

            'dateFrom',
            'dateTo',
            'invalidDateRange',
        )
    );

    // ====================================================
    // REPORT TOTAL PRODUCTS
    // ====================================================

    $reportTotalProducts =
        $products->count();


    // ====================================================
    // REPORT TOTAL USERS
    // ====================================================

    $reportTotalUsers =
        $users->count();


    // ====================================================
    // REPORT TOTAL ORDERS
    // ====================================================

    $reportTotalOrders =
        $orders->count();


    // ====================================================
    // REPORT TOTAL STOCK
    // ====================================================

    $reportTotalStock =
        $products->sum(
            function ($product) {

                return (int) (
                    $product->stock ?? 0
                );
            }
        );


    // ====================================================
    // LOW STOCK
    // ====================================================

    $reportLowStock =
        $products->filter(
            function ($product) {

                $stock =
                    (int) (
                        $product->stock ?? 0
                    );

                return (
                    $stock > 0 &&
                    $stock <= 5
                );
            }
        )->count();


    // ====================================================
    // OUT OF STOCK
    // ====================================================

    $reportOutOfStock =
        $products->filter(
            function ($product) {

                return (
                    (int) (
                        $product->stock ?? 0
                    ) === 0
                );
            }
        )->count();


    // ====================================================
    // IN STOCK
    // ====================================================

    $reportInStock =
        $products->filter(
            function ($product) {

                return (
                    (int) (
                        $product->stock ?? 0
                    ) > 5
                );
            }
        )->count();


    // ====================================================
    // TOTAL SALES
    // ====================================================

    $reportTotalSales = 0;


    foreach (
        $orders as $order
    ) {

        // ------------------------------------------------
        // SKIP CANCELLED ORDERS
        // ------------------------------------------------

        if (
            strtolower(
                $order->status ?? ''
            ) === 'cancelled'
        ) {

            continue;
        }


        // ------------------------------------------------
        // ORDER HAS ITEMS
        // ------------------------------------------------

        if (
            isset($order->items) &&
            $order->items &&
            $order->items->count() > 0
        ) {

            foreach (
                $order->items as $item
            ) {

                $itemTotal =
                    $item->total
                    ??
                    (
                        ($item->price ?? 0)
                        *
                        ($item->quantity ?? 0)
                    );


                $reportTotalSales +=
                    (float) $itemTotal;
            }

        } else {

            // ------------------------------------------------
            // ORDER WITHOUT ITEMS
            // ------------------------------------------------

            $reportTotalSales +=
                (float) (
                    $order->total_amount
                    ??
                    $order->total
                    ??
                    0
                );
        }
    }


    // ====================================================
    // RETURN ADMIN DASHBOARD
    // ====================================================

    return view(
        'dashboard',
        compact(

            // ------------------------------------------------
            // DASHBOARD
            // ------------------------------------------------

            'totalProducts',
            'totalUsers',
            'activeOrders',
            'recentOrders',


            // ------------------------------------------------
            // FILTERED REPORT DATA
            // ------------------------------------------------

            'products',
            'orders',
            'users',


            // ------------------------------------------------
            // OTHER DATA
            // ------------------------------------------------

            'categories',
            'page',
            'newOrderCount',
            'newOrders',
            'coupons',


            // ------------------------------------------------
            // VISITORS
            // ------------------------------------------------

            'totalVisitors',
            'todayVisitors',
            'latestVisitor',
            'visitors',


            // ------------------------------------------------
            // SETTINGS
            // ------------------------------------------------

            'setting',


            // ------------------------------------------------
            // ADMINS
            // ------------------------------------------------

            'admins',


            // ------------------------------------------------
            // ENQUIRIES
            // ------------------------------------------------

            'enquiries',
            'pendingEnquiries',
            'unreadEnquiries',


            // ------------------------------------------------
            // SHIPPING
            // ------------------------------------------------

            'shipping',


            // ------------------------------------------------
            // DATE FILTER
            // ------------------------------------------------

            'dateFrom',
            'dateTo',
            'invalidDateRange',


            // ------------------------------------------------
            // REPORT SUMMARY
            // ------------------------------------------------

            'reportTotalProducts',
            'reportTotalUsers',
            'reportTotalOrders',
            'reportTotalStock',
            'reportLowStock',
            'reportOutOfStock',
            'reportInStock',
            'reportTotalSales'

        )
    );


        // ====================================================
    // ====================================================
    // DATE FILTER
    // ====================================================

    $dateFrom = $request->query(
        'date_from'
    );

    $dateTo = $request->query(
        'date_to'
    );


    // ====================================================
    // CLEAN DATE VALUES
    // ====================================================

    $dateFrom = $dateFrom
        ? trim($dateFrom)
        : null;


    $dateTo = $dateTo
        ? trim($dateTo)
        : null;


    // ====================================================
    // INVALID DATE RANGE FLAG
    // ====================================================

    $invalidDateRange = false;


    // ====================================================
    // VALIDATE DATE FORMAT
    // ====================================================

    if (

        $dateFrom &&

        !preg_match(
            '/^\d{4}-\d{2}-\d{2}$/',
            $dateFrom
        )

    ) {

        $dateFrom = null;

        $invalidDateRange = true;
    }


    if (

        $dateTo &&

        !preg_match(
            '/^\d{4}-\d{2}-\d{2}$/',
            $dateTo
        )

    ) {

        $dateTo = null;

        $invalidDateRange = true;
    }


    // ====================================================
    // CHECK FROM DATE > TO DATE
    // ====================================================

    if (
        $dateFrom &&
        $dateTo &&
        !$invalidDateRange
    ) {

        try {

            $fromDate = \Carbon\Carbon::createFromFormat(
                'Y-m-d',
                $dateFrom
            )->startOfDay();


            $toDate = \Carbon\Carbon::createFromFormat(
                'Y-m-d',
                $dateTo
            )->endOfDay();


            // ====================================================
            // IMPORTANT
            // DO NOT SWAP DATES
            // ====================================================

            if (
                $fromDate->greaterThan(
                    $toDate
                )
            ) {

                $invalidDateRange = true;
            }

        } catch (
            \Exception $e
        ) {

            $invalidDateRange = true;
        }
    }


    // ====================================================
    // NORMAL USERS
    // ====================================================

    $usersQuery = User::where(
        'is_admin',
        0
    );


    // ====================================================
    // USER DATE FILTER
    // ====================================================

    if ($invalidDateRange) {

        // Impossible condition
        // Returns ZERO records

        $usersQuery->whereRaw(
            '1 = 0'
        );

    } else {

        if ($dateFrom) {

            $usersQuery->where(
                'created_at',
                '>=',
                \Carbon\Carbon::parse(
                    $dateFrom
                )->startOfDay()
            );
        }


        if ($dateTo) {

            $usersQuery->where(
                'created_at',
                '<=',
                \Carbon\Carbon::parse(
                    $dateTo
                )->endOfDay()
            );
        }
    }


    $users = $usersQuery

        ->latest('created_at')

        ->get();


    // ====================================================
    // ADMINS
    // ====================================================

    $admins = User::where(
        'is_admin',
        1
    )
        ->latest('created_at')
        ->get();


    // ====================================================
    // NEW ORDER NOTIFICATION
    // ====================================================

    $lastSeenOrderId = session(
        'last_seen_order_id',
        0
    );


    $newOrders = Order::with(
        'user'
    )

        ->where(
            'id',
            '>',
            $lastSeenOrderId
        )

        ->where(
            'status',
            'Pending'
        )

        ->latest('created_at')

        ->get();


    $newOrderCount =
        $newOrders->count();


    // ====================================================
    // DASHBOARD SUMMARY
    // ====================================================

    $totalProducts =
        Product::count();


    $totalUsers =
        User::where(
            'is_admin',
            0
        )->count();


    $activeOrders =
        Order::whereIn(
            'status',
            [
                'Pending',
                'Processing',
                'Shipped'
            ]
        )->count();


    // ====================================================
    // WEBSITE VISITORS
    // ====================================================

    $totalVisitors =
        Visitor::distinct(
            'ip_address'
        )->count(
            'ip_address'
        );


    $todayVisitors =
        Visitor::whereDate(
            'created_at',
            today()
        )

        ->distinct(
            'ip_address'
        )

        ->count(
            'ip_address'
        );


    $latestVisitor =
        Visitor::latest(
            'created_at'
        )->first();


    $visitors =
        Visitor::orderBy(
            'created_at',
            'desc'
        )->get();


    // ====================================================
    // SETTINGS
    // ====================================================

    $setting =
        Setting::first();


    // ====================================================
    // RECENT ORDERS
    // ====================================================

    $recentOrders =
        Order::with([

            'user',
            'items.product'

        ])

        ->latest('created_at')

        ->take(10)

        ->get();


    // ====================================================
    // PRODUCTS
    // ====================================================

    $productsQuery =
        Product::query();


    // ====================================================
    // PRODUCT DATE FILTER
    // ====================================================

    if ($invalidDateRange) {

        $productsQuery->whereRaw(
            '1 = 0'
        );

    } else {

        if ($dateFrom) {

            $productsQuery->where(
                'created_at',
                '>=',
                \Carbon\Carbon::parse(
                    $dateFrom
                )->startOfDay()
            );
        }


        if ($dateTo) {

            $productsQuery->where(
                'created_at',
                '<=',
                \Carbon\Carbon::parse(
                    $dateTo
                )->endOfDay()
            );
        }
    }


    $products =
        $productsQuery

        ->latest('created_at')

        ->get();


    // ====================================================
    // CATEGORIES
    // ====================================================

    $categories =
        Product::select(
            'category'
        )

        ->distinct()

        ->orderBy(
            'category'
        )

        ->pluck(
            'category'
        );


    // ====================================================
    // ORDERS
    // ====================================================

    $ordersQuery =
        Order::with([

            'user',
            'items.product'

        ]);


    // ====================================================
    // ORDER DATE FILTER
    // ====================================================

    if ($invalidDateRange) {

        $ordersQuery->whereRaw(
            '1 = 0'
        );

    } else {

        if ($dateFrom) {

            $ordersQuery->where(
                'created_at',
                '>=',
                \Carbon\Carbon::parse(
                    $dateFrom
                )->startOfDay()
            );
        }


        if ($dateTo) {

            $ordersQuery->where(
                'created_at',
                '<=',
                \Carbon\Carbon::parse(
                    $dateTo
                )->endOfDay()
            );
        }
    }


    $orders =
        $ordersQuery

        ->latest('created_at')

        ->get();


    // ====================================================
    // COUPONS
    // ====================================================

    $coupons =
        Coupon::latest()
        ->get();


    // ====================================================
    // ENQUIRIES
    // ====================================================

    $enquiries =
        Enquiry::with(
            'user'
        )

        ->latest('created_at')

        ->get();


    // ====================================================
    // PENDING ENQUIRIES
    // ====================================================

    $pendingEnquiries =
        Enquiry::where(
            'status',
            'pending'
        )->count();


    // ====================================================
    // UNREAD ENQUIRIES
    // ====================================================

    $unreadEnquiries =
        Enquiry::where(
            'admin_read',
            false
        )->count();


    // ====================================================
    // REPORT TOTAL PRODUCTS
    // ====================================================

    $reportTotalProducts =
        $products->count();


    // ====================================================
    // REPORT TOTAL USERS
    // ====================================================

    $reportTotalUsers =
        $users->count();


    // ====================================================
    // REPORT TOTAL ORDERS
    // ====================================================

    $reportTotalOrders =
        $orders->count();


    // ====================================================
    // REPORT TOTAL STOCK
    // ====================================================

    $reportTotalStock =
        $products->sum(

            function ($product) {

                return (int) (
                    $product->stock ?? 0
                );
            }

        );


    // ====================================================
    // LOW STOCK
    // ====================================================

    $reportLowStock =
        $products->filter(

            function ($product) {

                $stock = (int) (
                    $product->stock ?? 0
                );


                return (

                    $stock > 0 &&

                    $stock <= 5

                );
            }

        )->count();


    // ====================================================
    // OUT OF STOCK
    // ====================================================

    $reportOutOfStock =
        $products->filter(

            function ($product) {

                return (

                    (int) (
                        $product->stock ?? 0
                    ) === 0

                );
            }

        )->count();


    // ====================================================
    // IN STOCK
    // ====================================================

    $reportInStock =
        $products->filter(

            function ($product) {

                return (

                    (int) (
                        $product->stock ?? 0
                    ) > 5

                );
            }

        )->count();


    // ====================================================
    // TOTAL SALES
    // ====================================================

    $reportTotalSales = 0;


    foreach (
        $orders
        as $order
    ) {


        // ====================================================
        // CANCELLED ORDER SKIP
        // ====================================================

        if (

            strtolower(
                $order->status ?? ''
            ) === 'cancelled'

        ) {

            continue;
        }


        // ====================================================
        // ORDER HAS ITEMS
        // ====================================================

        if (

            isset($order->items) &&

            $order->items &&

            $order->items->count() > 0

        ) {


            foreach (
                $order->items
                as $item
            ) {


                $itemTotal =
                    $item->total
                    ??
                    (
                        ($item->price ?? 0)
                        *
                        ($item->quantity ?? 0)
                    );


                $reportTotalSales +=
                    (float) $itemTotal;
            }


        } else {


            // ====================================================
            // ORDER WITHOUT ITEMS
            // ====================================================

            $reportTotalSales +=
                (float) (

                    $order->total_amount
                    ??
                    $order->total
                    ??
                    0

                );
        }
    }


    // ====================================================
    // RETURN DASHBOARD VIEW
    // ====================================================

    return view(
        'dashboard',
        compact(

            // ====================================================
            // DASHBOARD
            // ====================================================

            'totalProducts',
            'totalUsers',
            'activeOrders',
            'recentOrders',


            // ====================================================
            // FILTERED REPORT DATA
            // ====================================================

            'products',
            'orders',
            'users',


            // ====================================================
            // OTHER DATA
            // ====================================================

            'categories',
            'page',

            'newOrderCount',
            'newOrders',

            'coupons',


            // ====================================================
            // VISITORS
            // ====================================================

            'totalVisitors',
            'todayVisitors',
            'latestVisitor',
            'visitors',


            // ====================================================
            // SETTINGS
            // ====================================================

            'setting',


            // ====================================================
            // ADMINS
            // ====================================================

            'admins',


            // ====================================================
            // ENQUIRIES
            // ====================================================

            'enquiries',
            'pendingEnquiries',
            'unreadEnquiries',


            // ====================================================
            // DATE FILTER
            // ====================================================

            'dateFrom',
            'dateTo',
            'invalidDateRange',


            // ====================================================
            // REPORT SUMMARY
            // ====================================================

            'reportTotalProducts',
            'reportTotalUsers',
            'reportTotalOrders',
            'reportTotalStock',
            'reportLowStock',
            'reportOutOfStock',
            'reportInStock',
            'reportTotalSales'

        )
    );
}

// ====================================================
// DATABASE BACKUP PAGE
// ====================================================

public function backupDatabase()
{
    // ------------------------------------------------
    // ADMIN LOGIN CHECK
    // ------------------------------------------------

    if (session('admin_logged_in') !== true) {

        return redirect()
            ->route('admin.login')
            ->with(
                'admin_error',
                'Please login to access database backup.'
            );
    }


    // ------------------------------------------------
    // SUPERADMIN CHECK
    // ------------------------------------------------

    if (session('admin_role') !== 'superadmin') {

        return redirect()
            ->route('admin.dashboard')
            ->with(
                'error',
                'You are not authorized to access database backup.'
            );
    }


    // ------------------------------------------------
    // OPEN BACKUP SECTION INSIDE DASHBOARD
    // ------------------------------------------------

    return redirect()->route(
        'admin.dashboard',
        [
            'page' => 'backup'
        ]
    );
}



// ====================================================
// DOWNLOAD SQL DATABASE BACKUP
// ====================================================

public function downloadBackup()
{
    // ------------------------------------------------
    // ADMIN LOGIN CHECK
    // ------------------------------------------------

    if (session('admin_logged_in') !== true) {

        return redirect()
            ->route('admin.login')
            ->with(
                'admin_error',
                'Please login to access database backup.'
            );
    }


    // ------------------------------------------------
    // SUPERADMIN CHECK
    // ------------------------------------------------

    if (session('admin_role') !== 'superadmin') {

        return redirect()
            ->route('admin.dashboard')
            ->with(
                'error',
                'You are not authorized to download database backup.'
            );
    }


    // ------------------------------------------------
    // DATABASE CONFIGURATION
    // ------------------------------------------------

    $database = config(
        'database.connections.mysql.database'
    );

    $username = config(
        'database.connections.mysql.username'
    );

    $password = config(
        'database.connections.mysql.password'
    );

    $host = config(
        'database.connections.mysql.host'
    );

    $port = config(
        'database.connections.mysql.port',
        3306
    );


    // ------------------------------------------------
    // MYSQLDUMP LOCATION
    // ------------------------------------------------

    $mysqldump =
        'C:\\xampp\\mysql\\bin\\mysqldump.exe';


    // ------------------------------------------------
    // CHECK MYSQLDUMP
    // ------------------------------------------------

    if (!file_exists($mysqldump)) {

        return redirect()
            ->route(
                'admin.dashboard',
                [
                    'page' => 'backup'
                ]
            )
            ->with(
                'error',
                'mysqldump.exe not found. Please check XAMPP MySQL installation.'
            );
    }


    // ------------------------------------------------
    // BACKUP FILE NAME
    // ------------------------------------------------

    $fileName =
        'classic_database_backup_' .
        date('Y-m-d_H-i-s') .
        '.sql';


    // ------------------------------------------------
    // BACKUP PATH
    // ------------------------------------------------

    $backupPath =
        storage_path(
            'app\\' . $fileName
        );


    // ------------------------------------------------
    // MYSQLDUMP COMMAND
    // ------------------------------------------------

    $command =
        '"' . $mysqldump . '"' .
        ' --host=' .
        escapeshellarg($host) .
        ' --port=' .
        escapeshellarg($port) .
        ' --user=' .
        escapeshellarg($username) .
        ' --password=' .
        escapeshellarg($password) .
        ' --single-transaction' .
        ' --routines' .
        ' --triggers' .
        ' ' .
        escapeshellarg($database) .
        ' > ' .
        escapeshellarg($backupPath);


    // ------------------------------------------------
    // EXECUTE BACKUP
    // ------------------------------------------------

    exec(
        $command,
        $output,
        $returnCode
    );


    // ------------------------------------------------
    // BACKUP FAILED
    // ------------------------------------------------

    if (
        $returnCode !== 0 ||
        !file_exists($backupPath) ||
        filesize($backupPath) === 0
    ) {

        if (file_exists($backupPath)) {
            unlink($backupPath);
        }

        return redirect()
            ->route(
                'admin.dashboard',
                [
                    'page' => 'backup'
                ]
            )
            ->with(
                'error',
                'Database SQL backup failed.'
            );
    }


    // ------------------------------------------------
    // DOWNLOAD SQL BACKUP
    // ------------------------------------------------

    return response()
        ->download(
            $backupPath,
            $fileName,
            [
                'Content-Type' =>
                    'application/sql',
            ]
        )
        ->deleteFileAfterSend(true);
}



// ====================================================
// DOWNLOAD JSON DATABASE BACKUP
// ====================================================

public function downloadJsonBackup()
{
    // ------------------------------------------------
    // ADMIN LOGIN CHECK
    // ------------------------------------------------

    if (session('admin_logged_in') !== true) {

        return redirect()
            ->route('admin.login')
            ->with(
                'admin_error',
                'Please login to access database backup.'
            );
    }


    // ------------------------------------------------
    // SUPERADMIN CHECK
    // ------------------------------------------------

    if (session('admin_role') !== 'superadmin') {

        return redirect()
            ->route('admin.dashboard')
            ->with(
                'error',
                'You are not authorized to download database backup.'
            );
    }


    try {

        // ------------------------------------------------
        // GET ALL DATABASE TABLES
        // ------------------------------------------------

        $tables = \DB::select(
            'SHOW TABLES'
        );


        // ------------------------------------------------
        // CREATE BACKUP ARRAY
        // ------------------------------------------------

        $backup = [

            'backup_info' => [

                'project' =>
                    'Classic Glasses Store',

                'database' =>
                    config(
                        'database.connections.mysql.database'
                    ),

                'created_at' =>
                    now()->format(
                        'Y-m-d H:i:s'
                    ),

            ],

            'tables' => [],

        ];


        // ------------------------------------------------
        // GET TABLE DATA
        // ------------------------------------------------

        foreach ($tables as $table) {

            $tableArray =
                (array) $table;

            $tableName =
                reset($tableArray);


            try {

                $backup['tables'][$tableName] =
                    \DB::table(
                        $tableName
                    )
                    ->get()
                    ->toArray();

            } catch (\Throwable $e) {

                $backup['tables'][$tableName] = [];
            }
        }


        // ------------------------------------------------
        // JSON FILE NAME
        // ------------------------------------------------

        $fileName =
            'classic_database_backup_' .
            date('Y-m-d_H-i-s') .
            '.json';


        // ------------------------------------------------
        // JSON CONTENT
        // ------------------------------------------------

        $json =
            json_encode(
                $backup,
                JSON_PRETTY_PRINT |
                JSON_UNESCAPED_UNICODE
            );


        // ------------------------------------------------
        // DOWNLOAD JSON
        // ------------------------------------------------

        return response(
            $json,
            200,
            [

                'Content-Type' =>
                    'application/json',

                'Content-Disposition' =>
                    'attachment; filename="' .
                    $fileName .
                    '"',

            ]
        );

    } catch (\Throwable $e) {

        return redirect()
            ->route(
                'admin.dashboard',
                [
                    'page' => 'backup'
                ]
            )
            ->with(
                'error',
                'JSON database backup failed: ' .
                $e->getMessage()
            );
    }
}



// ====================================================
// RESTORE / IMPORT SQL DATABASE
// ====================================================

public function restoreSqlBackup(Request $request)
{
    // ------------------------------------------------
    // ADMIN LOGIN CHECK
    // ------------------------------------------------

    if (session('admin_logged_in') !== true) {

        return redirect()
            ->route('admin.login')
            ->with(
                'admin_error',
                'Please login to access database restore.'
            );
    }


    // ------------------------------------------------
    // SUPERADMIN CHECK
    // ------------------------------------------------

    if (session('admin_role') !== 'superadmin') {

        return redirect()
            ->route('admin.dashboard')
            ->with(
                'error',
                'You are not authorized to restore database.'
            );
    }


    // ------------------------------------------------
    // VALIDATE SQL FILE
    // ------------------------------------------------

    $request->validate(
        [
            'sql_file' =>
                'required|file|mimes:sql,txt|max:51200',
        ],
        [
            'sql_file.required' =>
                'Please select an SQL backup file.',

            'sql_file.file' =>
                'Invalid backup file.',

            'sql_file.mimes' =>
                'Only SQL backup files are allowed.',

            'sql_file.max' =>
                'Backup file size must not exceed 50 MB.',
        ]
    );


    try {

        // ------------------------------------------------
        // GET UPLOADED FILE
        // ------------------------------------------------

        $file =
            $request->file('sql_file');


        $sql =
            file_get_contents(
                $file->getRealPath()
            );


        if (
            !$sql ||
            trim($sql) === ''
        ) {

            return redirect()
                ->route(
                    'admin.dashboard',
                    [
                        'page' => 'backup'
                    ]
                )
                ->with(
                    'error',
                    'The SQL backup file is empty.'
                );
        }


        // ------------------------------------------------
        // DATABASE CONNECTION
        // ------------------------------------------------

        $pdo =
            \DB::connection()
                ->getPdo();


        // ------------------------------------------------
        // DISABLE FOREIGN KEY CHECK
        // ------------------------------------------------

        \DB::statement(
            'SET FOREIGN_KEY_CHECKS=0'
        );


        // ------------------------------------------------
        // EXECUTE SQL
        // ------------------------------------------------

        $pdo->exec($sql);


        // ------------------------------------------------
        // ENABLE FOREIGN KEY CHECK
        // ------------------------------------------------

        \DB::statement(
            'SET FOREIGN_KEY_CHECKS=1'
        );


        // ------------------------------------------------
        // SUCCESS
        // ------------------------------------------------

        return redirect()
            ->route(
                'admin.dashboard',
                [
                    'page' => 'backup'
                ]
            )
            ->with(
                'success',
                'SQL database restored successfully.'
            );

    } catch (\Throwable $e) {

        // ------------------------------------------------
        // ENABLE FOREIGN KEY CHECK AGAIN
        // ------------------------------------------------

        try {

            \DB::statement(
                'SET FOREIGN_KEY_CHECKS=1'
            );

        } catch (\Throwable $ignored) {
        }


        return redirect()
            ->route(
                'admin.dashboard',
                [
                    'page' => 'backup'
                ]
            )
            ->with(
                'error',
                'SQL database restore failed: ' .
                $e->getMessage()
            );
    }
}



// ====================================================
// RESTORE / IMPORT JSON DATABASE BACKUP
// ====================================================

public function restoreJsonBackup(Request $request)
{
    // ------------------------------------------------
    // ADMIN LOGIN CHECK
    // ------------------------------------------------

    if (session('admin_logged_in') !== true) {

        return redirect()
            ->route('admin.login')
            ->with(
                'admin_error',
                'Please login to access database restore.'
            );
    }


    // ------------------------------------------------
    // SUPERADMIN CHECK
    // ------------------------------------------------

    if (session('admin_role') !== 'superadmin') {

        return redirect()
            ->route('admin.dashboard')
            ->with(
                'error',
                'You are not authorized to restore database.'
            );
    }


    // ------------------------------------------------
    // VALIDATE JSON FILE
    // ------------------------------------------------

    $request->validate(
        [
            'json_file' =>
                'required|file|mimes:json,txt|max:51200',
        ],
        [
            'json_file.required' =>
                'Please select a JSON backup file.',

            'json_file.file' =>
                'Invalid backup file.',

            'json_file.mimes' =>
                'Only JSON backup files are allowed.',

            'json_file.max' =>
                'Backup file size must not exceed 50 MB.',
        ]
    );


    try {

        // ------------------------------------------------
        // GET UPLOADED FILE
        // ------------------------------------------------

        $file =
            $request->file('json_file');


        $json =
            file_get_contents(
                $file->getRealPath()
            );


        if (
            !$json ||
            trim($json) === ''
        ) {

            return redirect()
                ->route(
                    'admin.dashboard',
                    [
                        'page' => 'backup'
                    ]
                )
                ->with(
                    'error',
                    'The JSON backup file is empty.'
                );
        }


        // ------------------------------------------------
        // DECODE JSON
        // ------------------------------------------------

        $backup =
            json_decode(
                $json,
                true
            );


        if (
            !is_array($backup) ||
            !isset($backup['tables']) ||
            !is_array($backup['tables'])
        ) {

            return redirect()
                ->route(
                    'admin.dashboard',
                    [
                        'page' => 'backup'
                    ]
                )
                ->with(
                    'error',
                    'Invalid Classic database JSON backup file.'
                );
        }


        // ------------------------------------------------
        // DATABASE CONNECTION
        // ------------------------------------------------

        \DB::statement(
            'SET FOREIGN_KEY_CHECKS=0'
        );


        // ------------------------------------------------
        // RESTORE TABLE DATA
        // ------------------------------------------------

        foreach (
            $backup['tables']
            as $tableName => $rows
        ) {

            // --------------------------------------------
            // CHECK TABLE NAME
            // --------------------------------------------

            if (
                !is_string($tableName) ||
                !preg_match(
                    '/^[A-Za-z0-9_]+$/',
                    $tableName
                )
            ) {
                continue;
            }


            // --------------------------------------------
            // CHECK TABLE EXISTS
            // --------------------------------------------

            if (
                !\Schema::hasTable(
                    $tableName
                )
            ) {
                continue;
            }


            // --------------------------------------------
            // CHECK ROW DATA
            // --------------------------------------------

            if (
                !is_array($rows) ||
                empty($rows)
            ) {
                continue;
            }


            // --------------------------------------------
            // CLEAR EXISTING TABLE
            // --------------------------------------------

            \DB::table(
                $tableName
            )->delete();


            // --------------------------------------------
            // INSERT DATA IN CHUNKS
            // --------------------------------------------

            $insertRows = [];

            foreach ($rows as $row) {

                if (
                    is_array($row) &&
                    !empty($row)
                ) {

                    $insertRows[] = $row;
                }


                // ----------------------------------------
                // INSERT EVERY 500 ROWS
                // ----------------------------------------

                if (
                    count($insertRows) >= 500
                ) {

                    \DB::table(
                        $tableName
                    )->insert(
                        $insertRows
                    );

                    $insertRows = [];
                }
            }


            // --------------------------------------------
            // INSERT REMAINING ROWS
            // --------------------------------------------

            if (!empty($insertRows)) {

                \DB::table(
                    $tableName
                )->insert(
                    $insertRows
                );
            }
        }


        // ------------------------------------------------
        // ENABLE FOREIGN KEY CHECK
        // ------------------------------------------------

        \DB::statement(
            'SET FOREIGN_KEY_CHECKS=1'
        );


        // ------------------------------------------------
        // SUCCESS
        // ------------------------------------------------

        return redirect()
            ->route(
                'admin.dashboard',
                [
                    'page' => 'backup'
                ]
            )
            ->with(
                'success',
                'JSON database restored successfully.'
            );

    } catch (\Throwable $e) {

        // ------------------------------------------------
        // ENABLE FOREIGN KEY CHECK AGAIN
        // ------------------------------------------------

        try {

            \DB::statement(
                'SET FOREIGN_KEY_CHECKS=1'
            );

        } catch (\Throwable $ignored) {
        }


        return redirect()
            ->route(
                'admin.dashboard',
                [
                    'page' => 'backup'
                ]
            )
            ->with(
                'error',
                'JSON database restore failed: ' .
                $e->getMessage()
            );
    }
}




    // ====================================================
    // ADMIN ENQUIRY LIVE NOTIFICATION
    // ====================================================

    public function adminEnquiryNotification()
    {
        // ====================================================
        // ADMIN LOGIN CHECK
        // ====================================================

        if (!session('admin_logged_in')) {

            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }


        // ====================================================
        // GET LATEST UNREAD ENQUIRY
        // ====================================================

        $latest = Enquiry::with('user')
            ->where(
                'admin_read',
                false
            )
            ->latest()
            ->first();


        // ====================================================
        // TOTAL UNREAD ENQUIRIES
        // ====================================================

        $count =
            Enquiry::where(
                'admin_read',
                false
            )
            ->count();


        // ====================================================
        // RESPONSE
        // ====================================================

        return response()->json([

            'success' => true,

            'count' => $count,

            'latest' => $latest
                ? [

                    'id' =>
                        $latest->id,

                    'name' =>
                        $latest->name
                        ?? optional(
                            $latest->user
                        )->name
                        ?? 'Guest',

                    'email' =>
                        $latest->email
                        ?? optional(
                            $latest->user
                        )->email
                        ?? '',

                    'subject' =>
                        $latest->subject,

                    'message' =>
                        $latest->message,

                    'created_at' =>
                        $latest->created_at
                        ? $latest->created_at
                            ->format(
                                'd M Y, h:i A'
                            )
                        : '',
                ]

                : null
        ]);
    }

// ====================================================
// MARK NEW ORDERS AS SEEN
// ====================================================

public function markOrderNotificationsSeen()
{
    if (!session('admin_logged_in')) {
        return response()->json([
            'success' => false
        ], 401);
    }

    $latestOrder = Order::latest('id')->first();

    if ($latestOrder) {

        session([
            'last_seen_order_id' => $latestOrder->id
        ]);

    }

    return response()->json([
        'success' => true
    ]);
}
    // ====================================================
    // ADMIN ORDERS
    // ====================================================

    public function adminOrders()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $orders = Order::with([
            'user',
            'items.product'
        ])
            ->latest()
            ->get();

        return view('admin-orders', compact('orders'));
    }

// ====================================================
// UPDATE ORDER STATUS
// ====================================================

public function updateOrderStatus(Request $request, $id)
{


    // ====================================================
    // ADMIN LOGIN CHECK
    // ====================================================

    if (!session('admin_logged_in')) {
        return redirect()->route('admin.login');
    }

    // ====================================================
    // VALIDATION
    // ====================================================

    $request->validate([
        'status' => 'required|in:Pending,Processing,Shipped,Delivered,Cancelled',
    ]);

    // ====================================================
    // FIND ORDER
    // ====================================================

    $order = Order::findOrFail($id);

    // ====================================================
    // UPDATE ORDER STATUS
    // ====================================================

    $order->status = $request->status;
    $order->save();

    // ====================================================
    // CREATE NOTIFICATION FOR USER ONLY
    // ====================================================

    if ($order->user_id) {

        $status = $order->status;

        // ====================================================
        // MESSAGE ACCORDING TO STATUS
        // ====================================================

        switch ($status) {

            case 'Pending':

                $message =
                    'Your Order #' . $order->id .
                    ' is Pending.';

                break;

            case 'Processing':

                $message =
                    'Your Order #' . $order->id .
                    ' is now Processing.';

                break;

            case 'Shipped':

                $message =
                    'Your Order #' . $order->id .
                    ' has been Shipped!';

                break;

            case 'Delivered':

                $message =
                    'Your Order #' . $order->id .
                    ' has been Delivered!';

                break;

            case 'Cancelled':

                $message =
                    'Your Order #' . $order->id .
                    ' has been Cancelled.';

                break;

            default:

                $message =
                    'Your Order #' . $order->id .
                    ' status has been updated.';

                break;
        }

        // ====================================================
        // SAVE USER NOTIFICATION
        // ====================================================

        OrderNotification::create([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'status' => $status,
            'message' => $message,
            'is_read' => false,
        ]);
    }

    // ====================================================
    // ADMIN SUCCESS MESSAGE ONLY
    // ====================================================

    return redirect()
        ->route('admin.dashboard', [
            'page' => 'view-orders'
        ])
        ->with(
            'success',
            'Order status updated successfully!'
        );
}
// =====================================================
// VIEW ORDER BILL
// =====================================================

public function orderBill($id)
{
    $order = Order::with([
        'user',
        'items'
    ])->findOrFail($id);

    if ($order->status !== 'Delivered') {

        return redirect()
            ->back()
            ->with(
                'error',
                'Bill is available only after the order is delivered.'
            );
    }

    return view('order-bill', compact('order'));
}


// =====================================================
// DOWNLOAD ORDER BILL PDF
// =====================================================

public function downloadOrderBill($id)
{
    $order = Order::with([
        'user',
        'items'
    ])->findOrFail($id);

    if ($order->status !== 'Delivered') {

        return redirect()
            ->back()
            ->with(
                'error',
                'PDF bill is available only after the order is delivered.'
            );
    }

    $pdf = Pdf::loadView(
        'order-bill',
        compact('order')
    );

    $pdf->setPaper('A4', 'portrait');

    return $pdf->download(
        'Order-Bill-' . $order->id . '.pdf'
    );

}
    // ====================================================
    // ADD PRODUCT PAGE
    // ====================================================

    public function create()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return redirect()->route(
            'admin.dashboard',
            ['page' => 'add-product']
        );
    }

    // ====================================================
// STORE PRODUCT
// ====================================================

public function store(Request $request)
{
    if (!session('admin_logged_in')) {
        return redirect()->route('admin.login');
    }

    // ====================================================
    // VALIDATION
    // ====================================================

    $request->validate([

        'name' => 'required|string|max:255',

        'category' => 'required|string|max:255',

        'price' => 'required|numeric|min:0',

        'stock' => 'required|integer|min:0',

        'images' => 'required|array|min:1|max:5',

        'images.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',

        'description' => 'required|string',

    ]);


    // ====================================================
    // IMAGE DESTINATION
    // ====================================================

    $destinationPath = public_path('product-images');

    if (!file_exists($destinationPath)) {

        mkdir($destinationPath, 0777, true);

    }


    // ====================================================
    // FIRST IMAGE
    // ====================================================

    $mainImageName = null;


    // ====================================================
    // CREATE PRODUCT FIRST
    // ====================================================

    $product = Product::create([

        'name' => $request->name,

        'category' => $request->category,

        'price' => $request->price,

        'stock' => $request->stock,

        'image' => null,

        'description' => $request->description,

    ]);


    // ====================================================
    // UPLOAD ALL IMAGES
    // ====================================================

    foreach ($request->file('images') as $index => $image) {

        $imageName =
            time() . '_' .
            uniqid() . '_' .
            $image->getClientOriginalName();


        // MOVE IMAGE

        $image->move(
            $destinationPath,
            $imageName
        );


        // ====================================================
        // FIRST IMAGE = MAIN IMAGE
        // ====================================================

        if ($index === 0) {

            $mainImageName = $imageName;

        }


        // ====================================================
        // SAVE IMAGE IN PRODUCT_IMAGES TABLE
        // ====================================================

        ProductImage::create([

            'product_id' => $product->id,

            'image' => $imageName,

        ]);

    }


    // ====================================================
    // UPDATE MAIN IMAGE
    // ====================================================

    $product->update([

        'image' => $mainImageName,

    ]);


    // ====================================================
    // REDIRECT
    // ====================================================

    return redirect()
        ->route(
            'admin.dashboard',
            ['page' => 'add-product']
        )
        ->with(
            'success',
            'Product added successfully with images!'
        );
}
   // ====================================================
// PRODUCTS PAGE
// ====================================================

public function index()
{
    $products = Product::with('images')->latest()->get();

    return view(
        'products',
        compact('products')
    );
}
// ====================================================
// PRODUCT DETAILS
// ====================================================

public function show($id)
{
    $product = Product::with('images')
        ->findOrFail($id);

    return view(
        'product-details',
        compact('product')
    );
}
    // ====================================================
    // MANAGE PRODUCTS
    // ====================================================

    public function manage()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return redirect()->route(
            'admin.dashboard',
            ['page' => 'manage-products']
        );
    }

    // ====================================================
    // EDIT PRODUCT
    // ====================================================

    public function edit($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return redirect()->route(
            'admin.dashboard',
            [
                'page' => 'manage-products',
                'edit' => $id
            ]
        );
    }

    // ====================================================
// UPDATE PRODUCT
// ====================================================

public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    // ====================================================
    // VALIDATION
    // ====================================================

    $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:100',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'description' => 'required|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
    ]);

    // ====================================================
    // BASIC PRODUCT DETAILS
    // ====================================================

    $product->name = $request->name;
    $product->category = $request->category;
    $product->price = $request->price;
    $product->stock = $request->stock;
    $product->description = $request->description;

    // ====================================================
    // UPDATE IMAGE
    // ====================================================

    if ($request->hasFile('image')) {

        $image = $request->file('image');

        // Unique filename
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

        // Make sure folder exists
        $imagePath = public_path('product-images');

        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0777, true);
        }

        // Delete old image
        if (
            $product->image &&
            file_exists(public_path('product-images/' . $product->image))
        ) {
            unlink(public_path('product-images/' . $product->image));
        }

        // Save new image
        $image->move($imagePath, $imageName);

        // Save filename in database
        $product->image = $imageName;
    }

    // ====================================================
    // SAVE PRODUCT
    // ====================================================

    $product->save();

    // ====================================================
    // REDIRECT
    // ====================================================

    return redirect()
        ->route('admin.dashboard', ['page' => 'manage-products'])
        ->with('success', 'Product updated successfully.');
}

    // ====================================================
    // DELETE PRODUCT
    // ====================================================

    public function destroy($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $product = Product::findOrFail($id);

        // DELETE IMAGE

        if ($product->image) {

            $imagePath = public_path(
                'product-images/' . $product->image
            );

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // DELETE PRODUCT

        $product->delete();

        return redirect()
            ->route(
                'admin.dashboard',
                ['page' => 'manage-products']
            )
            ->with(
                'success',
                'Product deleted successfully!'
            );
    }

// ====================================================
// ADD PRODUCT REVIEW
// ====================================================

public function addReview(Request $request, $id)
{
    if (!auth()->check()) {
        return redirect()
            ->route('login')
            ->with('error', 'Please login to review this product.');
    }

    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'nullable|string|max:1000',
    ]);

    $product = Product::findOrFail($id);

    // Check whether user purchased this product
    $hasPurchased = \App\Models\OrderItem::where('product_id', $product->id)
        ->whereHas('order', function ($query) {
            $query->where('user_id', auth()->id())
                  ->whereIn('status', [
                      'Pending',
                      'Processing',
                      'Shipped',
                      'Delivered'
                  ]);
        })
        ->exists();

    if (!$hasPurchased) {
        return back()->with(
            'error',
            'Only customers who purchased this product can submit a review.'
        );
    }

    // Prevent duplicate review
    $alreadyReviewed = \App\Models\Review::where('user_id', auth()->id())
        ->where('product_id', $product->id)
        ->exists();

    if ($alreadyReviewed) {
        return back()->with(
            'error',
            'You have already reviewed this product.'
        );
    }

    \App\Models\Review::create([
        'user_id' => auth()->id(),
        'product_id' => $product->id,
        'rating' => $request->rating,
        'review' => $request->review,
    ]);

    return back()->with(
        'success',
        'Thank you! Your review has been submitted.'
    );
}

// ====================================================
// ADD PRODUCT TO CART
// ====================================================

public function addToCart(Request $request, $id)
{
    // ====================================================
    // USER LOGIN CHECK
    // ====================================================

    if (!auth()->check()) {

        return redirect()
            ->route('login')
            ->with(
                'error',
                'Please login to add products to cart.'
            );
    }


    // ====================================================
    // FIND PRODUCT
    // ====================================================

    $product = Product::find($id);

    if (!$product) {

        return back()->with(
            'error',
            'Product not found.'
        );
    }


    // ====================================================
    // CHECK PRODUCT STOCK
    // ====================================================

    $stock = (int) ($product->stock ?? 0);

    if ($stock <= 0) {

        return back()->with(
            'error',
            'This product is out of stock.'
        );
    }


    // ====================================================
    // CHECK EXISTING CART ITEM
    // ====================================================

    $cartItem = CartItem::where(
        'user_id',
        auth()->id()
    )
    ->where(
        'product_id',
        $product->id
    )
    ->first();


    // ====================================================
    // PRODUCT ALREADY IN CART
    // ====================================================

    if ($cartItem) {

        $newQuantity =
            (int) $cartItem->quantity + 1;


        // ====================================================
        // STOCK LIMIT CHECK
        // ====================================================

        if ($newQuantity > $stock) {

            return back()->with(
                'error',
                'You cannot add more than available stock.'
            );
        }


        $cartItem->quantity = $newQuantity;

        $cartItem->save();

    } else {

        // ====================================================
        // ADD NEW CART ITEM
        // ====================================================

        CartItem::create([

            'user_id' =>
                auth()->id(),

            'product_id' =>
                $product->id,

            'quantity' =>
                1,

        ]);
    }


    // ====================================================
    // SUCCESS MESSAGE
    // ====================================================

    return redirect()
        ->route('cart')
        ->with(
            'success',
            'Product added to cart successfully!'
        );
}


// ====================================================
// CART PAGE
// ====================================================

public function cart()
{
    // ====================================================
    // USER LOGIN CHECK
    // ====================================================

    if (!auth()->check()) {

        return redirect()
            ->route('login')
            ->with(
                'error',
                'Please login to view your cart.'
            );
    }


    // ====================================================
    // CART ITEMS
    // ====================================================

    $cartItems = CartItem::with('product')
        ->where(
            'user_id',
            auth()->id()
        )
        ->get();


    // ====================================================
    // SUBTOTAL
    // ====================================================

    $subtotal = 0;

    foreach ($cartItems as $item) {

        if ($item->product) {

            $subtotal +=
                (float) $item->product->price *
                (int) $item->quantity;
        }
    }


    // ====================================================
    // GET SHIPPING SETTINGS
    // ====================================================

    $shipping = \DB::table('shipping_settings')
        ->latest('id')
        ->first();


    // ====================================================
    // DEFAULT SHIPPING VALUES
    // ====================================================

    $shippingCharge = 0;

    $freeShippingAmount = 0;


    // ====================================================
    // GET ADMIN SHIPPING SETTINGS
    // ====================================================

    if ($shipping) {

        if (
            isset($shipping->shipping_charge) &&
            $shipping->shipping_charge !== null
        ) {

            $shippingCharge =
                (float) $shipping->shipping_charge;
        }


        if (
            isset($shipping->free_shipping_amount) &&
            $shipping->free_shipping_amount !== null
        ) {

            $freeShippingAmount =
                (float) $shipping->free_shipping_amount;
        }
    }


    // ====================================================
    // PREVENT NEGATIVE VALUES
    // ====================================================

    if ($shippingCharge < 0) {

        $shippingCharge = 0;
    }

    if ($freeShippingAmount < 0) {

        $freeShippingAmount = 0;
    }


    // ====================================================
    // FREE SHIPPING CONDITION
    // ====================================================

    if (
        $freeShippingAmount > 0 &&
        $subtotal >= $freeShippingAmount
    ) {

        $shippingCharge = 0;
    }


    // ====================================================
    // GRAND TOTAL
    // ====================================================

    $grandTotal =
        $subtotal +
        $shippingCharge;


    // ====================================================
    // PREVENT NEGATIVE TOTAL
    // ====================================================

    if ($grandTotal < 0) {

        $grandTotal = 0;
    }


    // ====================================================
    // RETURN CART VIEW
    // ====================================================

    return view(
        'cart',
        compact(
            'cartItems',
            'subtotal',
            'shippingCharge',
            'freeShippingAmount',
            'grandTotal'
        )
    );
}


// ====================================================
// INCREASE CART QUANTITY
// ====================================================

public function increaseQuantity($id)
{
    // ====================================================
    // USER LOGIN CHECK
    // ====================================================

    if (!auth()->check()) {

        return redirect()
            ->route('login')
            ->with(
                'error',
                'Please login to update cart.'
            );
    }


    // ====================================================
    // FIND CART ITEM
    // ====================================================

    $cartItem = CartItem::with('product')
        ->where(
            'id',
            $id
        )
        ->where(
            'user_id',
            auth()->id()
        )
        ->first();


    // ====================================================
    // CART ITEM NOT FOUND
    // ====================================================

    if (!$cartItem) {

        return redirect()
            ->route('cart')
            ->with(
                'error',
                'Cart item not found.'
            );
    }


    // ====================================================
    // GET PRODUCT
    // ====================================================

    $product = $cartItem->product;


    if (!$product) {

        return redirect()
            ->route('cart')
            ->with(
                'error',
                'Product not found.'
            );
    }


    // ====================================================
    // GET AVAILABLE STOCK
    // ====================================================

    $stock = (int) ($product->stock ?? 0);


    // ====================================================
    // CHECK STOCK
    // ====================================================

    if ($stock <= 0) {

        return redirect()
            ->route('cart')
            ->with(
                'error',
                'This product is out of stock.'
            );
    }


    // ====================================================
    // NEW QUANTITY
    // ====================================================

    $newQuantity =
        (int) $cartItem->quantity + 1;


    // ====================================================
    // STOCK LIMIT CHECK
    // ====================================================

    if ($newQuantity > $stock) {

        return redirect()
            ->route('cart')
            ->with(
                'error',
                'You cannot add more than available stock.'
            );
    }


    // ====================================================
    // UPDATE QUANTITY
    // ====================================================

    $cartItem->quantity = $newQuantity;

    $cartItem->save();


    // ====================================================
    // SUCCESS
    // ====================================================

    return redirect()
        ->route('cart')
        ->with(
            'success',
            'Product quantity increased.'
        );
}


// ====================================================
// DECREASE CART QUANTITY
// ====================================================

public function decreaseQuantity($id)
{
    // ====================================================
    // USER LOGIN CHECK
    // ====================================================

    if (!auth()->check()) {

        return redirect()
            ->route('login')
            ->with(
                'error',
                'Please login to update cart.'
            );
    }


    // ====================================================
    // FIND CART ITEM
    // ====================================================

    $cartItem = CartItem::where(
        'id',
        $id
    )
    ->where(
        'user_id',
        auth()->id()
    )
    ->first();


    // ====================================================
    // CART ITEM NOT FOUND
    // ====================================================

    if (!$cartItem) {

        return redirect()
            ->route('cart')
            ->with(
                'error',
                'Cart item not found.'
            );
    }


    // ====================================================
    // CURRENT QUANTITY
    // ====================================================

    $currentQuantity =
        (int) $cartItem->quantity;


    // ====================================================
    // IF QUANTITY IS 1
    // ====================================================
    // Do not allow quantity to become 0.
    // User can use Remove button to remove product.
    // ====================================================

    if ($currentQuantity <= 1) {

        return redirect()
            ->route('cart')
            ->with(
                'error',
                'Minimum quantity is 1.'
            );
    }


    // ====================================================
    // DECREASE QUANTITY
    // ====================================================

    $cartItem->quantity =
        $currentQuantity - 1;

    $cartItem->save();


    // ====================================================
    // SUCCESS
    // ====================================================

    return redirect()
        ->route('cart')
        ->with(
            'success',
            'Product quantity decreased.'
        );
}


// ====================================================
// REMOVE PRODUCT FROM CART
// ====================================================

public function removeFromCart($id)
{
    // ====================================================
    // USER LOGIN CHECK
    // ====================================================

    if (!auth()->check()) {

        return redirect()
            ->route('login')
            ->with(
                'error',
                'Please login to remove product from cart.'
            );
    }


    // ====================================================
    // FIND CART ITEM
    // ====================================================

    $cartItem = CartItem::where(
        'id',
        $id
    )
    ->where(
        'user_id',
        auth()->id()
    )
    ->first();


    // ====================================================
    // CART ITEM NOT FOUND
    // ====================================================

    if (!$cartItem) {

        return redirect()
            ->route('cart')
            ->with(
                'error',
                'Cart item not found.'
            );
    }


    // ====================================================
    // DELETE CART ITEM
    // ====================================================

    $cartItem->delete();


    // ====================================================
    // SUCCESS MESSAGE
    // ====================================================

    return redirect()
        ->route('cart')
        ->with(
            'success',
            'Product removed from cart successfully!'
        );
}


// ====================================================
// CHECKOUT
// ====================================================

public function checkout()
{
    // ====================================================
    // USER LOGIN CHECK
    // ====================================================

    if (!auth()->check()) {

        return redirect()
            ->route('login')
            ->with(
                'error',
                'Please login before checkout.'
            );
    }


    // ====================================================
    // CART ITEMS
    // ====================================================

    $cartItems = CartItem::with('product')
        ->where(
            'user_id',
            auth()->id()
        )
        ->get();


    // ====================================================
    // EMPTY CART
    // ====================================================

    if ($cartItems->count() == 0) {

        return redirect()
            ->route('cart')
            ->with(
                'error',
                'Your cart is empty.'
            );
    }


    // ====================================================
    // SUBTOTAL
    // ====================================================

    $subtotal = 0;

    foreach ($cartItems as $item) {

        if ($item->product) {

            $subtotal +=
                (float) $item->product->price *
                (int) $item->quantity;
        }
    }

    $subtotal = round($subtotal, 2);


    // ====================================================
    // SHIPPING SETTINGS
    // ====================================================
    // IMPORTANT:
    // Get the latest/current shipping setting from database.
    // DO NOT keep $delivery = 0 here.

    $shipping = \App\Models\ShippingSetting::latest('id')->first();


    // ====================================================
    // DEFAULT SHIPPING VALUES
    // ====================================================

    $shippingChargeSetting = 0;
    $freeShippingAmount = 0;


    // ====================================================
    // GET ADMIN SHIPPING SETTINGS
    // ====================================================

    if ($shipping) {

        $shippingChargeSetting =
            (float) ($shipping->shipping_charge ?? 0);

        $freeShippingAmount =
            (float) ($shipping->free_shipping_amount ?? 0);
    }


    // ====================================================
    // CALCULATE SHIPPING CHARGE
    // ====================================================

    if (
        $freeShippingAmount > 0 &&
        $subtotal >= $freeShippingAmount
    ) {

        // Free shipping
        $shippingCharge = 0;

    } else {

        // Admin configured shipping charge
        $shippingCharge =
            $shippingChargeSetting;
    }


    // ====================================================
    // DELIVERY
    // ====================================================
    // Keep delivery same as shipping charge.
    // This is used for final total.

    $delivery = $shippingCharge;


    // ====================================================
    // AVAILABLE COUPONS
    // ====================================================

    $coupons = \App\Models\Coupon::where(
        'status',
        1
    )

        // Start date
        ->where(function ($query) {

            $query->whereNull('start_date')
                ->orWhereDate(
                    'start_date',
                    '<=',
                    now()
                );

        })

        // Expiry date
        ->where(function ($query) {

            $query->whereNull('expiry_date')
                ->orWhereDate(
                    'expiry_date',
                    '>=',
                    now()
                );

        })

        // Usage limit
        ->where(function ($query) {

            $query->whereNull('usage_limit')
                ->orWhereColumn(
                    'used_count',
                    '<',
                    'usage_limit'
                );

        })

        ->orderBy(
            'created_at',
            'desc'
        )

        ->get();


    // ====================================================
    // COUPON SESSION DATA
    // ====================================================

    $couponCode =
        session('coupon_code');

    $couponId =
        session('coupon_id');

    $discount =
        session(
            'coupon_discount',
            0
        );


    // ====================================================
    // CHECK APPLIED COUPON
    // ====================================================

    if (
        $couponCode &&
        $couponId
    ) {

        $appliedCoupon =
            \App\Models\Coupon::find(
                $couponId
            );


        // ====================================================
        // COUPON DOES NOT EXIST
        // ====================================================

        if (!$appliedCoupon) {

            session()->forget([
                'coupon_code',
                'coupon_discount',
                'coupon_id'
            ]);

            $couponCode = null;
            $couponId = null;
            $discount = 0;
        }


        // ====================================================
        // COUPON EXISTS
        // ====================================================

        else {

            // ====================================================
            // COUPON INACTIVE
            // ====================================================

            if (!$appliedCoupon->status) {

                session()->forget([
                    'coupon_code',
                    'coupon_discount',
                    'coupon_id'
                ]);

                $couponCode = null;
                $couponId = null;
                $discount = 0;
            }


            // ====================================================
            // COUPON EXPIRED
            // ====================================================

            elseif (
                $appliedCoupon->expiry_date &&
                now()->startOfDay()->gt(
                    $appliedCoupon->expiry_date->startOfDay()
                )
            ) {

                session()->forget([
                    'coupon_code',
                    'coupon_discount',
                    'coupon_id'
                ]);

                $couponCode = null;
                $couponId = null;
                $discount = 0;
            }


            // ====================================================
            // COUPON NOT STARTED
            // ====================================================

            elseif (
                $appliedCoupon->start_date &&
                now()->startOfDay()->lt(
                    $appliedCoupon->start_date->startOfDay()
                )
            ) {

                session()->forget([
                    'coupon_code',
                    'coupon_discount',
                    'coupon_id'
                ]);

                $couponCode = null;
                $couponId = null;
                $discount = 0;
            }


            // ====================================================
            // USAGE LIMIT REACHED
            // ====================================================

            elseif (
                $appliedCoupon->usage_limit !== null &&
                $appliedCoupon->used_count >=
                $appliedCoupon->usage_limit
            ) {

                session()->forget([
                    'coupon_code',
                    'coupon_discount',
                    'coupon_id'
                ]);

                $couponCode = null;
                $couponId = null;
                $discount = 0;
            }
        }
    }


    // ====================================================
    // DISCOUNT
    // ====================================================

    $discount = is_numeric($discount)
        ? (float) $discount
        : 0;


    // Discount cannot be greater than subtotal
    $discount = min(
        $discount,
        $subtotal
    );


    // Discount cannot be negative
    $discount = max(
        0,
        $discount
    );


    $discount =
        round(
            $discount,
            2
        );


    // ====================================================
    // GRAND TOTAL
    // ====================================================

    $grandTotal =
        $subtotal +
        $shippingCharge -
        $discount;


    // ====================================================
    // PREVENT NEGATIVE TOTAL
    // ====================================================

    $grandTotal =
        max(
            0,
            $grandTotal
        );


    $grandTotal =
        round(
            $grandTotal,
            2
        );


    // ====================================================
    // GET GENERAL SETTINGS
    // ====================================================

    $setting =
        Setting::first();


    // ====================================================
    // DEFAULT UPI SETTINGS
    // ====================================================

    $adminUpi = '';

    $merchantName =
        'Classic Glasses Store';


    // ====================================================
    // GET UPI SETTINGS
    // ====================================================

    if ($setting) {

        if (!empty($setting->upi_id)) {

            $adminUpi =
                $setting->upi_id;
        }


        if (!empty($setting->merchant_name)) {

            $merchantName =
                $setting->merchant_name;
        }
    }


    // ====================================================
    // UPI URL
    // ====================================================

    $upiUrl = null;

    if (!empty($adminUpi)) {

        $upiUrl =
            'upi://pay?' .
            http_build_query([

                'pa' =>
                    $adminUpi,

                'pn' =>
                    $merchantName,

                'am' =>
                    number_format(
                        $grandTotal,
                        2,
                        '.',
                        ''
                    ),

                'cu' =>
                    'INR'
            ]);
    }


    // ====================================================
    // CHECKOUT VIEW
    // ====================================================

    return view(
        'checkout',
        compact(

            'cartItems',

            'subtotal',

            'delivery',

            'shipping',

            'shippingCharge',

            'shippingChargeSetting',

            'freeShippingAmount',

            'discount',

            'grandTotal',

            'couponCode',

            'couponId',

            'coupons',

            'setting',

            'adminUpi',

            'merchantName',

            'upiUrl'
        )
    );
}


// ====================================================
// PLACE ORDER
// ====================================================

public function placeOrder(Request $request)
{
    // ====================================================
    // USER LOGIN CHECK
    // ====================================================

    if (!auth()->check()) {

        return redirect()
            ->route('login')
            ->with(
                'error',
                'Please login before placing an order.'
            );
    }


    // ====================================================
    // VALIDATION
    // ====================================================

    $request->validate([

        'name' =>
            'required|string|max:255',

        'email' =>
            'required|email|max:255',

        'mobile' => [
            'required',
            'regex:/^[0-9]{10}$/'
        ],

        'pincode' => [
            'required',
            'regex:/^[0-9]{6}$/'
        ],

        'address' =>
            'required|string|max:1000',

        'city' =>
            'required|string|max:255',

        'state' =>
            'required|string|max:255',

        'payment_method' => [
            'required',
            'in:Cash on Delivery,UPI,Credit/Debit Card'
        ],

    ]);


    // ====================================================
    // GET CART ITEMS
    // ====================================================

    $cartItems = CartItem::with('product')
        ->where(
            'user_id',
            auth()->id()
        )
        ->get();


    // ====================================================
    // EMPTY CART CHECK
    // ====================================================

    if ($cartItems->count() == 0) {

        return redirect()
            ->route('cart')
            ->with(
                'error',
                'Your cart is empty.'
            );
    }


    // ====================================================
    // CHECK PRODUCT STOCK
    // ====================================================

    foreach ($cartItems as $item) {

        if (!$item->product) {

            return redirect()
                ->route('cart')
                ->with(
                    'error',
                    'One of the products in your cart is no longer available.'
                );
        }


        if (
            $item->quantity >
            $item->product->stock
        ) {

            return redirect()
                ->route('cart')
                ->with(
                    'error',
                    $item->product->name .
                    ' has only ' .
                    $item->product->stock .
                    ' item(s) available.'
                );
        }


        if (
            $item->product->stock <= 0
        ) {

            return redirect()
                ->route('cart')
                ->with(
                    'error',
                    $item->product->name .
                    ' is currently out of stock.'
                );
        }
    }


    // ====================================================
    // CALCULATE SUBTOTAL
    // ====================================================

    $subtotal = 0;

    foreach ($cartItems as $item) {

        if ($item->product) {

            $subtotal +=
                (float) $item->product->price *
                (int) $item->quantity;
        }
    }

    $subtotal =
        round(
            $subtotal,
            2
        );


    // ====================================================
    // GET SHIPPING SETTINGS
    // ====================================================

    $shipping =
        \App\Models\ShippingSetting::latest('id')->first();


    // ====================================================
    // DEFAULT SHIPPING VALUES
    // ====================================================

    $shippingChargeSetting = 0;

    $freeShippingAmount = 0;


    // ====================================================
    // READ ADMIN SETTINGS
    // ====================================================

    if ($shipping) {

        $shippingChargeSetting =
            (float) (
                $shipping->shipping_charge ?? 0
            );

        $freeShippingAmount =
            (float) (
                $shipping->free_shipping_amount ?? 0
            );
    }


    // ====================================================
    // CALCULATE SHIPPING
    // ====================================================

    if (
        $freeShippingAmount > 0 &&
        $subtotal >= $freeShippingAmount
    ) {

        // FREE SHIPPING
        $delivery = 0;

    } else {

        // ADMIN SHIPPING CHARGE
        $delivery =
            $shippingChargeSetting;
    }


    $delivery =
        round(
            $delivery,
            2
        );


    // ====================================================
    // COUPON DATA FROM SESSION
    // ====================================================

    $couponCode =
        session('coupon_code');

    $couponId =
        session('coupon_id');

    $discount =
        session(
            'coupon_discount',
            0
        );


    // ====================================================
    // CONVERT DISCOUNT TO NUMBER
    // ====================================================

    $discount =
        is_numeric($discount)
            ? (float) $discount
            : 0;


    // ====================================================
    // VERIFY COUPON
    // ====================================================

    if ($couponId) {

        $coupon =
            Coupon::find(
                $couponId
            );


        // ====================================================
        // COUPON DOES NOT EXIST
        // ====================================================

        if (!$coupon) {

            $couponCode = null;

            $couponId = null;

            $discount = 0;
        }


        // ====================================================
        // COUPON EXISTS
        // ====================================================

        else {

            // ====================================================
            // STATUS CHECK
            // ====================================================

            if (!$coupon->status) {

                $couponCode = null;

                $couponId = null;

                $discount = 0;
            }


            // ====================================================
            // START DATE CHECK
            // ====================================================

            elseif (
                $coupon->start_date &&
                now()->startOfDay()->lt(
                    $coupon->start_date->startOfDay()
                )
            ) {

                $couponCode = null;

                $couponId = null;

                $discount = 0;
            }


            // ====================================================
            // EXPIRY DATE CHECK
            // ====================================================

            elseif (
                $coupon->expiry_date &&
                now()->startOfDay()->gt(
                    $coupon->expiry_date->startOfDay()
                )
            ) {

                $couponCode = null;

                $couponId = null;

                $discount = 0;
            }


            // ====================================================
            // USAGE LIMIT CHECK
            // ====================================================

            elseif (
                $coupon->usage_limit !== null &&
                $coupon->used_count >=
                $coupon->usage_limit
            ) {

                $couponCode = null;

                $couponId = null;

                $discount = 0;
            }
        }
    }


    // ====================================================
    // DISCOUNT LIMIT
    // ====================================================

    if ($discount > $subtotal) {

        $discount =
            $subtotal;
    }


    // ====================================================
    // DISCOUNT CANNOT BE NEGATIVE
    // ====================================================

    if ($discount < 0) {

        $discount = 0;
    }


    // ====================================================
    // ROUND DISCOUNT
    // ====================================================

    $discount =
        round(
            $discount,
            2
        );


    // ====================================================
    // GRAND TOTAL
    // ====================================================

    $grandTotal =
        $subtotal +
        $delivery -
        $discount;


    // ====================================================
    // PREVENT NEGATIVE TOTAL
    // ====================================================

    if ($grandTotal < 0) {

        $grandTotal = 0;
    }


    // ====================================================
    // ROUND FINAL TOTAL
    // ====================================================

    $grandTotal =
        round(
            $grandTotal,
            2
        );


    // ====================================================
    // PAYMENT METHOD
    // ====================================================

    $paymentMethod =
        $request->payment_method;


    // ====================================================
    // CREATE ORDER
    // ====================================================

    $order = Order::create([

        'user_id' =>
            auth()->id(),

        'name' =>
            $request->name,

        'email' =>
            $request->email,

        'mobile' =>
            $request->mobile,

        'pincode' =>
            $request->pincode,

        'address' =>
            $request->address,

        'city' =>
            $request->city,

        'state' =>
            $request->state,

        'payment_method' =>
            $paymentMethod,

        // Final amount after discount
        // and including shipping
        'total_amount' =>
            $grandTotal,

        'status' =>
            'Pending',
    ]);


    // ====================================================
    // CREATE ORDER ITEMS
    // ====================================================

    foreach ($cartItems as $item) {

        if (!$item->product) {

            continue;
        }


        // ====================================================
        // ITEM TOTAL
        // ====================================================

        $itemTotal =
            (float) $item->product->price *
            (int) $item->quantity;


        $itemTotal =
            round(
                $itemTotal,
                2
            );


        // ====================================================
        // CREATE ORDER ITEM
        // ====================================================

        OrderItem::create([

            'order_id' =>
                $order->id,

            'product_id' =>
                $item->product->id,

            'product_name' =>
                $item->product->name,

            'quantity' =>
                $item->quantity,

            'price' =>
                $item->product->price,

            'total' =>
                $itemTotal,
        ]);


        // ====================================================
        // REDUCE PRODUCT STOCK
        // ====================================================

        $item->product->decrement(
            'stock',
            $item->quantity
        );
    }


    // ====================================================
    // INCREASE COUPON USED COUNT
    // ====================================================

    if ($couponId) {

        $usedCoupon =
            Coupon::find(
                $couponId
            );

        if ($usedCoupon) {

            $usedCoupon->increment(
                'used_count'
            );
        }
    }


    // ====================================================
    // CLEAR CART
    // ====================================================

    CartItem::where(
        'user_id',
        auth()->id()
    )->delete();


    // ====================================================
    // CLEAR COUPON SESSION
    // ====================================================

    session()->forget([

        'coupon_code',

        'coupon_discount',

        'coupon_id',

    ]);


    // ====================================================
    // SUCCESS
    // ====================================================

    return redirect()
        ->route(
            'products.index'
        )
        ->with(
            'success',
            'Order placed successfully! Your Order ID is #' .
            $order->id
        );
}



// ====================================================
// USER MY ORDERS
// ====================================================

public function myOrders()
{
    // ====================================================
    // USER LOGIN CHECK
    // ====================================================

    if (!auth()->check()) {

        return redirect()
            ->route('login');
    }


    // ====================================================
    // GET USER ORDERS
    // ====================================================

    $orders = Order::with([
        'items'
    ])
        ->where(
            'user_id',
            auth()->id()
        )
        ->latest()
        ->get();


    // ====================================================
    // MY ORDERS VIEW
    // ====================================================

    return view(
        'my-orders',
        compact('orders')
    );
}
// ====================================================
// USER ORDER NOTIFICATION
// ====================================================

public function getOrderNotification()
{
    // User login check
    if (!auth()->check()) {

        return response()->json([
            'success' => false,
            'notification' => null
        ]);
    }

    // Get latest unread notification
    $notification = OrderNotification::where(
        'user_id',
        auth()->id()
    )
        ->where(
            'is_read',
            false
        )
        ->latest()
        ->first();

    // No notification
    if (!$notification) {

        return response()->json([
            'success' => true,
            'notification' => null
        ]);
    }

    return response()->json([
        'success' => true,

        'notification' => [

            'id' => $notification->id,

            'order_id' => $notification->order_id,

            'status' => $notification->status,

            'message' => $notification->message,

        ]
    ]);
}


// ====================================================
// MARK USER ORDER NOTIFICATION AS READ
// ====================================================

public function markOrderNotificationRead($id)
{
    // User login check
    if (!auth()->check()) {

        return response()->json([
            'success' => false
        ], 401);
    }

    $notification = OrderNotification::where(
        'id',
        $id
    )
        ->where(
            'user_id',
            auth()->id()
        )
        ->first();

    if ($notification) {

        $notification->update([
            'is_read' => true
        ]);
    }

    return response()->json([
        'success' => true
    ]);
}
// ====================================================
// EXPORT BILLS EXCEL
// COMPLETE BILL REPORT
// DATE FILTER SUPPORTED
// EXCEL FORMAT
// ====================================================

public function exportBillsExcel(Request $request)
{
    // ====================================================
    // ADMIN CHECK
    // ====================================================

    if (!session('admin_logged_in')) {
        return redirect()->route('admin.login');
    }

    // ====================================================
    // DATE FILTER
    // ====================================================

    $fromDate = $request->input('date_from');
    $toDate   = $request->input('date_to');

    // ====================================================
    // BILL QUERY
    // ====================================================

    $query = Order::with([
        'user',
        'items.product'
    ]);

    if ($fromDate) {
        $query->whereDate(
            'created_at',
            '>=',
            $fromDate
        );
    }

    if ($toDate) {
        $query->whereDate(
            'created_at',
            '<=',
            $toDate
        );
    }

    // ====================================================
    // GET ORDERS
    // ====================================================

    $orders = $query
        ->latest()
        ->get();

    // ====================================================
    // FILE NAME
    // ====================================================

    $filename =
        'bill-report-' .
        ($fromDate ?? 'all') .
        '-to-' .
        ($toDate ?? 'all') .
        '.xls';

    // ====================================================
    // BUILD EXCEL HTML
    // ====================================================

    $html = '';

    $html .= '<!DOCTYPE html>';
    $html .= '<html>';
    $html .= '<head>';

    $html .= '<meta charset="UTF-8">';

    $html .= '
        <style>

            body {
                font-family: Arial, sans-serif;
                font-size: 12px;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            th {
                background-color: #1f2937;
                color: white;
                font-weight: bold;
                border: 1px solid #000;
                padding: 8px;
                text-align: center;
            }

            td {
                border: 1px solid #999;
                padding: 7px;
            }

            .title {
                font-size: 20px;
                font-weight: bold;
                text-align: center;
            }

            .subtitle {
                font-size: 16px;
                font-weight: bold;
                text-align: center;
            }

            .summary {
                font-weight: bold;
            }

            .amount {
                text-align: right;
            }

        </style>
    ';

    $html .= '</head>';
    $html .= '<body>';

    // ====================================================
    // TITLE
    // ====================================================

    $html .= '
        <table>
            <tr>
                <td colspan="12" class="title">
                    CLASSIC - GLASSES STORE
                </td>
            </tr>

            <tr>
                <td colspan="12" class="subtitle">
                    BILL REPORT
                </td>
            </tr>

            <tr>
                <td colspan="12">&nbsp;</td>
            </tr>
        </table>
    ';

    // ====================================================
    // FILTER INFORMATION
    // ====================================================

    $html .= '
        <table>
            <tr>
                <td class="summary">From Date</td>
                <td>' .
                htmlspecialchars(
                    $fromDate ?? 'All Dates'
                ) .
                '</td>

                <td class="summary">To Date</td>
                <td>' .
                htmlspecialchars(
                    $toDate ?? 'All Dates'
                ) .
                '</td>
            </tr>

            <tr>
                <td colspan="12">&nbsp;</td>
            </tr>
        </table>
    ';

    // ====================================================
    // TABLE HEADER
    // ====================================================

    $html .= '
        <table>

            <thead>

                <tr>

                    <th>Sr. No.</th>

                    <th>Bill / Order ID</th>

                    <th>Customer Name</th>

                    <th>Email</th>

                    <th>Mobile</th>

                    <th>Products</th>

                    <th>Total Quantity</th>

                    <th>Bill Amount</th>

                    <th>Payment Method</th>

                    <th>Bill Date</th>

                    <th>Bill Time</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody>
    ';

    // ====================================================
    // VARIABLES
    // ====================================================

    $srNo = 0;

    $grandTotal = 0;

    $totalBills = $orders->count();

    // ====================================================
    // LOOP
    // ====================================================

    foreach ($orders as $order) {

        $srNo++;

        // ====================================================
        // CUSTOMER NAME
        // ====================================================

        $customerName = '';

        if (!empty($order->name)) {

            $customerName = $order->name;

        } elseif ($order->user && !empty($order->user->name)) {

            $customerName = $order->user->name;

        } else {

            $customerName = 'Guest';
        }

        // ====================================================
        // EMAIL
        // ====================================================

        $email = '';

        if (!empty($order->email)) {

            $email = $order->email;

        } elseif ($order->user && !empty($order->user->email)) {

            $email = $order->user->email;
        }

        // ====================================================
        // MOBILE
        // ====================================================

        $mobile = '';

        if (!empty($order->mobile)) {

            $mobile = $order->mobile;

        } elseif (!empty($order->phone)) {

            $mobile = $order->phone;

        } elseif ($order->user) {

            if (!empty($order->user->mobile)) {

                $mobile = $order->user->mobile;

            } elseif (!empty($order->user->phone)) {

                $mobile = $order->user->phone;
            }
        }

        // ====================================================
        // PRODUCTS
        // ====================================================

        $productNames = [];

        $totalQuantity = 0;

        $itemsTotal = 0;

        if (
            $order->items &&
            $order->items->count() > 0
        ) {

            foreach ($order->items as $item) {

                // --------------------------------------------
                // PRODUCT NAME
                // --------------------------------------------

                $productName = '';

                if (!empty($item->product_name)) {

                    $productName =
                        $item->product_name;

                } elseif (
                    $item->product &&
                    !empty($item->product->name)
                ) {

                    $productName =
                        $item->product->name;

                } else {

                    $productName = 'Product';
                }

                // --------------------------------------------
                // QUANTITY
                // --------------------------------------------

                $quantity = (int) (
                    $item->quantity ?? 0
                );

                $totalQuantity += $quantity;

                // --------------------------------------------
                // ITEM PRICE
                // --------------------------------------------

                $itemPrice = (float) (
                    $item->price ?? 0
                );

                // --------------------------------------------
                // ITEM TOTAL
                // --------------------------------------------

                if (
                    isset($item->total) &&
                    $item->total !== null &&
                    $item->total !== ''
                ) {

                    $itemAmount =
                        (float) $item->total;

                } else {

                    $itemAmount =
                        $itemPrice * $quantity;
                }

                $itemsTotal += $itemAmount;

                // --------------------------------------------
                // PRODUCT TEXT
                // --------------------------------------------

                $productNames[] =
                    $productName .
                    ' x ' .
                    $quantity;
            }

        } else {

            $productNames[] = 'N/A';
        }

        // ====================================================
        // PRODUCT TEXT
        // ====================================================

        $productsText = implode(
            ', ',
            $productNames
        );

        // ====================================================
        // BILL AMOUNT
        // ====================================================

        if (
            isset($order->total_amount) &&
            $order->total_amount !== null &&
            $order->total_amount !== ''
        ) {

            $billAmount =
                (float) $order->total_amount;

        } elseif (
            isset($order->total) &&
            $order->total !== null &&
            $order->total !== ''
        ) {

            $billAmount =
                (float) $order->total;

        } else {

            $billAmount =
                (float) $itemsTotal;
        }

        // ====================================================
        // GRAND TOTAL
        // ====================================================

        $grandTotal += $billAmount;

        // ====================================================
        // PAYMENT METHOD
        // ====================================================

        $paymentMethod = '';

        if (!empty($order->payment_method)) {

            $paymentMethod =
                $order->payment_method;

        } elseif (!empty($order->payment)) {

            $paymentMethod =
                $order->payment;

        } else {

            $paymentMethod = 'N/A';
        }

        // ====================================================
        // DATE
        // ====================================================

        $billDate = '';

        if ($order->created_at) {

            $billDate =
                $order->created_at
                    ->format('Y-m-d');
        }

        // ====================================================
        // TIME
        // ====================================================

        $billTime = '';

        if ($order->created_at) {

            $billTime =
                $order->created_at
                    ->format('h:i A');
        }

        // ====================================================
        // STATUS
        // ====================================================

        $status =
            $order->status ?? 'Unknown';

        // ====================================================
        // EXCEL ROW
        // ====================================================

        $html .= '<tr>';

        $html .= '<td>' .
            $srNo .
            '</td>';

        $html .= '<td>' .
            htmlspecialchars(
                '#' . $order->id
            ) .
            '</td>';

        $html .= '<td>' .
            htmlspecialchars(
                $customerName
            ) .
            '</td>';

        $html .= '<td>' .
            htmlspecialchars(
                $email
            ) .
            '</td>';

        $html .= '<td>' .
            htmlspecialchars(
                $mobile
            ) .
            '</td>';

        $html .= '<td>' .
            htmlspecialchars(
                $productsText
            ) .
            '</td>';

        $html .= '<td style="text-align:center;">' .
            $totalQuantity .
            '</td>';

        $html .= '<td class="amount">' .
            number_format(
                $billAmount,
                2,
                '.',
                ''
            ) .
            '</td>';

        $html .= '<td>' .
            htmlspecialchars(
                $paymentMethod
            ) .
            '</td>';

        $html .= '<td>' .
            $billDate .
            '</td>';

        $html .= '<td>' .
            $billTime .
            '</td>';

        $html .= '<td>' .
            htmlspecialchars(
                $status
            ) .
            '</td>';

        $html .= '</tr>';
    }

    // ====================================================
    // CLOSE TABLE
    // ====================================================

    $html .= '
            </tbody>
        </table>
    ';

    // ====================================================
    // SUMMARY
    // ====================================================

    $html .= '
        <br>

        <table>

            <tr>

                <td colspan="6"
                    class="summary">
                    TOTAL BILLS
                </td>

                <td>' .
                    $totalBills .
                '</td>

                <td colspan="5"></td>

            </tr>

            <tr>

                <td colspan="6"
                    class="summary">
                    GRAND TOTAL
                </td>

                <td class="amount">' .
                    number_format(
                        $grandTotal,
                        2,
                        '.',
                        ''
                    ) .
                '</td>

                <td colspan="5"></td>

            </tr>

        </table>
    ';

    // ====================================================
    // FOOTER
    // ====================================================

    $html .= '
        <br>

        <table>

            <tr>

                <td colspan="12">
                    Report generated from
                    Classic - Glasses Store
                </td>

            </tr>

        </table>
    ';

    $html .= '</body>';
    $html .= '</html>';

    // ====================================================
    // EXCEL HEADERS
    // ====================================================

    $headers = [

        'Content-Type' =>
            'application/vnd.ms-excel; charset=UTF-8',

        'Content-Disposition' =>
            'attachment; filename="' .
            $filename .
            '"',

        'Cache-Control' =>
            'no-store, no-cache, must-revalidate',

        'Pragma' =>
            'no-cache',

        'Expires' =>
            '0',

    ];

    // ====================================================
    // DOWNLOAD EXCEL
    // ====================================================

    return response(
        "\xEF\xBB\xBF" . $html,
        200,
        $headers
    );
}


// ====================================================
// REPORTS - DATE WISE FILTER
// ====================================================

public function reports(Request $request)
{
    // ====================================================
    // ADMIN LOGIN CHECK
    // ====================================================

    if (!session('admin_logged_in')) {
        return redirect()->route('admin.login');
    }

    // ====================================================
    // GET DATE FILTER
    // ====================================================

    $fromDate = $request->input('date_from');
    $toDate   = $request->input('date_to');

    // ====================================================
    // ORDERS QUERY
    // ====================================================

    $orderQuery = Order::with([
        'user',
        'items.product'
    ]);

    if (!empty($fromDate)) {
        $orderQuery->whereDate(
            'created_at',
            '>=',
            $fromDate
        );
    }

    if (!empty($toDate)) {
        $orderQuery->whereDate(
            'created_at',
            '<=',
            $toDate
        );
    }

    $orders = $orderQuery
        ->latest()
        ->get();

    // ====================================================
    // ORDER ITEMS
    // ====================================================

    $orderItems = collect();

    foreach ($orders as $order) {

        foreach ($order->items as $item) {

            $orderItems->push($item);

        }
    }

    // ====================================================
    // TOTAL SALES
    // ====================================================

    $totalSales = $orders->sum(function ($order) {

        return (float) ($order->total_amount ?? 0);

    });

    // ====================================================
    // TOTAL ORDERS
    // ====================================================

    $totalOrders = $orders->count();

    // ====================================================
    // TOTAL QUANTITY SOLD
    // ====================================================

    $totalQuantity = $orderItems->sum(function ($item) {

        return (int) ($item->quantity ?? 0);

    });

    // ====================================================
    // AVERAGE ORDER VALUE
    // ====================================================

    $averageOrderValue = $totalOrders > 0
        ? $totalSales / $totalOrders
        : 0;

    // ====================================================
    // USERS DATE WISE
    // ====================================================

    $userQuery = User::where(
        'is_admin',
        0
    );

    if (!empty($fromDate)) {

        $userQuery->whereDate(
            'created_at',
            '>=',
            $fromDate
        );
    }

    if (!empty($toDate)) {

        $userQuery->whereDate(
            'created_at',
            '<=',
            $toDate
        );
    }

    $users = $userQuery
        ->latest()
        ->get();

    // ====================================================
    // TOTAL USERS
    // ====================================================

    $totalUsers = $users->count();

    // ====================================================
    // PRODUCTS
    // ====================================================

    $products = Product::with('images')
        ->latest()
        ->get();

    // ====================================================
    // CATEGORY REPORT
    // ====================================================

    $categoryReport = [];

    foreach ($orderItems as $item) {

        $product = $item->product;

        if (!$product) {
            continue;
        }

        $category = $product->category ?? 'Other';

        if (!isset($categoryReport[$category])) {

            $categoryReport[$category] = [
                'category' => $category,
                'quantity' => 0,
                'sales' => 0,
                'orders' => 0,
            ];
        }

        $quantity = (int) ($item->quantity ?? 0);

        $itemTotal = isset($item->total)
            ? (float) $item->total
            : (
                (float) ($item->price ?? 0)
                * $quantity
            );

        $categoryReport[$category]['quantity']
            += $quantity;

        $categoryReport[$category]['sales']
            += $itemTotal;

        $categoryReport[$category]['orders']++;
    }

    $categoryReport = collect(
        array_values($categoryReport)
    )->sortByDesc('sales')->values();

    // ====================================================
    // CUSTOMER REPORT
    // ====================================================

    $customerReport = [];

    foreach ($orders as $order) {

        $customerName = $order->name
            ?? optional($order->user)->name
            ?? 'Guest';

        $customerEmail = $order->email
            ?? optional($order->user)->email
            ?? '';

        $key = $order->user_id
            ? 'user_' . $order->user_id
            : 'guest_' . $customerEmail;

        if (!isset($customerReport[$key])) {

            $customerReport[$key] = [
                'name' => $customerName,
                'email' => $customerEmail,
                'orders' => 0,
                'quantity' => 0,
                'sales' => 0,
            ];
        }

        $customerReport[$key]['orders']++;

        $customerReport[$key]['sales']
            += (float) ($order->total_amount ?? 0);

        foreach ($order->items as $item) {

            $customerReport[$key]['quantity']
                += (int) ($item->quantity ?? 0);
        }
    }

    $customerReport = collect(
        array_values($customerReport)
    )->sortByDesc('sales')->values();

    // ====================================================
    // SALES REPORT - DATE WISE
    // ====================================================

    $salesReport = [];

    foreach ($orders as $order) {

        if (!$order->created_at) {
            continue;
        }

        $date = $order->created_at->format(
            'Y-m-d'
        );

        if (!isset($salesReport[$date])) {

            $salesReport[$date] = [
                'date' => $date,
                'orders' => 0,
                'quantity' => 0,
                'sales' => 0,
            ];
        }

        $salesReport[$date]['orders']++;

        $salesReport[$date]['sales']
            += (float) ($order->total_amount ?? 0);

        foreach ($order->items as $item) {

            $salesReport[$date]['quantity']
                += (int) ($item->quantity ?? 0);
        }
    }

    $salesReport = collect(
        array_values($salesReport)
    )->sortByDesc('date')->values();

    // ====================================================
    // USER REGISTRATION DATE REPORT
    // ====================================================

    $userDateReport = [];

    foreach ($users as $user) {

        if (!$user->created_at) {
            continue;
        }

        $date = $user->created_at->format(
            'Y-m-d'
        );

        if (!isset($userDateReport[$date])) {

            $userDateReport[$date] = [
                'date' => $date,
                'users' => 0,
            ];
        }

        $userDateReport[$date]['users']++;
    }

    $userDateReport = collect(
        array_values($userDateReport)
    )->sortByDesc('date')->values();

    // ====================================================
    // PAYMENT METHOD REPORT
    // ====================================================

    $paymentReport = [];

    foreach ($orders as $order) {

        $payment = $order->payment_method
            ?? 'Unknown';

        if (!isset($paymentReport[$payment])) {

            $paymentReport[$payment] = [
                'payment_method' => $payment,
                'orders' => 0,
                'sales' => 0,
            ];
        }

        $paymentReport[$payment]['orders']++;

        $paymentReport[$payment]['sales']
            += (float) ($order->total_amount ?? 0);
    }

    $paymentReport = collect(
        array_values($paymentReport)
    )->sortByDesc('sales')->values();

    // ====================================================
    // ORDER STATUS REPORT
    // ====================================================

    $statusReport = [];

    foreach ($orders as $order) {

        $status = $order->status ?? 'Unknown';

        if (!isset($statusReport[$status])) {

            $statusReport[$status] = [
                'status' => $status,
                'orders' => 0,
                'sales' => 0,
            ];
        }

        $statusReport[$status]['orders']++;

        $statusReport[$status]['sales']
            += (float) ($order->total_amount ?? 0);
    }

    $statusReport = collect(
        array_values($statusReport)
    )->sortByDesc('orders')->values();

    // ====================================================
    // VISITORS DATE WISE
    // ====================================================

    $visitorQuery = Visitor::query();

    if (!empty($fromDate)) {

        $visitorQuery->whereDate(
            'created_at',
            '>=',
            $fromDate
        );
    }

    if (!empty($toDate)) {

        $visitorQuery->whereDate(
            'created_at',
            '<=',
            $toDate
        );
    }

    $visitors = $visitorQuery
        ->latest()
        ->get();

    // ====================================================
    // TOTAL VISITORS
    // ====================================================

    $totalVisitors = $visitors
        ->pluck('ip_address')
        ->filter()
        ->unique()
        ->count();

    // ====================================================
    // VISITOR DATE REPORT
    // ====================================================

    $visitorDateReport = [];

    foreach ($visitors as $visitor) {

        if (!$visitor->created_at) {
            continue;
        }

        $date = $visitor->created_at->format(
            'Y-m-d'
        );

        if (!isset($visitorDateReport[$date])) {

            $visitorDateReport[$date] = [
                'date' => $date,
                'visitors' => 0,
            ];
        }

        $visitorDateReport[$date]['visitors']++;
    }

    $visitorDateReport = collect(
        array_values($visitorDateReport)
    )->sortByDesc('date')->values();

    // ====================================================
    // ENQUIRY REPORT
    // ====================================================

    $enquiryQuery = Enquiry::with('user');

    if (!empty($fromDate)) {

        $enquiryQuery->whereDate(
            'created_at',
            '>=',
            $fromDate
        );
    }

    if (!empty($toDate)) {

        $enquiryQuery->whereDate(
            'created_at',
            '<=',
            $toDate
        );
    }

    $enquiries = $enquiryQuery
        ->latest()
        ->get();

    // ====================================================
    // ENQUIRY STATUS REPORT
    // ====================================================

    $enquiryStatusReport = [];

    foreach ($enquiries as $enquiry) {

        $status = $enquiry->status
            ?? 'Unknown';

        if (!isset($enquiryStatusReport[$status])) {

            $enquiryStatusReport[$status] = [
                'status' => $status,
                'count' => 0,
            ];
        }

        $enquiryStatusReport[$status]['count']++;
    }

    $enquiryStatusReport = collect(
        array_values($enquiryStatusReport)
    )->sortByDesc('count')->values();

    // ====================================================
    // ENQUIRY DATE REPORT
    // ====================================================

    $enquiryDateReport = [];

    foreach ($enquiries as $enquiry) {

        if (!$enquiry->created_at) {
            continue;
        }

        $date = $enquiry->created_at->format(
            'Y-m-d'
        );

        if (!isset($enquiryDateReport[$date])) {

            $enquiryDateReport[$date] = [
                'date' => $date,
                'enquiries' => 0,
            ];
        }

        $enquiryDateReport[$date]['enquiries']++;
    }

    $enquiryDateReport = collect(
        array_values($enquiryDateReport)
    )->sortByDesc('date')->values();

    // ====================================================
    // REPORT VIEW
    // ====================================================

    return view(
        'reports',
        compact(

            'fromDate',
            'toDate',

            'orders',
            'orderItems',

            'products',
            'users',

            'totalSales',
            'totalOrders',
            'totalQuantity',
            'averageOrderValue',
            'totalUsers',
            'totalVisitors',

            'categoryReport',
            'customerReport',
            'salesReport',
            'userDateReport',

            'paymentReport',
            'statusReport',

            'visitors',
            'visitorDateReport',

            'enquiries',
            'enquiryStatusReport',
            'enquiryDateReport'
        )
    );
}
// ====================================================
// ADMIN LOGOUT
// ====================================================

public function logout(Request $request)
{
    // ====================================================
    // CLEAR ADMIN SESSION
    // ====================================================

    session()->forget([
        'admin_logged_in',
        'admin_id',
        'admin_email',
        'admin_role',
        'admin_permissions',
        'admin_user.permissions',
    ]);


    // ====================================================
    // INVALIDATE SESSION
    // ====================================================

    $request->session()->invalidate();


    // ====================================================
    // REGENERATE CSRF TOKEN
    // ====================================================

    $request->session()->regenerateToken();


    // ====================================================
    // REDIRECT TO ADMIN LOGIN
    // ====================================================

    return redirect()
        ->route('admin.login')
        ->with(
            'success',
            'Admin logged out successfully.'
        );
}
// ====================================================
// USER MANAGEMENT
// ====================================================

public function userManagement()
{
    if (!session('admin_logged_in')) {
        return redirect()->route('admin.login');
    }

    return redirect()->route(
        'admin.dashboard',
        [
            'page' => 'user-management'
        ]
    );
}
}