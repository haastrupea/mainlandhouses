<?php
session_start();
include_once 'lib/loader.php';
include_once 'route/Router.php';
include_once 'model/loader.php';
include_once 'controller/loader.php';
include_once 'view/loader.php';

//admin login check

function adminCHeck(){
    if(!isset($_SESSION['adminLogIn'])){
        header('Location: /home');
        exit();
        }
        
        if(empty($_SESSION['adminLogIn'])){
          header('Location: /home');
          exit();
        }
        
          // check the
          $model = new adminModel();
        if($model->loginTokenCheck($_SESSION['adminLogIn'])!==true){
          header('Location: /home');
        exit();
        }

    return $_SESSION['adminLogIn'];
}
$router= new Router;

$router->get("/[home]",function(){
    //load the controller
    $landingPage=new landingPageController();
    $landingPage->run();
});


//POST REQUEST
$router->post("/home-tab",function($req){
    
    
    //redirect to landing page with form of search type preloaded
    $post=$req->getBody();
    $search=filter_var($post['search_base_on'],FILTER_SANITIZE_SPECIAL_CHARS);
    header("Location: /home/{$search}");
});


$router->get("/house-search/{searchType}/{searchTerm}",function($req,$arg){

    $action=$arg['searchType']; $param=$arg['searchTerm'];
    
    //loadController
    $resultPage=new resultPageController();
    $resultPage->run($action,$param);
});


$router->get("/house-search/{searchType}",function($req,$arg){
    //redirect to landing page with form of search type preloaded
    $search=filter_var($arg['searchType'],FILTER_SANITIZE_SPECIAL_CHARS);
    header("Location: /home/{$search}");
    exit();

});

$router->get("/admin",function($req,$arg){
    //loadController
    $login=adminCHeck();

    include_once "template/admin/home.php";
});//admin home page

//put the
$router->get("/admin/login/{loginToken}",function($req,$arg){
      //loadController
      $loginToken=filter_var($arg['loginToken'],FILTER_SANITIZE_SPECIAL_CHARS);

      if(isset($_SESSION['adminLogIn']) && $_SESSION['adminLogIn'] ===$loginToken){
          header("Location: /admin");
          exit();
      }


      $action="login";
      $loginController=new adminLoginController();
      $loginController->run($action,$loginToken);
});

$router->get("/admin/logout",function($req,$arg){
    //loadController
    $token = $_SESSION['adminLogIn'];
    unset($_SESSION['adminLogIn']);
    unset($_SESSION['manage-filter']);
    unset($_SESSION["hide-notice"]);
    unset($_SESSION["gallery-referer"]);
    unset($_SESSION["view-house"]);
    unset($_SESSION["house-message"]);
    unset($_SESSION["add-photo-message"]); 

    header("Location: /admin/login/$token");
    exit();
});//admin home page


//manage a photo
$router->get("/admin/gallery/{action}/{photo_id}",function($req,$arg){
    $action = $arg['action'];
    $photo = $arg['photo_id'];
    $galleryController = new galleryController;
    $galleryController->run($action,$photo);
});

//manage a photo
$router->post("/admin/gallery/updateView/{photo_id}/{value}/ajax",function($req,$arg){
    $action = "updateView";
    $value = $arg['value'];
    $photo = $arg['photo_id'];
    $galleryController = new galleryController;
    $galleryController->run($action,['data'=>$value,'imgId'=>$photo]);
});

//manage a photo
$router->post("/admin/gallery/add-photo",function($req){
    $post = $req->getBody();
    $action = "addPhoto";
    $galleryController = new galleryController;
    $galleryController->run($action,$post);
});


/**===========================Edit house Start======================================= */

$router->get("/admin/edit-house/{house_id}[/{step}]",function($req,$arg){
    $model = new housedataModel;
    global $config;
   $login =adminCHeck();
   $step = isset($arg['step'])?$arg['step']:"";
   $house_id = $arg['house_id'];
   $house =$model->getHouseInfoById($house_id);
   $views = $model->allImageView();
   $gallery = $model->getphotogallery($house_id,false);
   $imgDir = $config['housePictureDir']['unCategorisedPictures'];

   $measureUnit = $model->getMeasuringUnit();
   $category = $model->gethouseCategory();
   $houseStructure = $model->gethouseStructure();
   $propType = $model->propType($house['type']);
   $countries = $model->allCountries();
   $states = $model->getState($house['Country']);
   $currencies = $model->getCurrency();

   $error =isset($_SESSION['edit-house-error'])?$_SESSION['edit-house-error']:[];
   include_once "template/admin/edit-house.php";
   unset($_SESSION['edit-house-error']);
});//manage home page

$router->post("/admin/edit-house",function($req){
$post= $req->getBody();
$action="editHouse";

$editHouse= new editHouseController;
$editHouse->run($action,$post);
});//manage home page

/**===========================edit new house end======================================= */



/**===========================Add new house Start======================================= */

