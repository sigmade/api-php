<?php
namespace classes\helpers;

use MysqliDb; //https://packagist.org/packages/joshcam/mysqli-database-class

class DB
{
    public static function init()
    {
        return new MysqliDb (DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

}