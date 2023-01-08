<?php
    session_start();
    if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
        $role = $_SESSION['role'];
        header('Location: ' . BASEURL . '/dashboard/'.$role);
    }
    class Signin extends Controller{
        public function __construct(){
            // echo "this is the signin controller";
        }

        public function user($error = null){
            $data = [];

            if($error != null){
                switch($error){
                    case '1':
                        $data['error'] = 'fill all the fields';
                        break;
                    case '2':
                        $data['error'] = 'too many login attempts, recommend reset your password';
                        break;
                    case '3':
                        $data['error'] = 'password missmatch';
                        break;
                    case '4':
                        $data['error'] = 'invalid email';
                        break;
                }
                
            }
            $this->view('signin/user', $data);
        }

        public function usersignin(){
            // form information
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            // check if user is already registered
            $result = $this->model('User')->getUser($email);
            $data = $this->model('User')->userSignin($email,$password);
            if($data['success']){
                header('Location: '.BASEURL.'/dashboard/'.$_SESSION['role']);
            }else{
                header('Location: '.BASEURL.'/signin/user/'.$data['error']);
            }
        }
    }
?>