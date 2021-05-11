<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsletterRequest;
use App\Mail\InviteSubscriberToBlogMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Newsletter as SpatieNewsletterFacade;

class NewsletterController extends Controller
{
        public function store(NewsletterRequest $request): \Illuminate\Http\RedirectResponse
    {
        SpatieNewsletterFacade::subscribe($request->get('email'));
        Mail::to($request->get('email'))->send(new InviteSubscriberToBlogMail());
        return redirect()->back()->with(['success' => 'Email agregado!']);
    }
}
