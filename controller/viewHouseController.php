<?php
class viewHouseController{
  protected $model;
  private function viewHouse($houseId)
  {
    //interact with model
    $house = $this->model->getHouseInfoById($houseId);

    if(!empty($house)){
      $_SESSION['view-house'] = true;
    }

    $login= adminCHeck();
    //fetch the view
    $view = new viewhouseVIew;
    include_once $view->run();
  }
  public function run($method,$param){
    $this->model=new housedataModel();
    $run = method_exists($this,$method)?$method : "viewHouse";

    $this->{$run}($param);
  }
}