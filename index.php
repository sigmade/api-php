<?php
require_once("back/vendor/autoload.php");

/*-----------------------------------
Основные настройки
-----------------------------------*/
require_once "settings.php";


/*-----------------------------------
Основные глобальные классы
-----------------------------------*/
$User   = new \classes\User();
$Path   = new \classes\helpers\Path();
//$Auth       = new \classes\Auth();

/*-----------------------------------
Глобальные выборки
-----------------------------------*/
$globals["auth"] =  $User->isAuth($_COOKIE['token']);

$Path->parse();


/*-----------------------------------
Подключаем контроллеры
-----------------------------------*/
if($_GET["url_part_1"] && file_exists(APP_DIR.DS."controllers".DS.$_GET["url_part_1"].".php"))
{
    include(APP_DIR.DS."controllers".DS.$_GET["url_part_1"].".php");
}
else{

    include(APP_DIR.DS."controllers".DS."index.php");


    /*$url_path  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    switch ($url_path):
        case "/": include("App/controllers/main.php"); break;
        case "/sitemap.xml":
            $_GET['m'] = "sitemap";
            include("App/controllers/sitemap.php");
            break;
        case "/sitemap.image.xml":
            $_GET['m'] = "sitemap.image";
            include("App/controllers/sitemap.php");
            break;

        default:
            header("HTTP/1.1 404 Not Found");
            include('404.html');
            exit();
    endswitch;*/

}