<?php
namespace classes\helpers;


class TextSecurity
{

    public static function is_email($email){
        return filter_var(strtolower($email), FILTER_VALIDATE_EMAIL);
    }

    public static function shield_hard($string){
        $string = htmlspecialchars($string, ENT_QUOTES);
        $string = addslashes($string);
        $string = str_replace(["`"], ["&lsquo;"], $string);
        $string = trim($string);
        return $string;
    }

    /**
     * HTML без JS
     * @param $string
     * @return mixed|string
     */
    public static function shield_medium($string){

        $string = addslashes($string);
        $string = str_replace(["`"], ["&lsquo;"], $string);

        return $string;
    }

    /**
     * Чистый HTML + JS
     * @param $string
     * @return mixed|string
     */
    public static function shield_light($string){
        $string = addslashes($string);
        $string = str_replace(["`"], ["&lsquo;"], $string);
        return $string;
    }

    public static function is_price($price)
    {
        if(!$price){ return null; }
        $price   = str_replace(",", ".", $price);
        $price   = trim($price);

        if(!is_numeric($price)){ return null; }
        return $price;

    }



    //работа со ссылками
    public static function correctLinks($text) {
        return preg_replace_callback('~(http|https|ftp|ftps)://[^\s]+~siu',
            'self::shortLink', $text);
    }

    private static function shortLink($matches) {
        $left = 39; //часть текста слева
        $right = 16; //часть текста справа
        $in = ' ... '; //вставка
        $enc = 'UTF-8';
        $linkText = $matches[0];
        $len = mb_strlen($linkText, $enc);
        /*if ($len > ($left + $right + mb_strlen($in, $enc))) {
            $linkText = mb_substr($linkText, 0, $left, $enc) .
                $in .
                mb_substr($linkText, $len - $right, $right, $enc);
        }*/
        if ($len > ($left + mb_strlen($in, $enc))) {
            $linkText = mb_substr($linkText, 0, $left, $enc).$in;
        }

        return '<a href="' . $matches[0] . '" target="_blank">' . $linkText . '</a>';
    }



}