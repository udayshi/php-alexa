<?php
namespace USAlexa;
/**
 * Class Utils
 * (c) Uday Shiwakoti <shiuday@gmail.com>
 * @package USAlexa
 * @date 29th July 2019
 */
class Utils{

    static function filterUrl($url){
        if(!preg_match("/(^https?)|(^soundbank)/",$url)){
            if(isset($_SERVER['HTTP_HOST'])){
                $url=$_SERVER['HTTP_HOST'].'/'.$url;

                $url='https://'.$url;
            }
        }
        return $url;
    }
}

