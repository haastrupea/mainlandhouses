<?php
class houseInfoPageController{
    private $model;
    private function detail($id,$request=false)
    {
        global $config;
        if($request===false){
            unset($_SESSION['requestData']);
       }//reset back to default
        $allAmenities=$this->model->getAmenityIcon();//get array
        $amentyShowMax=4;//show 4 amenities from the gallery and hide the rest
        
        $houseInfo=$this->model->getHouseInfoById($id);
        if(empty($houseInfo)){
            header("Location: /home");
            exit();
        }
        $housephoto=$this->model->getphotogallery($id);
        $photoShowMax=4;//show 4 pictures from the gallery and hide the rest
        $photoGallery=[];
        // $photoDir=$config['housePictureDir']['categorisedPictures'];
        $photoDir=$config['housePictureDir']['unCategorisedPictures'];
        //build up  slide images
        $slidePhotos=[];
        
        foreach ($housephoto as $key => $value) {
            array_push($photoGallery,$value);//buid up the gallery picture array
            if($value["view"]!=null){

                if($value['view']=='front'){
                    array_push($slidePhotos,$value);
                }
               if($value['view']=='palour'){
                    array_push($slidePhotos,$value);
                }
                if($value['view']=='kitchen'){
                    array_push($slidePhotos,$value);
                }
            }else{
                // $photoDir=$config['housePictureDir']['unCategorisedPictures'];
                if(count($slidePhotos)<3){
                    array_push($slidePhotos,$value);
                }
            }
        }// select front,palour and kitchen view from all the pictures in the gallery

        //load all house info into variables
        $houseId=$houseInfo['id'];
        $houseStatus=$houseInfo['status'];
        $houseCat=$houseInfo['category'];
        $houseLocation=$houseInfo['location'];
        $houseAddr=$houseInfo['address'];
        $priceNum=$houseInfo['fixed_price'];
        $formatedPrice= currencyComma($priceNum);
        $housePrice="{$houseInfo['fixed_price_currency']}{$formatedPrice}";
        $housePropType=$houseInfo['propType'];
        $housesize="{$houseInfo['size_measurement']}{$houseInfo['size_measure_unit']}";
        $houseRoom=$houseInfo['room'];
        $houseBath=$houseInfo['bath'];
        $houseDesc=$houseInfo['description'];
        $onInstall=$houseInfo['onInstalment'];
        $houseAmenities=explode(',',$houseInfo['amenities']);

        //agent_info
        //TODO: i will be replacing the agent id with valus from database
        $house_agent_id='1';
        $agentinfo=$this->model->getHouseAgentData($house_agent_id);
        $agentPhone=$agentinfo['phoneNo'];


        $postReqData=isset($_SESSION['requestData'])?$_SESSION['requestData']:[]; //data submited via request form stored in a session for
        $fullName="";
        $email="";
        $pNote="";
        $error=[];
        if(!empty($postReqData)){
            $fullName=$postReqData['data']['fullName'];
            $email=$postReqData['data']['email'];
            $pNote=$postReqData['data']['personal_Note'];
        }

        $WhatasappMsg="Hi, my name is $fullName, i am interested in the house at $houseAddr with id $houseId";
        $requestWhatasappText=rawurlencode($WhatasappMsg);

        $WhatasappMsgLink="https://api.whatsapp.com/send?phone=$agentPhone&text=$requestWhatasappText";
        if(isset($postReqData['error'] )){
            $error=$postReqData['error'];

            if(isset($error['house_id'])){
                //someon is trying to edit the value of id given
                header("Location: /home");
                exit();
            }

            if(isset($error['pay'])){
                //someon is trying to edit the payment plan
                header("Location: /home");
                exit();
            }
        }



        unset($_SESSION['requestData']);
        if($onInstall==true){
            $instalmentPlan=$this->model->getInstalmentPlan($houseId);
            $per=$instalmentPlan['per'];
            $instalment=(int) ceil(($priceNum*10/100))+($priceNum);
            
            $minTimes=(int) $instalmentPlan['minPayTimes'];
            $maxTimes=(int) $instalmentPlan['maxPayTimes'];
            $InstalmentCurrency= $instalmentPlan['currency'];
        }

        //view
        $house=new houseInfoView;

        include_once $house->run();

    }
    /**
     * @todo: uncommment code that add the code to db
     */
    private function requested($formData)
    {
        $house_id=$formData['house_id'];
        //validate;
        $validated= $this->model->validateRequestFormInput($formData);

        if($validated['valid']){
            //save all the request data in the database
            // $this->model->placeRequest($validated['data']);
        
            //send a copy of the data to email to admin
            $this->model->sendRequestCopyToAdmin($validated['data']);
            
            //send a copy of the data to email to user email
            $this->model->sendRequestCopyToUser($validated['data']);

        }
        //setup a session with the data given
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