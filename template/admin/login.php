<?php
if(!isset($login)){
  header('Location: /home');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#b78727">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/template/styles/bs/bs.min.css">
    <link rel="stylesheet" href="/template/styles/fa/css/all.min.css">
    <link rel="stylesheet" href="/template/admin/styles/login.css">
    <title>MainLandHouses-Admin Login</title>
</head>
<body>
  <div class="container">
  <div class="row align-items-center justify-content-center vh100">
  <div class="col-lg-5 col-md-8 col-sm-11 card p-4">
    <?php if(isset($error) && !empty($error)): ?>
    <div class="alert alert-danger">
     <span class="fa fa-exclamation-triangle"></span> 
     <?php echo $error; ?>
    </div>
    <?php endif; ?>
  <form action="/admin/login/<?php echo $loginToken ?>" method="post">
    <h2 class="text-uppercase">Mainlandhouses <br>Admin Login</h2>
  <div class="form-group">
    <label for="username">Username</label>
    <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text"><i class="fa fa-user-alt"></i></div>
        </div>
    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
    </div>
  </div>

  <div class="form-group">
    <label for="password">Password</label>
    <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text"><i class="fa fa-lock"></i></div>
        </div>
    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
    </div>
  </div>
  <div class="form-row justify-content-end">
    <button type="submit" class="btn login-btn">Login</button>
  </div>
  </form>
  
  </div>
  </div>
  
  </div>
</body>
</html>