<?php
namespace USAlexa;

use USAlexa\Component\Image;
use USAlexa\Component\TextContent;

/**
 * Class:Template
 * This class provides methods used to interact with alexa template.
 * https://developer.amazon.com/docs/custom-skills/display-template-reference.html
 * (c) Uday Shiwakoti <shiuday@gmail.com>
 * @package USAlexa
 * @date 29th July 2019
 */
class Template{

    private $directives=['type'=>'Display.RenderTemplate','template'=>[]];
    private $template=[];
    static $init=false;
    static $tpl=[
        'BodyTemplate1'=>'BodyTemplate1',
        'BodyTemplate2'=>'BodyTemplate2',
        'BodyTemplate3'=>'BodyTemplate3',
        'BodyTemplate6'=>'BodyTemplate6',
        'ListTemplate1'=>'ListTemplate1',
        'ListTemplate2'=>'ListTemplate2'
    ];




    function init($tpl=NULL){
        if(!isset($this->template['type'])) {
            if (isset($tpl) && isset(self::$tpl[$tpl])) {
                $this->setType($tpl);
            } else {
                $this->setType(self::$tpl['BodyTemplate1']);
            }
            self::$init = true;
        }
    }


    function setType($type,$title=NULL,$token=NULL){
            self::$init = true;
            if(isset($this->template['type']))
                $prev_type=$this->template['type'];

            if($prev_type!=$type) {
                $this->template['type'] = $type;
                $this->template['title'] = isset($title) ? $title : $type;
                $this->template['token'] = isset($token) ? $token : $type;
            }

    }

    function setTitle($title){

        $this->init();

        $this->template['title']=$title;
    }

    function setToken($token){
        $this->init();
        $this->template['title']=$token;
    }

    function setBackButton($show=true){
        $this->init();
        $show=$show?'VISIBLE':'HIDDEN';
        $this->template['backButton']=$show;
    }

    function setBackgroundImage(Image $img){
        $this->init();
        $this->template['backgroundImage']=$img->get();
    }
    function setImage(Image $img){
        $this->init();
        if($this->template['type']=='BodyTemplate1')
          $this->setType(self::$tpl['BodyTemplate2']);

        $this->template['image']=$img->get();
    }



    function setText(TextContent $txt){
        $this->init();
        $this->template['textContent']=$txt->get();
    }

    function setListItem($token=NUll,TextContent $txt=null,Image $img=null){
        $this->init();
        if(!isset($this->template['listItems'])) {
            $this->template['listItems'] = [];


            $type=$this->template['type'];
            if(substr($type,0,4)=='Body')
                    $this->setType(self::$tpl['ListTemplate1']);
        }

        $data=['token'=>$token];
        if($img instanceof  Image)
            $data['image']=$img->get();

        if($txt instanceof  TextContent)
            $data['image']=$txt->get();

        $this->template['listItems'][]=$data;

    }

    function setListText($token=NUll,TextContent $txt=null){
        $this->setListItem($token,$txt);

    }


    function setListTexts($objTxts=[]){
        foreach ($objTxts as $k=>$txt){

            $token=$txt->getToken();
            if(!$token)
                $token='text_'.$k;
            $this->setListItem($token,$txt);
        }

    }


    function setListImage($token=NUll,Image $img=null){
        $this->setListItem($token,null,$img);
    }

    function setListImages($objImg=[]){
        foreach ($objImg as $k=>$img){
            $token=$img->getToken();
            if(!$token)
                $token='image_'.$k;
            $this->setListItem($token,null,$img);
        }
    }

    function get(){
        $output=$this->directives;
        $output['template']=$this->template;
        return $output;
    }





}