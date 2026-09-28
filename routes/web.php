<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\EnquiryController;
use App\Models\Enquiry;

// ====================================================
// HOME
// ====================================================

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


// ====================================================
// PUBLIC PAGES
// ====================================================

// HOME - LOGIN शिवायही दिसेल
Route::get('/home', function () {
    return view('home');
})->name('home');


// BLOG
Route::get('/blog', function () {
    return view('blog');
});


// CONTACT
Route::get('/contact', function () {
    return view('contact');
});


// ====================================================
// USER AUTHENTICATION
// ====================================================

// REGISTER
Route::get('/register', [
    AuthController::class,
    'showRegister'
])->name('register');

Route::post('/register', [
    AuthController::class,
    'register'
])->name('register.store');


// LOGIN
Route::get('/login', [
    AuthController::class,
    'showLogin'
])->name('login');

Route::post('/login', [
    AuthController::class,
    'login'
])->name('login.store');


// LOGOUT
Route::post('/logout', [
    AuthController::class,
    'logout'
])->name('logout');



// ====================================================
// DATABASE BACKUP & RESTORE
// ====================================================

// ----------------------------------------------------
// BACKUP PAGE
// Dashboard मध्ये Backup section open होईल
// ----------------------------------------------------

Route::get('/admin/backup', [ProductController::class, 'backupDatabase'])
    ->name('admin.backup');


// ====================================================
// DATABASE BACKUP DOWNLOAD
// ====================================================

// ----------------------------------------------------
// SQL DATABASE BACKUP DOWNLOAD
// ----------------------------------------------------

Route::get('/admin/backup/sql', [ProductController::class, 'downloadBackup'])
    ->name('admin.backup.sql');


// ----------------------------------------------------
// JSON DATABASE BACKUP DOWNLOAD
// ----------------------------------------------------

Route::get('/admin/backup/json', [ProductController::class, 'downloadJsonBackup'])
    ->name('admin.backup.json');


// ====================================================
// DATABASE RESTORE / IMPORT
// ====================================================

// ----------------------------------------------------
// SQL DATABASE RESTORE
// Form मधून .sql file upload करून restore करेल
// ----------------------------------------------------

Route::post('/admin/backup/restore/sql', [ProductController::class, 'restoreSqlBackup'])
    ->name('admin.backup.restore.sql');


// ----------------------------------------------------
// JSON DATABASE RESTORE
// Form मधून .json file upload करून restore करेल
// ----------------------------------------------------

Route::post('/admin/backup/restore/json', [ProductController::class, 'restoreJsonBackup'])
    ->name('admin.backup.restore.json');


// ====================================================
// USER DASHBOARD
// ====================================================

Route::get('/dashboard', function () {
    return view('dashboard');
})
->middleware('auth')
->name('dashboard');


// ====================================================
// ADMIN LOGIN
// ====================================================

Route::get('/admin', [
    ProductController::class,
    'dashboard'
])->name('admin.login');

Route::post('/admin/login', [
    ProductController::class,
    'adminLogin'
])->name('admin.login.submit');


// ====================================================
// ADMIN DASHBOARD
// ====================================================

Route::get('/admin/dashboard', [
    ProductController::class,
    'adminDashboard'
])->name('admin.dashboard');
// ====================================================
// MARK ORDER NOTIFICATION AS SEEN
// ====================================================

Route::post(
    '/admin/orders/notifications/seen',
    [
        ProductController::class,
        'markOrderNotificationsSeen'
    ]
)->name('admin.orders.notifications.seen');

// ====================================================
// ADMIN DASHBOARD PAGES
// ====================================================

// ADD PRODUCT
Route::get('/admin/dashboard/add-product', function () {

    return redirect()->route('admin.dashboard', [
        'page' => 'add-product'
    ]);

})->name('admin.add-product');


// MANAGE PRODUCTS
Route::get('/admin/dashboard/manage-products', function () {

    return redirect()->route('admin.dashboard', [
        'page' => 'manage-products'
    ]);

})->name('admin.manage-products');


// STOCK MANAGEMENT
Route::get('/admin/dashboard/stock-management', function () {

    return redirect()->route('admin.dashboard', [
        'page' => 'stock-management'
    ]);

})->name('admin.stock-management');


// VIEW ORDERS
Route::get('/admin/dashboard/view-orders', function () {

    return redirect()->route('admin.dashboard', [
        'page' => 'view-orders'
    ]);

})->name('admin.view-orders');


// ====================================================
// ADMIN ORDERS
// ====================================================

// VIEW ALL ORDERS
Route::get('/admin/orders', [
    ProductController::class,
    'adminOrders'
])->name('admin.orders');


// UPDATE ORDER STATUS
Route::put('/admin/orders/{id}/status', [
    ProductController::class,
    'updateOrderStatus'
])->name('admin.orders.update');


// ====================================================
// ADMIN LOGOUT
// ====================================================

Route::post('/admin/logout', [
    ProductController::class,
    'logout'
])->name('admin.logout');


// ====================================================
// ADD PRODUCT
// ====================================================

// ADD PRODUCT FORM
Route::get('/add-products', [
    ProductController::class,
    'create'
])->name('products.create');


// STORE PRODUCT
Route::post('/add-products', [
    ProductController::class,
    'store'
])->name('products.store');


// ====================================================
// PRODUCTS - PUBLIC
// ====================================================

Route::get('/products', [
    ProductController::class,
    'index'
])->name('products.index');


// ====================================================
// MANAGE PRODUCTS
// ====================================================

Route::get('/manage-products', function () {

    return redirect()->route('admin.dashboard', [
        'page' => 'manage-products'
    ]);

})->name('products.manage');


// ====================================================
// PRODUCT UPDATE
// ====================================================

Route::put('/products/{id}', [
    ProductController::class,
    'update'
])->name('products.update');


// ====================================================
// DELETE PRODUCT
// ====================================================

