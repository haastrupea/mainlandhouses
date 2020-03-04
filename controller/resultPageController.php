<?php
class resultPageController{
    private $model;
    private function price($price)
    {
      $this->generalSearch($price,null,null);
    }

    private function location($location)
    {
      $this->generalSearch(null,$location,null);
    }

    private function proptype($propType)
    {
       $this->generalSearch(null,null,$propType);
    }
    private function searchForm($param){
      $this->generalSearch($param['price'],$param['location'],$param['propType']);
    }


    protected function generalSearch($price="",$location="",$propType=""){
      //general info
        $allprice=$this->model->priceRange();
        $allPropsType=$this->model->getAllPropsModel();
        $allLocation=$this->model->getAllLocations();

        $location=urldecode($location);
        $price=urldecode($price);
        $propType=urldecode($propType);

        
        //param is from post request submitted on result page
        $result=$this->model->houseSearch($price,$location,$propType);


        //views
      $resultView= new resultPageView();
      include_once $resultView->run();

    }
    public function run($action,$param) 
    {
        //load the model into controller Object
        $this->model=new housedataModel;
        if(method_exists($this,$action)){
            $this->{$action}($param);
        }
    }
}