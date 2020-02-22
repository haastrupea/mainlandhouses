<?php
class housedataModel{
    public function getAllLocations()
    {
        return ['Gbagada','Maryland','Ikeja','Surulere','Ojodu','Omole phase 1','Omole phase 2','Ogba','Magodo phase 1','Magodo phase 2', 'Ogudu'];
    }

    public function priceRange($start=0,$end=0)
    {
        // return "{$start}-{$end}";
    }

    public function getAllPropsModel()
    {
        return ['detached','semi-detached',"Terraced"];
    }
    public function countAllHouseByLocation()
    {
      return [0=>['location'=>'Gbagada','type'=>'duplex','totalNumber'=>200],1=>['location'=>'Maryland','type'=>'duplex','totalNumber'=>20],2=>['location'=>'Ikeja','type'=>'duplex','totalNumber'=>205],3=>['location'=>'Surulere','type'=>'duplex','totalNumber'=>15],4=>['location'=>'Ojodu','type'=>'duplex','totalNumber'=>20],5=>['location'=>'Omole phase 1','type'=>'duplex','totalNumber'=>200],6=>['location'=>'Omole phase 2','type'=>'duplex','totalNumber'=>20],7=>['location'=>'Ogba','type'=>'duplex','totalNumber'=>21],8=>['location'=>'Magodo phase 1','type'=>'duplex','totalNumber'=>20],9=>['location'=>'Magodo phase 2','type'=>'duplex','totalNumber'=>20],10=>['location'=>'Ogudu','type'=>'duplex','totalNumber'=>200]];
    }

    public function gethouseWithPriceRange($lower,$upper)
    {
        $mockData=[];
        $result=[];

        if(!empty($upper)){
            //search with lower and upper limit
        }else{
            //search with lower limit
        }

        return $result;
    }

    public function generalHouseSearch($postData)
    {
        $result=[];
        $sqlQuery="SELECT * from houses where";
        foreach ($postData as $key => $value) {
            $obj=trim(strtolower($value[$key]));
            switch ($key) {
                case 'price':
                    if($obj!=='any'){
                        $price=explode("-",$obj);
                        $upper=$price[1];
                        $lower=$price[0];
                        if(!empty($upper)){
                           //use price between the range of upper and lower
                        }else{
                            //use >=lower Price
                        }     
                    }
                    break;
                case 'location':
                    if($obj!=='all'){
                        //add location to query
                    }
                    break;
                case 'propType':
                    if($obj!=='all'){
                        //add proptype to query
                    }
                    break;
            }
            
        }

        //construct the query and execute it
        return $result;
    }

    public function gethouseByPropType($prop)
    {
        // var_dump($prop);
        return [];
    }
    public function gethouseByLocation($loc)
    {
        // var_dump($loc);

        return [];
    }
}