<?php

namespace tests;
require_once "../../settings.php";

use classes\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_login()
    {
        $res = (new User())->login([
            "email" => "user@test.com",
            "pass" => 123
        ]);

        $this->assertTrue(is_array($res) || is_bool($res));
    }

    public function test_confirm()
{
    $res = (new User())->confirm( "df0a65347b0034698cb7bd1fcd6e41ce");

    $this->assertTrue(is_array($res) || is_null($res));
}

    public function test_isAuth()
    {
        $res = (new User())->isAuth( "50c1a1bead967424918ece43ac14be0a");

        $this->assertTrue(is_array($res) || is_bool($res));
    }
}
