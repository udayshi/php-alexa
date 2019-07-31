<?php
namespace USAlexa;
/**
 * Class:Request
 * This class provides methods used to interact with alexa request.
 *
 *
 * (c) Uday Shiwakoti <shiuday@gmail.com>
 * @package USAlexa
 * @date 29th July 2019
 */

class Request{
    private static $data=[];
    private static $request,$intent,$slots=[],$session=[],$system;


    function __construct()
    {
        $this->setData();
    }

    /**
     * This method initialize the request data if its not set.
     */
    private  function setData(){

        if(!self::$data){
            //file_get_contents("php://input");
            #self::$data=json_decode(file_get_contents("./data/response.json"));

            self::$data=json_decode(file_get_contents("php://input"));
            if(!is_object(self::$data))
                die("It's not valid alexa request");

            self::$request=self::$data->request;
            self::$intent=self::$request->intent;
            self::$slots=self::$intent->slots;

            self::$session=self::$data->session;
            self::$system=self::$data->context->System;

        }

    }

    /**
     * returns session id
     * @return string
     */
    function getIdSession(){
        return self::$session->sessionId;
    }

    /**
     * returns application id
     * @return string
     *
     */
    function getIdApplication(){
        return self::$system->application->applicationId;
    }

    /**
     * returns user id
     * @return string
     */
    function getIdUser(){
        return self::$system->user->userId;
    }
    /**
     * returns device id
     * @return string
     */
    function getIdDevice(){

        return self::$system->device->deviceId;
    }

    /**
     * returns api access token
     * @return string
     */
    function getAPIAccessToken(){
        return self::$system->apiAccessToken;
    }


    /**
     * returns api end point
     * @return string
     */
    function getAPIEndpoint(){
        return self::$system->apiEndpoint;
    }

    /**
     * returns request id
     * @return string
     */
    function getIdRequest(){
        return self::$request->requestId;
    }

    /**
     * returns intent name
     * @return string
     */
    function getIntent(){

        $intent=self::$request->intent->name;
        if(empty($intent))
            $intent='LaunchRequest';
        return $intent;
    }
    /**
     * returns intent name
     * @return string
     */
    function getToken(){
        return self::$request->token;
    }

    /**
     * returns previous intent name
     * @return string
     */
    function getIntentPrevious(){
        return self::getSessions('prevIntent');
    }

    /**
     * This method returns slots if no key is provided or return specified slot value.
     * If provided key not found it will give the error message.
     *
     * @param null $key
     * @return array|string
     */
    function getSlots($key=NULL){
        if(!isset($key)){
            $output=[];
             foreach(self::$slots as $k=>$v){
                 $output[$k]=$v->value;
            }
             return $output;
        }else if(self::$slots->$key)
            return self::$slots->$key->value;
        else
            return 'Slot '.$key.' not found';
    }

    /**
     * This method returns sessions if no key is provided or return specified session value.
     * If provided key not found it return false.
     *
     * @param null $key
     * @return array|string
     */
    function getSessions($key=NULL){
        if(!isset($key)){
            $output=[];
            if(self::$session->attributes) {
                foreach (self::$session->attributes as $k => $v) {
                    $output[$k] = $v;
                }
            }

            return $output;
        }else if(self::$session->attributes->$key)
            return self::$session->attributes->$key;
        else
            return false;

    }

    function isValidAppID($app_id=NULL){
        return $this->getIdApplication()==$app_id;
    }

}