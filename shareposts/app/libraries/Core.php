<?php

//* App Core Class / Create URl and loads core controller 
// * URL format /controller/method/params

class Core {
  protected $currentController = 'Pages';
  protected $currentMethod = 'index';
  protected $params = [];

  public function __construct() {
    $url = $this->getUrl();

    // Look in controllers for first values
     if(isset($url[0]) && file_exists('../app/controllers/' . ucwords($url[0]). '.php')){
      // If exists, set as controller
      $this->currentController = ucwords($url[0]);
      // Unset 0 Index
      unset($url[0]);
    }

      // Require the controller
      require_once '../app/controllers/'. $this->currentController . '.php';

      // Instantiate controller class
      $this->currentController = new $this->currentController;

      //Check for second par of url
      if(isset($url[1])) {
        //Check to see if method exist in controller
        if(method_exists($this->currentController, $url[1])) {
          $this->currentMethod = $url[1]; 
          // on unset dans le tableau de strin url, pour qu'il ne reste plus que les params
          unset($url[1]);
        }
      }

      // echo $this->currentMethod;

      //Get params 
      $this->params = $url ? array_values($url) : [];

      //Call a callback with array of params 
      call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

  }

  public function getUrl() {
    if(isset($_GET['url'])) {
       //rtrim supprime les slash de fin de chaines
      $url = rtrim($_GET['url'], '/');
      $url = filter_var($url, FILTER_SANITIZE_URL);
      $url = explode('/', $url); // renvoie un tableau des el separés par un slash
       return $url;
    }
  }
}