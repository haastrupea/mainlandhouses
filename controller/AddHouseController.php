<?php
class AddHouseController{
  protected $model;

  private function addHouse($newFormData){
    $login=adminCHeck(); //check if the admin is logged in;
    //[DataType,required=1 | optional=0]
    //key of validate is the same as the name of form field
    $validate=["size_measurement"=>"Number,1","size_measure_unit"=>"MeasuringUnit,1","category"=>"String,1","houseCategory"=>"String,1","propType"=>"String,1","Country"=>"Country,1","State"=>"State,1","area_located"=>"String,1","address"=>"String,1","fixed_price"=>"Number,1","fixed_price_currency"=>"Currency,1","room"=>"Number,1","bath"=>"Number,1","description"=>"String,1","features"=>"String,0","amenities"=>"String,0"];
   

    //validate the data
    $error = $this->model->validate($newFormData,$validate);
    //pass the data on th model for insert
    if(empty($error)){
      $cleanData = $this->model->removeEmptyfield($newFormData);
      $Alreadyexist = $this->model->houseExist($cleanData);

      if($Alreadyexist){
        $houseId = $this->model->getLastHouseId($cleanData);
        $_SESSION['house-message'] = "Already Exist: The house is already in your collections,Check it out <a href='/admin/view-house/$houseId' class='btn btn-outline-warning'>here</a>";
        header("Location: /admin/add-house");
        exit();
      }

      $house_id =$this->model->saveNewHouse($cleanData);
      if($house_id !==false){
            //set session of message
            $_SESSION['house-message'] = "House added successfully";
            //redirect to gallery step under add house
             $_SESSION['gallery-referer'] = "/admin/add-house/gallery/$house_id";
            header("Location: /admin/add-house/gallery/$house_id");
            exit();
      }

     
    }else{
      $_SESSION['add-house-error']=$error;
      header("Location: /admin/add-house");
      exit();
    }

    // $view = new addHouseView;
    // include_once $view->run();
  }
  private function doNothing(){
    header("Location: /admin");
    exit();
  }
  public function run($method,$param)
  {
    $this->model = new housedataModel;
    $run = method_exists($this,$method)?$method:"doNothing";

    $this->{$run}($param);
  }
}