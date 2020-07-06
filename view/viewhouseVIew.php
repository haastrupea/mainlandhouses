<?php
class viewHouseView{

  public function htmlView()
  {
      return 'template/admin/view-house.php';
  }

  public function run($dataType='html')
  {
      //for now render only html template in this view
      return $this->htmlView();
  }
}