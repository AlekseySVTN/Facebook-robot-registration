<?php

namespace App\Utils;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Driver\Mysqli\MysqliConnection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Driver\Connection;

class OnlineSim {

    private static $api_key = "fa223358aaa875680b1374864c1f3386";
    private static $base_url = "https://onlinesim.ru/api/";

    private static $lang     = "ru";
    private static $country  = 7; // украина

    public static $service_array = [
        "VK" => "VKcom",
        "FB" => "3223"
    ];

    /**
     * @param string $service
     * @return int
     */
    public static function getTz($service = ""){

        $tzid = 0;

        $method_name = "getNum.php";

        if(!$service){
            return $tzid;
        }

        $api_key = self::$api_key;

        $url = self::$base_url.$method_name."?lang=".self::$lang."&country=".self::$country."&apikey=".$api_key."&service=".$service;


        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $url);
        $json_from_online_sim = $res->getBody();
        $json_from_online_sim = json_decode($json_from_online_sim, true);



        if(isset($json_from_online_sim["tzid"])){
            $tzid = $json_from_online_sim["tzid"];
        }


        return $tzid;
    }

    /**
     * @param int $tzid
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    public static function getState($tzid = 0){
        if(!$tzid){
            return false;
        }

        $method ="getState.php";
        $client = new \GuzzleHttp\Client();
        $get_state_url = self::$base_url.$method."?apikey=".self::$api_key."&tzid=".$tzid;
        $get_state_res = $client->request('GET', $get_state_url);
        $json_get_state = $get_state_res->getBody();
        $json_get_state = json_decode($json_get_state, true);

        return $json_get_state;

    }

    public static function getPhoneNumber($tzid = 0){

        $phone = "";

        if(!$tzid){
            return $phone;
        }

        $current_state = self::getState($tzid);

        $current_state = reset($current_state);

        if(isset($current_state["number"])){
            $phone = $current_state["number"];
        }

        return $phone;
    }

    public static function getCodeFromSms($tzid){
        if(!$tzid){
            return 0;
        }

        $exit = false;

        $res = [
            "status" => "start",
            "code" => "",
        ];

        do{
            $current_state = self::getState($tzid);
            $current_state = reset($current_state);

            if(!$current_state || !isset($current_state["response"])
                || (isset($current_state["response"]) && $current_state["response"] == "WARNING_NO_NUMS")
                || (isset($current_state["response"]) && $current_state["response"] == "TZ_OVER_EMPTY")
                || (isset($current_state["response"]) && $current_state["response"] == "TZ_OVER_OK")
                || (isset($current_state["response"]) && $current_state["response"] == "ERROR_NO_TZID")
                || (isset($current_state["response"]) && $current_state["response"] == "ERROR_NO_OPERATIONS")
                || (isset($current_state["response"]) && $current_state["response"] == "ACCOUNT_IDENTIFICATION_REQUIRED")
            ){
                $res["status"] = "fail";
                $res["status_code"] = $current_state["response"];
                $exit = true;
            }elseif($current_state["response"] == "TZ_NUM_WAIT"){
                $res["status"] = "continue";
                $res["status_code"] = $current_state["response"];
                $exit = false;
                sleep(10);
            }elseif($current_state["response"] == "TZ_NUM_ANSWER"){
                $res["status"] = "success";
                $res["status_code"] = $current_state["response"];
                $res["sms_code"] = $current_state["msg"];
                $exit = true;
            }else{
                $res["status"] = "fail";
                $res["status_code"] = $current_state["response"];
                $exit = true;
            }

            echo json_encode($res)."\n\n\n";

        } while (!$exit) ;

        return $current_state;
    }

}