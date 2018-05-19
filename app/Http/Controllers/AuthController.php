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
        return $this->validateMsisdn($request->input('msisdn'));
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
        if ($msisdn == env('TEST_NUMBER')) {
            session([
                'subscription' => [
                    'msisdn' => env('TEST_NUMBER'),
                    'subscription' => 1,
                ]
            ]);

            return redirect()->route('view.portal');
        }

        $client = new \App\Subsyz\Client();
        $result = $client->validateMsisdn($msisdn);

        if ($result && $result->subscription) {
            session([
                'subscription' => [
                    'msisdn' => $result->subscription->msisdn,
                    'subscription' => $result->subscription->subscription_id,
                ]
            ]);

            return redirect()->route('view.portal');
        }

        if ($result && $result->subscribe) {

            $shortcode = $result->subscribe->shortcode;
            $keyword = $result->subscribe->keyword;
            $sms = 'sms:' . $shortcode . ';?&body=' . $keyword;

            $agent = new \Jenssegers\Agent\Agent();
            if ($agent->isDesktop()) {
                $sms = '';
            }

            $subscribe = [
                'shortcode' => $shortcode,
                'keyword' => $keyword,
                'sms' => $sms,
                'price' => $result->subscribe->price,
                'currency' => $result->subscribe->currency
            ];

            return redirect('/authenticate')->with([
                'subscribe' => $subscribe
            ])->withInput();

        } else if ($result && $result->error) {
            return redirect('/authenticate')->with(['error' => trans('portal.' . $result->error),])->withInput();
        }

        return redirect('/authenticate')->with(['error' => 'Something wrong with server',])->withInput();
    }

    public function unsubscribe(Request $request)
    {
        $client = new \App\Subsyz\Client();
        $result = $client->unsubscribe(session('subscription')['subscription']);

        if ($result->success) {
            return view('frontend.subscription.unsubscribe');
        } else {
            return redirect()->route('view.portal');
        }

    }
}
