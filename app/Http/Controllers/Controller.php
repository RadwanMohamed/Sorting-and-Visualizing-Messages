<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    const MESSAGES_API = 'https://spreadsheets.google.com/feeds/list/0Ai2EnLApq68edEVRNU0xdW9QX1BqQXhHRl9sWDNfQXc/od6/public/basic?alt=json';
    const  GOOGLE_API  = "https://maps.googleapis.com/maps/api/geocode/json?address=%s&key=%s";
    public function makeExternalRequest($url)
    {
        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $error_msg = '';
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            return $error_msg;
        }
        curl_close($ch);
        return  json_decode($result,true);
    }
    protected static  function getIcon($sentiment)
    {
        if ($sentiment == 'Positive')
            return url('/img/map_smile.png');
        if ($sentiment == 'Negative')
            return url('/img/map_sad.png');
        return url('/img/map_normal.png');
    }

}
