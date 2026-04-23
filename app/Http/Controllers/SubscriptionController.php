<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;

class SubscriptionController extends Controller
{
    public function show()
    {
        return view('subscription.show');
    }

    public function checkout(Request $request)
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        $session = $stripe->checkout->sessions->create([
            'mode' => 'subscription',
            'customer_email' => auth()->user()->email,
            'line_items' => [[
                'price' => config('services.stripe.price_id'),
                'quantity' => 1,
            ]],
            'success_url' => route('subscription.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('subscription.show'),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $stripe = new StripeClient(config('services.stripe.secret'));
        $session = $stripe->checkout->sessions->retrieve($request->session_id);

        if ($session->payment_status === 'paid') {
            auth()->user()->update(['is_subscribed' => true]);
        }

        return view('subscription.success', ['paid' => $session->payment_status === 'paid']);
    }
}
