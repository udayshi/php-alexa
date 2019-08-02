<?php
require('./vendor/autoload.php');
$obj=new \USAlexa\Alexa();
#Define function to handle request
function launchIntentHandlerPhp(\USAlexa\Alexa $obj){
    $cardImg='https://avatars3.githubusercontent.com/u/1732894';
    $obj->response->setResponse('Hello From PHP USAlexa.')->setCard('Hello','Hello card description');
}

#Register intent and run
$obj->registerIntentHandler('LaunchRequest','launchIntentHandlerPhp')
    ->run();

?>