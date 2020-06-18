<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/template/styles/bs/bs.min.css">
    <link rel="stylesheet" href="/template/styles/fa/css/all.min.css">
    <link rel="stylesheet" href="/template/styles/animate.css">
    <link rel="stylesheet" href="/template/styles/mh/mh.css">
    <link rel="stylesheet" href="/template/styles/house-info.css">
    <title>MainLandHouses-house information page</title>
</head>
<body>
    <div class="body-div">
        <section class="house-basic-info">
            <div class="house-wrp">
                <div class="house">
                    <div class="goto-home">
                        <a href="/"><span class="fa fa-home"> Home</span></a>
                    </div>
                    <div class="house-img">
                        <div class="img-pc">
                            <?php foreach ($slidePhotos as $key => $value): ?>
                            <img data-index="<?php echo "{$key}" ?>" src="<?php echo $photoDir.$value['image']; ?>" class="img-fluid slide-fade" alt="<?php echo $value['view']; ?> view" title="<?php echo $value['description'] ?>">
                            <?php endforeach; ?>
                        </div>
                        <div class="img-overlay-wrp">
                            <div class="img-overlay">
                                <p class="house-condition"><?php echo $houseCat ?></p>
                                <div class="slide-control-wrp">
                                    <div class="slide-control">
                                    <?php foreach ($slidePhotos as $key => $value): ?>
                                        <span class="dot" data-index="<?php echo $key+1 ?>"></span>
                                    <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="house-price" title="Price Tag">
                                   <?php echo $housePrice ?>
                                   <i class="fa fa-tags"></i>
                                </div>
                                <div class="request-btn">
                                    <a href="/house/request/<?php echo $houseId; ?>">
                                        <i class="fa fa-phone fa-2x"></i>
                                        <span>Agent</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="house-info">
                        <div class="house-location"><?php echo $houseAddr; //$houseLocation; ?></div>
                        <h4 class="property-type"><?php echo $housePropType; ?></h4>
                    </div>
                    <div class="house-desc">
                        <div class="house-area"><span class="mh mh-measurement"></span> <span><?php echo $housesize; ?></span></div>
                        <div class="house-bath"><span class="mh mh-shower"></span> <span><?php echo $houseBath; ?> Bath(s)</span> </div>
                        <div class="house-bed"><span class="mh mh-bed"></span> <span><?php echo $houseRoom; ?> Room(s)</span></div>
                    </div>
                    <hr class="house-hr">
                </div>
            </div>


        </section>
        <section class="house-more-info">
            <div class="more-info-wrp">
                <div class="more-info">
                    <div class="house-desc-wrp">
                        <div class="house-desc">
                            <h6 class="house-desc-title"> House Description</h6>
                            <p class="house-desc-para"><?php echo $houseDesc; ?>
                               <a class="house-desc-link" href="#">Read&nbsp;More</a>
                            </p>
                        </div>
                    </div>
                    <div class="house-amenity-wrp">
                        <div class="house-amenity">
                            <h5 class="amenity-title"><span class="">Amenities</span> <a class="fa-pull-right see-more" href="#moreAmenities">See all</a></h5>
                            <div class="amenities-wrp">
                                <div id="moreAmenities" class="amenities">
                                    <div class="container">
                                        <div class="row mt-4">
                                            
                                        <?php foreach ($houseAmenities as $key => $value): ?>
                                            <div class=" col-md-3 col-sm-6 sm-half mb-3 animated fadeInDown <?php echo ($key>=$amentyShowMax)?"amenity-hide":""; ?>">
                                                <div class="box-wrp">
                                                    <a href="#" class="box">
                                                        <i class="<?php echo $allAmenities[$value]; ?> icon fa-3x"></i>
                                                        <p><?php echo $value; ?></p>
                                                    </a>
                                                </div>
                                            </div>

                                        <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
        </section>
        <section class="house-photo-gallery">
            <div class="photo-gallery-wrp">
                <div class="photo-gallery">
                    <h5 class="photo-gallery-title"><span>More photos</span>
                    <?php if(count($housephoto)>=$photoShowMax): ?>
                        <a class="fa-pull-right see-more" href="#morePhotos">See all</a> 
                    <?php endif; ?>
                </h5>
                    <div class="house-photo-wrp">
                        <div id="morePhotos" class="house-photo">
                            <div class="container-fluid">
                                <div class="row">

                                <?php foreach ($housephoto as $key => $value): ?>
                                    <div class=" col-md-3 col-sm-6 sm-half mb-3 animated fadeInDown <?php echo ($key>=$photoShowMax)?"photo-hide":""; ?>">
                                        <div class="box-wrp">
                                        <img data-index="<?php echo $key+1 ?>" src="<?php echo $photoDir.$value['image']; ?>" class="img-fluid slide-fade" alt="<?php echo $value['view']; ?> view" title="<?php echo $value['description'] ?>">
                                           </div>
                                    </div>

                                <?php endforeach; ?>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div id="gallery-modal" class="gallery-modal d-none">
    <div class="modal-backdrop fade show"></div>
    <div id="modal-request" style="display: block;" class="modal fade show animated fadeInDown" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog-centered modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Photo Gallery</h5>
        <a href="#" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
        </div>
        <div class="modal-body">
            <div class="gallery">
                <div class="summary-view">
                    <span class="current-position">1</span><span> of </span><span class="total-position">10</span>
                </div>
                <div class="prev-btn  bg-dark"><i class="fa fa-angle-left fa-3x text-white"></i></div>
                <div class="next-btn bg-dark"><i class="fa fa-angle-right fa-3x text-white"></i></div>
                <div class="gallery-photo-wrp">
                    
                <?php foreach ($photoGallery as $key => $value): ?>
                <div data-index="<?php echo $key; ?>" class="gallery-photo <?php echo $key==0?"active":""; ?>">
                    <div class="gallery-img d-flex">
                            <img data-index="<?php echo "{$key}" ?>" src="<?php echo $photoDir.$value['image']; ?>" class="img-fluid slide-fade m-auto " alt="<?php echo $value['view']; ?> view" title="<?php echo $value['description'] ?>">
                    <?php //break; ?>
                </div>
                <div class="gallery-img-description text-center d-none">
                    picture description goes here
                </div>
            </div>
            <?php endforeach; ?>

            </div>

            </div>
            
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
    <div id="modal-container" class="position-fixed w-100 h-100 <?php echo $request?"":"d-none" ?>">
        <div class="modal-backdrop fade show"></div>
        <!-- Modal 1 -->
        <?php if(empty($postReqData) || $postReqData["valid"]===false): ?>
