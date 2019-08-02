<?php
namespace USAlexa;
use USAlexa\Component\Image;
use USAlexa\Component\TextContent;

/**
 * Class Alexa
 * This call is the bootstrap for this module.
 *
 *
 * (c) Uday Shiwakoti <shiuday@gmail.com>
 * @package USAlexa
 * @date 29th July 2019
 */
class Alexa{
        public $request,$response,$template;
        static $intents=[];
    /**
     * Alexa constructor.
     */
        function __construct($app_id=NULL)
        {
            $this->request=new Request();
            $this->response=new Response();
            $this->template=new Template();
            if($app_id){
                //getIdApplication
                if(!$this->request->isValidAppID($app_id)){
                    die('Invalid '.$app_id);
                }
            }

        }

    /**
     *
     * @param null $src
     * @param null $title
     * @return Image
     */
        function getImageObject($src=NULL,$title=NULL):Image{
            return new Image($src,$title);
        }

    /**
     * Returns textContent Object
     *
     * @return TextContent
     */

        function getTextObject():TextContent{
            return new TextContent();
        }

    /**
     * Returns json
     *
     * @return json
     */
       private function getResponse(){


            $response=$this->response->get();
            if(Template::$init){

                $response['response']['directives']=[$this->template->get()];
            }

            return $response;


        }



        function registerIntentHandler($intent,$method=NULL){
            self::$intents[$intent]=['intent'=>$intent,'type'=>'function','method'=>$method];
            return $this;
        }


        function registerIntentHandlerObject($intent,$object=NULL,$method='run'){
            self::$intents[$intent]=['intent'=>$intent,'type'=>'class','object'=>$object,'method'=>$method];
            return $this;
        }

       function run(){
            $intent=$this->request->getIntent();

            if(isset(self::$intents[$intent])) {
                $intent_info = self::$intents[$intent];

                if ($intent_info['type'] == 'function') {
                    $intent_info['method']($this);
                } else if ($intent_info['type'] == 'class') {
                    $obj=$intent_info['object'];
                    $method=$intent_info['method'];
                    $obj->$method();

                }
            }else{
                $msg='I am having trouble to process '.$intent.' intent. We will fix the problem ASAP.';
                $quit_intent=['AMAZON.CancelIntent','AMAZON.StopIntent'];
                if(in_array($intent,$quit_intent)){
                    $msg='Thank you for using our skill. ';
                }
                $this->response->setResponse($msg);
            }
           header('Content-Type: application/json');


           $res=json_encode($this->getResponse());
           file_put_contents('log.json');
           echo $res;

        }



}