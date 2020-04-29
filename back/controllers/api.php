<?php

if($_REQUEST["method_name"] == "confirm_email" && $_REQUEST["token"])
{
    $O = new \classes\User();

    try{
        $res = $O->confirm($_REQUEST["token"]);
        if($res){
            setcookie("token", $res["token"], strtotime("+2 month"), "/");
            setcookie("need_verified", 1, strtotime("-2 month"), "/");
            header("Location: /");
        }
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }

    exit;
}

if($_REQUEST["method_name"] == "login")
{
    $O = new \classes\User();

    try{
        $res = $O->login($_REQUEST);
        if($res){
            setcookie("token", $res["token"], strtotime("+2 month"), "/");
            setcookie("need_verified", 1, strtotime("-2 month"), "/");
            header("Location: /");
        }
        else
        {
            setcookie("need_verified", "Необходимо подтвердить email", strtotime("+2 month"), "/");
            header("Location: /");
        }
    }
    catch (Exception $e)
    {
        if($e->getCode() == 3)
        {
            setcookie("need_verified", $e->getMessage(), strtotime("+2 month"), "/");
            header("Location: /");
        }
        else
        {
            echo $e->getMessage();
        }
    }

    exit;
}

if($_REQUEST["method_name"] == "logout")
{
    setcookie("token", 1, strtotime("-2 month"), "/");
    header("Location: /");

    exit;
}

if($_REQUEST["method_name"] == "client_create")
{
    $O = new \classes\Client();
    $_REQUEST["token"] = $_COOKIE["token"];

    try{
       $O->create($_REQUEST);
       header("Location: /");
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }

    exit;
}

if($_REQUEST["method_name"] == "client_delete")
{
    $O = new \classes\Client();
    $_REQUEST["token"] = $_COOKIE["token"];

    try{
        $O->delete($_REQUEST);
        header("Location: /");
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }

    exit;
}