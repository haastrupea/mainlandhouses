<?php
class resultPageController{
    private $model;
    private function price($param)
    {
        $allLocation=$this->model->getAllLocations();
        $allPropsType=$this->model->getAllPropsModel();

        $rangeDelimeter="-";
        //get houses with price Range
        $param=explode($rangeDelimeter,$param);

        $lower=$param[0];
        $upper=$param[1];

        $result=$this->model->gethouseWithPriceRange($lower,$upper);
        // $allLocation=$this->model->getAllLocations();
         //views
       $resultView= new resultPageView();
       include_once $resultView->run();

    }

    private function location($param)
    {
        
        $allPropsType=$this->model->getAllPropsModel();
        $allLocation=$this->model->getAllLocations();

        $result=$this->model->gethouseByLocation($param);

         //views
       $resultView= new resultPageView();
       include_once $resultView->run();
    }

    private function proptype($param)
    {
        $allPropsType=$this->model->getAllPropsModel();
        $allLocation=$this->model->getAllLocations();

        $result=$this->model->gethouseByPropType($param);


        //views
      $resultView= new resultPageView();
      include_once $resultView->run();
    }

    private function generalSearch($param){
        $allPropsType=$this->model->getAllPropsModel();
        $allLocation=$this->model->getAllLocations();
        
        //param is from post request submitted on result page
        $result=$this->model->generalHouseSearch($param);
        // var_dump($param);
        //views
      $resultView= new resultPageView();
      include_once $resultView->run();

    }
    public function run($action,$param) 
    {
        //load the model into this Object
        $this->model=new housedataModel;
        if(method_exists($this,$action)){
            $this->{$action}($param);
        }
    }
}