<div id="modal-request" class="modal fade show animated fadeInDown" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered " role="document">
  <form class="w-100" action="/house/requested" method="POST">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Place Your Request</h5>
        <a href="/house/detail/<?php echo $houseId; ?>"  type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
      </div>
      <div class="modal-body">
          <?php if(!empty($postReqData['error'])): ?>
          <div class="alert alert-danger">
              <?php foreach ($postReqData['error'] as $key => $value): ?>
                <p class="mb-0"><?php echo $value ?></p>
              <?php endforeach; ?>
            </div>
            <?php endif; ?>
      <div class="form-group">
    <label for="name">Name(Required)</label>
    <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text"><i class="fa fa-user-alt"></i></div>
        </div>
    <input type="text" class="form-control <?php echo isset($error['fullName'])?"border-danger":"" ?>" id="name" name="fullName" placeholder="Fullname" value="<?php echo $fullName ?>" required>
    </div>
  </div>
  <div class="form-group">
    <label for="email">Email address(Required)</label>
    <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text"><i class="fa fa-envelope"></i></div>
        </div>
    <input type="email" inputmode="email" class="form-control <?php echo isset($error['email'])?"border-danger":"" ?>" name="email" id="email" value="<?php echo $email; ?>" aria-describedby="emailHelp" placeholder="Email Address" required>
    </div>
    <small id="emailHelp pl-2" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-row">
      <div class="col-2">
      <label for="pay">Pay</label>
      </div>
    <div class="col-10 instalment_plan">
    <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="pay" id="full-payment" value="full" checked>
  <label class="form-check-label" for="full-payment">Full Payment(<?php echo $housePrice ?>)</label>
