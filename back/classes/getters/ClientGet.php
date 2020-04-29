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

    private function m_2($array)
    {
        if(!$u = (new User())->check_email_and_pass($array)){ return false; }

        $this->DB->where("user_id", $u['id']);
        if($key = TextSecurity::shield_hard($array['public_key'])){
            $this->DB->where("public_key", $key);
        }
        return $this->DB->get("clients");
    }



}