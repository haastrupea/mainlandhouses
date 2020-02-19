<?php

class Router{
    private $requestMethods=['POST','GET'];//valid http request methods

    /**
     * magic method that respond when request method is called as a method of router object
     */
    public function __call($name, $args)
    {
        if(!in_array(strtoupper($name),$this->requestMethods)){
            //stop bad request by sending header with 405 bad request method
            return;
        }
      
        list($route, $method)=$args;

        //trim off right most slashes if route is not /
        $route=$route==='/'?$route:rtrim($route,'/');

        $routeKey=$this->routeRegex($route);//transform route to regex string
        //use regex form of the route as they key of route dictionary
        $this->{strtolower($name)}[$routeKey]['method']=$method;//method to call when a route matches a uri
        $this->{strtolower($name)}[$routeKey]['route']=$route;// the original route specified
        $this->{strtolower($name)}[$routeKey]['request']="new Request";// the original route specified
    }

    /**
     * Transform any part of the route enclosed in {} to "(?P<$1>.+?) where $1 is replaced with anything within the {}"
     * @param String $route
     * @return String $parsed 
     */
    protected function parseParam($route){
        $patern='/\{(.+?)\}/';
        $replace="(?P<$1>.+?)";
        $parsed=preg_replace($patern,$replace,$route);

        return $parsed;
    }
    
    /**
     * Transform any part of the route enclosed in [] to "($1)? where $1 is replaced with anything within the []"
     * @param String $route
     * @return String $parsed
     */
    protected function parseOptional($route){
        $patern='/\[(.+?)\]/';
        $replace="($1)?";
        $parsed=preg_replace($patern,$replace,$route);

        return $parsed;
    }

    /**
     * Escape forward slashes in the given regular expression string thereby making it a valid regex
     * @param String $regex Unparsed reglar expression
     * @return String $regex parsed regular expression
     */
    protected function parseRegex($regex){
        return str_replace("/","\/",$regex);
    }

    /**
     * produces a valid regex that matches a given route
     * @return String $Regex
     * @param String $route 
     */
    protected function routeRegex($route){
        $op=$this->parseOptional($route);
        $param=$this->parseParam($op);
        $regex=$this->parseRegex($param);

        return $regex;
    }

    /**
     * @todo get uri from request object
     * @return $uri the current request URI
     */
    protected function getUri(){
        //case insensitive
        $uri=strtolower($_SERVER['REQUEST_URI']);

        return $uri==='/'?$uri:rtrim($uri,'/');
    }

    /**
     * return the router dictionary that match the given REQUEST URI
     * @param Array $routeDict
     * @return Array $routeDict the matching route dictionary
     */
    protected function selectRoute($routeDict){
        return !is_null($routeDict)?array_filter($routeDict,function($key){
            return preg_match("/^$key$/i",$this->getUri());
        },ARRAY_FILTER_USE_KEY):false;
    }

    /**
     * extract parameter in request uri base on route given and pass it into the callback attached to the route as arguments.
     * @NOTE Numbers can not be use as parameter in the router, if used, they will not be added as arguments to be passed on to the callback 
     * @param String $routeRegex this is the key of routeDict(regex that was generated base on the given route)
     * @return Array $args associative array of all the arguments as extracted from the uri
     */
    protected function getMethodArgs($routeRegex)
    {
        preg_match("/^$routeRegex$/i",$this->getUri(),$result);

        return array_filter($result,function($key){
            return preg_match("/^[\D]/",$key);
        },ARRAY_FILTER_USE_KEY);
    }
    
    /**
     * this is called to resolve all routing functionality
     * @param null
     * @return void
     */
    protected function resolved(){
        $requestMethod=strtolower($_SERVER['REQUEST_METHOD']);//fetch current request method
        if(isset($this->{$requestMethod})){

            $routeDict=$this->selectRoute($this->{$requestMethod});//select the route dictionary that match the uri given
    
            if(!empty($routeDict)){
                // var_dump($routeDict);
                // var_dump($_SERVER['REQUEST_URI']);
                $this->callBack($routeDict);
            }else{
                //custom redirect
                if (isset($this->{$requestMethod}['\/Redirect'])) {
                   $this->redirect($requestMethod);
                }
                
                if (isset($this->{$requestMethod}['error404'])) {
                    //custom 404
                    //use callBack or string
                }
                
            }
        }
    }

    /**
     * when a router method prop attached to the given routeDict is a callack function
     * @param $routeDict
     * @return void
     */
    protected function callBack($routeDict){
        $key=array_keys($routeDict)[0];//extract the key of the selected dictionary which is a regular expression
        $args=$this->getMethodArgs($key);//extract param in url base on uri given into array
        $request=$routeDict[$key]['request'];
            call_user_func($routeDict[$key]['method'],$request,$args);//call method with args
    }

    /**
     * handle redirection
     * @param $requestMethod
     * @return void
     */
    protected function redirect($requestMethod){
        //custom redirect handler
        $routeDict=$this->{$requestMethod};
        $redirect=$routeDict['\/Redirect'];
        $path=$redirect['method'];
        if (is_callable($path)) {
            //use callBack for redirect
            $this->callBack($redirect);
        }elseif(is_string($path)){
            //build standard link from given string
           
            if(!is_file($path) || !is_dir($path) || !filter_var($path,FILTER_VALIDATE_URL)){
                header("Location: {$path}");
                exit();
            }
            return;
        }
    }

    /**
     * call when user is ready to run all the defined routers
     * @param null
     * @return void
     */
    public function run()
    {
        $this->resolved();
    }
}