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
    <title>MainHouse-search result</title>
</head>
<body>
   <div class="body-div">
    <header></header>
    <section class="search-result-wrp">
        <div class="search-result">
            <div class="search-form-wrp">
                <div class="search-form">
                    <form class="col-md-6 offset-md-3 col-sm-8 offset-sm-2" action="/general-search" method="post">
                        <div class="form-row search-form-bg">
                            <div class="col-md-3 col-sm-3 custom-dropdown sm-half border" title="Price">
                                <label for="Price">Price</label>
                                <select class="form-control" name="price" id="price-tag">
                                    <option value="0-40000000">Below NGN 40M</option>
                                    <option value="40000000-60000000">NGN 40M - NGN 60M</option>
                                    <option value="61000000-60000000">NGN 61M - NGN 100M</option>
                                    <option value="100000000-">Above NGN 100M</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3 custom-dropdown sm-half border" title="Location">
                                <label for="location">Location</label>

                                <select class="form-control" name="location" id="location">
                                    <?php foreach ($allLocation as $value):?>
                                        <option value="<?php echo $value ?>"><?php echo $value ?></option>
                                    <?php endforeach; ?> 
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3 custom-dropdown sm-half border" title="Property type">
                                <label for="Property-type">Property type</label>
                                <select class="form-control" name="propType" id="PropType">
                                    <?php foreach ($allPropsType as $value):?>
                                        <option value="<?php echo $value ?>"><?php echo $value ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="search-btn col-md-2 col-sm-2 sm-half d-flex align-items-center justify-content-center ">
                                <button class="fa fa-search"></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="result-list-wrp">
             <div class="result-list">
                 <div class="container">
                     <div class="row">
                         <div class="col-md-4 col-sm-12 mb-5">
                             <div class="house-wrp">
                                 <div class="house">
                                     <div class="house-img">
                                         <img src="/assets/images/house-thumbnail.jpg" class="img-fluid" alt="">
                                         <div class="img-overlay-wrp">
                                             <div class="img-overlay">
                                                 <p class="house-condition">distressed</p>
                                                 <div class="house-price">
                                                     $1,200 / mo
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="house-info">
                                         <div class="house-location">Port Harcourt</div>
                                         <div class="property-type">Semi-detached</div>
                                     </div>
                                     <div class="house-desc">
                                         <div class="house-area"><span class="mh mh-measurement"></span> <span>12sqft</span></div>
                                         <div class="house-bath"><span class="mh mh-shower"></span> <span>2 baths</span> </div>
                                         <div class="house-bed"><span class="mh mh-bed"></span> <span>2 beds</span></div>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <div class="col-md-4 col-sm-12 mb-5">
                            <div class="house-wrp">
                                <div class="house">
                                    <div class="house-img">
                                        <img src="/assets/images/house-thumbnail.jpg" class="img-fluid" alt="">
                                        <div class="img-overlay-wrp">
                                            <div class="img-overlay">
                                                <p class="house-condition">New</p>
                                                <div class="house-price">
                                                    $1,200 / mo
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="house-info">
                                        <div class="house-location">Ikeja</div>
                                        <div class="property-type">Semi-detached</div>
                                    </div>
                                    <div class="house-desc">
                                        <div class="house-area"><span class="mh mh-measurement"></span> <span>12sqft</span></div>
                                        <div class="house-bath"><span class="mh mh-shower"></span> <span>2 baths</span> </div>
                                        <div class="house-bed"><span class="mh mh-bed"></span> <span>2 beds</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4 col-sm-12 mb-5">
                            <div class="house-wrp">
                                <div class="house">
                                    <div class="house-img">
                                        <img src="/assets/images/house-thumbnail.jpg" class="img-fluid" alt="">
                                        <div class="img-overlay-wrp">
                                            <div class="img-overlay">
                                                <p class="house-condition">New</p>
                                                <div class="house-price">
                                                    $1,200 / mo
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="house-info">
                                        <div class="house-location">Ikeja</div>
                                        <div class="property-type">Semi-detached</div>
                                    </div>
                                    <div class="house-desc">
                                        <div class="house-area"><span class="mh mh-measurement"></span> <span>12sqft</span></div>
                                        <div class="house-bath"><span class="mh mh-shower"></span> <span>2 baths</span> </div>
                                        <div class="house-bed"><span class="mh mh-bed"></span> <span>2 beds</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4 col-sm-12 mb-5">
                            <div class="house-wrp">
                                <div class="house">
                                    <div class="house-img">
                                        <img src="/assets/images/house-thumbnail.jpg" class="img-fluid" alt="">
                                        <div class="img-overlay-wrp">
                                            <div class="img-overlay">
                                                <p class="house-condition">New</p>
                                                <div class="house-price">
                                                    $1,200 / mo
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="house-info">
                                        <div class="house-location">Ikeja</div>
                                        <div class="property-type">Semi-detached</div>
                                    </div>
                                    <div class="house-desc">
                                        <div class="house-area"><span class="mh mh-measurement"></span> <span>12sqft</span></div>
                                        <div class="house-bath"><span class="mh mh-shower"></span> <span>2 baths</span> </div>
                                        <div class="house-bed"><span class="mh mh-bed"></span> <span>2 beds</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                         <div class="col-md-4 col-sm-12 mb-5">
                             <div class="house-wrp">
                                 <div class="house">
                                     <div class="house-img">
                                         <img src="/assets/images/house-thumbnail.jpg" class="img-fluid" alt="">
                                         <div class="img-overlay-wrp">
                                             <div class="img-overlay">
                                                 <p class="house-condition">New</p>
                                                 <div class="house-price">
                                                     $1,200 / mo
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="house-info">
                                         <div class="house-location">Ikeja</div>
                                         <div class="property-type">Semi-detached</div>
                                     </div>
                                     <div class="house-desc">
                                         <div class="house-area"><span class="mh mh-measurement"></span> <span>12sqft</span></div>
                                         <div class="house-bath"><span class="mh mh-shower"></span> <span>2 baths</span> </div>
                                         <div class="house-bed"><span class="mh mh-bed"></span> <span>2 beds</span></div>
                                     </div>
                                 </div>
                             </div>
                         </div>


                         <div class="col-md-4 col-sm-12 mb-5">
                            <div class="house-wrp">
                                <div class="house">
                                    <div class="house-img">
                                        <img src="/assets/images/house-thumbnail.jpg" class="img-fluid" alt="">
                                        <div class="img-overlay-wrp">
                                            <div class="img-overlay">
                                                <p class="house-condition">New</p>
                                                <div class="house-price">
                                                    $1,200 / mo
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="house-info">
                                        <div class="house-location">Ikeja</div>
                                        <div class="property-type">Semi-detached</div>
                                    </div>
                                    <div class="house-desc">
                                        <div class="house-area"><span class="mh mh-measurement"></span> <span>12sqft</span></div>
                                        <div class="house-bath"><span class="mh mh-shower"></span> <span>2 baths</span> </div>
                                        <div class="house-bed"><span class="mh mh-bed"></span> <span>2 beds</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 mb-5">
                            <div class="house-wrp">
                                <div class="house">
                                    <div class="house-img">
                                        <img src="/assets/images/house-thumbnail.jpg" class="img-fluid" alt="">
                                        <div class="img-overlay-wrp">
                                            <div class="img-overlay">
                                                <p class="house-condition">New</p>
                                                <div class="house-price">
                                                    $1,200 / mo
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="house-info">
                                        <div class="house-location">Ikeja</div>
                                        <div class="property-type">Semi-detached</div>
                                    </div>
                                    <div class="house-desc">
                                        <div class="house-area"><span class="mh mh-measurement"></span> <span>12sqft</span></div>
                                        <div class="house-bath"><span class="mh mh-shower"></span> <span>2 baths</span> </div>
                                        <div class="house-bed"><span class="mh mh-bed"></span> <span>2 beds</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4 col-sm-12 mb-5">
                            <div class="house-wrp">
                                <div class="house">
                                    <div class="house-img">
                                        <img src="/assets/images/house-thumbnail.jpg" class="img-fluid" alt="">
                                        <div class="img-overlay-wrp">
                                            <div class="img-overlay">
                                                <p class="house-condition">New</p>
                                                <div class="house-price">
                                                    $1,200 / mo
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="house-info">
                                        <div class="house-location">Ikeja</div>
                                        <div class="property-type">Semi-detached</div>
                                    </div>
                                    <div class="house-desc">
                                        <div class="house-area"><span class="mh mh-measurement"></span> <span>12sqft</span></div>
                                        <div class="house-bath"><span class="mh mh-shower"></span> <span>2 baths</span> </div>
                                        <div class="house-bed"><span class="mh mh-bed"></span> <span>2 beds</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4 col-sm-12 mb-5">
                            <div class="house-wrp">
                                <div class="house">
                                    <div class="house-img">
                                        <img src="/assets/images/house-thumbnail.jpg" class="img-fluid" alt="">
                                        <div class="img-overlay-wrp">
                                            <div class="img-overlay">
                                                <p class="house-condition">New</p>
                                                <div class="house-price">
                                                    $1,200 / mo
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="house-info">
                                        <div class="house-location">Ikeja</div>
                                        <div class="property-type">Semi-detached</div>
                                    </div>
                                    <div class="house-desc">
                                        <div class="house-area"><span class="mh mh-measurement"></span> <span>12sqft</span></div>
                                        <div class="house-bath"><span class="mh mh-shower"></span> <span>2 baths</span> </div>
                                        <div class="house-bed"><span class="mh mh-bed"></span> <span>2 beds</span></div>
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
   </div>
<script src="/script/custom-select.js"></script>
</body>
</html>