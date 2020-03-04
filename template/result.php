<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/template/styles/bs/bs.min.css">
    <link rel="stylesheet" href="/template/styles/fa/css/all.min.css">
    <link rel="stylesheet" href="/template/styles/mh/mh.css">
    <link rel="stylesheet" href="/template/styles/result.css">
    <title>MainLandHouses-search result</title>
</head>
<body>
   <div class="body-div">
    <header></header>
    <section class="search-result-wrp">
        <div class="search-result">
            <div class="search-form-wrp">
                <div class="search-form">
                    <div class="container-fluid">
                        <div class="row">  
                    <form class="col-lg-6 offset-lg-3 col-md-12 offset-md-0" action="/general-search" method="post">
                        <div class="form-row search-form-bg">
                            <div class="col-md-4 custom-dropdown sm-half border" title="Price">
                                <label for="Price">Price</label>
                                <select class="form-control custom-select" name="price" id="price-tag">
                                    <option value="any">Any</option>
                                <?php foreach ($allprice as $key => $value):?>
                                        <option value="<?php echo $value ?>" <?php echo $value===$price?"selected":""; ?>><?php echo $key ?></option>
                                    <?php endforeach; ?> 
                                </select>
                            </div>
                            <div class="col-md-3 custom-dropdown sm-half border" title="Location">
                                <label for="location">Location</label>

                                <select class="form-control custom-select" name="location" id="location">
                                    <option value="any">Any</option>
                                    <?php foreach ($allLocation as $value):?>
                                        <?php $loc=$value['area_located'];  ?>
                                        <option value="<?php echo $loc ?>" <?php echo strtolower($loc)===strtolower($location)?"selected":""; ?>><?php echo $loc ?></option>
                                    <?php endforeach; ?> 
                                </select>
                            </div>
                            <div class="col-md-4 custom-dropdown sm-half border" title="Property type">
                                <label for="Property-type">Property type</label>
                                <select class="form-control custom-select" name="propType" id="PropType">
                                    <option value="any">Any</option>
                                    <?php foreach ($allPropsType as $value):?>
                                        <?php $prop=$value['propType'];  ?>
                                        <option value="<?php echo $prop ?>" <?php echo strtolower($prop)===strtolower($propType)?"selected":""; ?> ><?php echo $prop ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="search-btn col-md-1 sm-half d-flex align-items-center justify-content-center ">
                                <button class="fa fa-search"></button>
                            </div>
                        </div>
                    </form>
                    </div>
                    </div>

                </div>
            </div>
            <div class="result-list-wrp">
             <div class="result-list">
                 <div class="container">
                     <div class="row">
                         <?php foreach($result as $value): ?>
                        
                         <div class="col-md-4 col-sm-12 mb-5">
                             <div class="house-wrp">
                                 <a href="/house/detail/<?php echo $value['id']; ?>" class="house">
                                     <div class="house-img">
                                         <img src="/assets/images/house_01_01_front_view.jpg" class="img-fluid" alt="">
                                         <div class="img-overlay-wrp">
                                             <div class="img-overlay">
                                                 <p class="house-condition"><?php echo $value["category"]; ?></p>
                                                 <div class="house-price" title="Fixed price">
                                                 <?php $p=currencyComma($value["fixed_price"]); ?>
                                                 <?php echo $value["fixed_price_currency"]; echo $p; ?>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="house-info">
                                         <div class="house-location"><?php echo $value["location"]; ?></div>
                                         <div class="property-type"><?php echo $value["propType"]; ?></div>
                                     </div>
                                     <div class="house-desc">
                                         <div class="house-area"><span class="mh mh-measurement"></span> <span><?php echo $value["size_measurement"]; echo $value["size_measure_unit"]; ?></span></div>
                                         <div class="house-bath"><span class="mh mh-shower"></span> <span><?php echo $value["bath"]; ?> bath(s)</span> </div>
                                         <div class="house-bed"><span class="mh mh-bed"></span> <span><?php echo $value["room"]; ?> bed(s)</span></div>
                                     </div>
                         </a>
                             </div>
                         </div>

                         <?php endforeach; ?>

                        
                     </div>
                 </div>
             </div>   
            </div>
        </div>
    </section>
   </div>
</body>
</html>