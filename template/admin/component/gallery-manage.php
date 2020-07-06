<?php
if(!isset($login)){
  header('Location: /home');
  exit();
}
?>
<?php if($step=="gallery"):?>
    <?php
      if(empty($house_id)){
        header("Location: /admin/add-house");
        exit();
      }
      ?>
      <?php if(isset($_SESSION['edit-message'])): ?>
      <div class="alert alert-success text-capitalize">
            <i class="fa fa-exclamation-circle"></i>
            <?php echo $_SESSION['edit-message']; ?>
      </div>
    <?php endif;
    unset($_SESSION['edit-message']);
    ?>
     <?php if(isset($_SESSION['gallery-message-success'])): ?>
      <div class="alert alert-success text-capitalize">
            <i class="fa fa-exclamation-circle"></i>
            <?php echo $_SESSION['gallery-message-success']; ?>
      </div>
    <?php endif;
    unset($_SESSION['gallery-message-success']);
    ?>
     <?php if(isset($_SESSION['gallery-message-error'])): ?>
      <div class="alert alert-danger text-capitalize">
            <i class="fa fa-exclamation-circle"></i>
            <?php echo $_SESSION['gallery-message-error']; ?>
      </div>
    <?php endif;
    unset($_SESSION['gallery-message-error']);
    ?>

    <?php 
    if(isset($_SESSION['add-photo-message'])):
    if(is_string($_SESSION['add-photo-message'])): ?>
      <div class="alert alert-danger">
          <div class="text-capitalize">
            <i class="fa fa-exclamation-triangle"></i>
           <?php echo $_SESSION['add-photo-message'] ?>
          </div>
       
      </div>
    <?php else:  ?>
      <div class="alert alert-success">
          <div class="text-capitalize">
            <i class="fa fa-exclamation-circle"></i>
           Image Added to gallery Successfully
          </div>
       
      </div>
        <?php 
        endif;
        unset($_SESSION['add-photo-message']);
        endif;
        ?>
   <div class=" row card mb-4">
      <div class="card-header">
        <h1 class="card-title text-center text-uppercase text-monospace">Add New Image to the Gallery</h1>
      </div>
      <div class="card-body">
      <div class="container-fluid">

      
    <!-- <div class="row mt-2 justify-content-center align-items-center">
      <div id="preview-uploading-image">
        <img src="ddd/fff.jpg" alt="preview">
      </div>
    </div>
    <div class="row text-center">
      <div class="col-9 col-md-11">
        <div class="upload-progress-bar">
          <div class="upload-progress"></div>
        </div>
      </div>
      <div class="col-3 col-md-1">
        <div class="uploadPercent">
          <span id="percentUploaded">20</span>
          <span>%</span>
        </div>
      </div>
    </div> -->
    <hr>
    <div class="row mt-4">
      <form id="upload-form" action="/admin/gallery/add-photo" method="post" enctype="multipart/form-data" class="w-100">
        <div class="form-row text-center">
          <div class="col-md-6 mb-2">
            <input type="hidden" name="house-id" value="<?php echo $house_id; ?>" id="house-id" class="form-control" required>
            <input type="file" name="image" id="house-image" class="form-control" required accept="image/jpeg">
          </div>
          <div class="col-md-3 mb-2">
          <select name="view" id="view" class="form-control" required>
            <option value="">Set View</option>
            <?php foreach ($views as $view): ?>
              <option value="<?php echo $view ?>"><?php echo $view ?></option>
            <?php endforeach; ?>
          </select>
          </div>
          <div class="col-md-3 mb-2">
            <button type="submit" class="btn btn-block btn-outline-success">Upload</button>
          </div>
        </div>
      </form>
    </div>
    </div>
    </div>
    </div>

    <div class="row card mb-3">
      <div class=" card-body">
    <table class="table table-bordered table-hover">
      <thead class="thead-dark">
        <th>Image</th>
        <th>View</th>
        <th>Action</th>
      </thead>
      <tbody>
        <?php foreach ($gallery as $photo): ?>
        <tr>
          <td><img src="<?php echo $imgDir.$photo['image'] ?>" alt="<?php echo $photo['description'] ?>" width="150" height="150"></td>
          <td><select data-img-id="<?php echo $photo['id'] ?>" onchange="effectChange(event)" name="view" id="view" class="form-control col-md-6 offset-md-3" >
            <option value="">Set View</option>
            <?php foreach ($views as $view): ?>
              <option value="<?php echo $view ?>" <?php echo $view === $photo['view']?"selected":""; ?>><?php echo $view ?></option>
            <?php endforeach; ?>
          </select></td>
          <td><a  href="/admin/gallery/delete/<?php echo $photo['id'] ?>" class="btn fa fa-trash-alt delete-image text-danger"></a></td>
        </tr>
            <?php endforeach; ?>
      </tbody>

    </table>
    </div>
    </div>
  <?php endif; ?>