<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterRequest;
use App\Mail\InviteSubscriberToBlogMail;
use Illuminate\Support\Facades\Mail;
use Spatie\Newsletter\Newsletter;

class NewsletterController extends Controller
{
    public function store(NewsletterRequest $request, Newsletter $newsletter): \Illuminate\Http\RedirectResponse
    {
        $newsletter->subscribe($request->get('email'));
        Mail::to($request->get('email'))->send(new InviteSubscriberToBlogMail());
        return redirect()->back()->with(['success' => 'Email agregado!']);
    }
}
