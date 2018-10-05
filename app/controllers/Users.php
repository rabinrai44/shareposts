<?php
    class Users extends Controller{
        public function __construct(){
            $this->userModel = $this->model('User');
        }

        /**
         * Method does handle two things like loading a form
         * when user go to the register page
         * another example is register form when you make
         * a POST from a form request
         * And it check whether form is submitted or not then process/load the form
         */    
        public function register(){
            // Check for post
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Process form
                //die('Submitted');
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                // Init data 
                $data = [
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                // Validate Email
                if(empty($data['email'])){
                    $data['email_err'] = "Please enter email";
                } else {
                    // Check email
                    if($this->userModel->findUserByEmail($data['email'])){
                        $data['email_err'] = 'Email is already register';
                    }
                }              
                // Validate Name
                if(empty($data['name'])){
                    $data['name_err'] = "Please enter name";
                }
                // Validate Password
                if(empty($data['password'])){
                    $data['password_err'] = "Please enter email";
                } elseif(strlen($data['password']) < 6){
                    $data['password_err'] = 'Password must be at least 6 characters';
                }
                 // Validate Confirm Password
                 if(empty($data['confirm_password'])){
                    $data['confirm_password_err'] = "Please confirm password";
                } else{
                    if($data['password'] != $data['confirm_password']){
                    $data['confirm_password_err'] = 'Passwords do not match';
                    }
                }
                // Make sure errors are empty
                if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                    // Validated
                    // Hash Password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    // Register User
                    if($this->userModel->register($data)){
                        flash('register_success', 'You are registered and can log in');
                        redirect('users/login');
                    } else{
                        die('Something went wrong');
                    }
                } else {
                    // Load view with errors 
                    $this->view('users/register', $data);
                }

            } else {
                // Init data 
                $data = [
                    'name' => '',
                    'email' => '',
                    'password' => '',
                    'confirm_password' => '',
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                // Load view 
                $this->view('users/register', $data);
            }
        }

        /**
         * Login method 
         */
        public function login(){
            // Check for post
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Process form
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                 // Init data 
                 $data = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'email_err' => '',
                    'password_err' => ''
                ];

                // Validate Email
                if(empty($data['email'])){
                    $data['email_err'] = 'Please enter email';
                }

                /// Validate Password
                if(empty($data['password'])){
                    $data['password'] = 'Please enter password';
                }

                // Check for user/email
                if($this->userModel->findUserByEmail($data['email'])){
                    // User found

                } else{
                    // User not found
                    $data['email_err'] = 'No user found';
                }

                // Make sure errors are empty
                if(empty($data['email']) && empty($data['password'])){
                    // Validated
                    // Check and set logged in user
                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                    if($loggedInUser){
                        // Create Session
                        die('SUCCESS');
                    } else{
                        $data['password_err'] = 'Password incorrect';

                        $this->view('users/login', $data);
                    }
                } else {

                    // Load view 
                    $this->view('users/login', $data);
                }

            } else {
                // Init data 
                $data = [
                    'email' => '',
                    'password' => '',
                    'email_err' => '',
                    'password_err' => ''
                ];

                // Load view 
                $this->view('users/login', $data);
            }
        }
    }