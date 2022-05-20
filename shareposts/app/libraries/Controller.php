<?php
// Base controller
// Loads the models and views

class Controller {
  //load model
  public function model($model) {
    // require model file
    require_once '../app/models/' .$model . '.php';

    //instanciate model
    return new $model();
  }

  //LOAD VIEWS 
  public function view($view, $data = []) {
    //check for view file
    if(file_exists('../app/views/'. $view . '.php')) {
      require_once '../app/views/'. $view . '.php';
    } else {
      die('View doest not exist');
    }
  }
}