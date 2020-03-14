<?php

namespace App\Http\Controllers;

use App\Http\Requests\MqttSubscribeRequest;
use Mqtt;

class MqttController extends Controller
{
    public function sendMsgViaMqtt(MqttSubscribeRequest $request)
    {
        $topic =  $request->topic; 
        $message =  $request->message;
        $client_id = 'clientId-Wf64dDH74y';
        $output = Mqtt::ConnectAndPublish($topic, $message, $client_id);

        if ($output === true)
        {
            $request->session()->flash('alert-success', 'Mensagem enviada com sucesso.');
            return redirect()->route('subscribe.view');
        }else{
            $request->session()->flash('alert-danger', 'A mensagem não pode ser enviada.');
            return redirect()->route('subscribe.view');
        }
        
    }

    public function subscribetoTopic()
    {
        $topic = request()->topic;
        $client_id = 'clientId-Wf64dDH74y';
        Mqtt::ConnectAndSubscribe($topic, function($topic, $msg){
            echo "Msg Received: \n";
            echo "Topic: {$topic}\n\n";
            echo "\t$msg\n\n";
        }, $client_id);
    }
}
