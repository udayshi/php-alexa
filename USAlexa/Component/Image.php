<?php
namespace USAlexa\Component;
use USAlexa\Utils;

/**
 * Class Image
 *
 * (c) Uday Shiwakoti <shiuday@gmail.com>
 * @package USAlexa\Component
 * @date 29th July 2019
 */
class Image{
    private $data=['contentDescription'=>NULL,'sources'=>[]];
    private $token=null;

    function __construct($src=NULL,$title=NULL)
    {
        if(isset($src))
            $this->set($src,$title);
    }

    public function setToken($token){
        $this->token=$token;
    }
    public function getToken(){
        return $this->token;
    }
    function set($src=null,$title=null,$widthPx=0,$heightPx=0){


        if(isset($title))
            $this->data['contentDescription']=$title;



        $this->data['sources'][]=['url'=>Utils::filterUrl($src),'widthPixels'=>$widthPx,'heightPixels'=>$heightPx];
        return $this;
    }

    function setTitle($title){
        $this->data['contentDescription']=$title;
        return $this;
    }

    function setImage($src,$widthPx=0,$heightPx=0){
        $this->data['sources'][]=['url'=>Utils::filterUrl($src),'widthPixels'=>$widthPx,'heightPixels'=>$heightPx];
        return $this;
    }




    function reset(){
        $this->data=$data=['contentDescription'=>NULL,'sources'=>[]];
        return $this;
    }

    function get(){
        if(empty($this->data['contentDescription']))
            $this->data['contentDescription']="";
        return $this->data;

    }
}