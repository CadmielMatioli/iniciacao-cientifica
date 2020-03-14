<?php

namespace App\Http\Controllers;

use Salman\Mqtt\MqttClass\Mqtt;
use App\Http\Requests\MqttSubscribeRequest;

class MqttController extends Controller
{
    public function SendMsgViaMqtt(MqttSubscribeRequest $request)
    {
        $topic =  $request->topic; 
        $message =  $request->message;
        $mqtt = new Mqtt();
        $client_id = auth()->user()->id;
        $output = $mqtt->ConnectAndPublish($topic, $message, $client_id);

        if ($output === true)
        {
            $request->session()->flash('alert-success', 'Mensagem enviada com sucesso.');
            return redirect()->route('subscribe.view');
        }else{
            $request->session()->flash('alert-danger', 'A mensagem não pode ser enviada.');
            return redirect()->route('subscribe.view');
        }
        
    }

    public function SubscribetoTopic($topic)
    {
        $mqtt = new Mqtt();
        $client_id = auth()->user()->id;
        $mqtt->ConnectAndSubscribe($topic, function($topic, $msg){
            echo "Msg Received: \n";
            echo "Topic: {$topic}\n\n";
            echo "\t$msg\n\n";
        }, $client_id);

        return response()->json($mqtt);
    }
}
