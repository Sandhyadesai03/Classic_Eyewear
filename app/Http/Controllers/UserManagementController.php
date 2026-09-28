<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserManagementController extends Controller
{
    // ====================================================
    // CREATE NEW ADMIN
    // ====================================================

    public function storeAdmin(Request $request)
    {
        // ONLY SUPER ADMIN CAN CREATE ADMIN
        if (session('admin_role') !== 'superadmin') {

            return redirect()
                ->route('admin.dashboard', [
                    'page' => 'user-management'
                ])
                ->with(
                    'error',
                    'You are not authorized to create a new admin.'
                );
        }


        // VALIDATION
        $request->validate([

            'name' =>
                'required|string|max:100',

            'email' =>
                'required|email|max:255|unique:users,email',

            'phone' =>
                'nullable|string|max:20',

            'password' =>
                'required|string|min:6|confirmed',

            'permissions' =>
                'nullable|array',

        ]);


        // CREATE ADMIN
        User::create([

            'name' =>
                $request->name,

            'email' =>
                strtolower(trim($request->email)),

            'phone' =>
                $request->phone,

            /*
            |--------------------------------------------------------------------------
            | IMPORTANT
            |--------------------------------------------------------------------------
            | User model मध्ये 'password' => 'hashed' आहे.
            | त्यामुळे इथे Hash::make() वापरायचा नाही.
            */

            'password' =>
                $request->password,

            'is_admin' =>
                1,

            'role' =>
                'admin',

            'permissions' =>
                $request->input(
                    'permissions',
                    []
                ),

        ]);


        return redirect()
            ->route(
                'admin.dashboard',
                [
                    'page' => 'user-management'
                ]
            )
            ->with(
                'success',
                'New admin created successfully!'
            );
    }


    // ====================================================
    // UPDATE ADMIN PERMISSIONS
    // ====================================================

    public function updatePermissions(
        Request $request,
        $id
    ) {

        // ====================================================
        // ONLY SUPER ADMIN
        // ====================================================

        if (
            session('admin_role') !==
            'superadmin'
        ) {

            return redirect()
                ->route(
                    'admin.dashboard',
                    [
                        'page' =>
                            'user-management'
                    ]
                )
                ->with(
                    'error',
                    'You are not authorized to change permissions.'
                );
        }


        // ====================================================
        // FIND ADMIN
        // ====================================================

        $admin = User::where(
            'is_admin',
            1
        )->findOrFail($id);


        // ====================================================
        // GET PERMISSIONS
        // ====================================================

        $permissions =
            $request->input(
                'permissions',
                []
            );


        // Make sure permissions is array
        if (!is_array($permissions)) {

            $permissions = [];

        }


        // ====================================================
        // SAVE PERMISSIONS
        // ====================================================

        $admin->permissions =
            array_values($permissions);

        $admin->save();


        // ====================================================
        // SUCCESS
        // ====================================================

        return redirect()
            ->route(
                'admin.dashboard',
                [
                    'page' =>
                        'user-management'
                ]
            )
            ->with(
                'success',
                'Admin permissions updated successfully!'
            );
    }
}