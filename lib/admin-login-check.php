<?php
//check admin login
// include_once "../model/adminModel.php";

if(!isset($_SESSION['adminLogIn'])){
header('Location: /home');
exit();
}

if(empty($_SESSION['adminLogIn'])){
  header('Location: /home');
  exit();
}

  // check the
  $model = new adminModel();
if($model->loginTokenCheck($_SESSION['adminLogIn'])!==true){
  header('Location: /home');
exit();
}