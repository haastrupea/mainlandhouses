<?php
session_start();
include_once 'lib/loader.php';
include_once 'route/Router.php';
include_once 'model/loader.php';
include_once 'controller/loader.php';
include_once 'view/loader.php';

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

$router->get("/house/images/{view}/{quality}/{house_id}",function($req,$arg){
    //view=front/back/bath/dinning/right/left/kitchen/bed
    //quality=thumbnail/mobile/desktop/hd;
    //house_id=house id used
});

$router->get("/house-search/{searchType}",function($req,$arg){
    //redirect to landing page with form of search type preloaded
    $search=filter_var($arg['searchType'],FILTER_SANITIZE_SPECIAL_CHARS);
    header("Location: /home/{$search}");
    exit();

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