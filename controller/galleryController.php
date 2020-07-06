<?php
class galleryController{
  protected $model;

  private function delete($imageId){
    global $config;
    //admin check
    $login = adminCHeck();

    //get image folder
    $imgDir = $config['housePictureDir']['unCategorisedPictures'];
    
    //delete from db
    $status=$this->model->deleteGalleryImage($imageId,$imgDir);
    if($status){
      $_SESSION['gallery-message-success']="Image deleted Successfully";
    }else{
      $_SESSION['gallery-message-error']="Failed to delete Image, please try again later";
    }

    $refer = $_SESSION['gallery-referer'];

    header("Location: $refer");
  }

  private function uploadProgress()
  {
    
  }
  private function updateView($imgId){
    if(is_array($imgId)){
      echo $this->model->updatePhotoView($imgId['imgId'],$imgId['data']);
    }
  }

  private function addPhoto($postData){
    $status= $this->model->savePhoto($postData);
    $_SESSION['add-photo-message']=$status;
    $refer=$_SESSION["gallery-referer"];
    header("Location: $refer");
    exit();
  
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