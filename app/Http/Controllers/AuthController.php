<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Show login form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('authenticate');
    }

    /**
     * Authenticate based on the Payment API SDK.
     */
    public function login(Request $request)
    {
        $client = new \App\Subsyz\Client();
        $result = $client->validateMsisdn($request->input('msisdn'));

        if ($request->input('msisdn') == env('TEST_NUMBER')) {
            session([
                'subscription' => [
                    'msisdn' => env('TEST_NUMBER'),
                    'subscription_id' => 100,
                ]
            ]);
        } else if($result && $result->success == 'true') {
            session([
                'subscription' => [
                    'msisdn' => $request->input('msisdn'),
                    'subscription_id' => $result->subscription,
                ]
            ]);
        } else {
            return redirect('/authenticate')
                ->with('loginError', 'Invalid msisdn.')
                ->withInput();
        }

        return redirect()->route('view.portal');
    }


    public function challenge($token)
    {
        [$id, $remoteId] = explode('-', $token, 2);
        $client = new \App\Subsyz\Client();
        $result = $client->validateSubscription($id, $remoteId);

        if ($result->success == 'true') {
            \Cookie::queue(cookie('subscription', [
                'subscription' => [
                    'msisdn' => $result->msisdn,
                    'status' => $result->status,
                    'remote_tracking_id' => $result->remote_tracking_id,
                    'subscription_id' => $result->subscription,
                    'offer_id' => $result->offer_id,
                    'operator' => $result->operator,
                    'confirmed_at' => $result->confirmed_at->date ?? Carbon::now(),
                    'closed_at' => $result->closed_at,
                ]
            ]));

            session([
                'subscription' => [
                    'msisdn' => $result->msisdn ?? '',
                    'subscription_id' => $result->subscription,
                ]
            ]);

//            $seconds = Carbon::now()->diffInSeconds(Carbon::parse($result->confirmed_at->date));
//            if ($seconds > 30) {
//                return redirect()->route('view.portal');
//            }

            return redirect()->route('view.portal');
        } else {
            return response('No valid subscription', 422);
        }
    }

    public function cancelSubscription()
    {
        return view('frontend.subscription.cancel');
    }

    public function validateMsisdn($msisdn)
    {
        $client = new \App\Subsyz\Client();
        $result = $client->validateMsisdn($msisdn);

        if ($result->success == 'true') {
            \Cookie::queue(cookie('subscription', [
                'subscription' => [
                    'msisdn' => $result->msisdn,
                    'status' => $result->status,
                    'remote_tracking_id' => $result->remote_tracking_id,
                    'subscription_id' => $result->subscription,
                    'operator' => $result->operator ?? '',
                    'confirmed_at' => $result->confirmed_at->date ?? '',
                    'closed_at' => $result->closed_at ?? '',
                ]
            ]));

            session([
                'subscription' => [
                    'msisdn' => $msisdn,
                    'subscription_id' => $result->subscription,
                ]
            ]);

            return redirect()->route('view.portal');
        } else {
            return response('No valid subscription', 422);
        }
    }

    public function unsubscribe(Request $request)
    {
        $subscription = Cookie::get('subscription')['subscription'];
        $client = new \App\Subsyz\Client();
        $result = $client->unsubscribe(subscription('subscription_id'));
        $subscription['status'] = 'stopped';
        Cookie::queue(cookie('subscription', ['subscription' => $subscription]));

        if ($result->success == "true") {
            //return "uitgeschreven";
            return view('frontend.subscription.unsubscribe');
        } else {
            return redirect()->route('view.portal');
        }

    }
}
