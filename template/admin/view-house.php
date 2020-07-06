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
    <link rel="stylesheet" href="/template/styles/mh/mh.css">
    <link rel="stylesheet" href="/template/admin/styles/main.css">
    <link rel="stylesheet" href="/template/admin/styles/view-house.css">
  <title>MainLand Housing:Admin dashboard</title>
</head>
<body>
<?php include_once "template/admin/component/admin-header.php"; ?>
<main>
  <div class="container">
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
  <div class="row mt-4 justify-content-end position-relative">
    <span class="status btn btn-sm btn-outline-info position-absolute"><span>Status: </span><?php echo $house['status'] ?></span>
    <div class="action">
    <?php if($house['status']!="sold"): ?>
              <?php if($house['status']=="listed"): ?>
              <a href="/admin/unlist-house/<?php echo $house['id']; ?>" class="btn btn-danger">Unlist</a>
              <?php elseif($house['status']=="unlisted"): ?>
              <a href="/admin/list-house/<?php echo $house['id']; ?>" class="btn btn-success">List</a>
              <?php endif; ?>
              <a href="/admin/sold-house/<?php echo $house['id']; ?>" class="btn btn-warning">Sold</a>

              <?php endif; ?>
              <a href="/admin/edit-house/<?php echo $house['id']; ?>" class="btn btn-outline-success"><span class="fa fa-edit"></span> Edit</a>
    </div>
  </div>
  <div class=" row mt-4 house-details">
    <div class="form-row w-100">
      <div class="col-lg-3 col-md-auto">
      <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text"><i class="fa fa-id-card mr-1"> </i>Id</div>
        </div>
    <span class="input form-control disabled"> <?php echo $house['id'] ?></span>
    </div>
      </div>
      <div class="col-lg-3 col-md-auto">
      <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text"><i class="fa fa-map-marker-alt mr-1"> </i>Location</div>
        </div>
    <span class="input form-control disabled"> <?php echo $house['location'] ?></span>
    </div>
      </div>

      <div class="col-lg-3 col-md-auto">
      <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text"><i class="fa fa-hourglass mr-1"> </i>On installement</div>
        </div>
    <span class="input form-control disabled"> <?php echo $house['onInstalment']==="0"?"No":"Yes" ?></span>
    </div>
      </div>

      <div class="col-lg-3 col-md-auto">
      <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text"><i class="fa fa-money-bill-alt mr-1"> </i>Price</div>
        </div>
    <span class="input form-control disabled"> <?php echo $house['fixed_price_currency'].currencyComma($house ['fixed_price']); ?></span>
    </div>
      </div>

      <div class="col-lg-3 col-md-auto">
      <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text"><i class="fa fa-home mr-1"> </i>Structure</div>
        </div>
    <span class="input form-control disabled"> <?php echo $house['type'] ?></span>
    </div>
      </div>

      <div class="col-lg-3 col-md-auto">
      <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text"><i class="fa fa-home mr-1"> </i>Structure Type</div>
        </div>
    <span class="input form-control disabled"> <?php echo $house['propType'] ?></span>
    </div>
      </div>

      <div class="col-lg-3 col-md-auto">
      <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text"><i class="fab fa-black-tie mr-1"> </i>Category</div>
        </div>
    <span class="input form-control disabled"> <?php echo $house['category'] ?></span>
    </div>
      </div>

      <div class="col-lg-3 col-md-auto">
      <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text"><i class="mh mh-measurement mr-1"> </i>Size</div>
        </div>
    <span class="input form-control disabled"> <?php echo $house['size_measurement']." ". $house['size_measure_unit'] ?>(s)</span>
    </div>
      </div>

      <div class="col-lg-2 col-md-auto">
      <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text"><i class="mh mh-bed mr-1"> </i>Room(s)</div>
        </div>
    <span class="input form-control disabled"> <?php echo $house['room'] ?></span>
    </div>
      </div>
      <div class="col-lg-2 col-md-auto">
      <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text"><i class="mh mh-shower mr-1"> </i>Bath(s)</div>
        </div>
    <span class="input form-control disabled"> <?php echo $house['bath'] ?></span>
    </div>
      </div>
      <div class="col-lg-4 col-md-auto">
      <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text"><i class="fa fa-map mr-1"> </i>Date Uploaded</div>
        </div>
    <span class="input form-control disabled"> <?php echo $house['date_created'] ?></span>
    </div>
      </div> 
      <div class="col-lg-2 col-md-auto">
      <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text"><i class="fa fa-map mr-1"> </i>State</div>
        </div>
    <span class="input form-control disabled"> <?php echo $house['State'] ?></span>
    </div>
      </div> 
         <div class="col-lg-2 col-md-auto">
      <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text"><i class="fa fa-map mr-1"> </i>Country</div>
        </div>
    <span class="input form-control disabled"> <?php echo $house['Country'] ?></span>
    </div>
      </div> 
      
      
      <div class="col-lg-12 col-md-auto">
      <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text"><i class="mh mh-shower mr-1"> </i>Amenities</div>
        </div>
    <span class="input form-control disabled"> <?php echo $house['amenities'] ?></span>
    </div>
      </div> 
      <div class="col-lg-12 col-md-auto">
      <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text"><i class="fa fa-directions mr-1"> </i>Address</div>
        </div>
    <span class="input form-control disabled"> <?php echo $house['address'] ?></span>
    </div>
      </div> 
       <div class="col-lg-12 col-md-auto">
      <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text"><i class="fa fa-comment-alt mr-1"> </i>Description</div>
        </div>
    <span class="input form-control disabled"> <?php echo $house['description'] ?></span>
    </div>
      </div>

      

    </div>


  </div>
  <div class="row">
    <div class="col-12 alert alert-info">
    <span class="fa fa-images"> </span> For pictures Gallery, <a class="btn" target="_blank" href="/house/detail/<?php echo $house['id']; ?>">Click here</a>
    </div>
  </div>
  </div>
</main>
</body>
</html>