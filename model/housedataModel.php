<?php
class housedataModel{
    protected $dbCon;
    public function __construct()
    {
        global $config;
        $database=$config['database'];
        $dbdriver=$database['driver'];
        $dbname=$database['name'];
        $dbUser=$database['user'];
        $dbPass=$database['password'];

        $this->dbCon=database::getInstance($dbdriver,$dbname,$dbUser,$dbPass);

    }

    public function validateRequestFormInput($formData){
        //validate with db and php
        return ["valid"=>true,"data"=>$formData];
    }
    public function getAmenityIcon()
    {
        //everything in lowercase
        $dictFaIcon=["parking"=>"fa fa-parking","wifi"=>"fas fa-wifi","mall"=>"fas fa-shopping-cart","bank"=>"fas fa-piggy-bank","cinema"=>"fas fa-film","school"=>"fas fa-university","road"=>"fas fa-road","security"=>"fas fa-lock"];
        return $dictFaIcon;
    }
    public function getAllLocations()
    {
        //get all Unique location from db
        $sql="SELECT area_located from Houses GROUP BY area_located ORDER BY COUNT(area_located) DESC";
        $result=$this->dbCon->crudQuery($sql);
        return $result;
    }

    public function priceRange()
    {
        return ["Below NGN 40M"=>"0-40000000","NGN 40M - NGN 60M"=>"40000000-60000000","NGN 60M - NGN 100M"=>"60000000-100000000","Above NGN 100M"=>"100000000-"];
    }

    public function getAllPropsModel()
    {
        $sql="SELECT DISTINCT propType FROM Houses";
        $result=$this->dbCon->crudQuery($sql);

        return $result;
    }
    public function countAllHouseByLocation()
    {
        $sql="SELECT area_located as location, houseCategory as type, COUNT(*) as totalNumber FROM Houses GROUP BY location ORDER BY totalNumber DESC LIMIT 12";
        $result=$this->dbCon->crudQuery($sql);
      return $result;
    //   return [0=>['location'=>'Gbagada','type'=>'duplex','totalNumber'=>200],1=>['location'=>'Maryland','type'=>'duplex','totalNumber'=>20],2=>['location'=>'Ikeja','type'=>'duplex','totalNumber'=>205],3=>['location'=>'Surulere','type'=>'duplex','totalNumber'=>15],4=>['location'=>'Ojodu','type'=>'duplex','totalNumber'=>20],5=>['location'=>'Omole phase 1','type'=>'duplex','totalNumber'=>200],6=>['location'=>'Omole phase 2','type'=>'duplex','totalNumber'=>20],7=>['location'=>'Ogba','type'=>'duplex','totalNumber'=>21],8=>['location'=>'Magodo phase 1','type'=>'duplex','totalNumber'=>20],9=>['location'=>'Magodo phase 2','type'=>'duplex','totalNumber'=>20],10=>['location'=>'Ogudu','type'=>'duplex','totalNumber'=>200]];
    }


    public function houseSearch($price,$location,$propType)
    {
        $col_values=[]; $col_placeholder=[];

        $propType=strtolower($propType);
        $price =strtolower($price);
        $location=strtolower($location);

        $sql="SELECT id,area_located as location, houseCategory as type, category, fixed_price_currency,fixed_price,propType,size_measure_unit,size_measurement,room,bath FROM Houses";
        $sql.=($price!="any" || $location!="any" || $propType!="any")?" where":"";

        $result=[];

        if($location!=="any" && !empty($location)){
            if(!empty($col_values)){
                $sql.=" And ";
            }

            $sql .= " area_located = :loc";
            array_push($col_values, $location);
            array_push($col_placeholder, ':loc');
        }

        if($propType!=="any" && !empty($propType)){
            if(!empty($col_values)){
                $sql.=" And ";
            }
            $sql .= " propType = :prop";
            array_push($col_values, $propType);
            array_push($col_placeholder, ':prop');
        }

        if($price!=="any" && !empty($price)){
            if(!empty($col_values)){
                $sql.=" And ";
            }
            $split=explode("-",$price);
            $lower=(int) $split[0];
            $upper=(int) $split[1];

            if(!empty($upper)){
                $sql.=" CAST(fixed_price AS UNSIGNED) BETWEEN :lower and :upper";

                array_push($col_values, $lower);
                array_push($col_placeholder, ':lower');
                array_push($col_values, $upper);
                array_push($col_placeholder, ':upper');
            }else{
                $sql .= " CAST(fixed_price AS UNSIGNED)>= :lower";
                array_push($col_values, $lower);
                array_push($col_placeholder, ':lower');
            }

        }


        if(!empty($col_values)){
            $param=array_combine($col_placeholder,$col_values);
            
            $result=$this->dbCon->crudQuery($sql,$param);
        }else{
            $result=$this->dbCon->crudQuery($sql);
        }
        return $result;
    }

    public function getHouseInfoById($id)
    {
        //search db for house info and gallery
        $sql="SELECT id,area_located as location,onInstalment, houseCategory as type, category, fixed_price_currency,fixed_price,propType,size_measure_unit,size_measurement,room,bath,description,amenities FROM Houses where CAST(id as UNSIGNED)=?";
        $house=$this->dbCon->crudQuery($sql,[$id]);
        
        return $house;   
    }

    public function getphotogallery($house_id){
        $house=[
            ['description'=>"Close up view",'view'=>'front','ext'=>"jpg",'photo_id'=>1],
            ['description'=>"Close up view",'view'=>'back','ext'=>"jpg",'photo_id'=>2],
            ['description'=>"Close up view",'view'=>'bath','ext'=>"jpg",'photo_id'=>3],
            ['description'=>"Close up view",'view'=>'dinning','ext'=>"jpg",'photo_id'=>4],
            ['description'=>"Close up view",'view'=>'right','ext'=>"jpg",'photo_id'=>5],
            ['description'=>"Close up view",'view'=>'left','ext'=>"jpg",'photo_id'=>6],
            ['description'=>"Close up view",'view'=>'kitchen','ext'=>"jpg",'photo_id'=>7],
            ['description'=>"Close up view",'view'=>'bed','ext'=>"jpg",'photo_id'=>8],  
            ['description'=>"Close up view",'view'=>'palour','ext'=>"jpg",'photo_id'=>9]    
        ];

        return $house;
    }

    public function getInstalmentPlan($house_id)
    {
        $house=['per'=>"month",'instalment'=>'13000000','minPayTimes'=>3,'maxPayTimes'=>24,"currency"=>"NGN"];

        return $house; 
    }
}


