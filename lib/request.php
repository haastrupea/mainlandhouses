<?php
class Request{
    public function __construct(){
       //server
       foreach ($_SERVER as $key => $value) {
           $key=$this->camelCased($key);
           if(!empty($key)){
               $this->{$key}=$value; 
           }
       }
    }
    private function camelCased($str)
    {

        $strLower=strtolower($str);
        $res="";
        preg_match_all("/_[a-z]/",$strLower,$matches);
        foreach ($matches[0] as $match) {
            $re=str_replace('_',"",strtoupper($match));
            $res=str_replace($match,$re,$strLower);
        }
        return $res;
    }
    public function getBody()
    {
        if($this->requestMethod==="GET"){
            return;
        }

        $body=[];
        if($this->requestMethod==='POST' && !empty($_POST)){
            foreach ($_POST as $key => $value) {
                $body[$key]=filter_input(INPUT_POST,$key,FILTER_SANITIZE_SPECIAL_CHARS);
            }

            return $body;
        }
    }
}