<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class ReportController extends Controller
{
    // ====================================================
    // REPORT PAGE
    // ====================================================

    public function index(Request $request)
    {
        // Admin login check
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // ------------------------------------------------
        // FILTER VALUES
        // ------------------------------------------------

        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');

        $report = $request->get('report', 'all');


        // ====================================================
        // USERS
        // ====================================================

        $usersQuery = User::query();

        if ($fromDate) {
            $usersQuery->whereDate(
                'created_at',
                '>=',
                $fromDate
            );
        }

        if ($toDate) {
            $usersQuery->whereDate(
                'created_at',
                '<=',
                $toDate
            );
        }

        $users = $usersQuery
            ->latest()
            ->get();


        // ====================================================
        // PRODUCTS
        // ====================================================

        $productsQuery = Product::query();

        if ($fromDate) {
            $productsQuery->whereDate(
                'created_at',
                '>=',
                $fromDate
            );
        }

        if ($toDate) {
            $productsQuery->whereDate(
                'created_at',
                '<=',
                $toDate
            );
        }

        $products = $productsQuery
            ->latest()
            ->get();


        // ====================================================
        // ORDERS
        // ====================================================

        $ordersQuery = Order::query();

        if ($fromDate) {
            $ordersQuery->whereDate(
                'created_at',
                '>=',
                $fromDate
            );
        }

        if ($toDate) {
            $ordersQuery->whereDate(
                'created_at',
                '<=',
                $toDate
            );
        }

        $orders = $ordersQuery
            ->latest()
            ->get();


        // ====================================================
        // SALES
        // ====================================================

        $salesOrdersQuery = Order::query()
            ->whereNotIn('status', ['Cancelled']);

        if ($fromDate) {
            $salesOrdersQuery->whereDate(
                'created_at',
                '>=',
                $fromDate
            );
        }

        if ($toDate) {
            $salesOrdersQuery->whereDate(
                'created_at',
                '<=',
                $toDate
            );
        }

        $salesOrders = $salesOrdersQuery
            ->latest()
            ->get();


        // ====================================================
        // SUMMARY
        // ====================================================

        $totalUsers = $users->count();

        $totalProducts = $products->count();

        $totalOrders = $salesOrders->count();

        $totalSales = $salesOrders->sum(
            'total_amount'
        );

        $totalStock = $products->sum('stock');


        // ====================================================
        // LOW STOCK
        // ====================================================

        $lowStock = $products
            ->filter(function ($product) {

                return $product->stock > 0 &&
                       $product->stock <= 5;

            })
            ->count();


        // ====================================================
        // OUT OF STOCK
        // ====================================================

        $outOfStock = $products
            ->where('stock', 0)
            ->count();


        // ====================================================
        // DATE WISE USERS
        // ====================================================

        $dateWiseUsers = $users
            ->groupBy(function ($user) {

                return $user->created_at
                    ->format('Y-m-d');

            })
            ->map(function ($items) {

                return $items->count();

            });


        // ====================================================
        // DATE WISE ORDERS
        // ====================================================

        $dateWiseOrders = $orders
            ->groupBy(function ($order) {

                return $order->created_at
                    ->format('Y-m-d');

            })
            ->map(function ($items) {

                return $items->count();

            });


        // ====================================================
        // DATE WISE SALES
        // ====================================================

        $dateWiseSales = $salesOrders
            ->groupBy(function ($order) {

                return $order->created_at
                    ->format('Y-m-d');

            })
            ->map(function ($items) {

                return $items->sum(
                    'total_amount'
                );

            });


        // ====================================================
        // REPORT VIEW
        // ====================================================

        return view(
            'reports',
            compact(
                'users',
                'products',
                'orders',
                'salesOrders',
                'totalUsers',
                'totalProducts',
                'totalOrders',
                'totalSales',
                'totalStock',
                'lowStock',
                'outOfStock',
                'dateWiseUsers',
                'dateWiseOrders',
                'dateWiseSales',
                'fromDate',
                'toDate',
                'report'
            )
        );
    }


    // ====================================================
    // EXPORT USERS CSV
    // ====================================================

    public function exportUsers(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $query = User::query();

        if ($request->from_date) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->from_date
            );
        }

        if ($request->to_date) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->to_date
            );
        }

        $users = $query->latest()->get();

        $filename =
            'users-report-' .
            now()->format('Y-m-d') .
            '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' =>
                'attachment; filename="' .
                $filename .
                '"',
        ];

        $callback = function () use ($users) {

            $file = fopen(
                'php://output',
                'w'
            );

            fputcsv($file, [
                'ID',
                'Name',
                'Email',
                'Registration Date'
            ]);

            foreach ($users as $user) {

                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->created_at
                        ? $user->created_at->format('Y-m-d')
                        : ''
                ]);
            }

            fclose($file);
        };

        return response()->stream(
            $callback,
            200,
            $headers
        );
    }


    // ====================================================
    // EXPORT PRODUCTS CSV
    // ====================================================

    public function exportProducts()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $products = Product::latest()->get();

        $filename =
            'products-report-' .
            now()->format('Y-m-d') .
            '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' =>
                'attachment; filename="' .
                $filename .
                '"',
        ];

        $callback = function () use ($products) {

            $file = fopen(
                'php://output',
                'w'
            );

            fputcsv($file, [
                'ID',
                'Product Name',
                'Category',
                'Price',
                'Stock',
                'Created Date'
            ]);

            foreach ($products as $product) {

                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->category,
                    $product->price,
                    $product->stock,
                    $product->created_at
                        ? $product->created_at->format('Y-m-d')
                        : ''
                ]);
            }

            fclose($file);
        };

        return response()->stream(
            $callback,
            200,
            $headers
        );
    }


    // ====================================================
    // EXPORT ORDERS CSV
    // ====================================================

    public function exportOrders(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $query = Order::query();

        if ($request->from_date) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->from_date
            );
        }

        if ($request->to_date) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->to_date
            );
        }

        $orders = $query->latest()->get();

        $filename =
            'orders-report-' .
            now()->format('Y-m-d') .
            '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' =>
                'attachment; filename="' .
                $filename .
                '"',
        ];

        $callback = function () use ($orders) {

            $file = fopen(
                'php://output',
                'w'
            );

            fputcsv($file, [
                'Order ID',
                'Customer',
                'Email',
                'Mobile',
                'Total Amount',
                'Payment Method',
                'Status',
                'Date'
            ]);

            foreach ($orders as $order) {

                fputcsv($file, [
                    $order->id,
                    $order->name,
                    $order->email,
                    $order->mobile,
                    $order->total_amount,
                    $order->payment_method,
                    $order->status,
                    $order->created_at
                        ? $order->created_at->format('Y-m-d')
                        : ''
                ]);
            }

            fclose($file);
        };

        return response()->stream(
            $callback,
            200,
            $headers
        );
    }


    // ====================================================
    // EXPORT SALES CSV
    // ====================================================

    public function exportSales(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $query = Order::query()
            ->whereNotIn(
                'status',
                ['Cancelled']
            );

        if ($request->from_date) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->from_date
            );
        }

        if ($request->to_date) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->to_date
            );
        }

        $orders = $query->latest()->get();

        $filename =
            'sales-report-' .
            now()->format('Y-m-d') .
            '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' =>
                'attachment; filename="' .
                $filename .
                '"',
        ];

        $callback = function () use ($orders) {

            $file = fopen(
                'php://output',
                'w'
            );

            fputcsv($file, [
                'Order ID',
                'Customer',
                'Amount',
                'Status',
                'Date'
            ]);

            foreach ($orders as $order) {

                fputcsv($file, [
                    $order->id,
                    $order->name,
                    $order->total_amount,
                    $order->status,
                    $order->created_at
                        ? $order->created_at->format('Y-m-d')
                        : ''
                ]);
            }

            fputcsv($file, []);

            fputcsv($file, [
                '',
                'TOTAL SALES',
                $orders->sum(
                    'total_amount'
                )
            ]);

            fclose($file);
        };

        return response()->stream(
            $callback,
            200,
            $headers
        );
    }
}