Route::delete('/products/{id}', [
    ProductController::class,
    'destroy'
])->name('products.destroy');


// ====================================================
// EDIT PRODUCT
// ====================================================

Route::get('/products/{id}/edit', function ($id) {

    return redirect()->route('admin.dashboard', [
        'page' => 'manage-products',
        'edit' => $id
    ]);

})->name('products.edit');

Route::get('/products/{id}', [ProductController::class, 'show'])
    ->name('products.show');

/*
|--------------------------------------------------------------------------
| ADMIN REPORTS
|--------------------------------------------------------------------------
*/

Route::get('/admin/reports', function (Request $request) {

    // ------------------------------------------------
    // ADMIN LOGIN CHECK
    // ------------------------------------------------

    if (!session('admin_logged_in')) {
        return redirect()->route('admin.login');
    }


    // ------------------------------------------------
    // FILTER VALUES
    // ------------------------------------------------

    $reportType = $request->get('report_type', 'all');

    $dateFrom = $request->get('date_from');

    $dateTo = $request->get('date_to');


    // ====================================================
    // USERS REPORT
    // ====================================================

    $usersQuery = DB::table('users');

    if (!empty($dateFrom)) {
        $usersQuery->whereDate(
            'created_at',
            '>=',
            $dateFrom
        );
    }

    if (!empty($dateTo)) {
        $usersQuery->whereDate(
            'created_at',
            '<=',
            $dateTo
        );
    }

    $users = $usersQuery
        ->orderByDesc('created_at')
        ->get();


    // ====================================================
    // PRODUCTS REPORT
    // ====================================================

    $productsQuery = DB::table('products');

    if (!empty($dateFrom)) {
        $productsQuery->whereDate(
            'created_at',
            '>=',
            $dateFrom
        );
    }

    if (!empty($dateTo)) {
        $productsQuery->whereDate(
            'created_at',
            '<=',
            $dateTo
        );
    }

    $products = $productsQuery
        ->orderByDesc('created_at')
        ->get();


    // ====================================================
    // ORDERS REPORT
    // ====================================================

    $orders = collect();

    if (
        DB::getSchemaBuilder()->hasTable('orders')
    ) {

        $ordersQuery = DB::table('orders');

        if (!empty($dateFrom)) {
            $ordersQuery->whereDate(
                'created_at',
                '>=',
                $dateFrom
            );
        }

        if (!empty($dateTo)) {
            $ordersQuery->whereDate(
                'created_at',
                '<=',
                $dateTo
            );
        }

        $orders = $ordersQuery
            ->orderByDesc('created_at')
            ->get();
    }


    // ====================================================
    // ORDER ITEMS
    // ====================================================

    $orderItems = collect();

    if (
        DB::getSchemaBuilder()->hasTable('order_items') &&
        DB::getSchemaBuilder()->hasTable('orders')
    ) {

        $orderItemsQuery = DB::table('order_items')
            ->leftJoin(
                'orders',
                'order_items.order_id',
                '=',
                'orders.id'
            )
            ->select(
                'order_items.*',
                'orders.created_at as order_date',
                'orders.name as customer_name',
                'orders.email as customer_email',
                'orders.status as order_status'
            );

        if (!empty($dateFrom)) {
            $orderItemsQuery->whereDate(
                'orders.created_at',
                '>=',
                $dateFrom
            );
        }

        if (!empty($dateTo)) {
            $orderItemsQuery->whereDate(
                'orders.created_at',
                '<=',
                $dateTo
            );
        }

        $orderItems = $orderItemsQuery
            ->orderByDesc('orders.created_at')
            ->get();
    }


    // ====================================================
    // SUMMARY
    // ====================================================

    $totalUsers = $users->count();

    $totalProducts = $products->count();

    $totalStock = $products->sum(
        function ($product) {

            return (int)(
                $product->stock ?? 0
            );

        }
    );


    $lowStock = $products
        ->filter(
            function ($product) {

                $stock = (int)(
                    $product->stock ?? 0
                );

                return $stock > 0 && $stock <= 5;
            }
        )
        ->count();


    $outOfStock = $products
        ->filter(
            function ($product) {

                return (int)(
                    $product->stock ?? 0
                ) === 0;

            }
        )
        ->count();


    $totalOrders = $orders->count();


    // ====================================================
    // SALES ORDERS
    // CANCELLED EXCLUDED
    // ====================================================

    $salesOrders = $orders
        ->filter(
            function ($order) {

                return strtolower(
                    trim(
                        $order->status ?? ''
                    )
                ) !== 'cancelled';

            }
        )
        ->values();


    // ====================================================
    // TOTAL SALES
    // ====================================================

    $totalSales = $salesOrders->sum(
        function ($order) {

            return (float)(
                $order->total_amount
                ?? $order->total
                ?? 0
            );

        }
    );


    // ====================================================
    // CATEGORIES
    // ====================================================

    $categories = $products
        ->pluck('category')
        ->filter()
        ->unique()
        ->values();


    // ====================================================
    // CATEGORY REPORT
    // ====================================================

    $categoryReport = $products
        ->groupBy('category')
        ->map(
            function ($items, $category) {

                return (object)[

                    'category' =>
                        $category,

                    'total_products' =>
                        $items->count(),

                    'total_stock' =>
                        $items->sum(
                            function ($item) {

                                return (int)(
                                    $item->stock ?? 0
                                );

                            }
                        ),

                    'total_value' =>
                        $items->sum(
                            function ($item) {

                                return
                                    ((float)(
                                        $item->price ?? 0
                                    )) *
                                    ((int)(
                                        $item->stock ?? 0
                                    ));

                            }
                        ),

                ];
            }
        )
        ->values();


    // ====================================================
    // CUSTOMER REPORT
    // ====================================================

    $customerReport = $salesOrders
        ->groupBy(
            function ($order) {

                return strtolower(
                    trim(
                        $order->email ?? 'guest'
                    )
                );

            }
        )
        ->map(
            function ($customerOrders, $email) {

                $firstOrder =
                    $customerOrders->first();

                return (object)[

                    'name' =>
                        $firstOrder->name
                        ?? 'Customer',

                    'email' =>
                        $email,

                    'total_orders' =>
                        $customerOrders->count(),

                    'total_spent' =>
                        $customerOrders->sum(
                            function ($order) {

                                return (float)(
                                    $order->total_amount
                                    ?? $order->total
                                    ?? 0
                                );

                            }
                        ),

                    'last_order_date' =>
                        $customerOrders->max(
                            'created_at'
                        ),

                ];
            }
        )
        ->values()
        ->sortByDesc('total_spent')
        ->values();


    // ====================================================
    // SALES REPORT - DATE WISE
    // ====================================================

    $salesReport = $salesOrders
        ->groupBy(
            function ($order) {

                return date(
                    'Y-m-d',
                    strtotime(
                        $order->created_at
                    )
                );

            }
        )
        ->map(
            function ($dayOrders, $date) {

                return (object)[

                    'date' =>
                        $date,

                    'total_orders' =>
                        $dayOrders->count(),

                    'total_sales' =>
                        $dayOrders->sum(
                            function ($order) {

                                return (float)(
                                    $order->total_amount
                                    ?? $order->total
                                    ?? 0
                                );

                            }
                        ),

                ];
            }
        )
        ->sortByDesc('date')
        ->values();


    // ====================================================
    // USER DATE WISE REPORT
    // ====================================================

    $userDateReport = $users
        ->groupBy(
            function ($user) {

                return date(
                    'Y-m-d',
                    strtotime(
                        $user->created_at
                    )
                );

            }
        )
        ->map(
            function ($dayUsers, $date) {

                return (object)[

                    'date' =>
                        $date,

                    'total_users' =>
                        $dayUsers->count(),

                ];
            }
        )
        ->sortByDesc('date')
        ->values();


    // ====================================================
    // ORDER DATE WISE REPORT
    // ====================================================

    $orderDateReport = $orders
        ->groupBy(
            function ($order) {

                return date(
                    'Y-m-d',
                    strtotime(
                        $order->created_at
                    )
                );

            }
        )
        ->map(
            function ($dayOrders, $date) {

                return (object)[

                    'date' =>
                        $date,

                    'total_orders' =>
                        $dayOrders->count(),

                    'total_sales' =>
                        $dayOrders
                            ->filter(
                                function ($order) {

                                    return strtolower(
                                        trim(
                                            $order->status ?? ''
                                        )
                                    ) !== 'cancelled';

                                }
                            )
                            ->sum(
                                function ($order) {

                                    return (float)(
                                        $order->total_amount
                                        ?? $order->total
                                        ?? 0
                                    );

                                }
                            ),

                ];
            }
        )
        ->sortByDesc('date')
        ->values();


    // ====================================================
    // RETURN REPORT PAGE
    // ====================================================

    return view(
        'admin-reports',
        [

            'users' =>
                $users,

            'products' =>
                $products,

            'orders' =>
                $orders,

            'orderItems' =>
                $orderItems,

            'categories' =>
                $categories,

            'categoryReport' =>
                $categoryReport,

            'customerReport' =>
                $customerReport,

            'salesReport' =>
                $salesReport,

            'userDateReport' =>
                $userDateReport,

            'orderDateReport' =>
                $orderDateReport,

            'totalUsers' =>
                $totalUsers,

            'totalProducts' =>
                $totalProducts,

            'totalStock' =>
                $totalStock,

            'lowStock' =>
                $lowStock,

            'outOfStock' =>
                $outOfStock,

            'totalOrders' =>
                $totalOrders,

            'totalSales' =>
                $totalSales,

            'reportType' =>
                $reportType,

            'dateFrom' =>
                $dateFrom,

            'dateTo' =>
                $dateTo,

        ]
    );

})->name('admin.reports');



