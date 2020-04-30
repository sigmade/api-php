<?php


namespace classes;


use classes\helpers\DB;
use classes\helpers\TextSecurity;

class Feed
{
    public function __construct()
    {
        $this->DB = DB::init();
    }


    public function add($array)
    {
        $c = (new Client())->check_key($array['private_key']);
        if(!$c){
            throw new \Exception("Access denied");}

        $arr = [
            "title" => TextSecurity::shield_hard($array['title']),
            "text" => TextSecurity::shield_light($array['text']),
            "protected" => ($array['protected'])? 1 : 0,
            "date" => time(),
            "client_id" => $c['id']
        ];

        $resDb = $this->DB->insert("feed", $arr);
        $arr['id'] = $resDb;

        return $arr;
    }

    public function edit($array)
    {
        $c = (new Client())->check_key($array['private_key']);
        if(!$c){
            throw new \Exception("Access denied");}

        if(!is_numeric($array['id'])){
            throw new \Exception("Не корректный параметр id");}


        $arr = [
            "title" => TextSecurity::shield_hard($array['title']),
            "text" => TextSecurity::shield_light($array['text']),
            "protected" => ($array['protected'])? 1 : 0
        ];

        $this->DB->where("client_id", $c['id'])->where("id", $array['id']);
        $resDb = $this->DB->update("feed", $arr);
        if(!$resDb){
            throw new \Exception("Access denied or item not found");}

        return $resDb;
    }

    public function delete($array)
    {
        $c = (new Client())->check_key($array['private_key']);
        if(!$c){
            throw new \Exception("Access denied");}

        if(!is_numeric($array['id'])){
            throw new \Exception("Не корректный параметр id");}

        $this->DB->where("client_id", $c['id'])->where("id", $array['id']);
        $resDb = $this->DB->delete("feed");
        return $resDb;
    }

}