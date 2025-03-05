<?php

namespace App\Helper;

class sendNotif
{
    public function sendWA($mobileNumber, $message)
    {

        $url = "https://jogja.wablas.com";
        $token = "zX8x2FOfZW203UptysmQsDccJHyQofZyrN6JWRSZc55qK6uBf6S7ZSdLkMq07YFN.afcch63i";

        $client = new \GuzzleHttp\Client([
            'base_uri' => $url,
        ]);
        $response = $client->post('/api/send-message', [
            'form_params' => [
                'phone' => $mobileNumber,
                'message' => $message
            ],
            'headers' => [
                'Accept'     => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => $token
            ]
        ]);

        $body = json_decode($response->getBody(), true);
        if($body['status'] == true) {
            // return true;
            if($response->getStatusCode() != 200) {
                return false;
            }else{
                return true;
            }
        }
        return false;

    }
}