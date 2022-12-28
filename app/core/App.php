<?php
    class App{
        protected $controller = 'Home';
        protected $method = 'index';
        protected $params = [];

        public function __construct(){
            $url =$this->getURL();
           //print_r($url);
            if(isset($url[0])){
                if(file_exists('../app/controllers/'.ucwords($url[0]).'.php')){
                    // if controller exists
                    $this->controller = ucwords($url[0]);
                    //print_r($this->controller."->") ;
                    unset($url[0]);

                }
            }
            
            require_once '../app/controllers/'.$this->controller.'.php';
            $this->controller = new $this->controller;
 
            if(isset($url[1])){
                if(method_exists($this->controller,$url[1])){
                    
                    $this->method = $url[1];
                    //print_r($this->method) ;
                    unset($url[1]);
                }
            }

            $this->params = $url ? array_values($url) : [];
            unset($url);
            
            call_user_func_array([$this->controller,$this->method], $this->params);
        }

        private function getURL(){
            if(isset($_GET['url'])){
                
                $url = rtrim($_GET['url'],'/');

                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/',$url);

                return $url;
            }
        }
    }
?>