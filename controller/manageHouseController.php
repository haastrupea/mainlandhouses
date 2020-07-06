<?php

class manageHouseController{
  private $model;

  protected function getHouses($filter){

    return $this->model->getHouses($filter);
  }

  protected function getListedHouses(){
    return $this->getHouses("listed");
  }
  protected function getUnlistedHouses(){
    return $this->getHouses("unlisted");
  } 
  
  protected function getSoldHouses(){
    return $this->getHouses("sold");
  }

  protected function changeHouseStatus($newStatus,$houseId){
    $login=adminCHeck(); //check if the admin is logged in;

    //call model to update the status
    $state = $this->model->setHouseSatus($newStatus,$houseId);

    // $_SESSION["manageActionState"]="success";



    //redirect back to where the user was
    if(isset( $_SESSION['manage-filter'])){
      $backto=  $_SESSION['manage-filter'];
      header("Location: /admin/manage-houses/$backto");
      exit();
    }

    if(isset( $_SESSION['view-house'] )){
      header("Location: /admin/view-house/$houseId");
      exit();
    }

    header("Location: /admin/manage-houses/$newStatus");
    exit();
  }
  private function unlist($id){
    $this->changeHouseStatus("unlisted",$id);
  }

  private function list($id){
    $this->changeHouseStatus("listed",$id);
    
  }

  private function sell($id){
    $this->changeHouseStatus("sold",$id);
  }

  private function manageHouses($filter="listed"){
    $login=adminCHeck();//check if the admin is logged in
    $houses=[];
    switch (strtolower($filter)) {

      case 'unlisted':
        $houses= $this->getUnlistedHouses();
        break;

      case 'sold':
        $houses= $this->getSoldHouses();
        break; 
        
      case 'listed':
      default:
      $houses= $this->getListedHouses();
        break;
    }

    //get house manage view
    $view = new managehousesVIew;
    include_once $view->run();
  }
  public function run($method,$param){
    $this->model=new housedataModel();
    $run = method_exists($this,$method)?$method : "manageHouses";

    $this->{$run}($param);
  }
}