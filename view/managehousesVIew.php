<?php
class managehousesVIew{

  public function htmlView()
  {
      return "template/admin/manage-houses.php";
  }

  public function run($dataType='html')
  {
      //for now render only html template in this view
      return $this->htmlView();
  }

}