<?php

  class Users extends Controller {
    public function __construct() {
      $this->userModel = $this->model('User');
    }
    
    public function register() {
      // Check for post 
      if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Process the form

        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //Init the data
        $data = [
          'name' => trim($_POST['name']),
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'confirm_password' => trim($_POST['confirm_password']),
          'email_err' => '',
          'name_err' => '',
          'password_err' => '',
          'confirmed_password_err' => '',
        ];

        //Validate Email
        if(empty($data['email'])) {
          $data['email_err'] = 'Please enter email';
        } else {
          // check email
          if($this->userModel->findUserByemail($data['email'])) {
            $data['email_err'] = 'Email already taken';
          }
        }

        //Validate name
        if(empty($data['name'])) {
          $data['name_err'] = 'Please enter name';
        }

        //Validate password
        if(empty($data['password'])) {
          $data['password_err'] = 'Please enter password';
        }elseif(strlen($data['password']) < 6) {
          $data['password_err'] = 'Password must be at least 6 characters';
        }

        //Validate confirm password
        if(empty($data['confirm_password'])) {
          $data['confirm_password_err'] = 'Please confirm password';
        }else {
          if($data['password'] != $data['confirm_password']) {
            $data['confirm_password_err'] = 'Password do not match';
          }
        }

        //Make sure errors are empty
        if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
          // die('SUCCESS');
          //Validated
          // Hash Password 
          $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

          //Register User 
          if($this->userModel->register($data)) {
            flash('register_success', 'You are registered and can log in');
            redirect('users/login');
          } else {
            die('Something went wrong');
          }
        } else {
          // load view with errors
          $this->view('users/register', $data);

        }


      } else {
        // init data
        $data = [
          'name' => '',
          'email' => '',
          'email_err' => '',
          'password' => '',
          'confirm_password' => '',
          'name_err' => '',
          'password_err' => '',
          'confirmed_password_err' => '',
        ];

        $this->view('users/register', $data);
      }
    }


    public function login() {
      // Check for post 
      if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Process the form
             // Sanitize POST data
             $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
             //Init the data
             $data = [
               'email' => trim($_POST['email']),
               'password' => trim($_POST['password']),
               'email_err' => '',
               'password_err' => '',
             ];

                  //Validate name
        if(empty($data['email'])) {
          $data['email_err'] = 'Please enter email';
        }

         //Validate password
         if(empty($data['password'])) {
          $data['password_err'] = 'Please enter password';
        }

        // Check for user/email
        if($this->userModel->findUserByEmail($data['email'])) {
          // user found

        } else {
          //user not found
          $data['email_err'] = 'No user found';
        }

        

          //Make sure errors are empty
          if(empty($data['email_err']) && empty($data['password_err'])) {
            // Validated
            // Check and set logged in user
            $loggedInUser = $this->userModel->login($data['email'], $data['password']);

            if($loggedInUser) {
                //Cretae Session
                $this->createUserSession($loggedInUser);
            } else {
              $data['password_err'] = 'Password incorrect';
              $this->view('users/login', $data);
            }
          } else {
            // load view with errors
            $this->view('users/login', $data);
  
          }
  
      } else {
        // init data
        $data = [
          'email' => '',
          'email_err' => '',
          'password' => '',
          'password_err' => '',
        ];

        $this->view('users/login', $data);
      }
    }

    public function createUserSession($user) {
      $_SESSION['user_id'] = $user->id;
      $_SESSION['user_email'] = $user->email;
      $_SESSION['user_name'] = $user->name;
      redirect('posts');

    }

    public function logout() {
      unset($_SESSION['user_id']);
      unset($_SESSION['user_email']);
      unset($_SESSION['user_name']);
      session_destroy();
      redirect('users/login');
    }


  }