<?php

class addHouseView{
  public function htmlView()
  {
      return 'template/admin/add-house.php';
  }

  public function run($dataType='html')
  {
      //for now render only html template in this view
      return $this->htmlView();
  }
}