<?php

namespace tests;

require "../../settings.php";

use PHPUnit\Framework\TestCase;

use classes\getters\ClientGet;

class ClientGetTest extends TestCase
{
    public function test_m_1()
    {
        $arr = [
            "m" => 1,
          "token" => "50c1a1bead967424918ece43ac14be0a"
        ];

        $res = (new ClientGet())->get($arr);
        $this->assertTrue(is_array($res) || is_bool($res));


    }
}
