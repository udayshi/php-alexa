<?php
require('./vendor/autoload.php');
$obj=new \USAlexa\Alexa();
#Define function to handle request
function launchIntentHandlerPhp(\USAlexa\Alexa $obj){
    $obj->response->setResponse('Hello From PHP USAlexa.');
}

#Register intent and run
$obj->registerIntentHandler('LaunchRequest','launchIntentHandlerPhp')
    ->run();

?>