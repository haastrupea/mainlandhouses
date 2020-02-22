<?php
session_start();
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
$router->post("/home-tab",function($req,$arg){
    
    
    //redirect to landing page with form of search type preloaded
    $post=$req->getBody();
    $search=filter_var($post['search_base_on'],FILTER_SANITIZE_SPECIAL_CHARS);
    header("Location: /home/{$search}");
    

    //helps with toggling of price, location and property Types tab on the home page
    // $method=(isset($_POST['search_base_on']))?$method=$_POST['search_base_on']:"";
    // $searchType=new landingPageController();
    // $searchType->run($method);
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


$router->get("/house-search",function($req,$arg){
    //to redirect general search back here
    if(isset($_SESSION['generalSearch'])){
        //aet both action and action
        $param=$_SESSION['generalSearch']; $action='generalSearch';

            //loadController
        $generalsearch=new resultPageController();
        $generalsearch->run($action,$param);

        //unset the session
        unset($_SESSION['generalSearch']);

    }else{
        //go to landing page if visiting the link directly
        header("Location: /home");
        exit();
    }
    
});


//POST REQUEST
$router->post("/general-search",function($req,$arg){
    $post=$req->getBody();

    $_SESSION['generalSearch']=$post;
    header("Location: /house-search");
    exit();
});

$router->post("/house-search",function($req,$arg){
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
    switch ($arg['params']) {
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

$router->run();