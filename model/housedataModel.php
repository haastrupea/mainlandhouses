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
        $valid=true; //overall assement of the validation
        $er=[];//array of all the error that occur
        $data=[];//array of what to return
        $fullName=trim($formData['fullName']);
        //check if it is not empty
        if(empty($fullName)){
            $er['fullName']="Please enter your Name";
        }
        $email=trim($formData['email']);
        //check if it is not empty and is valid
        if(empty($email)){
            $er["email"]="Please Enter a valid Email";

        }else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $er["email"]="Invalid Email provided";
        }
        //hidden type input, we need to be sure nobody is trying to mess with the page
        $pay=trim(strtolower($formData["pay"]));
        if(($pay!=='full') && $pay!=="installment"){
            $er["pay"]="";//someone is trying to mess with the webpage/redirect them to home page
        }
        $house_id=trim($formData['house_id']);
        //check if it exist
        if(empty($this->getHouseInfoById($house_id))){
           $er['house_id']="";//someone is trying to mess with the webpage/redirect them to home page
        }

        if($pay==="installment"){
            $pay_dur=trim($formData['installment_duration']);
            //get installment plan from db
            //check if the value is within min and max specified in the instalment plan incase someone mess with the form
        }

        //handle error output
        if(!empty($er)){
            $valid=false;
            $data['error']=$er;
        }

        $data['valid']=$valid;
        $data['data']=$formData;
        return $data;
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

    public function placeRequest($formData) {
        $sql="INSERT INTO House_request(email, fullName, personal_note, payment_duration, house_id, offer) VALUES (:email,:fullName,:pNote,:pay_dur,:house_id,:offer)";
        $email=$formData['email'];
        $pay_dur=1;
        $fullName=$formData['fullName'];
        $offer=$formData['pay'];
        $pNote=$formData['personal_Note'];
        $hash_House_Id=$formData['house_id'];
        $houseRealId=$this->gethouseRealId($hash_House_Id);

        if($offer==="installment"){
            $pay_dur=$formData['installment_duration'];
        }

        $this->dbCon->crudQuery($sql,[":email"=>$email,":fullName"=>$fullName,":pNote"=>$pNote,":pay_dur"=>$pay_dur,":house_id"=>$houseRealId,":offer"=>$offer]);
    }


    public function getAllPropsModel()
    {
        $sql="SELECT DISTINCT propType FROM Houses";
        $result=$this->dbCon->crudQuery($sql);

        return $result;
    }

    /**
     * @todo: send a mail to admin using a nice emailing Api
     */
     public function sendRequestCopyToAdmin($requestData){

     }

 /**
     * @todo: send a mail to user using a nice emailing Api
     */
     public function sendRequestCopyToUser($requestData){

     }
            
   
    public function countAllHouseByLocation()
    {
        $sql="SELECT area_located as location, houseCategory as type, COUNT(*) as totalNumber FROM Houses where status='listed' GROUP BY location ORDER BY totalNumber DESC LIMIT 12";
        $result=$this->dbCon->crudQuery($sql);
      return $result;
    }


    public function houseSearch($price,$location,$propType)
    {
        $col_values=[]; $col_placeholder=[];

        $propType=strtolower($propType);
        $price =strtolower($price);
        $location=strtolower($location);

        $sql="SELECT SUBSTRING(SHA2(CONCAT(id,address),0),50,60) as id,area_located as location, houseCategory as type, category, fixed_price_currency,fixed_price,propType,size_measure_unit,size_measurement,room,bath FROM Houses where status='listed' and";
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
        $sql="SELECT SUBSTRING(SHA2(CONCAT(id,address),0),50,60) as id,area_located as location,address,onInstalment, houseCategory as type, category, fixed_price_currency,fixed_price,propType,size_measure_unit,size_measurement,room,bath,description,amenities FROM Houses where SUBSTRING(SHA2(CONCAT(id,address),0),50,60)=?";
        $house=$this->dbCon->crudQuery($sql,[$id]);
        return $house[0];   
    }

    public function gethouseRealId($hashId){
         //search db for house info and gallery
         $sql="SELECT id FROM Houses where SUBSTRING(SHA2(CONCAT(id,address),0),50,60)=?";
         $houserealId=$this->dbCon->crudQuery($sql,[$hashId]);
         return $houserealId[0]['id'];   
    }

    public function getphotogallery($house_id){
        //get the real id of the house
        //get all the house pictures
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

    public function getHouseAgentData($agent_id){

        return ["phoneNo"=>'2348150220461'];
    }
}


