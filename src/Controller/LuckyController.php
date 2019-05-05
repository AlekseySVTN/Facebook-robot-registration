<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Driver\Mysqli\MysqliConnection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Driver\Connection;


class LuckyController extends Controller
{
    private static $api_key = "fa223358aaa875680b1374864c1f3386";
    /**
     * @Route("/getTz")
     * @return JsonResponse
     * @throws \Exception
     */
    public function getTz(){
        $api_key = self::$api_key;
        $method_name = "getNum.php";
        $service="3223";
        $url = "https://onlinesim.ru/api/".$method_name."?lang=ru&country=380&apikey=".$api_key."&service=".$service;
        //echo $url;

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $url);
        $json_from_online_sim = $res->getBody();
        $json_from_online_sim = json_decode($json_from_online_sim, true);

        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        $response->setData($json_from_online_sim);

        return $response;
    }

    /**
     * @Route("/getstate")
     */
    public function getState(){
        $tzid =  9524814;
        $api_key = self::$api_key;
        $client = new \GuzzleHttp\Client();
        $get_state_url = "https://onlinesim.ru/api/getState.php?apikey=".$api_key."&tzid=".$tzid;
        $get_state_res = $client->request('GET', $get_state_url);
        $json_get_state = $get_state_res->getBody();
        $json_get_state = json_decode($json_get_state, true);

        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        $response->setData($json_get_state);

        return $response;

    }

    /**
    * @Route("/test")
     */
    public function test(Connection $connection)
    {
// this looks exactly the same

        $api_key = "fa223358aaa875680b1374864c1f3386";
        $method_name = "getNum.php";
        $service="VKcom";
        $url = "https://onlinesim.ru/api/".$method_name."?lang=ru&country=86&apikey=".$api_key."&service=".$service;
        //echo $url;

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $url);
        $json_from_online_sim = $res->getBody();
        $json_from_online_sim = json_decode($json_from_online_sim, true);
        //var_dump($json_from_online_sim);

        //$users = $connection->fetchAll('SELECT * FROM Persons');
        //var_dump($users);
        if($json_from_online_sim && isset($json_from_online_sim["tzid"]) && $json_from_online_sim["tzid"]){
            $tzid = $json_from_online_sim["tzid"];
            echo "Номер tzid ".$tzid;
             $get_state_url = "https://onlinesim.ru/api/getState.php?apikey=".$api_key."&tzid=".$tzid;
             $get_state_res = $client->request('GET', $get_state_url);
            $json_get_state = $get_state_res->getBody();
            $json_get_state = json_decode($json_get_state, true);
            var_dump($json_get_state);

        }else{
            echo "error";
        }


        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        $response->setData($json_from_online_sim);


        return new Response('Hello, world');
    }
}