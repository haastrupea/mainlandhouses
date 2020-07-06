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

    public function setHouseSatus($newStatus,$houseId){
        //get original id
        $reaId = $this->gethouseRealId($houseId);
        $sql ="UPDATE Houses SET status = ? WHERE id = ?";
        return $this->dbCon->crudQuery($sql,[$newStatus,$reaId]);
    }
    public function getHouses($filter)
    {
        $sql="SELECT SUBSTRING(SHA2(CONCAT(id,address),0),50,60) as id,address, description,status FROM Houses where status= ?";

        return $this->dbCon->crudQuery($sql,[$filter]);
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

    private function allStates(){
        $states=['Nigeria'=>["states"=>['Lagos']]];
        return $states;
    }

    public function allCountries(){
        $countries=['Nigeria'];
        return $countries;
    }

    public function getState($country){
        return $this->allStates()[$country]['states'];
    }  
    
    public function getCurrency(){
        $currencies=['NGN'];
        return $currencies;
    }  

    public function getMeasuringUnit(){
        return ["sqft","sqm","hectare","car park"];
    } 
    
    public function gethouseCategory(){
        return ["new","distressed"];
    } 
    
    public function gethouseStructure(){
        return ["Duplex","Shopping Complex","bungalow"];
     
    }
    
    public function propType($houseStructure){
        $propTypes=['Duplex'=>["detached","semi-detached","terraced"],'Shopping Complex'=>["detached","semi-detached","terraced"],
        'bungalow'=>["detached","semi-detached","terraced"]];

        return $propTypes[$houseStructure];
     
    }

    public function savePhoto($postData){
        global $config;
        $allowed = array(IMAGETYPE_JPEG,"image/jpeg");
        $img = $_FILES['image'];
            if(empty($img)){
                return "No File Uploaded";
            }

        $imgTemp = $img['tmp_name'];
        $uploaded =is_uploaded_file($imgTemp);
            if(!$uploaded){
                return "Invalid File";
            }

        $fileSize = $img['size'];
            if($fileSize==0){
                return "The file size Should be greater than zero Byte";
            }

        $errorUpload = $img['error']!=UPLOAD_ERR_OK;
            if($errorUpload){
                return "Something went wrong with the uploading, please try again";
            }

            //get filetype
            if(function_exists('exif_imagetype')){
              $fileType = exif_imagetype($_FILES["image"]["tmp_name"]);
            }else{
              $fileType = $_FILES["image"]["type"];
            }

            if(!in_array($fileType,$allowed)){
                $allowType= implode(',',$allowed);
                return "Only JPG file type is allow";
            }

    
         
        $fileTempName= $img['name'];
        $file= filter_var($fileTempName,FILTER_SANITIZE_STRING); //MAKE SAFE
        $houseId = $this->gethouseRealId($postData['house-id']);
        if(!is_numeric($houseId)){
            header("Location: /admin/logout");
            exit();
        }
        $view = $postData['view'];
        $ext = "jpg";
        // var_dump($postData);
        // var_dump($img);
        //hash file name
        $hash = hash("sha256",$fileTempName.$fileSize.$imgTemp.rand(0,10));
        $fileName = substr($hash,10,20).".".$ext;
        $imgDir = trim($config['housePictureDir']['unCategorisedPictures'].$fileName,"\/");
        
        $sql= "INSERT INTO House_photo_gallery (view,house_id,ext,image) VALUES (:view,:house_id,:ext,:image)";
        $this->dbCon->startTransaction();//begin transaction
        //houseid, image,view,ext
        $status=$this->dbCon->crudQuery($sql,[":view"=>$view,":house_id"=>$houseId,":ext"=>$ext,":image"=>$fileName]);

        if(!$status){
           return "Failed to add Image to database, pls try again later"; 
        }
        //move uploaded file
        $fileSave = move_uploaded_file($imgTemp,$imgDir);

        if(!$fileSave){
            $this->dbCon->rollBackTransaction();
            return "Filesystem permission error,Pls try again";
        }

        chmod($imgDir, 0644);
        $this->dbCon->commitTransaction();
        return true;
    }

    public function getAllPropsModel()
    {
        $sql="SELECT DISTINCT propType FROM Houses";
        $result=$this->dbCon->crudQuery($sql);

        return $result;
    }
    
    public function validateCurrency($currency){

        return in_array($currency,$this->getCurrency());
    }
    public function validateMeasuringUnit($unit){
        return in_array($unit,$this->getMeasuringUnit());
    }
    public function validateNumber($data){
        return is_numeric($data);
    }

    public function validateString($data){
        return is_string($data);
    }
    public function validateCountry($country){
        return in_array($country,$this->allCountries());
    } 
    
    public function validateState($state){
        $states = $this->getState("Nigeria");
        return in_array($state,$states);
    }

    private function parseValidate($valdate){
        $split = explode(",",$valdate);
        return $split;
    }

    private function getDataType($data){
        return $this->parseValidate($data)[0];
    }
    
    private function isRequired($validate){
        return $this->parseValidate($validate)[1]==0?false:true;
    }

    private function setUpPDONamedParementer($arrayData){
        $parameteredArray=[];
        foreach ($arrayData as $key => $value) {
                $parameteredArray[":$key"]=$value;
        }
        return $parameteredArray;
    } 
    
    public function removeEmptyfield($arrayData){
        $data=[];
        foreach ($arrayData as $key => $value) {
            if(!empty($value)){
                $data[$key]=$value;
            }
        }
        return $data;
    }
    public function houseExist($formData){
        $sql = "select COUNT(*) as total,SUBSTRING(SHA2(CONCAT(id,address),0),50,60) as id from Houses where ";

        $para= $this->setUpPDONamedParementer($formData);
        $v = array_keys($formData);

        foreach ($v as $value) {
            $sql.= "$value =:$value and ";
        }

        $sql = substr($sql,0,-5);
        return $this->dbCon->crudQuery($sql,$para)[0]['total']==0?false:true;
    }
    
    public function getLastHouseId($formData){
        $sql = "select SUBSTRING(SHA2(CONCAT(id,address),0),50,60) as id from Houses where ";

        $para= $this->setUpPDONamedParementer($formData);
        $v = array_keys($formData);

        foreach ($v as $value) {
            $sql.= "$value =:$value and ";
        }

        $sql = substr($sql,0,-5);
        return $this->dbCon->crudQuery($sql,$para)[0]['id'];
    }

    public function updateHouse($houseData,$houseId){
            $parametered = $this->setUpPDONamedParementer($houseData);
            $reaId = $this->gethouseRealId($houseId);
            $parametered[":id"] = $reaId;
            $v = array_keys($houseData);
            $sql = "UPDATE Houses SET ";
            foreach ($v as $value) {
                $sql.= "$value =:$value, ";
            }
    
            $sql = substr($sql,0,-11);
            $sql.=" where id = :id";
            return $this->dbCon->crudQuery($sql,$parametered); 
    }

    public function saveNewHouse($newhouseData){
        $parametered = $this->setUpPDONamedParementer($newhouseData);
        $v = implode(",",array_keys($newhouseData));
        $para = implode(",:",array_keys($newhouseData));
        $sql = "INSERT INTO Houses ($v) VALUES (:$para)";
        
        $status = $this->dbCon->crudQuery($sql,$parametered);

        return ($status)?$this->getLastHouseId($newhouseData):false;    
    }

    public function validate($data,$validate){
        $error=[];//field=>[datatype='false or true,optinal |required =true or false']

        foreach ($data as $key => $value) {
            if($this->isRequired($validate[$key])){
                if(empty($value)){
                    $error['required'][]=$key;
                }
            }

            if(!empty($value)){
                $dataType =$this->getDataType($validate[$key]);
                $validateFn= "validate".$dataType;
                if(!$this->{$validateFn}($value)){
                    
                    $error['dataType'][$key]=$dataType;
                }
            }
        }

        return $error;
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

        $sql="SELECT SUBSTRING(SHA2(CONCAT(id,address),0),50,60) as id,area_located as location, houseCategory as type, category, fixed_price_currency,fixed_price,propType,size_measure_unit,size_measurement,room,bath FROM Houses where status='listed'";
        $result=[];

        if($location!=="any" && !empty($location)){
                $sql.=" And ";

            $sql .= " area_located = :loc";
            array_push($col_values, $location);
            array_push($col_placeholder, ':loc');
        }

        if($propType!=="any" && !empty($propType)){
                $sql.=" And ";

            $sql .= " propType = :prop";
            array_push($col_values, $propType);
            array_push($col_placeholder, ':prop');
        }

        if($price!=="any" && !empty($price)){
                $sql.=" And ";

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
        $sql="SELECT SUBSTRING(SHA2(CONCAT(id,address),0),50,60) as id,area_located as location,address,onInstalment, houseCategory as type, category, fixed_price_currency,fixed_price,propType,size_measure_unit,size_measurement,room,bath,description,amenities,features,status,State,Country,date_created FROM Houses where SUBSTRING(SHA2(CONCAT(id,address),0),50,60)=?";
        $house=$this->dbCon->crudQuery($sql,[$id]);
        return $house[0];   
    }

    public function gethouseRealId($hashId){
         //search db for house info and gallery
         $sql="SELECT id FROM Houses where SUBSTRING(SHA2(CONCAT(id,address),0),50,60)=?";
         $houserealId=$this->dbCon->crudQuery($sql,[$hashId]);
         return $houserealId[0]['id'];   
    }

    public function getPreviewPhoto($house_id){
            //get the real id of the house
            $real_id=$this->gethouseRealId($house_id);
            //get all the house pictures
            $sql="SELECT view,description,ext,image FROM House_photo_gallery where house_id=:hs_id and view='front' LIMIT 1";
            $house=$this->dbCon->crudQuery($sql,[':hs_id'=>$real_id]);
            if(empty($house)){
                $house=[
                    ['description'=>"Close up view",'view'=>'front','ext'=>"jpg",'photo_id'=>1,'image'=>'house_dummy_1.jpg']    
                ];
            }
    
            return $house[0];
    }
    public function getphotogallery($house_id,$getDummy=true){
        //get the real id of the house
        $real_id=$this->gethouseRealId($house_id);
        //get all the house pictures
        $sql="SELECT SUBSTRING(SHA2(CONCAT(id,image),0),50,60) as id,view,description,ext,image FROM House_photo_gallery where house_id=:hs_id";
        $house=$this->dbCon->crudQuery($sql,[':hs_id'=>$real_id]);
        if(empty($house) && $getDummy){
            $house=[
                ['description'=>"Close up view",'view'=>'front','ext'=>"jpg",'photo_id'=>1,'image'=>'house_dummy_1.jpg'],
                ['description'=>"Close up view",'view'=>'back','ext'=>"jpg",'photo_id'=>2,'image'=>'house_dummy_2.jpg'],
                ['description'=>"Close up view",'view'=>'bath','ext'=>"jpg",'photo_id'=>3,'image'=>'house_dummy_3.jpg'],
                ['description'=>"Close up view",'view'=>'dinning','ext'=>"jpg",'photo_id'=>4,'image'=>'house_dummy_4.jpg'],
                ['description'=>"Close up view",'view'=>'right','ext'=>"jpg",'photo_id'=>5,'image'=>'house_dummy_5.jpg'],
                ['description'=>"Close up view",'view'=>'left','ext'=>"jpg",'photo_id'=>6,'image'=>'house_dummy_6.jpg'],
                ['description'=>"Close up view",'view'=>'kitchen','ext'=>"jpg",'photo_id'=>7,'image'=>'house_dummy_7.jpg'],
                ['description'=>"Close up view",'view'=>'bed','ext'=>"jpg",'photo_id'=>8,'image'=>'house_dummy_8.jpg'],  
                ['description'=>"Close up view",'view'=>'palour','ext'=>"jpg",'photo_id'=>9,'image'=>'house_dummy_9.jpg']    
            ];
        }

        return $house;
    }

    public function updatePhotoView($imgId,$newValue)
    {
        $sql = "UPDATE House_photo_gallery set view =? WHERE SUBSTRING(SHA2(CONCAT(id,image),0),50,60) = ?";
        return $this->dbCon->crudQuery($sql,[$newValue,$imgId]);

    }
    public function deleteGalleryImage($imageId,$imgDir)
    {
        //delete from db
        $select = "SELECT image FROM House_photo_gallery where SUBSTRING(SHA2(CONCAT(id,image),0),50,60) =?";
        $img= $this->dbCon->crudQuery($select,[$imageId])[0]['image'];
        $sql = "DELETE FROM House_photo_gallery WHERE SUBSTRING(SHA2(CONCAT(id,image),0),50,60) = ?";

        $file =trim($imgDir.$img,"\/");

        $state = $this->dbCon->crudQuery($sql,[$imageId]);

        if(!$state){
            return false;
        }

        if(is_writable($file)){
            unlink($file);
            return true;
        }
        return false;
    }

    public function allImageView(){
        $views =   ['front','back','bath','dinning','right','left','kitchen','bed','palour'];
        return $views;
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