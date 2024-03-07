<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Mail;
// use App\Mail\DemoMail;

// class MailController extends Controller
// {
//     public function index(){
        
//         $mailData = [
//             'title'=> 'Mail from Afrin',
//             'body' => 'Hello This is me Afrin Sultana'
//         ];
//         Mail::to('afrinsultana.su@gmail.com')->send(new DemoMail($mailData));
//         dd('Email send Successfully.');
//     }
// }

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\DemoMail;
use App\Models\Test;

class MailController extends Controller
{
    public function index()
    {
        // Fetch all users
        $all_users = Test::all();

        // Loop through each user and send email
        foreach ($all_users as $user) {
            $mailData = [
                'title'=> 'Mail from Afrin',
                'body' => 'Hello, This is me Afrin Sultana'
            ];

            // Send email to each user
            Mail::to($user->email)->send(new DemoMail($mailData));
        }

        return "Emails sent successfully!";
    }
}

