var connected_flag=0
var mqtt;
var reconnectTimeout = 2000;
var host="201.21.138.99";
var port=1886;
var labelsChart = [];
var datasetsChart = [];

function onConnectionLost(){
    console.log("connection lost");
    document.getElementById("status").innerHTML = "Conexão Perdida";
    document.getElementById("messages").className = "btn btn-warning";
    document.getElementById("messages").innerHTML ="Conexão Perdida";
    connected_flag=0;
}

function onFailure(message) {
    console.log("Failed");
    document.getElementById("messages").className = "btn btn-danger";
    document.getElementById("messages").innerHTML = "Não conectado";
    setTimeout(MQTTconnect, reconnectTimeout);

}


function onMessageArrived(r_message){
   var out_msg =r_message.destinationName+" : "+ r_message.payloadString;
    // console.log(out_msg);
    // console.log("Message received ", r_message.payloadString);
    document.getElementById("messages").className = "btn btn-success";
    document.getElementById("messages").innerHTML = 'Dados carregados';
    // var div = document.createElement('div');
    // div.appendChild(document.createTextNode(out_msg));
    // document.getElementById("item-received").appendChild(div);
    labelsChart.push(r_message.destinationName);
    datasetsChart.push(r_message.payloadString);
}

function onConnected(recon,url){
    console.log(" in onConnected " +reconn);
    document.getElementById("messages").className = "btn btn-success";
    document.getElementById("messages").innerHTML = "Conectado";
}

function onConnect(){
    document.getElementById("messages").className = "btn btn-success";
    document.getElementById("messages").innerHTML = "Conectado";
    connected_flag=1
    document.getElementById("status").innerHTML = "Connected";
    sub_topics();
}

function MQTTconnect(){
    document.getElementById("messages").className = "btn btn-primary";
    document.getElementById("messages").innerHTML ="conectando <input type='text' class='loader'>";
    var p = port;
    if (p!=""){
        port=parseInt(p);
    }
    console.log("connecting to "+ host +" "+ port);
    mqtt = new Paho.MQTT.Client(host,port,"clientWeb"+Math.floor((Math.random() * 100000) + 1));
    var options = {
        timeout: 3,
        onSuccess: onConnect,
        onFailure: onFailure,
    };

    mqtt.onConnectionLost = onConnectionLost;
    mqtt.onMessageArrived = onMessageArrived;
    mqtt.onConnected = onConnected;
    mqtt.connect(options);

    return false;
}

function sub_topics(){
    document.getElementById("messages").innerHTML ="conectado carregando dados <input type='text' class='loader'>";
    if (connected_flag==0){
        var out_msg="<b>Conexão perdida</b>"
        console.log(out_msg);
        document.getElementById("messages").innerHTML = out_msg;
        return false;
    }
    var stopic= '#';
    console.log("Subscribing to topic = "+stopic);
    mqtt.subscribe(stopic);
   

    return false;
}
// function send_message(){
//     document.getElementById("messages").innerHTML ="";
//     if (connected_flag==0){
//         var out_msg="<b>Not Connected so can't send</b>"
//         console.log(out_msg);
//         document.getElementById("messages").innerHTML = out_msg;
//         return false;
//     }
//     var msg = document.forms["smessage"]["message"].value;
//     console.log(msg);

//     var topic = document.forms["smessage"]["Ptopic"].value;
//     var message = new Paho.MQTT.Message(msg);
//     if (topic=="")
//         message.destinationName = "test-topic";
//     else
//         message.destinationName = topic;
//     mqtt.send(message);
//     return false;
// }
