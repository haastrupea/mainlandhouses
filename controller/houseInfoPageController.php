<?php
class houseInfoPageController{
    private $model;
    private function detail($id,$request=false)
    {
        if($request===false){
            unset($_SESSION['requestData']);
       }//reset back to default
        $allAmenities=$this->model->getAmenityIcon();//get array
        $amentyShowMax=4;//show 4 amenities from the gallery and hide the rest
        
        $houseInfo=$this->model->getHouseInfoById($id);
        $housephoto=$this->model->getphotogallery($id);
        $photoShowMax=4;//show 4 pictures from the gallery and hide the rest

        
        //build up  slide images
        $slidePhotos=[];
        foreach ($housephoto as $key => $value) {
            if($value['view']=='front'){
                array_push($slidePhotos,$value);
            }
           if($value['view']=='palour'){
                array_push($slidePhotos,$value);
            }
            if($value['view']=='kitchen'){
                array_push($slidePhotos,$value);
            }
        }// select front,palour and kitchen view from all the pictures in the gallery

        //load all house info into variables
        $houseId=$houseInfo[0]['id'];
        $houseCat=$houseInfo[0]['category'];
        $houseLocation=$houseInfo[0]['location'];
        $priceNum=$houseInfo[0]['fixed_price'];
        $formatedPrice= currencyComma($priceNum);
        $housePrice="{$houseInfo[0]['fixed_price_currency']}{$formatedPrice}";
        $housePropType=$houseInfo[0]['propType'];
        $housesize="{$houseInfo[0]['size_measurement']}{$houseInfo[0]['size_measure_unit']}";
        $houseRoom=$houseInfo[0]['room'];
        $houseBath=$houseInfo[0]['bath'];
        $houseDesc=$houseInfo[0]['description'];
        $onInstall=$houseInfo[0]['onInstalment'];
        $houseAmenities=explode(',',$houseInfo[0]['amenities']);
       
        $postReqData=isset($_SESSION['requestData'])?$_SESSION['requestData']:[]; //data submited via request form stored in a session for

        if($onInstall==true){
            $instalmentPlan=$this->model->getInstalmentPlan($houseId);
            $per=$instalmentPlan['per'];
            $instalment=(int) ceil(($priceNum*10/100))+($priceNum);
            // $instalment=currencyComma($instalment);
            // $instalment=(int) $instalmentPlan['instalment'];
            $minTimes=(int) $instalmentPlan['minPayTimes'];
            $maxTimes=(int) $instalmentPlan['maxPayTimes'];
            $InstalmentCurrency= $instalmentPlan['currency'];
        }

        //view
        $house=new houseInfoView;

        include_once $house->run();

    }
    private function requested($formData)
    {
        $house_id=$formData['house_id'];
        //validate;
        $validated= $this->model->validateRequestFormInput($formData);

        if($validated['valid']){
            //save all the request data in the database
            //send a copy of the data to email to admin
            //send a copy of the data to email to user email

            //setup a session with the data given
        //house_id,instalment duration,full name,instalment per month,installment_time
        $instalment_dur="";
        $fullName="";
        $InstmentToPay="";
        $InstmentTime="";
        }
        $_SESSION['requestData']=$validated;

        header("Location: /house/request/$house_id");
        exit();   
    }

    private function request($house_id)
    {
        $request=true;
        $this->detail($house_id,$request);
    }
    public function run($action,$param)
    {
        $this->model=new housedataModel;

        if (method_exists($this,$action)) {
            $this->{$action}($param);
        }
    }
}

//house/request/id will display form that make a post req to 
//house/request that will now set up a session that contain all the 
//info submited and redirect back to house/request/id and now since 
//the session exist the form will not be seen but a message to chat us up on whatsapp 