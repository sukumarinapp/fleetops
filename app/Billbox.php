<?php

namespace App;

class Billbox
{
    private static $appid = "71b911ee-56a6-c2a0-8dba-2fadfa16db80";
    private static $appReference = "test@fleetops.com";
    private static $secret = "Fl3310p5";

    public function __construct(){}

    public static function listPayOptions()
    {
        $appid = self::$appid;
        $post_data =  array();
        $post_data['requestId'] = uniqid();
        $post_data['appReference'] = self::$appReference;
        $post_data['secret'] = self::$secret;
        $post_url = "https://posapi.usebillbox.com/webpos/listPayOptions";
        $curl = curl_init($post_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'content-type: application/json',
                    'appid: '.$appid ));
        $response = curl_exec($curl); 
        /*print_r($response);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            echo $error_msg;
        }
        die;*/
        curl_close($curl);
        $response = json_decode($response);
        return $response->result;
    }

    public static function payNow($requestId,$amount,$provider,$mobile,$cust_name)
    {
        $appid = self::$appid;
        $post_data =  array();
        $post_data['requestId'] = $requestId;
        $post_data['appReference'] = self::$appReference;
        $post_data['secret'] = self::$secret;
        $post_data['serviceCode'] = "246";
        $post_data['currency'] = "GHS";
        $post_data['amount'] = $amount;
        $post_data['customerSegment'] = "";
        $post_data['reference'] = $requestId;
        $post_data['transactionId'] = $requestId;
        $post_data['provider'] = $provider;
        $post_data['customerName'] = $cust_name;
        $post_data['walletRef'] = $mobile;
        $post_data['customerMobile'] = $mobile;
        $post_url = "https://posapi.usebillbox.com/webpos/payNow";
        $curl = curl_init($post_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'content-type: application/json',
                    'appid: '.$appid ));
        $response = curl_exec($curl); 
        /*print_r($response);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            echo $error_msg;
        }
        die;*/
        curl_close($curl);
        $response = json_decode($response);
        return $response;
    }
}