<?php

namespace App;
use DB;

class SMSFleetops
{
    private static $key = "hawpdd9xh3zkpCof3grFhafKr";
    private static $sender_id = "FLEETOPS";
    public function __construct(){}

    public static function send($to,$msg)
    {
        $sql = "select REF_SMB from tbl494";
        $result = DB::select(DB::raw($sql));
        $REF_SMB = $result[0]->REF_SMB;
        $REF_SMB --;
        if($REF_SMB > 0){
            $sql = "update tbl494 set REF_SMB = $REF_SMB";
            DB::update(DB::raw($sql));
        }else{
            //echo "SMS balance finished";
            return;
        }
        $msg=urlencode($msg);
        $key =  self::$key;
        $sender_id =  self::$sender_id;
        $url = "https://apps.mnotify.net/smsapi?key=$key&to=$to&sender_id=$sender_id&msg=$msg";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $sms_response = curl_exec($ch);
        /*echo $sms_response;
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            echo $error_msg;
        }*/
        curl_close($ch);
    }
}