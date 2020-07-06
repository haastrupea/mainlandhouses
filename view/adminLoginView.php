<?php

class adminLoginView{

  public function htmlView()
  {
      return 'template/admin/login.php';
  }

  public function run($dataType='html')
  {
      //for now render only html template in this view
      return $this->htmlView();
  }
}