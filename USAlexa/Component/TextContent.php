<?php
namespace USAlexa\Component;
/**
 * Class TextContent
 * (c) Uday Shiwakoti <shiuday@gmail.com>
 * @package USAlexa\Component
 * @date 29th July 2019
 */
class TextContent{
    private $data=[];
    private $token=NULL;


    /**
     * @param $text
     * @param string $type
     * @param string $section
     * @return $this
     */
    function setText($text,$type='PlainText',$section='primaryText'){

        if(!isset($this->data[$section][$section]))
            $this->data[$section]=[];

        $this->data[$section]['type']=$type;
        $this->data[$section]['text']=$text;

        return $this;
    }

    public function setToken($token){
        $this->token=$token;
    }
    public function getToken(){
        return $this->token;
    }

    function setPrimaryRichText($text=null){
        return $this->setText($text,'RichText','primaryText');

    }
    function setPrimaryPlainText($text){
        return $this->setText($text,'PlainText','primaryText');
    }

    function setSecondaryRichText($text=null){
        return $this->setText($text,'RichText','secondaryText');
    }
    function setSecondaryPlainText($text){
        return $this->setText($text,'PlainText','secondaryText');
    }

    function setTertiaryRichText($text=null){
        return  $this->setText($text,'RichText','tertiaryText');
    }
    function setTertiaryPlainText($text){
        return $this->setText($text,'PlainText','tertiaryText');
    }

    function reset(){
        $this->data=[];
        return $this;
    }


    function get(){
        return $this->data;

    }



}