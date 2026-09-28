<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();

        /*
        |--------------------------------------------------------------------------
        | CHECK TODAY'S VISIT
        |--------------------------------------------------------------------------
        |
        | Same IP ने आज आधीच visit केली असेल तर नवीन record create करणार नाही.
        | पण दुसऱ्या दिवशी त्याच IP ने visit केली तर नवीन record तयार होईल.
        |
        */

        $alreadyVisitedToday = Visitor::where('ip_address', $ip)
            ->whereDate('created_at', today())
            ->exists();

        /*
        |--------------------------------------------------------------------------
        | CREATE NEW DAILY VISIT
        |--------------------------------------------------------------------------
        */

        if (!$alreadyVisitedToday) {

            Visitor::create([
                'ip_address' => $ip,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        }

        return $next($request);
    }
}