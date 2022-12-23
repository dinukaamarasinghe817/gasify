<?php

class User extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getUser($email){
        $result = $this->read('users', "email = '$email'");
        return $result;
    }

}
?>