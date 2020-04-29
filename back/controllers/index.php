<?php

// Get всех клиентов
$clients = (new \classes\getters\ClientGet())->get(["m" => 1, "token" => $_COOKIE["token"]]);

\classes\helpers\Twig::render("pages/welcome", [
    "need_verified" => $_COOKIE['need_verified'],
    "clients" => $clients
]);