</div>  
<?php if($onInstall==true): ?>
    <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="pay" id="instalment" value="installment">
  <label class="form-check-label" for="instalment">Instalment (<?php echo $InstalmentCurrency; ?><span id="instalment_price_show"><?php echo "$instalment" ?></span>)</label>
</div>
<?php else: ?>
    <small class="d-block w-75 alert alert-info" for="instalment">This house has no installment Plan</small>
<?php endif; ?>

</div>

<?php if($onInstall==true): ?>
    <div id="instalment-plan" class="col-8 offset-2 animated fadeIn">
    <div class="form-group">
    <input type="hidden" id="Instalment_per"  name="instalment_per" value="<?php echo $per; ?>">
          <input id="Instalment_price" type="hidden" name="instalment_price" value="<?php echo $instalment; ?>">
        <input type="range" list="tickmarks" step="1" min="<?php echo $minTimes ?>" max="<?php echo $maxTimes; ?>" class="form-control-range custom-range" id="instalment_duration" name="installment_duration">
        <label for="instalment_duration" class="border-info"> <?php echo $InstalmentCurrency?><span id="instal_dur_value"><?php echo ceil(($instalment)/($minTimes)); echo "/$per"; ?> in <?php echo $minTimes; ?></span> <?php echo $per; ?>(s)</label>
    <datalist id="tickmarks">
    <?php for ($i=$minTimes; $i <=$maxTimes ; $i++):?>
        <option value="<?php echo $i ?>">
    <?php endfor; ?>
    </datalist>
    </div>
  </div>
    <?php endif; ?>



</div>
<div class="form-group">
    <label for="exampleInputEmail1">Personal Note(optional)</label>
    <div class="input-group mb-2">
    <div class="input-group-prepend">
          <div class="input-group-text"><i class="fa fa-edit"></i></div>
        </div>
    <textarea  name="personal_Note" class="form-control" id="p-note" aria-describedby="personalNoteHelp" rows="3"><?php echo $pNote ?></textarea>
    </div>
    <small id="p-noteHelp" class="form-text text-muted pl-2">Anything you want us to know?</small>
  </div>
      <div class="modal-footer">
          <input type="hidden" name="house_id" value="<?php echo $houseId; ?>">
        <button class="btn btn-request">Request</button>
      </div>
    </div>

    </form>
  </div>
  </div>

    <?php endif; ?>
        <?php if(isset($postReqData['valid']) && $postReqData['valid']===true): ?>
          <!-- Modal 2 -->
<div id="modal-request-successful" class="modal fade show animated fadeInDown" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content border-success">
        <div class="modal-header bg-success">
          <h3 class="modal-title text-white" id="exampleModalLabel">Request placed successfully</h3>
          <a href="/house/detail/<?php echo $houseId; ?>" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>
        <div class="modal-body">
        <h1 class="text-center text-success"><i class="fa fa-check-double animated pulse infinite"></i></h1>
        <h5 class="text-center animated fadeIn">Thank you, your request has been received</h5>
        <h1 class="text-center mt-4 animated"><a target="_blank" href="<?php echo $WhatasappMsgLink; ?>" class="btn btn-outline-success"><i class="fab fa-whatsapp fa-2x"> Chat with agent</i></a> </h1>
        <h6 class="text-center mt-2 animated fadeIn">To discuss scheduling an inspection of the house</h6>
  <!-- <pre>
      <?php //var_dump($postReqData) ?>
  </pre> -->
        <div class="modal-footer pb-1">
          <a href="/house/detail/<?php echo $houseId ?>" type="button" class="btn btn-light btn-outline-success px-4">Done</a>
        </div>
      </div>
    </div>
    </div>
 </div>
    <?php endif; ?>
    <script src="/script/slide.js"></script>
</body>
</html>