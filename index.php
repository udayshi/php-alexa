<?php

require('./vendor/autoload.php');
$app_id=null;
/**
 * If app id is not supplied it will not check.
 */
$obj=new \USAlexa\Alexa($app_id);



function launchIntent(\USAlexa\Alexa $obj){

    $intent=$obj->request->getIntent();
    $obj->response->endSession(false);
    $obj->response->setResponse('Hello running Intent'.$intent.' ?');

    $obj->template->setType('BodyTemplate3');
    $img=$obj->getImageObject('[[IMG_URL]]');
    $obj->template->setBackgroundImage($img);

    $img=$obj->getImageObject('[[IMG_URL]]');
    $obj->template->setImage($img);
}




class TestIntent{
    private $obj;
    function __construct(\USAlexa\Alexa $obj)
    {
        $this->obj=$obj;
    }

    function run(){
        $obj=$this->obj;
        $intent=$obj->request->getIntent();
        $obj->response->endSession(false);
        $obj->response->setResponse('Hello running Class Intent'.$intent.' ?');

        $obj->template->setType('BodyTemplate3');
        $img=$obj->getImageObject('[[IMG_URL]]');
        $obj->template->setBackgroundImage($img);

        $img=$obj->getImageObject('[[IMG_URL]]');
        $obj->template->setImage($img);

        $obj->response->setWhisper('Hello')
                       ->setBreak(2)
                       ->setEmphasisStrong('Strong')
                       ->setEmphasisModerate('Moderate')
                       ->setEmphasisReduced('Reduced')
                       ->setSayAs('TEST');

    }
}

class TestIntent2{
    private $obj;
    function __construct(\USAlexa\Alexa $obj)
    {
        $this->obj=$obj;
    }

    function process(){
        $obj=$this->obj;
        $intent=$obj->request->getIntent();
        $obj->response->endSession(false);
        $obj->response->setResponse('Hello running Class Intent'.$intent.' ?');



        $obj->template->setType('BodyTemplate3');
        $img=$obj->getImageObject('[[IMG_URL]]');
        $obj->template->setBackgroundImage($img);

        $img=$obj->getImageObject('[[IMG_URL]]');
        $obj->template->setImage($img);
    }
}
$helloWorld=new TestIntent($obj);
$helloWorld2=new TestIntent2($obj);

$obj->registerIntentHandler('LaunchRequestx','launchIntent')
    ->registerIntentHandlerObject('LaunchRequestc',$helloWorld)
    ->registerIntentHandlerObject('LaunchRequest',$helloWorld2,'process')
    ->run();






?>
