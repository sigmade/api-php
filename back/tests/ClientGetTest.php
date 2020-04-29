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

    public function test_m_2()
    {
        $arr = [
            "m" => 2,
            "email" => "sychyov1991@mail.ru",
            "pass" => 1234,
           "public_key" => "1a1b89f1f16f001e0196af02c66f0194293993802ecd04b2e71a52412dd01adc"
        ];

        $res = (new ClientGet())->get($arr);
        $this->assertTrue(is_array($res) || is_bool($res));


    }
}
