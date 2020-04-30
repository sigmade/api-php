<?php


namespace classes\getters;


use classes\Client;
use classes\helpers\Counter;
use classes\helpers\DB;
use classes\helpers\TextSecurity;
use classes\User;

class FeedGet
{
    use MainGet;

    public function __construct()
    {
        $this->DB = DB::init();
    }

    /**
     * Вывод by id
     */
    private function m_1($array)
    {
        if(!is_numeric($array['id'])){
            throw new \Exception("Не корректный параметр id");}

        $this->DB->where("id", $array['id']);
        $resFeed = $this->DB->getOne("feed");
        if(!$resFeed){
            throw new \Exception('Запись не найдена');}

        $client = ($resFeed['protected'])?
            (new Client())->check_key($array['private_key']):
            (new Client())->check_key($array['public_key'], "public");
        if(!$client){
            throw new \Exception("Отказано в доступе");}

        $resFeed['text'] = stripslashes($resFeed['text']);

        return $resFeed;
    }



    private function m_2($array)
    {
        if($array['private_key']){
            $client = (new Client())->check_key($array['private_key']);
            $tmp1 = null;
        }
        else{
            $client = (new Client())->check_key($array['public_key'], "public");
            $tmp1 = " AND protected = 0";
        }

        if(!$client){
            throw new \Exception("Отказано в доступе");}

        $limit = (is_numeric($array["limit"]))? $array["limit"] : 35;
        $page  = (is_numeric($array["page"]))? $array["page"] : 0;

        $search = TextSecurity::shield_hard($array['search']);
        if($search){
            $search = str_replace(" ", '**', $search);
            $tmp2 = " AND MATCH(title, text) AGAINST('*".$search."*' IN BOOLEAN MODE)";
        }

        $sql = "SELECT COUNT(*) as n FROM feed WHERE client_id = ".$client['id']." ".$tmp1.$tmp2;
        $resCount = $this->DB->rawQueryOne($sql)['n'];
        if(!$resCount){ return false; }

        //pagination

        $resNav = Counter::get_nav([
            "limit" => $limit,
            "page" => $page,
            "posts" => $resCount
        ]);

        //проводим выборку
        $sql = "SELECT * FROM feed WHERE client_id = ".$client['id']." ".$tmp1.$tmp2." 
                ORDER BY date DESC LIMIT ".$resNav['start'].", ".$resNav['limit'];

        $resFeed = $this->DB->rawQuery($sql);

        $resFeed = array_map(function ($item){
            $item['text'] = stripslashes($item['text']);
            return $item;
        }, $resFeed);

        //response
        return [
            "stack" => $resNav["stack"],
            "items" => $resFeed,
            "search" => ($array['search'])?: false
        ];
    }

}