/*
|--------------------------------------------------------------------------
| EXPORT EXCEL
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/reports/export/excel',
    function (Request $request) {

        // ------------------------------------------------
        // ADMIN LOGIN
        // ------------------------------------------------

        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }


        // ------------------------------------------------
        // FILTERS
        // ------------------------------------------------

        $reportType =
            $request->get(
                'report_type',
                'all'
            );

        $dateFrom =
            $request->get('date_from');

        $dateTo =
            $request->get('date_to');


        // ====================================================
        // USERS
        // ====================================================

        $usersQuery =
            DB::table('users');


        if (!empty($dateFrom)) {

            $usersQuery->whereDate(
                'created_at',
                '>=',
                $dateFrom
            );
        }


        if (!empty($dateTo)) {

            $usersQuery->whereDate(
                'created_at',
                '<=',
                $dateTo
            );
        }


        $users =
            $usersQuery
                ->orderByDesc('created_at')
                ->get();


        // ====================================================
        // PRODUCTS
        // ====================================================

        $productsQuery =
            DB::table('products');


        if (!empty($dateFrom)) {

            $productsQuery->whereDate(
                'created_at',
                '>=',
                $dateFrom
            );
        }


        if (!empty($dateTo)) {

            $productsQuery->whereDate(
                'created_at',
                '<=',
                $dateTo
            );
        }


        $products =
            $productsQuery
                ->orderByDesc('created_at')
                ->get();


        // ====================================================
        // ORDERS
        // ====================================================

        $orders = collect();


        if (
            DB::getSchemaBuilder()
                ->hasTable('orders')
        ) {

            $ordersQuery =
                DB::table('orders');


            if (!empty($dateFrom)) {

                $ordersQuery->whereDate(
                    'created_at',
                    '>=',
                    $dateFrom
                );
            }


            if (!empty($dateTo)) {

                $ordersQuery->whereDate(
                    'created_at',
                    '<=',
                    $dateTo
                );
            }


            $orders =
                $ordersQuery
                    ->orderByDesc('created_at')
                    ->get();
        }


        // ====================================================
        // EXCEL HTML START
        // ====================================================

        $html = '
<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<style>

body {
    font-family: Arial, sans-serif;
    font-size: 12px;
}

h1 {
    text-align: center;
    font-size: 22px;
}

h2 {
    font-size: 18px;
    margin-top: 30px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
}

th {
    background-color: #8cc63f;
    color: #ffffff;
    border: 1px solid #555555;
    padding: 8px;
    font-weight: bold;
}

td {
    border: 1px solid #999999;
    padding: 7px;
}

.total {
    font-weight: bold;
}

</style>

</head>

<body>

<h1>
CLASSIC - STORE REPORT
</h1>

<p>
<strong>Report Type:</strong>
' .
htmlspecialchars($reportType)
. '
</p>

<p>
<strong>Date From:</strong>
' .
htmlspecialchars(
    $dateFrom ?? 'All'
)
. '
</p>

<p>
<strong>Date To:</strong>
' .
htmlspecialchars(
    $dateTo ?? 'All'
)
. '
</p>
';


        // ====================================================
        // USER REPORT
        // ====================================================

        if (
            $reportType === 'users' ||
            $reportType === 'all'
        ) {

            $html .= '

<h2>
USER REPORT
</h2>

<table>

<tr>

<th>#</th>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Registration Date</th>

</tr>
';


            if ($users->count() > 0) {

                $index = 1;


                foreach ($users as $user) {

                    $html .= '

<tr>

<td>
' . $index . '
</td>

<td>
#' . $user->id . '
</td>

<td>
' .
htmlspecialchars(
    $user->name ?? '-'
)
. '
</td>

<td>
' .
htmlspecialchars(
    $user->email ?? '-'
)
. '
</td>

<td>
' .
htmlspecialchars(
    $user->created_at ?? '-'
)
. '
</td>

</tr>
';

                    $index++;
                }

            } else {

                $html .= '

<tr>

<td colspan="5">
No users found.
</td>

</tr>
';
            }


            $html .= '</table>';
        }


        // ====================================================
        // PRODUCT REPORT
        // ====================================================

        if (
            $reportType === 'products' ||
            $reportType === 'all'
        ) {

            $html .= '

<h2>
PRODUCT REPORT
</h2>

<table>

<tr>

<th>#</th>
<th>Product ID</th>
<th>Product Name</th>
<th>Category</th>
<th>Price</th>
<th>Stock</th>
<th>Created Date</th>

</tr>
';


            if ($products->count() > 0) {

                $index = 1;


                foreach ($products as $product) {

                    $html .= '

<tr>

<td>
' . $index . '
</td>

<td>
#' . $product->id . '
</td>

<td>
' .
htmlspecialchars(
    $product->name ?? '-'
)
. '
</td>

<td>
' .
htmlspecialchars(
    $product->category ?? '-'
)
. '
</td>

<td>
₹' .
number_format(
    (float)(
        $product->price ?? 0
    ),
    2
)
. '
</td>

<td>
' .
(int)(
    $product->stock ?? 0
)
. '
</td>

<td>
' .
htmlspecialchars(
    $product->created_at ?? '-'
)
. '
</td>

</tr>
';

                    $index++;
                }

            } else {

                $html .= '

<tr>

<td colspan="7">
No products found.
</td>

</tr>
';
            }


            $html .= '</table>';
        }


        // ====================================================
        // STOCK REPORT
        // ====================================================

        if (
            $reportType === 'stock' ||
            $reportType === 'all'
        ) {

            $html .= '

<h2>
STOCK REPORT
</h2>

<table>

<tr>

<th>#</th>
<th>Product</th>
<th>Category</th>
<th>Price</th>
<th>Stock</th>
<th>Status</th>

</tr>
';


            if ($products->count() > 0) {

                $index = 1;


                foreach ($products as $product) {

                    $stock =
                        (int)(
                            $product->stock ?? 0
                        );


                    if ($stock === 0) {

                        $status =
                            'Out of Stock';

                    } elseif ($stock <= 5) {

                        $status =
                            'Low Stock';

                    } else {

                        $status =
                            'In Stock';
                    }


                    $html .= '

<tr>

<td>
' . $index . '
</td>

<td>
' .
htmlspecialchars(
    $product->name ?? '-'
)
. '
</td>

<td>
' .
htmlspecialchars(
    $product->category ?? '-'
)
. '
</td>

<td>
₹' .
number_format(
    (float)(
        $product->price ?? 0
    ),
    2
)
. '
</td>

<td>
' . $stock . '
</td>

<td>
' . $status . '
</td>

</tr>
';

                    $index++;
                }

            } else {

                $html .= '

<tr>

<td colspan="6">
No stock data found.
</td>

</tr>
';
            }


            $html .= '</table>';
        }


        // ====================================================
        // ORDERS REPORT
        // ====================================================

        if (
            $reportType === 'orders' ||
            $reportType === 'all'
        ) {

            $html .= '

<h2>
ORDER REPORT
</h2>

<table>

<tr>

<th>#</th>
<th>Order ID</th>
<th>Customer</th>
<th>Email</th>
<th>Amount</th>
<th>Payment</th>
<th>Status</th>
<th>Date</th>

</tr>
';


            if ($orders->count() > 0) {

                $index = 1;


                foreach ($orders as $order) {

                    $amount =
                        (float)(
                            $order->total_amount
                            ?? $order->total
                            ?? 0
                        );


                    $payment =
                        $order->payment_method
                        ?? $order->payment
                        ?? 'N/A';


                    $html .= '

<tr>

<td>
' . $index . '
</td>

<td>
#' . $order->id . '
</td>

<td>
' .
htmlspecialchars(
    $order->name ?? 'Guest'
)
. '
</td>

<td>
' .
htmlspecialchars(
    $order->email ?? '-'
)
. '
</td>

<td>
₹' .
number_format(
    $amount,
    2
)
. '
</td>

<td>
' .
htmlspecialchars(
    $payment
)
. '
</td>

<td>
' .
htmlspecialchars(
    $order->status ?? '-'
)
. '
</td>

<td>
' .
htmlspecialchars(
    $order->created_at ?? '-'
)
. '
</td>

</tr>
';

                    $index++;
                }

            } else {

                $html .= '

<tr>

<td colspan="8">
No orders found.
</td>

</tr>
';
            }


            $html .= '</table>';
        }


        // ====================================================
        // ⭐ BILL REPORT
        // ====================================================

        if (
            $reportType === 'bills' ||
            $reportType === 'all'
        ) {

            $html .= '

<h2>
BILL REPORT
</h2>

<table>

<tr>

<th>#</th>
<th>Bill / Order ID</th>
<th>Customer</th>
<th>Email</th>
<th>Amount</th>
<th>Payment Method</th>
<th>Bill Date</th>
<th>Status</th>

</tr>
';


            if ($orders->count() > 0) {

                $billIndex = 1;

                $totalBillAmount = 0;


                foreach ($orders as $order) {

                    $amount =
                        (float)(
                            $order->total_amount
                            ?? $order->total
                            ?? 0
                        );


                    $totalBillAmount += $amount;


                    $payment =
                        $order->payment_method
                        ?? $order->payment
                        ?? 'N/A';


                    $customer =
                        $order->name
                        ?? 'Guest';


                    $email =
                        $order->email
                        ?? '-';


                    $status =
                        $order->status
                        ?? '-';


                    $billDate =
                        $order->created_at
                        ?? '-';


                    $html .= '

<tr>

<td>
' . $billIndex . '
</td>

<td>
BILL #' . $order->id . '
</td>

<td>
' .
htmlspecialchars(
    $customer
)
. '
</td>

<td>
' .
htmlspecialchars(
    $email
)
. '
</td>

<td>
₹' .
number_format(
    $amount,
    2
)
. '
</td>

<td>
' .
htmlspecialchars(
    $payment
)
. '
</td>

<td>
' .
htmlspecialchars(
    $billDate
)
. '
</td>

<td>
' .
htmlspecialchars(
    $status
)
. '
</td>

</tr>
';


                    $billIndex++;
                }


                // TOTAL

                $html .= '

<tr>

<td colspan="4">

<strong>
TOTAL BILL AMOUNT
</strong>

</td>

<td>

<strong>
₹' .
number_format(
    $totalBillAmount,
    2
)
. '
</strong>

</td>

<td colspan="3">
</td>

</tr>
';


            } else {

                $html .= '

<tr>

<td colspan="8">

No bills found for
selected date range.

</td>

</tr>
';
            }


            $html .= '</table>';
        }


        // ====================================================
        // SALES REPORT
        // ====================================================

        if (
            $reportType === 'sales' ||
            $reportType === 'all'
        ) {

            $salesOrders =
                $orders->filter(
                    function ($order) {

                        return strtolower(
                            trim(
                                $order->status ?? ''
                            )
                        ) !== 'cancelled';

                    }
                );


            $salesByDate =
                $salesOrders->groupBy(
                    function ($order) {

                        return date(
                            'Y-m-d',
                            strtotime(
                                $order->created_at
                            )
                        );

                    }
                );


            $html .= '

<h2>
SALES REPORT - DATE WISE
</h2>

<table>

<tr>

<th>Date</th>
<th>Total Orders</th>
<th>Total Sales</th>

</tr>
';


            foreach (
                $salesByDate
                as $date => $dayOrders
            ) {

                $salesAmount =
                    $dayOrders->sum(
                        function ($order) {

                            return (float)(
                                $order->total_amount
                                ?? $order->total
                                ?? 0
                            );

                        }
                    );


                $html .= '

<tr>

<td>
' . $date . '
</td>

<td>
' .
$dayOrders->count()
. '
</td>

<td>
₹' .
number_format(
    $salesAmount,
    2
)
. '
</td>

</tr>
';
            }


            $html .= '</table>';
        }


        // ====================================================
        // CATEGORY REPORT
        // ====================================================

        if (
            $reportType === 'categories' ||
            $reportType === 'all'
        ) {

            $categoryData =
                $products->groupBy(
                    'category'
                );


            $html .= '

<h2>
CATEGORY REPORT
</h2>

<table>

<tr>

<th>Category</th>
<th>Total Products</th>
<th>Total Stock</th>
<th>Stock Value</th>

</tr>
';


            foreach (
                $categoryData
                as $category => $items
            ) {

                $stockValue =
                    $items->sum(
                        function ($item) {

                            return
                                ((float)(
                                    $item->price ?? 0
                                )) *
                                ((int)(
                                    $item->stock ?? 0
                                ));

                        }
                    );


                $html .= '

<tr>

<td>
' .
htmlspecialchars(
    $category ?? '-'
)
. '
</td>

<td>
' .
$items->count()
. '
</td>

<td>
' .
$items->sum('stock')
. '
</td>

<td>
₹' .
number_format(
    $stockValue,
    2
)
. '
</td>

</tr>
';
            }


            $html .= '</table>';
        }


        // ====================================================
        // CUSTOMER REPORT
        // ====================================================

        if (
            $reportType === 'customers' ||
            $reportType === 'all'
        ) {

            $customerData =
                $orders
                    ->filter(
                        function ($order) {

                            return strtolower(
                                trim(
                                    $order->status ?? ''
                                )
                            ) !== 'cancelled';

                        }
                    )
                    ->groupBy(
                        function ($order) {

                            return strtolower(
                                trim(
                                    $order->email
                                    ?? 'guest'
                                )
                            );

                        }
                    );


            $html .= '

<h2>
CUSTOMER REPORT
</h2>

<table>

<tr>

<th>Customer</th>
<th>Email</th>
<th>Total Orders</th>
<th>Total Spent</th>
<th>Last Order Date</th>

</tr>
';


            foreach (
                $customerData
                as $email => $customerOrders
            ) {

                $firstOrder =
                    $customerOrders->first();


                $totalSpent =
                    $customerOrders->sum(
                        function ($order) {

                            return (float)(
                                $order->total_amount
                                ?? $order->total
                                ?? 0
                            );

                        }
                    );


                $lastOrderDate =
                    $customerOrders->max(
                        'created_at'
                    );


                $html .= '

<tr>

<td>
' .
htmlspecialchars(
    $firstOrder->name
    ?? 'Customer'
)
. '
</td>

<td>
' .
htmlspecialchars(
    $email
)
. '
</td>

<td>
' .
$customerOrders->count()
. '
</td>

<td>
₹' .
number_format(
    $totalSpent,
    2
)
. '
</td>

<td>
' .
htmlspecialchars(
    $lastOrderDate
    ?? '-'
)
. '
</td>

</tr>
';
            }


            $html .= '</table>';
        }


        // ====================================================
        // CLOSE HTML
        // ====================================================

        $html .= '

</body>

</html>
';


        // ====================================================
        // DOWNLOAD EXCEL
        // ====================================================

        $filename =
            'classic-store-report-' .
            date('Y-m-d-H-i-s') .
            '.xls';


        return response(
            $html,
            200,
            [

                'Content-Type' =>
                    'application/vnd.ms-excel; charset=UTF-8',

                'Content-Disposition' =>
                    'attachment; filename="' .
                    $filename .
                    '"',

                'Cache-Control' =>
                    'max-age=0',

            ]
        );

    }
)->name('admin.reports.excel');



/*
|--------------------------------------------------------------------------
| EXPORT PDF
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/reports/export/pdf',
    function (Request $request) {

        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }


        $reportType =
            $request->get(
                'report_type',
                'all'
            );


        $dateFrom =
            $request->get('date_from');


        $dateTo =
            $request->get('date_to');


        // USERS

        $usersQuery =
            DB::table('users');


        if (!empty($dateFrom)) {

            $usersQuery->whereDate(
                'created_at',
                '>=',
                $dateFrom
            );
        }


        if (!empty($dateTo)) {

            $usersQuery->whereDate(
                'created_at',
                '<=',
                $dateTo
            );
        }


        $users =
            $usersQuery
                ->orderByDesc('created_at')
                ->get();


        // PRODUCTS

        $productsQuery =
            DB::table('products');


        if (!empty($dateFrom)) {

            $productsQuery->whereDate(
                'created_at',
                '>=',
                $dateFrom
            );
        }


        if (!empty($dateTo)) {

            $productsQuery->whereDate(
                'created_at',
                '<=',
                $dateTo
            );
        }


        $products =
            $productsQuery
                ->orderByDesc('created_at')
                ->get();


        // ORDERS

        $orders = collect();


        if (
            DB::getSchemaBuilder()
                ->hasTable('orders')
        ) {

            $ordersQuery =
                DB::table('orders');


            if (!empty($dateFrom)) {

                $ordersQuery->whereDate(
                    'created_at',
                    '>=',
                    $dateFrom
                );
            }


            if (!empty($dateTo)) {

                $ordersQuery->whereDate(
                    'created_at',
                    '<=',
                    $dateTo
                );
            }


            $orders =
                $ordersQuery
                    ->orderByDesc('created_at')
                    ->get();
        }


        // PDF

        $pdf =
            \Barryvdh\DomPDF\Facade\Pdf::loadView(
                'reports-pdf',
                [

                    'users' =>
                        $users,

                    'products' =>
                        $products,

                    'orders' =>
                        $orders,

                    'type' =>
                        $reportType,

                    'reportType' =>
                        $reportType,

                    'dateFrom' =>
                        $dateFrom,

                    'dateTo' =>
                        $dateTo,

                ]
            );


        return $pdf->download(
            'classic-store-report-' .
            date('Y-m-d-H-i-s') .
            '.pdf'
        );

    }
)->name('admin.reports.pdf');



/*
|--------------------------------------------------------------------------
| PRINT REPORT
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/reports/print',
    function (Request $request) {

        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }


        $reportType =
            $request->get(
                'report_type',
                'all'
            );


        $dateFrom =
            $request->get('date_from');


        $dateTo =
            $request->get('date_to');


        // USERS

        $usersQuery =
            DB::table('users');


        if (!empty($dateFrom)) {

            $usersQuery->whereDate(
                'created_at',
                '>=',
                $dateFrom
            );
        }


        if (!empty($dateTo)) {

            $usersQuery->whereDate(
                'created_at',
                '<=',
                $dateTo
            );
        }


        $users =
            $usersQuery
                ->orderByDesc('created_at')
                ->get();


        // PRODUCTS

        $productsQuery =
            DB::table('products');


        if (!empty($dateFrom)) {

            $productsQuery->whereDate(
                'created_at',
                '>=',
                $dateFrom
            );
        }


        if (!empty($dateTo)) {

            $productsQuery->whereDate(
                'created_at',
                '<=',
                $dateTo
            );
        }


        $products =
            $productsQuery
                ->orderByDesc('created_at')
                ->get();


        // ORDERS

        $orders = collect();


        if (
            DB::getSchemaBuilder()
                ->hasTable('orders')
        ) {

            $ordersQuery =
                DB::table('orders');


            if (!empty($dateFrom)) {

                $ordersQuery->whereDate(
                    'created_at',
                    '>=',
                    $dateFrom
                );
            }


            if (!empty($dateTo)) {

                $ordersQuery->whereDate(
                    'created_at',
                    '<=',
                    $dateTo
                );
            }


            $orders =
                $ordersQuery
                    ->orderByDesc('created_at')
                    ->get();
        }


        return view(
            'reports-print',
            [

                'users' =>
                    $users,

                'products' =>
                    $products,

                'orders' =>
                    $orders,

                'reportType' =>
                    $reportType,

                'dateFrom' =>
                    $dateFrom,

                'dateTo' =>
                    $dateTo,

            ]
        );

    }
)->name('admin.reports.print');



/*
|--------------------------------------------------------------------------
| CART + CHECKOUT + USER ORDERS
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(
    function () {

        // ADD TO CART

        Route::post(
            '/cart/add/{id}',
            [
                ProductController::class,
                'addToCart'
            ]
        )->name('cart.add');


        // CART PAGE

        Route::get(
            '/cart',
            [
                ProductController::class,
                'cart'
            ]
        )->name('cart');


        // INCREASE

        Route::post(
            '/cart/increase/{id}',
            [
                ProductController::class,
                'increaseQuantity'
            ]
        )->name('cart.increase');


        // DECREASE

        Route::post(
            '/cart/decrease/{id}',
            [
                ProductController::class,
                'decreaseQuantity'
            ]
        )->name('cart.decrease');


        // REMOVE

        Route::delete(
            '/cart/remove/{id}',
            [
                ProductController::class,
                'removeFromCart'
            ]
        )->name('cart.remove');


        // CHECKOUT

        Route::get(
            '/checkout',
            [
                ProductController::class,
                'checkout'
            ]
        )->name('checkout');


        // PLACE ORDER

        Route::post(
            '/order/place',
            [
                ProductController::class,
                'placeOrder'
            ]
        )->name('order.place');


        // MY ORDERS

        Route::get(
            '/my-orders',
            [
                ProductController::class,
                'myOrders'
            ]
        )->name('my.orders');

    }
);



/*
|--------------------------------------------------------------------------
| ADMIN REPORT PDF BY TYPE
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/report/pdf/{type}',
    [
        ProductController::class,
        'downloadReportPdf'
    ]
)->name('admin.report.pdf');

// ====================================================
// CART + CHECKOUT + USER ORDERS
// ====================================================

Route::middleware('auth')->group(function () {

    // ADD TO CART
    Route::post(
        '/cart/add/{id}',
        [
            ProductController::class,
            'addToCart'
        ]
    )->name('cart.add');


    // CART PAGE
    Route::get(
        '/cart',
        [
            ProductController::class,
            'cart'
        ]
    )->name('cart');


    // INCREASE QUANTITY
    Route::post(
        '/cart/increase/{id}',
        [
            ProductController::class,
            'increaseQuantity'
        ]
    )->name('cart.increase');


    // DECREASE QUANTITY
    Route::post(
        '/cart/decrease/{id}',
        [
            ProductController::class,
            'decreaseQuantity'
        ]
    )->name('cart.decrease');


    // REMOVE FROM CART
    Route::delete(
        '/cart/remove/{id}',
        [
            ProductController::class,
            'removeFromCart'
        ]
    )->name('cart.remove');


    // CHECKOUT PAGE
    Route::get(
        '/checkout',
        [
            ProductController::class,
            'checkout'
        ]
    )->name('checkout');


    // PLACE ORDER
    Route::post(
        '/order/place',
        [
            ProductController::class,
            'placeOrder'
        ]
    )->name('order.place');


    // MY ORDERS
    Route::get(
        '/my-orders',
        [
            ProductController::class,
            'myOrders'
        ]
    )->name('my.orders');

});


// ====================================================
// ADMIN REPORT PDF BY TYPE
// ====================================================

Route::get(
    '/admin/report/pdf/{type}',
    [
        ProductController::class,
        'downloadReportPdf'
    ]
)->name('admin.report.pdf');
/*
|--------------------------------------------------------------------------
| ADMIN SETTINGS
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/settings',
    [SettingController::class, 'index']
)->name('admin.settings');


Route::post(
    '/admin/settings',
    [SettingController::class, 'update']
)->name('admin.settings.update');

Route::get(
    '/my-orders',
    [ProductController::class, 'myOrders']
)
->middleware('auth')
->name('my.orders');

// ====================================================
// ADMIN USER MANAGEMENT
// ====================================================

Route::get('/admin/user-management', function () {

    return redirect()->route('admin.dashboard', [
        'page' => 'user-management'
    ]);

})->name('admin.user-management');

Route::post('/coupon/apply', [CouponController::class, 'apply'])
    ->name('coupon.apply')
    ->middleware('auth');

Route::post('/coupon/remove', [CouponController::class, 'remove'])
    ->name('coupon.remove')
    ->middleware('auth');
    // ================================
// ADMIN COUPON MANAGEMENT
// ================================

Route::get('/admin/coupons', [CouponController::class, 'index'])
    ->name('admin.coupons');

Route::post('/admin/coupons', [CouponController::class, 'store'])
    ->name('admin.coupons.store');

Route::put(
    '/admin/coupons/{id}',
    [CouponController::class, 'update']
)->name('admin.coupons.update');

Route::delete(
    '/admin/coupons/{id}',
    [CouponController::class, 'destroy']
)->name('admin.coupons.destroy');

// ====================================================
// USER MANAGEMENT
// ====================================================

Route::post(
    '/admin/user-management/admin/store',
    [UserManagementController::class, 'storeAdmin']
)->name('admin.user-management.admin.store');


Route::put(
    '/admin/user-management/admin/{id}/permissions',
    [UserManagementController::class, 'updatePermissions']
)->name('admin.user-management.permissions.update');

Route::post(
    '/products/{id}/review',
    [ProductController::class, 'addReview']
)->name('products.review');

// ====================================================
// USER ORDER NOTIFICATIONS
// ====================================================

Route::get(
    '/order-notification',
    [ProductController::class, 'getOrderNotification']
)->middleware('auth')
 ->name('order.notification');

Route::post(
    '/order-notification/{id}/read',
    [ProductController::class, 'markOrderNotificationRead']
)->middleware('auth')
 ->name('order.notification.read');

/*
|--------------------------------------------------------------------------
| CONTACT PAGE
|--------------------------------------------------------------------------
*/

