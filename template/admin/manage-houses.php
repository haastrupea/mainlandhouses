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
    <link rel="stylesheet" href="/template/admin/styles/manage-houses.css">
  <title>MainLand Housing:Admin dashboard</title>
</head>
<body>
<?php include_once "template/admin/component/admin-header.php"; ?>

<main>
  <div class="container">
  <div class="my-4">
  <ul class="nav nav-tabs nav-justified">
      <li class="nav-item"> <a href="/admin/manage-houses/listed" class="nav-link <?php echo $filter=="listed"? "active":""; ?>">Listed</a></li>
      <li class="nav-item"> <a href="/admin/manage-houses/unlisted" class="nav-link <?php echo $filter=="unlisted"? "active":""; ?>">Unlisted</a></li>
      <li class="nav-item"> <a href="/admin/manage-houses/sold" class="nav-link <?php echo $filter=="sold"? "active":""; ?>">Sold</a></li>
    </ul>
  </div>
    <div class="row">
      <?php if(!empty($houses)): ?>
      <table class="table table-bordered table-hover">
        <thead class="thead-dark">
          <th>Address</th>
          <th>Description</th>
          <th>Actions</th>
        </thead>
        <tbody>
          <?php
          foreach ($houses as $house):
          ?>
          <tr>
           
            <td> <a href="/admin/view-house/<?php echo $house['id'] ?>"><?php echo $house['address'] ?></a></td>
            <td> <a href="/admin/view-house/<?php echo $house['id'] ?>"><?php echo $house['description'] ?></a></td>
            
            <td class="action">

              <?php if($house['status']!="sold"): ?>
              <?php if($house['status']=="listed"): ?>
              <a href="/admin/unlist-house/<?php echo $house['id']; ?>" class="btn btn-danger">Unlist</a>
              <?php elseif($house['status']=="unlisted"): ?>
              <a href="/admin/list-house/<?php echo $house['id']; ?>" class="btn btn-success">List</a>
              <?php endif; ?>
              <a href="/admin/sold-house/<?php echo $house['id']; ?>" class="btn btn-warning">Sold</a>
              <?php endif; ?>

          </td>
          </tr>
          <?php endforeach; ?>
         

        </tbody>

      </table>
      <?php else: ?>
        <div class="col-12 mb-5">
                        <div class="not-found d-flex align-items-center justify-content-center flex-column">
                        <i class="fa fa-stack fa-3x">
                        <i class="fa fa-home fa-stack-2x text-white"></i>
                        <i class="fa fa-search fa-stack-1x animated infinit lookup"></i>
                        </i>
                        <h2 class="my-2"> No  <strong><?php echo $filter ?></strong> house Found</h2>
                        </div>
                        </div>
      <?php endif; ?>
    </div>
  </div>
</main>
</body>
</html>