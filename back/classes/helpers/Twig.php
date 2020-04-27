<?php
namespace classes\helpers;

use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Filter;
use Twig_Function;
use Twig_Loader_Filesystem;

class Twig{
    /**
     * Провести шаблон через twig, и затем отобразить его
     * @param $view - название шаблона: bla/bla/bla (без разширения twig)
     * @param array $params - массив с данными для передачи в шаблон
     * @param bool|false $cache - кешировать или нет (по умолчанию - нет)
     * @param bool $return
     * @return string - возвращать или печатать на экран? (по умалчанию печать)
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public static function render($view, $params = [], $cache = false, $return = false){

        global $globals;

        $settings   = ['debug' => true];
        if($cache or TWIG_CACHE){ $settings["cache"] = CACHE_DIR; }

        $loader     = new Twig_Loader_Filesystem(VIEWS_DIR);
        $twig       = new Twig_Environment($loader, $settings);
        $twig->addExtension(new Twig_Extension_Debug()); //обязательно, чтобы могла работать функция dump(var) - debugger для twig

        if($globals){ $twig->addGlobal('globals', $globals); }

        //расширим фильтры
        $filter = new Twig_Filter('urldecode', 'urldecode');
        $twig->addFilter($filter);

        //+ функции
        $function = new Twig_Function('preg_replace', function($pattern, $replacement, $string) {
            return preg_replace($pattern, $replacement, $string);
        });
        $twig->addFunction($function);

        $view       = str_replace('/', DS, $view);
        $res        = $twig->render($view.'.twig',  $params);

        if($return){ return $res; }else{ echo $res; }
    }
}

