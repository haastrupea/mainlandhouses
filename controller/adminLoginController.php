<?php

class adminLoginController{
  private $model;
  protected function loginCheck($token){
   //check if token given is correct
   if(!$this->model->loginTokenCheck($token)){
    header("Location: /home");
    exit();
  }
  }
  private function login($loginToken){
    $this->loginCheck($loginToken);//login token check
      //show login page
       //view
       $error=isset($_SESSION['adminLoginError'])?$_SESSION['adminLoginError']:null;

       
       $login=new adminLoginView;
       
       include_once $login->run();

       if(isset($_SESSION['adminLoginError'])){
        unset($_SESSION['adminLoginError']);
       }
  }

  private function logAdminIn($credencials)
  {
    //with token
    $loginToken = $credencials['loginToken'];
    $this->loginCheck($loginToken);//login token check

    $loginDetails = $credencials['loginDetails'];


    $login=$this->model->adminLogin($loginDetails['username'],$loginDetails['password'],$loginToken);
    if($login){
      header("Location: /admin");
    }else{
      $_SESSION['adminLoginError'] = "Wrong Login Credentials: Try again";
      header("Location: /admin/login/$loginToken");
    }
    exit();
  }

  public function run($method,$arg){

    $this->model=new adminModel;

      //load needed models to render current view
      $run=method_exists($this,$method)?$method:'login';
      $this->{$run}($arg);
  }

}