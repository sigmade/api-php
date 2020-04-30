<?php

namespace tests;
require "../../settings.php";
use classes\Feed;
use Faker\Factory;
use PHPUnit\Framework\TestCase;


class FeedTest extends TestCase
{
    public function test_add()
    {
        $faker = Factory::create();

        $res = (new Feed())->add([
            "private_key" => "4f33006390ef1695fbaf867c2186cde973298f309b1380c33062ca52bf343b27",
            "title" => $faker->text(60),
            "text" => $faker->realText(),
            "protected" => array_rand([true, false], 1)
        ]);

        $this->assertTrue(is_array($res));
    }

    public function test_delete()
    {
        $faker = Factory::create();

        $res = (new Feed())->delete([
            "private_key" => "f120a99e16f077df3d73e39e78692b5bdb6c42fb4e56f1d65d125ac663747772",
            "id" => 7
        ]);

        $this->assertTrue(is_bool($res));
    }

    public function test_edit()
    {
        $faker = Factory::create();

        $res = (new Feed())->edit([
            "private_key" => "4f33006390ef1695fbaf867c2186cde973298f309b1380c33062ca52bf343b27",
            "title" => $faker->text(60),
            "text" => $faker->realText(),
            "protected" => array_rand([true, false], 1),
            "id" => 5
        ]);

        $this->assertTrue(is_bool($res));
    }


}