Route::get('/contact', function () {

    $enquiries = collect();

    if (auth()->check()) {

        $enquiries = Enquiry::where(
            'user_id',
            auth()->id()
        )
        ->latest()
        ->get();

    }

    return view(
        'contact',
        compact('enquiries')
    );

})->name('contact');



/*
|--------------------------------------------------------------------------
| USER ENQUIRY
|--------------------------------------------------------------------------
|
| User sends enquiry to admin.
|
*/

Route::post(
    '/enquiry/store',
    [
        EnquiryController::class,
        'store'
    ]
)
->middleware('auth')
->name('enquiry.store');



/*
|--------------------------------------------------------------------------
| ADMIN ENQUIRIES
|--------------------------------------------------------------------------
|
| Admin can see all enquiries.
|
*/

Route::get(
    '/admin/enquiries',
    [
        EnquiryController::class,
        'adminIndex'
    ]
)
->name('admin.enquiries');



/*
|--------------------------------------------------------------------------
| ADMIN REPLY
|--------------------------------------------------------------------------
|
| Admin replies to user's enquiry.
|
*/

Route::post(
    '/admin/enquiries/{id}/reply',
    [
        EnquiryController::class,
        'reply'
    ]
)
->name('admin.enquiries.reply');



/*
|--------------------------------------------------------------------------
| ADMIN ENQUIRY LIVE NOTIFICATION
|--------------------------------------------------------------------------
|
| AJAX endpoint.
| Dashboard continuously checks this route.
|
*/

