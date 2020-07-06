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
    <link rel="stylesheet" href="/template/admin/styles/main.css">
    <link rel="stylesheet" href="/template/admin/styles/home.css">
  <title>MainLand Housing:Admin dashboard</title>
</head>
<body>
<?php include_once "template/admin/component/admin-header.php"; ?>
<div class="container vh100">
  <div class="row mt-4">
    <form action="/admin/view-house" method="post" class="search-house-by-id-form">
      <div class="form-row">
        <div class="col-8 col-md-4 offset-md-4 offset-1"> 
          <input type="text" name="house_id" class="form-control" required placeholder="Search house by ID">
        </div>
        <div class="col-2"><button type="submit" class="btn search-house"> <span class="fa fa-search"></span></button></div>
      </div>
    </form>
  </div>
  <div class="row align-items-center justify-content-center h-75">
    <div class="col">
      <div class="admin-options">
        <a href="/admin/manage-houses">
          <div class="p-4 card btn btn-outline-primary"><i class="fa fa-edit"></i> <span>Manage Houses</span></div>
        </a>
         <a href="/admin/add-house">
          <div class="p-4 card btn btn-outline-success"> <i class="fa fa-plus"></i> <span>Add New House</span></div>
        </a>

      </div>
    </div>
  </div>
  
  </div>
</body>
</html>