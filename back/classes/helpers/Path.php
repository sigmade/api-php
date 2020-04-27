<?php
namespace classes\helpers;


class Path{

    /**
     * Вывод чистого uri пути
     * @return string
     */
    public function clear_path(){
        return stristr(__DIR__, 'back', true);

        /*
        $DS         = DIRECTORY_SEPARATOR;
        $nameSpace  = (__NAMESPACE__)? str_replace("\\",$DS,__NAMESPACE__) : null;
        $path       = strstr(__DIR__, $DS.$nameSpace, true);
        $res        = ($path)? $path : __DIR__;
        return $res;*/
    }

    /**
     * Вывод читого URL
     * @return string
     */
    public function clear_url($dir = null){

        $isHttps  = !empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS']);
        $protocol = ($isHttps)? "https" : "http";

        return $protocol."://". $_SERVER["HTTP_HOST"].$dir;
    }

    /**
     * Вывод адреса страницы без GET
     * @return string
     */
    public function withoutGet(){

        if($res = strstr($this->clear_url().$_SERVER["REQUEST_URI"], "?", true))
        {
            return $res;
        }
        else
        {
            return  $this->clear_url().$_SERVER["REQUEST_URI"];
        }

//        return  strstr($this->path_clear_url().$_SERVER["REQUEST_URI"], "?", true);
    }

    public function fullUrl()
    {
        return  $this->clear_url().$_SERVER["REQUEST_URI"];
    }


    public function parse()
    {
        $url_path  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri_parts = explode('/', trim($url_path, ' /'));
        $uri_parts = array_filter($uri_parts);

        if(count($uri_parts)){
            foreach ($uri_parts as $key => $uri_part) {
                $_GET['url_part_'.++$key] = $uri_part;
            }
        }

    }

}