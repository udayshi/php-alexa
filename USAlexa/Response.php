<?php
namespace USAlexa;

/**
 * Class:Response
 * This class provides methods used to interact with alexa response.
 *
 * (c) Uday Shiwakoti <shiuday@gmail.com>
 * @package USAlexa
 * @date 29th July 2019
 */
class Response{

    private $response;
    private $response_data=[];
    private $request;


    function __construct()
    {
        $this->request=new Request();
        $this->init();
    }
    private function init(){
        $response=[];
        $response['version']='1.0';
        $response['userAgent']="Php/Uday Shiwakoti";
        $response['sessionAttributes']=[];
        $response['response']=[];
        #$response['response']['shouldEndSession']=true;
        $response['response']['type']='_DEFAULT_RESPONSE';
        $response['response']['outputSpeech']=['type'=>'PlainText','text'=>null,'ssml'=>null];
        $response['response']['reprompt']=['outputSpeech'=>['type'=>'PlainText','text'=>null,'ssml'=>null]];
        $response['sessionAttributes']=$this->request->getSessions();
        $response['sessionAttributes']['prevIntent']=$this->request->getIntent();

        $this->response=$response;
    }

    public function endSession($val=true){
        $this->response['response']['shouldEndSession']=$val;
        return $this;
    }



    private function setOutputSSML(){
        $this->response['response']['outputSpeech']['type']='SSML';
        $this->response['response']['reprompt']['outputSpeech']['type']='SSML';
        return $this;
    }


    function setSession($k,$v){

        if(!$this->response['response']['shouldEndSession'])
            $this->response['response']['shouldEndSession']=false;

        $this->response['sessionAttributes'][$k]=$v;
        return $this;
    }

    function setResponse($data,$tag=null,$params=[]){
        if(isset($tag))
            $this->setOutputSSML();


        $this->response_data[]=['data'=>$data,'tag'=>$tag,'params'=>$params];
        return $this;
    }
    function setCard($title=NULL,$description=NULL,$src=NULL,$large_image=null){


        $card=['type'=>'Simple','title'=>$title,'content'=>$description];

        if(isset($src)){
            $card['image']=[];
            $card['image']['smallImageUrl']=Utils::filterUrl($src);
            $card['image']['largeImageUrl']=Utils::filterUrl($src);

        }

        if(isset($large_image)){
            $card['image']['largeImageUrl']=Utils::filterUrl($large_image);
        }


        $this->response['response']['card']=$card;

        return $this;
    }

    function setWhisper($data){
        $this->setResponse($data,'amazon:effect',['name'=>'whispered']);
        return $this;
    }
    function setAudio($url){
        $this->setResponse(null,'audio',['src'=>Utils::filterUrl($url)]);
        return $this;
    }
    function setBreak($time/*1000ms | 1s*/){
        $this->setResponse(null,'break',['time'=>$time]);
        return $this;
    }

    function setEmphasisStrong($data){
        $this->setResponse($data,'emphasis',['level'=>'strong']);
        return $this;
    }
    function setEmphasisModerate($data){
        $this->setResponse($data,'emphasis',['level'=>'moderate']);
        return $this;
    }
    function setEmphasisReduced($data){
        $this->setResponse($data,'emphasis',['level'=>'reduced']);
        return $this;
    }
    function setSayAs($data){
        $this->setResponse($data,'say-as',['interpret-as'=>'spell-out']);
        return $this;
    }

    function setReprompt($data){
        $this->response['response']['reprompt']['outputSpeech']['text']=$data;
    }

    private function setOutputSpeech(){
        $speech_type=$this->response['response']['outputSpeech']['type']=='SSML'?'ssml':'text';
        $unset_speech_type=$speech_type=='text'?'ssml':'text';
        unset($this->response['response']['outputSpeech'][$unset_speech_type]);


        $this->response['response']['outputSpeech'][$speech_type]=$this->getOutputSpeech();

        if(empty($this->response['response']['reprompt']['outputSpeech']['text'])) {
            $this->response['response']['reprompt']['outputSpeech'][$speech_type] = $this->getOutputSpeech();
        }else{
            if($speech_type=='ssml'){
                $out=$this->response['response']['reprompt']['outputSpeech']['text'];
                $out='<speak>'.$out.'</speak>';
                $this->response['response']['reprompt']['outputSpeech'][$speech_type]=$out;

            }
        }


        unset($this->response['response']['reprompt']['outputSpeech'][$unset_speech_type]);



    }

    private function getOutputSpeech(){
        $tag=null;
        if($this->response['response']['outputSpeech']['type']=='SSML'){
            $tag="<speak>";
            foreach($this->response_data as $row){
                if(!isset($row['tag'])){
                    $tag.=$row['data'];
                }else {
                    $tag .= "\n\t<" . $row['tag'];


                    foreach ($row['params'] as $k => $v) {
                        $tag .= ' ' . $k . "=\"" . $v . "\" ";
                    }

                    if (empty($row['data']))
                        $tag .= " />";
                    else
                        $tag .= ">" . $row['data'] . "</" . $row['tag'] . ">";
                }

            }
            $tag.="\n</speak>";

        }else{
            foreach($this->response_data as $row){
                $tag.=$row['data']." .... ";
            }
        }
        return $tag;

    }


    function get(){
        $this->setOutputSpeech();
        return $this->response;
    }


}
