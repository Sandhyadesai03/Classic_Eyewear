<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | USER - STORE NEW ENQUIRY
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Please login first to send an enquiry.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Enquiry::create([
            'user_id' => auth()->id(),

            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],

            /*
            | New enquiry
            */
            'status' => 'pending',

            /*
            | Admin has NOT seen it
            */
            'admin_read' => false,

            /*
            | User should NOT get notification for
            | his own newly-created enquiry
            */
            'user_read' => true,

            /*
            | No reply yet
            */
            'reply' => null,
            'replied_at' => null,
        ]);

        return redirect()
            ->route('contact')
            ->with(
                'success',
                'Your enquiry has been sent successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - VIEW ALL ENQUIRIES
    |--------------------------------------------------------------------------
    */

    public function adminIndex()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $enquiries = Enquiry::with('user')
            ->latest()
            ->get();

        $pendingEnquiries = Enquiry::where(
            'status',
            'pending'
        )->count();

        return view(
            'enquiries',
            compact(
                'enquiries',
                'pendingEnquiries'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - REPLY TO ENQUIRY
    |--------------------------------------------------------------------------
    */

    public function reply(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'reply' => 'required|string',
        ]);

        $enquiry = Enquiry::findOrFail($id);

        $enquiry->update([
            /*
            | Admin reply
            */
            'reply' => $validated['reply'],

            /*
            | Status
            */
            'status' => 'replied',

            /*
            | Reply time
            */
            'replied_at' => now(),

            /*
            | User has NOT seen reply
            */
            'user_read' => false,
        ]);

        return redirect()
            ->route(
                'admin.dashboard',
                [
                    'page' => 'enquiries'
                ]
            )
            ->with(
                'success',
                'Reply sent successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - NOTIFICATION
    |--------------------------------------------------------------------------
    |
    | This API is used ONLY by admin dashboard.
    |
    | It returns enquiries where:
    |
    | admin_read = 0
    |
    |--------------------------------------------------------------------------
    */

    public function adminNotification()
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN LOGIN CHECK
        |--------------------------------------------------------------------------
        */

        if (!session('admin_logged_in')) {

            return response()->json([
                'success' => false,
                'count' => 0,
                'latest' => null,
                'enquiries' => [],
                'message' => 'Unauthorized',
            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | GET UNREAD ENQUIRIES
        |--------------------------------------------------------------------------
        */

        $enquiries = Enquiry::where(
            'admin_read',
            0
        )
        ->latest('created_at')
        ->get();


        /*
        |--------------------------------------------------------------------------
        | COUNT
        |--------------------------------------------------------------------------
        */

        $count = $enquiries->count();


        /*
        |--------------------------------------------------------------------------
        | LATEST
        |--------------------------------------------------------------------------
        */

        $latest = $enquiries->first();


        $latestData = null;


        if ($latest) {

            $latestData = [
                'id' => $latest->id,

                'user_id' => $latest->user_id,

                'name' => $latest->name,

                'email' => $latest->email,

                'subject' => $latest->subject,

                'message' => $latest->message,

                'status' => $latest->status,

                'created_at' => $latest->created_at
                    ? $latest->created_at->format(
                        'd M Y, h:i A'
                    )
                    : '',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | ALL UNREAD ENQUIRIES
        |--------------------------------------------------------------------------
        */

        $enquiriesData = $enquiries
            ->map(function ($enquiry) {

                return [
                    'id' => $enquiry->id,

                    'user_id' => $enquiry->user_id,

                    'name' => $enquiry->name,

                    'email' => $enquiry->email,

                    'subject' => $enquiry->subject,

                    'message' => $enquiry->message,

                    'status' => $enquiry->status,

                    'created_at' => $enquiry->created_at
                        ? $enquiry->created_at->format(
                            'd M Y, h:i A'
                        )
                        : '',
                ];
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | RETURN JSON
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,

            'count' => $count,

            'latest' => $latestData,

            'enquiries' => $enquiriesData,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - MARK ENQUIRY AS READ
    |--------------------------------------------------------------------------
    */

    public function markAdminRead($id)
    {
        if (!session('admin_logged_in')) {

            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }


        $enquiry = Enquiry::findOrFail($id);


        $enquiry->update([
            'admin_read' => true,
        ]);


        return response()->json([
            'success' => true,

            'message' => 'Enquiry marked as read.',
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | USER - NOTIFICATION
    |--------------------------------------------------------------------------
    |
    | This API is used ONLY by logged-in user.
    |
    | It returns ONLY admin replies which are unread.
    |
    |--------------------------------------------------------------------------
    */

    public function userNotification()
    {
        /*
        |--------------------------------------------------------------------------
        | USER LOGIN CHECK
        |--------------------------------------------------------------------------
        */

        if (!auth()->check()) {

            return response()->json([
                'success' => false,
                'count' => 0,
                'latest' => null,
                'enquiries' => [],
                'message' => 'Unauthorized',
            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | GET USER'S UNREAD REPLIES
        |--------------------------------------------------------------------------
        */

        $enquiries = Enquiry::where(
            'user_id',
            auth()->id()
        )
        ->where(
            'status',
            'replied'
        )
        ->where(
            'user_read',
            0
        )
        ->latest('replied_at')
        ->get();


        /*
        |--------------------------------------------------------------------------
        | COUNT
        |--------------------------------------------------------------------------
        */

        $count = $enquiries->count();


        /*
        |--------------------------------------------------------------------------
        | LATEST REPLY
        |--------------------------------------------------------------------------
        */

        $latest = $enquiries->first();


        $latestData = null;


        if ($latest) {

            $latestData = [
                'id' => $latest->id,

                'name' => $latest->name,

                'email' => $latest->email,

                'subject' => $latest->subject,

                'message' => $latest->message,

                'reply' => $latest->reply,

                'status' => $latest->status,

                'replied_at' => $latest->replied_at
                    ? $latest->replied_at->format(
                        'd M Y, h:i A'
                    )
                    : '',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | ALL UNREAD REPLIES
        |--------------------------------------------------------------------------
        */

        $enquiriesData = $enquiries
            ->map(function ($enquiry) {

                return [
                    'id' => $enquiry->id,

                    'name' => $enquiry->name,

                    'email' => $enquiry->email,

                    'subject' => $enquiry->subject,

                    'message' => $enquiry->message,

                    'reply' => $enquiry->reply,

                    'status' => $enquiry->status,

                    'replied_at' => $enquiry->replied_at
                        ? $enquiry->replied_at->format(
                            'd M Y, h:i A'
                        )
                        : '',
                ];
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | RETURN JSON
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,

            'count' => $count,

            'latest' => $latestData,

            'enquiries' => $enquiriesData,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | USER - MARK REPLY AS READ
    |--------------------------------------------------------------------------
    */

    public function markUserRead($id)
    {
        /*
        |--------------------------------------------------------------------------
        | USER LOGIN CHECK
        |--------------------------------------------------------------------------
        */

        if (!auth()->check()) {

            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | SECURITY
        |--------------------------------------------------------------------------
        |
        | User can ONLY mark his/her own enquiry.
        |
        |--------------------------------------------------------------------------
        */

        $enquiry = Enquiry::where(
            'id',
            $id
        )
        ->where(
            'user_id',
            auth()->id()
        )
        ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | MARK READ
        |--------------------------------------------------------------------------
        */

        $enquiry->update([
            'user_read' => true,
        ]);


        return response()->json([
            'success' => true,

            'message' => 'Reply marked as read.',
        ]);
    }
}