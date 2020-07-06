<?php
class editHouseController{
  protected $model;

  private function editHouse($newFormData){
    $login=adminCHeck(); //check if the admin is logged in;
    //[DataType,required=1 | optional=0]
    //key of validate is the same as the name of form field
    $validate=["size_measurement"=>"Number,1","size_measure_unit"=>"MeasuringUnit,1","category"=>"String,1","houseCategory"=>"String,1","propType"=>"String,1","Country"=>"Country,1","State"=>"State,1","area_located"=>"String,1","address"=>"String,1","fixed_price"=>"Number,1","fixed_price_currency"=>"Currency,1","room"=>"Number,1","bath"=>"Number,1","description"=>"String,1","features"=>"String,0","amenities"=>"String,0","id"=>"String,1"];
   

    //validate the data
    $error = $this->model->validate($newFormData,$validate);
    $cleanData = $this->model->removeEmptyfield($newFormData);
    $houseId = $cleanData['id'];
    //pass the data on th model for insert
    if(empty($error)){
      $Alreadyexist = $this->model->houseExist($cleanData);

      if($Alreadyexist){
        $_SESSION['edit-message'] = "You made no change, <a href='/admin/view-house/$houseId' class='btn btn-outline-warning'>view page</a>";
        header("Location: /admin/edit-house/$houseId");
        exit();
      }

      $updateStatus =$this->model->updateHouse($cleanData,$houseId);

      if($updateStatus !==false){
            //set session of message
            $_SESSION['edit-message'] = "House Updated successfully";
            //redirect to gallery step under add house
            $_SESSION['gallery-referer'] = "/admin/edit-house/$houseId/gallery";
            header("Location: /admin/edit-house/$houseId/gallery");
            exit();
      }

     
    }else{
      $_SESSION['edit-house-error']=$error;
      header("Location: /admin/edit-house/$houseId");
      exit();
    }


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