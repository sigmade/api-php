<?php


namespace classes\getters;


trait MainGet
{
    public function get(array $array)
    {
        if(!is_numeric($array['m'])){
            throw new \Exception("Не корректный параметр `m`");}


        $m = "m_".$array['m'];
        return $this->$m($array);
    }

}