Route::get(
    '/admin/enquiry-notification',
    [
        EnquiryController::class,
        'adminNotification'
    ]
)
->name('admin.enquiry.notification');



/*
|--------------------------------------------------------------------------
| ADMIN MARK ENQUIRY AS READ
|--------------------------------------------------------------------------
|
| AJAX endpoint.
| Admin opens/reads an enquiry.
|
*/

Route::post(
    '/admin/enquiry/{id}/read',
    [
        EnquiryController::class,
        'markAdminRead'
    ]
)
->name('admin.enquiry.read');



/*
|--------------------------------------------------------------------------
| USER ENQUIRY NOTIFICATION
|--------------------------------------------------------------------------
|
| AJAX endpoint.
| Checks if admin has replied to logged-in user.
|
*/

Route::get(
    '/user/enquiry-notification',
    [
        EnquiryController::class,
        'userNotification'
    ]
)
->middleware('auth')
->name('user.enquiry.notification');



/*
|--------------------------------------------------------------------------
| USER MARK REPLY AS READ
|--------------------------------------------------------------------------
|
| AJAX endpoint.
| Marks admin reply as seen by user.
|
*/

Route::post(
    '/user/enquiry/{id}/read',
    [
        EnquiryController::class,
        'markUserRead'
    ]
)
->middleware('auth')
->name('user.enquiry.read');

