<?php


namespace classes\getters;
use classes\helpers\TextSecurity;
use classes\helpers\DB;
use classes\User;

class ClientGet
{
    use MainGet;

    public function __construct()
    {
        $this->DB = DB::init();
    }

    // Вывод, всех внутренних api

    private function m_1($array)
    {
        if(!$u = (new User())->isAuth($array['token'])){
            return false;}

        $this->DB->where("user_id", $u["id"]);
        return $this->DB->get("clients");
    }



}