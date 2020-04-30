<?php


namespace tests;
require "../../settings.php";
use classes\getters\FeedGet;
use PHPUnit\Framework\TestCase;


class FeedGetTest extends TestCase
{
    public function test_m1()
    {
        $res = (new FeedGet())->get([
            "m"             => 1,
            "public_key"    => "bd2beea0f3ec419d301b7dc689c3ab612b3cdf8fa8b7057f82a1d76612224cfb",
            "private_key"   => "4f33006390ef1695fbaf867c2186cde973298f309b1380c33062ca52bf343b27",
            "id"            => 5
        ]);

        $this->assertTrue(is_array($res));
    }
    public function test_m2()
    {
        $res = (new FeedGet())->get([
            "m"             => 2,
            "public_key"    => "bd2beea0f3ec419d301b7dc689c3ab612b3cdf8fa8b7057f82a1d76612224cfb",
//            "private_key"   => "4f33006390ef1695fbaf867c2186cde973298f309b1380c33062ca52bf343b27",
            "limit"         => 2,
            "page"          => 1,
//            "search"        => "away"
        ]);

        $this->assertTrue(is_array($res) || is_bool($res));
    }
}
