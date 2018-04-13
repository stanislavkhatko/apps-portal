<?php

namespace App\Subsyz;

use GuzzleHttp\Client as GuzzleClient;

class Client
{
    protected $client;

    public function __construct()
    {
        $this->client = new GuzzleClient(['base_uri' => env('PAYMENT_GATEWAY')]);
    }

    public function validateSubscription($id, $remoteId)
    {

        $response = $this->client->get('api/subscription/validate', [
            'query' => [
                'api_token' => env('PAYMENT_GATEWAY_TOKEN'),
                'id' => $id,
                'remote_id' => $remoteId,
            ]
        ]);

        return json_decode($response->getBody());
    }

    public function validatePin($msisdn, $pin)
    {

        $response = $this->client->get('api/subscription/validate/pin', [
            'query' => [
                'api_token' => env('PAYMENT_GATEWAY_TOKEN'),
                'msisdn' => $msisdn,
                'pin' => $pin,
            ]
        ]);

        return json_decode($response->getBody());
    }
    
    public function validateMsisdn($msisdn)
    {
        $response = $this->client->get('api/subscription/validate/msisdn', [
            'query' => [
                'api_token' => env('PAYMENT_GATEWAY_TOKEN'),
                'msisdn' => $msisdn,
            ]
        ]);

        return json_decode($response->getBody());
    }

    
    public function subscribe($data)
    {
        $response = $this->client->get('api/subscribe', [
            'query' => array_merge(['api_token' => env('PAYMENT_GATEWAY_TOKEN')], $data),
        ]);

        return json_decode($response->getBody());
    }
    public function unsubscribe($id)
    {
        $response = $this->client->get('api/unsubscribe', [
            'query' => ['api_token' => env('PAYMENT_GATEWAY_TOKEN'), 'subscription_id' => $id,],
        ]);
        if ((string) $response->getBody() == '' || $response->getStatusCode() != 200) {
            $response = new \stdClass();
            $response->success = false;
            return $response;
        }
        
        return json_decode($response->getBody());
    }
}
