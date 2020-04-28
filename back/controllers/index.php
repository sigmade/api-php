<?php

\classes\helpers\Twig::render("pages/welcome", [
    "need_verified" => $_COOKIE['need_verified']
]);