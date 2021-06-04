<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsletterRequest;
use App\Mail\InviteSubscriberToBlogMail;
use Illuminate\Support\Facades\Mail;
use Newsletter as SpatieNewsletterFacade;

class NewsletterController extends Controller
{
        public function store(NewsletterRequest $request): \Illuminate\Http\JsonResponse
        {
        SpatieNewsletterFacade::subscribe($request->get('email'));
        Mail::to($request->get('email'))->send(new InviteSubscriberToBlogMail());
        return response()->json([
            'success' => 'Email agregado!'
        ]);
    }
}
