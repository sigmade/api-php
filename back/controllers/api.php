<?php


if ($_REQUEST['method_name'] == "login") {
    $O = new \classes\User();

    try {
        $res = $O->login($_REQUEST);
        if ($res) {
            setcookie("token", $res['token'], strtotime("+2 month"), "/");
            setcookie("need_verified", 1, strtotime("-2 month"), "/");
            header("Location: /");
        }
        else{
            setcookie("need_verified", "Необходимо подтвердить email", strtotime("+2 month"), "/");
            header("Location: /");
        }
    } catch (Exception $e) {
        if ($e->getCode() == 3) {
            setcookie("need_verified", $e->getMessage(), strtotime("+2 month"), "/");
            header("Location: /");
        }
        else{
            setcookie("error", $e->getMessage(), strtotime("+10 sec"), "/");
            header("Location: /");
        }
    }

    exit;
}
if ($_REQUEST['method_name'] == "logout") {
    setcookie("token", 1, strtotime("-2 month"), "/");
    header("Location: /");

    exit;
}
if ($_REQUEST['method_name'] == "confirm_email" && $_REQUEST['token']) {
    $O = new \classes\User();

    try {
        $res = $O->confirm($_REQUEST['token']);
        if ($res) {
            setcookie("token", $res['token'], strtotime("+2 month"), "/");
            setcookie("need_verified", 1, strtotime("-2 month"), "/");
            header("Location: /");
        }
    } catch (Exception $e) {
        setcookie("error", $e->getMessage(), strtotime("+10 sec"), "/");
        header("Location: /");
    }

    exit;
}
if ($_REQUEST['method_name'] == "client_create") {
    $O = new \classes\Client();
    $_REQUEST['token'] = $_COOKIE['token'];

    try {
        $O->create($_REQUEST);
        header("Location: /");

    } catch (Exception $e) {
        setcookie("error", $e->getMessage(), strtotime("+10 sec"), "/");
        header("Location: /");
    }

    exit;
}
if ($_REQUEST['method_name'] == "client_delete") {
    $O = new \classes\Client();
    $_REQUEST['token'] = $_COOKIE['token'];

    try {
        $O->delete($_REQUEST);
        header("Location: /");

    } catch (Exception $e) {
        setcookie("error", $e->getMessage(), strtotime("+10 sec"), "/");
        header("Location: /");
    }

    exit;
}

/*-----------------------------------
Внешнее api
-----------------------------------*/

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, content-type');
$postData = json_decode(file_get_contents('php://input'), true);
if($postData){$_REQUEST = array_merge($_REQUEST, $postData);}
header('Content-Type: application/json');

if ($_REQUEST['method_name'] == "client_get") {
    $O = new \classes\getters\ClientGet();
    $_REQUEST['token'] = $_COOKIE['token'];

    try {
        $res['response'] = $O->get($_REQUEST);

    } catch (Exception $e) {
        $res['error'] = $e->getMessage();
    }

    exit(json_encode($res));
}

if ($_REQUEST['method_name'] == "feed_add") {
    $O = new \classes\Feed();

    try {
        $res['response'] = $O->add($_REQUEST);

    } catch (Exception $e) {
        $res['error'] = $e->getMessage();
    }

    exit(json_encode($res));
}

if ($_REQUEST['method_name'] == "feed_delete") {
    $O = new \classes\Feed();

    try {
        $res['response'] = $O->delete($_REQUEST);

    } catch (Exception $e) {
        $res['error'] = $e->getMessage();
    }

    exit(json_encode($res));
}

if ($_REQUEST['method_name'] == "feed_edit") {
    $O = new \classes\Feed();

    try {
        $res['response'] = $O->edit($_REQUEST);

    } catch (Exception $e) {
        $res['error'] = $e->getMessage();
    }

    exit(json_encode($res));
}

if ($_REQUEST['method_name'] == "feed_get") {
    $O = new \classes\getters\FeedGet();

    try {
        $res['response'] = $O->get($_REQUEST);

    } catch (Exception $e) {
        $res['error'] = $e->getMessage();
    }

    exit(json_encode($res));
}

