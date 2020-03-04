<?php
class landingPageController{
    private $model;
    private function priceform(){
        //model
        $allprice=$this->model->priceRange();
        $countByHouse=$this->model->countAllHouseByLocation();

        //variable 
        $priceActive='active';
        $locationActive="";
        $propTypeActive="";
         //views
         
       $landingView= new landingPageView();
       include_once $landingView->run();
    }
    
    private function propertyTypeForm(){
        //model
        $allPropsType=$this->model->getAllPropsModel();
        $countByHouse=$this->model->countAllHouseByLocation();
        //variable 
        $priceActive='';
        $locationActive="";
        $propTypeActive="active";
        
         //views
       $landingView= new landingPageView();
       include_once $landingView->run();
    }

    private function locationForm(){
        //models
        $allLocation=$this->model->getAllLocations();
        $countByHouse=$this->model->countAllHouseByLocation();

        //variable for toggling price location and propType forms
        $priceActive='';
        $locationActive="active";
        $propTypeActive="";
        //views
       $landingView= new landingPageView();
       include_once $landingView->run();
    }
    
    private function home(){
        //model
        $allprice=$this->model->priceRange();
        $countByHouse=$this->model->countAllHouseByLocation();

        //variable 
        $priceActive='active';
        $locationActive="";
        $propTypeActive="";

         //views
       $landingView= new landingPageView();
       include_once $landingView->run();
    }

    public function run($method='home')
    {
        //load model into the object
        $this->model=new housedataModel();

        //load needed models to render current view
       $run=method_exists($this,$method)?$method:'home';
       $this->{$run}();
    }
}