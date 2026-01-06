<?php

namespace App\Http\Controllers;

use App\Mail\SendEbook;
use App\Models\Recipient;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stevebauman\Location\Facades\Location;

class RecipientController extends Controller
{
    public function sendEbook(Request $request, string $name, string $email)
    {
        if ($recipient = Recipient::where('email', $email)->first())
        {
            $secondsDifference = Carbon::parse($recipient->reception_date_time)->diffInSeconds(now());
        }

        $publicIp = $request->header('CF-Connecting-IP')
            ?? ($request->header('X-Forwarded-For') ? trim(explode(',', $request->header('X-Forwarded-For'))[0]) : null)
            ?? $request->ip();

        $country = null;

        if ($position = Location::get($publicIp)) {
            $country = $position->countryCode;
        }

        $validated = $request->validate([
            'name' => 'string|required',
            'email' => 'required|email',
        ]);

        if ($recipient && $secondsDifference < 4*3600) {
            $time_to_wait = 4*3600 - $secondsDifference;
            return back()->withErrors([
                'message' => 'Ebook already sent to this email, please wait ' . CarbonInterval::seconds($time_to_wait)->cascade()->forHumans() . ' before receiving it',
            ]);
        }

        try {
            if (!Recipient::where('email', $email)->exists()) {
                Recipient::create([
                    'name'  => $name,
                    'email' => $email,
                    'last_ip' => $publicIp,
                    'reception_date_time' => now(),
                    'country' => $country
                ]);

                Mail::to($email)->send(new SendEbook());

                return back()->with('success', true);
            }
        } catch (\Throwable $th) {
            report($th);

            return back()->withErrors([
                'message' => 'Failed to send Ebook! Please try again.',
            ]);
        }
    }
}
