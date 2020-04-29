<?php

namespace tests;
require "../../settings.php";
use classes\Client;
use PHPUnit\Framework\TestCase;
use Faker\Factory;

class ClientTest extends TestCase
{

    public function test_create()
{
    $faker = Factory::create();
    $res = (new Client())->create([
        "token" => "50c1a1bead967424918ece43ac14be0a",
        "title" => $faker->words(3, true),
    ]);

    $this->assertTrue(is_array($res));
}
    public function test_delete()
    {

        $res = (new Client())->delete([
            "token" => "50c1a1bead967424918ece43ac14be0a",
            "id" => 3,
        ]);

        $this->assertTrue($res);
    }
}
