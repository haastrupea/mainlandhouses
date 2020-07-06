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
    <link rel="stylesheet" href="/template/admin/styles/add-house.css">
  <title>MainLand Housing:Admin dashboard</title>
</head>
<body>
<?php include_once "template/admin/component/admin-header.php"; ?>

<main class="my-5">
<div class="container">
  <?php if(empty($step)): ?>

    <?php if(isset($error) && !empty($error)): ?>
      <div class="alert alert-danger">
        <?php if(isset($error['required'])): ?>
          <div class="text-capitalize">
            <i class="fa fa-exclamation-triangle"></i>
            <span class="py-1 pl-3">Required Field(s): </span><?php echo implode(", ",$error['required']) ?>
          </div>
        <?php endif; ?>
       
      </div>
    <?php endif; ?>
    <?php if(isset($_SESSION['edit-message'])): ?>
      <div class="alert alert-info">
        <i class="fa fa-exclamation-circle"></i>
        <?php echo $_SESSION['edit-message']; ?>
      </div>
    <?php endif; 
    unset($_SESSION['edit-message']);
    ?>
  <form action="/admin/edit-house" method="post" class="<?php echo isset($error['required'])?implode(" ",$error['required']):"" ?>">
   <div class="form-row">

    <div class="col-lg-4">
    <div class="form-group">
    <!-- <label for="name">Status(Required)</label> -->
    <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text">Size</div>
        </div>
        <input class="form-control" type="number" min="1" value="<?php echo $house['size_measurement']?>" require name="size_measurement">
    <select name="size_measure_unit" id="size-unit" class="form-control" required>
      <?php foreach ($measureUnit as $value):?>
        <option value="<?php echo $value; ?>" <?php echo $value==$house['size_measure_unit']?"selected" : "" ?>><?php echo $value; ?></option>
        <?php endforeach;?>
    </select>

    </div>
   </div>
    </div>
    <div class="col-lg-4">
    <div class="form-group">
    <!-- <label for="name">Status(Required)</label> -->
    <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text">Category</div>
        </div>
    <select name="category" id="category" class="form-control" required>
    <?php foreach ($category as $value):?>
        <option value="<?php echo $value; ?>" <?php echo $value==$house['category']?"selected" : "" ?> class="text-capitalize"><?php echo $value; ?></option>
        <?php endforeach;?>
    </select>

    </div>
   </div>
    </div>
    

  </div>
  <div class="form-row">

   <div class="col-lg-5">
    <div class="form-group">
    <!-- <label for="name">Status(Required)</label> -->
    <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text">House</div>
        </div>
    <select name="houseCategory" id="houseCategory" class="form-control" required>
    <?php foreach ($houseStructure  as $value):?>
        <option value="<?php echo $value; ?>" <?php echo $value==$house['type']?"selected" : "" ?>><?php echo $value; ?></option>
        <?php endforeach;?>
     
    </select>

    </div>
  </div>
    </div>  

    <div class="col-lg-5">
    <div class="form-group">
    <!-- <label for="name">Status(Required)</label> -->
    <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text">House type</div>
        </div>
    <select name="propType" id="propType" class="form-control" required>
    <?php foreach ($propType  as $value):?>
        <option value="<?php echo $value; ?>" <?php echo $value==$house['propType']?"selected" : "" ?>><?php echo $value; ?></option>
        <?php endforeach;?>
    </select>

    </div>
  </div>
    </div>
  </div>
  <div class="form-row">
  <div class="col-lg-3">
    <div class="form-group">
    <!-- <label for="name">Status(Required)</label> -->
    <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text">Country</div>
        </div>
    <select name="Country" id="country" class="form-control" required>
    <?php foreach ($countries  as $value):?>
        <option value="<?php echo $value; ?>" <?php echo $value==$house['Country']?"selected" : "" ?>><?php echo $value; ?></option>
        <?php endforeach;?>
    </select>

    </div>
  </div>
    </div>

    <div class="col-lg-3">
    <div class="form-group">
    <!-- <label for="name">Status(Required)</label> -->
    <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text">State</div>
        </div>
    <select name="State" id="state" class="form-control" required>
    <?php foreach ($states  as $value):?>
        <option value="<?php echo $value; ?>" <?php echo $value==$house['State']?"selected" : "" ?>><?php echo $value; ?></option>
        <?php endforeach;?>
    </select>

    </div>
  </div>
    </div>

    <div class="col-lg-3">
    <div class="form-group">
    <!-- <label for="name">Status(Required)</label> -->
    <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text">Area</div>
        </div>
    <input type="text" name="area_located" id="area" class="form-control" required placeholder="Area located" value="<?php echo $house['location'] ?>">

    </div>
  </div>
    </div>

    <div class="col-lg-8">
    <div class="form-group">
    <!-- <label for="name">Status(Required)</label> -->
    <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text">Address</div>
        </div>
    <input type="text" name="address" id="address" class="form-control" required placeholder="House address" value="<?php echo $house['address'] ?>">

    </div>
  </div>
    </div>
  </div>
  <div class="form-row">
    <div class="col-lg-5">
    <div class="form-group">
    <!-- <label for="name">Status(Required)</label> -->
    <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text">Price</div>
        </div>
        <input min="1" value="<?php echo $house['fixed_price'] ?>" type="number" name="fixed_price" id="price" class="form-control" required>
    <select name="fixed_price_currency" id="currency" class="form-control" required>
    <?php foreach ($currencies  as $value):?>
        <option value="<?php echo $value; ?>" <?php echo $value==$house['fixed_price_currency']?"selected" : "" ?>><?php echo $value; ?></option>
        <?php endforeach;?>
    </select>
    </div>
  </div>
    </div>

    <div class="col-lg-3 col-6">
    <div class="form-group">
    <!-- <label for="name">Status(Required)</label> -->
    <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text">Room</div>
        </div>
        <input min="1" value="<?php echo $house['room'] ?>" type="number" name="room" id="room" class="form-control" required>
  </div>
    </div>
  </div>
  
  <div class="col-lg-3 col-6">
    <div class="form-group">
    <!-- <label for="name">Status(Required)</label> -->
    <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text">Bath</div>
        </div>
        <input min="1" value="<?php echo $house['bath'] ?>" type="number" name="bath" id="bath" class="form-control" required>
  </div>
    </div>
  </div>
  </div>
  <div class="form-row">
  <div class="col-12">
    <div class="form-group">
    <!-- <label for="name">Status(Required)</label> -->
    <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text">Description</div>
        </div>
        <textarea name="description" id="description" rows="3" class="form-control" required><?php echo $house['description'] ?></textarea>
    </div>
  </div>
    </div>
  </div>

  <div class="form-row">

    <div class="col-6">
    <div class="form-group">
    <!-- <label for="name">Status(Required)</label> -->
    <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text">Features</div>
        </div>
        <input type="text" name="features" id="features" class="form-control" value="<?php echo $house['features'] ?>">
  </div>
    </div>
  </div>
  
  <div class="col-6">
    <div class="form-group">
    <!-- <label for="name">Status(Required)</label> -->
    <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text">Amenities</div>
        </div>
        <input name="amenities" id="amenities" class="form-control" value="<?php echo $house['amenities'] ?>">
  </div>
    </div>
  </div>
  </div>
  <div class="form-row justify-content-end">
    <input type="hidden" name="id" value="<?php echo $house_id; ?>" required>
    <button type="submit" class="btn btn-outline-success">Save</button>
  </div>
 </form>
  <?php endif; ?>
  
  <?php include_once "template/admin/component/gallery-manage.php"; ?>
</div>

<div id="modal">

<div id="gallery-modal" class="gallery-modal d-none">
    <div class="modal-backdrop fade show"></div>
    <div id="modal-request" style="display: block;" class="modal fade show animated fadeInDown" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog-centered modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Installement Plan</h5>
        <a href="#" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
        </div>
        <div class="modal-body">
            installement form
        </div>

        <div class="modal-footer pb-1 mt-3">
            <p class="mainlaind-copyright-footer text-center w-100 m-0">
                <i class="fa fa-copyright-alt"></i>
            &COPY; copyright <?php echo date("Y",time()); ?>
            Mainlandhouses
            </p>
        </div>
    </div>
    </div>
    </div>
    </div>


  </div>
</div>
</main>
<script src="/script/updateView.js">
  </script>
</body>
</html>