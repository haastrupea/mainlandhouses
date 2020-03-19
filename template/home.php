<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#b78727">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/template/styles/bs/bs.min.css">
    <link rel="stylesheet" href="/template/styles/fa/css/all.min.css">
    <link rel="stylesheet" href="/template/styles/home.css">
    <title>MainLandHouses-home</title>
</head>
<body>
    <div class="body-div">
        <header>
        </header>

        <?php if(!isset($_SESSION['hide-notice'])): ?>
        

        <div id="home-notice" class="position-fixed w-100 h-100">
            <div class="modal-backdrop fade show"></div>
        <div class="modal fade show animated fadeInDown d-block" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content border-success">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Important Notice</h5>
          <a href="#" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                Thank you for your support we have added 71 of houses to database, feel free to browse them.
                you can now Place your request on the listed houses
                <span class="text-info">Note: that none of the pictures are real</span> but every other infos are, New Updates will come in 24hours time
            </div>
            <div class="alert alert-danger">
                We will let you know when we are done adding all our houses to database
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary"><span class="close">Done</span></button>
        </div>
      </div>
    </div>
    </div>
 </div>
        </div>

        <?php $_SESSION["hide-notice"]=true; ?>
        <?php endif; ?>

        <section class="search home-pg-1">
            <div class="background-wrp">
                <div class="background">
                    <div class="bg-img">

                    </div>
                    <div class="overlay">
    
                    </div>
                </div>
            </div>
            <div class="foreground-wrp">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                         <div class="content-wrp">
                             <div class="content">
                                <div class="text-desc-wrp">
                                    <div class="text-desc">
                                     <h1>
                                         Find New Or Distressed<br>
                                         <Span class="gold-text">Duplex</Span> Easily
                                     </h1>
                                    </div>
                                </div>
                                 <div class="search-form-wrp">
                                     <div class="search-form">
                                         <div class="search-tab container-fluid">
                                             <form action="/home-tab" method="post">
                                             <ul class="tab row">
                                                 <li class="tab-item col-3"><button name="search_base_on" value="price" class="tab-link <?php echo $priceActive; ?>" href="#">Price</button></li>
                                                 <li class="tab-item col-4"><button name="search_base_on" value="location" class="tab-link <?php echo $locationActive; ?>" href="#">Location</button></li>
                                                 <li class="tab-item col-5"><button name="search_base_on" value="proptype" class="tab-link <?php echo $propTypeActive ?>" href="#">Property&nbsp;Type</button></li>
                                             </ul>
                                             </form>
                                         </div>
                                         <div class="form-wrp container">
                                             <div class="form row">
                                                 <form class="col-md-6 offset-md-3 col-sm-10 offset-sm-1" action="/house-search" method="post">
                                                     <div class="form-row search-form-bg">
                                                         <!-- <div class="col-9 offset-1"> -->
                                                         <div class="col-9 offset-1 custom-dropdown">
                                                             <?php if ($propTypeActive==='active'): ?>
                                                             <select class="form-control custom-select" name="propType" id="PropType">
                                                                 <?php foreach ($allPropsType as $value):?>
                                                                    <?php $prop=$value['propType'];  ?>
                                                                     <option value="<?php echo $prop ?>"><?php echo $prop ?></option>
                                                                 <?php endforeach; ?>
                                                             </select>
                                                             <?php elseif($locationActive==='active'): ?>
                                                            <select class="form-control custom-select" name="location" id="location">
                                                                <?php foreach ($allLocation as $value):?>
                                                                <?php $loc=$value['area_located'];  ?>
                                                                    <option value="<?php echo $loc ?>"><?php echo $loc ?></option>
                                                                <?php endforeach; ?> 
                                                            </select>
                                                             <?php else: ?>
                                                                <select class="form-control custom-select" name="price" id="price-tag">
                                                                <?php foreach ($allprice as $key => $value):?>
                                                                    <option value="<?php echo $value ?>"><?php echo $key ?></option>
                                                                <?php endforeach; ?> 
                                                                </select>
                                                                 <?php endif; ?>

                                                         </div>
                                                         <div class="col-2 d-flex align-items-center justify-content-center ">
                                                             <button class="fa fa-search fa-2x"></button>
                                                         </div>
                                                     </div>
                                                 </form>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div> 
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="destination home-pg-2">
            <div class="destination-wrp">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="dest-content-text-wrp">
                            <div class="dest-content-text">
                                <h4>Suggested destinations</h4>
                                <p>see our top places visited by most people</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">

                <?php foreach ($countByHouse as $value): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 sm-half mb-5">
                        <div class="box-wrp">
                            <a href="/house-search/location/<?php echo $value['location']; ?>" class="box">
                                <i class="fa fa-map-marker-alt map-icon"></i>
                                <h6 class="dest-place"><?php echo $value['location']; ?></h6>
                                <p><span><?php //echo $value['totalNumber']; ?></span> <?php echo rtrim($value['type']); ?> </p>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>


                </div>
            </div>
        </div>
        </section>
    </div>
    <script>
    let close=document.querySelectorAll(".modal .close");

    function closemodal(e){
        e.preventDefault();
        let getnotice=document.getElementById('home-notice').classList.add('d-none');
    }
    close.forEach(elm => {
        elm.addEventListener("click",closemodal);
    });
                
    </script>
    
</body>
</html>