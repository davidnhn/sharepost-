<?php

  class Pages extends Controller {
    public function __construct() {


    }

    public function index() {
      if(isLoggedIn()) {
        redirect('posts');
      }

        $data = ['title' => 'SharePosts', 'description'=> 'Simple network buit ont the MVC Framework'];

        $this->view('pages/index', $data);
    }
    public function about() {
      $data = ['title' => 'About', 'description' => 'This is the Description of our app SharePosts'];
      $this->view('pages/about', $data);
    }

    
  }