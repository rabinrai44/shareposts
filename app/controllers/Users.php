<?php
    class Users extends Controller{
        public function __construct(){

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