Route::get(
    '/admin/orders/{id}/bill',
    [ProductController::class, 'orderBill']
)->name('admin.orders.bill');

Route::get(
    '/admin/orders/{id}/bill/pdf',
    [ProductController::class, 'downloadOrderBill']
)->name('admin.orders.bill.pdf');

// ====================================================
// SHIPPING CHARGES
// ====================================================

Route::get('/admin/shipping', [
    ProductController::class,
    'shippingCharges'
])->name('admin.shipping');

Route::post('/admin/shipping', [
    ProductController::class,
    'updateShippingCharges'
])->name('admin.shipping.update');


// ====================================================
// TWO FACTOR AUTHENTICATION
// ====================================================


// ----------------------------------------------------
// TWO FACTOR SETTINGS PAGE
// ----------------------------------------------------
// Dashboard मधून "Two-Factor Authentication" click
// केल्यावर Active / Disabled page उघडेल.
// QR scanner इथे उघडणार नाही.
// ----------------------------------------------------

Route::get(
    '/admin/2fa/settings',
    [TwoFactorController::class, 'settings']
)->name('admin.2fa.settings');


// ----------------------------------------------------
// TWO FACTOR SETUP / QR SCANNER
// ----------------------------------------------------
// फक्त 2FA Enable करताना हा page उघडेल.
// ----------------------------------------------------

