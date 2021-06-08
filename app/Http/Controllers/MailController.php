<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ContactEmail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'yourEmail' => 'required|string|email',
            'content' => 'required',
        ]);
        $user = User::where('type', '1')->first();
        if (!$user)
            return response()->json([
                'message' => 'We can t find a user with that e-mail address.'
            ], 404);

        else
            $user->notify(
                new ContactEmail($request)
            );
        return response()->json([
            'message' => 'We have e-mailed you'
        ]);
    }
}
