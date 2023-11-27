<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\SendContactRequest;
use App\Mail\ContactFormEmail;
use Illuminate\Support\Facades\Mail;


class ContactPublicController extends Controller
{

    public function send(SendContactRequest $request)
    {
        $input = $request->all();
        $to = env('CONTACT_FORM_EMAIL');

        mail::to($to)
            ->send(new ContactFormEmail($input));

        return response()->json([
            'success' => true,
            'message' => 'Mesajul a fost trimis cu succes'
        ]);
    }

}