Route::get(
    '/admin/2fa/setup',
    [TwoFactorController::class, 'setup']
)->name('admin.2fa.setup');


// ----------------------------------------------------
// VERIFY 2FA SETUP
// ----------------------------------------------------
// QR scan केल्यानंतर Google Authenticator मधील
// 6 digit OTP verify करण्यासाठी.
// ----------------------------------------------------

Route::post(
    '/admin/2fa/setup/verify',
    [TwoFactorController::class, 'verifySetup']
)->name('admin.2fa.setup.verify');


// ----------------------------------------------------
// LOGIN OTP PAGE
// ----------------------------------------------------
// 2FA Active असल्यास password नंतर हा page उघडेल.
// ----------------------------------------------------

Route::get(
    '/admin/2fa/verify',
    [TwoFactorController::class, 'verify']
)->name('admin.2fa.verify');


// ----------------------------------------------------
// LOGIN OTP VERIFY
// ----------------------------------------------------
// Google Authenticator मधील 6 digit code verify.
// ----------------------------------------------------

Route::post(
    '/admin/2fa/verify',
    [TwoFactorController::class, 'verifyLogin']
)->name('admin.2fa.verify.login');


// ----------------------------------------------------
// ENABLE TWO FACTOR
// ----------------------------------------------------
// Settings page मधून Enable button click केल्यावर
// QR Setup page उघडेल.
// ----------------------------------------------------

Route::post(
    '/admin/2fa/enable',
    [TwoFactorController::class, 'enable']
)->name('admin.2fa.enable');


// ----------------------------------------------------
// DISABLE TWO FACTOR
// ----------------------------------------------------
// Settings page मधून Disable button click केल्यावर
// 2FA बंद होईल.
// ----------------------------------------------------

Route::post(
    '/admin/2fa/disable',
    [TwoFactorController::class, 'disable']
)->name('admin.2fa.disable');