$router->get("/admin/add-house[/{step}][/{house_id}]",function($req,$arg){
    global $config;
    $login =adminCHeck();
    $model = new housedataModel;
   $step = isset($arg['step'])?$arg['step']:"";
   $house_id = isset($arg['house_id'])?$arg['house_id']:"";
   $views = $model->allImageView();
   $gallery = $model->getphotogallery($house_id,false);
   $imgDir = $config['housePictureDir']['unCategorisedPictures'];
   $error =isset($_SESSION['add-house-error'])?$_SESSION['add-house-error']:[];
   include_once "template/admin/add-house.php";
   unset($_SESSION['add-house-error']);
});//manage home page

$router->post("/admin/add-house",function($req){
$post= $req->getBody();
$action="addHouse";

$addHouse= new AddHouseController;
$addHouse->run($action,$post);
});//manage home page

/**===========================Add new house end======================================= */




/**===========================View house Start======================================= */

$router->get("/admin/view-house/{id}",function($req,$arg){
    $action = "viewHouse";
    $house_id = $arg['id'];
    unset($_SESSION['manage-filter']);//remove last action for proper redirection to manage houses tab

    $viewHouses = new viewHouseController;
    $viewHouses->run($action,$house_id);
});//manage home page

$router->post("/admin/view-house",function($req){
    $post = $req->getBody();
    $house_id = $post['house_id'];
    header("Location: /admin/view-house/$house_id");
    exit();
});//manage home page

/**===========================View house end======================================= */



/**===========================manage start======================================= */

$router->get("/admin/manage-houses/{filter}",function($req,$arg){
    $action = "manageHouses";
    $filter = $arg['filter'];
    unset($_SESSION['view-house']);//remove last view house link for proper redirection to manage houses tab
    $_SESSION['manage-filter'] = $filter;
    $manageHouses = new manageHouseController;
    $manageHouses->run($action,$filter);

});//manage home page

$router->get("/admin/manage-houses",function($req,$arg){
       header("Location: /admin/manage-houses/listed");
       exit();
});//manage houses landing page

$router->get("/admin/manage-house/{action}/{id}",function($req,$arg){
    $action=$arg['action'];
    $id=$arg['id'];
    $manageHouses=new manageHouseController();
    $manageHouses->run($action,$id);
});


$router->get("/admin/unlist-house/{id}",function($req,$arg){
    $id=$arg['id'];
    header("Location: /admin/manage-house/unlist/$id");
    exit();
});

$router->get("/admin/list-house/{id}",function($req,$arg){
    $id=$arg['id'];
    header("Location: /admin/manage-house/list/$id");
    exit();
});

$router->get("/admin/sold-house/{id}",function($req,$arg){
    $id=$arg['id'];
    header("Location: /admin/manage-house/sell/$id");
    exit();
});

/**===============================manage end====================================== */
//admin login processing
$router->post("/admin/login/{loginToken}",function($req,$arg){
    //capture form data
    $post = $req->getBody();
    //loadController
    $loginToken=filter_var($arg['loginToken'],FILTER_SANITIZE_SPECIAL_CHARS);
    $action="logAdminIn";
    $loginController=new adminLoginController();
    $loginController->run($action,['loginToken'=>$loginToken,'loginDetails'=>$post]);
});



$router->get("/house-search",function(){
    //to redirect general search back here
    if(isset($_SESSION['generalSearch'])){
        //aet both action and action
        $param=$_SESSION['generalSearch']; $action='searchForm';


            //loadController
        $search=new resultPageController();
        $search->run($action,$param);

        //unset the session
        unset($_SESSION['generalSearch']);

    }else{
        //go to landing page if visiting the link directly
        header("Location: /home");
        exit();
    }
    
});


//POST REQUEST
$router->post("/general-search",function($req){
    $post=$req->getBody();

    $_SESSION['generalSearch']=$post;
    header("Location: /house-search");
    exit();
});

$router->post("/house-search",function($req){
    $post=$req->getBody();

    foreach ($post as $key => $value) {
            $value=filter_var($value,FILTER_SANITIZE_SPECIAL_CHARS);
            $key=filter_var(strtolower($key),FILTER_SANITIZE_SPECIAL_CHARS);
            header("Location: /house-search/{$key}/{$value}");
            exit();

    }
    
});


$router->get("/home/{params}",function($req,$arg){
    //load the controller
    $method='';
    switch (strtolower($arg['params'])) {
        case 'price':
            $method="priceForm";
            break;
        case 'location':
            $method="locationForm";
            break;
        case 'proptype':
            $method="propertyTypeForm";
            break;
        default:
           $method='home';
            break;
    }
    $landingPage=new landingPageController();
    $landingPage->run($method);
});



$router->get("/house/{action}/{id}",function($req,$arg){
    //can be view detail or show request house form


    $house_id=$arg['id'];
    $action=$arg['action'];

    $house=new houseInfoPageController;
    $house->run($action,$house_id);

});

$router->post("/house/requested",function($req){

    //post data
    $formData=$req->getBody();
    $action="requested";
    $house=new houseInfoPageController;
    $house->run($action,$formData);
});

$router->errorPage("/home");
$router->run();