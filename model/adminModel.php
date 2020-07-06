<?php
class adminModel{
  protected $dbCon;

  public function __construct()
  {
      global $config;
      $database=$config['database'];
      $dbdriver=$database['driver'];
      $dbname=$database['name'];
      $dbUser=$database['user'];
      $dbPass=$database['password'];

      $this->dbCon=database::getInstance($dbdriver,$dbname,$dbUser,$dbPass);

  }

  protected function getAdmin($username,$token){
 //check with db if token is correct
 $sql = "SELECT password, username FROM `admin_login` WHERE token = ? and username = ? ";

   return $this->dbCon->crudQuery($sql,[$token,$username])[0];

  }

  public function loginTokenCheck($token)
  {
    //check with db if token is correct
    $sql = "SELECT * FROM `admin_login` WHERE token = ? ";

    $result=$this->dbCon->crudQuery($sql,[$token]);

    if(empty($result)){
      return false;
    }

    return true;
  }

  public function adminLogin($username, $password,$loginToken){

    $admin=$this->getAdmin($username,$loginToken);
    if(empty($admin)){
     return false;
    }//check if the user it match

    $hash= $admin['password'];
    if(password_verify($password,$hash)!=true){
      return false;
    }
    
    //start session if the admin is right
       //start session
       $_SESSION['adminLogIn'] = $loginToken;
    return true;
  }
}