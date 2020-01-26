<?php

namespace App\Http\Controllers;

use Salman\Mqtt\MqttClass\Mqtt;

class MqttController extends Controller
{
    public function SendMsgViaMqtt($topic, $message)
    {
        $mqtt = new Mqtt();
        $client_id = 1;
        $output = $mqtt->ConnectAndPublish($topic, $message, $client_id);

        if ($output === true)
        {
            return "published";
        }
        
        return "Failed";
    }

    public function SubscribetoTopic($topic)
    {
        $mqtt = new Mqtt();
        $client_id = 1;
        $mqtt->ConnectAndSubscribe($topic, function($topic, $msg){
            echo "Msg Received: \n";
            echo "Topic: {$topic}\n\n";
            echo "\t$msg\n\n";
        }, $client_id);


    }
}
