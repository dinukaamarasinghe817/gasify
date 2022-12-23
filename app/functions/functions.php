<?php

function createSession($conn, $email, $user){
    $sql = "SELECT * FROM {$user} WHERE email = '{$email}'";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query)>0){
        $row = mysqli_fetch_assoc($query);
        return $row["{$user}_id"];
    }else{
        return NULL;
    }
}

function isPasswordNotStrength($password){
    $upper = preg_match('@[A-Z]@', $password);
    $lower = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialchar = preg_match('@[^\w]@', $password);

    if(!$upper || !$lower || !$number || !$specialchar){
        return true;
    }else{
        return false;
    }
}

function isEmpty(array $fields){
    foreach( $fields as $field ){
        if(empty($field)){
            return true;
        }
    }
    return false;
}

function isNotValidEmail($email){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        return false;
    }else{
        return true;
    }
}

function isUserExist($conn, $email){
    $sql = "SELECT email FROM (SELECT email FROM admin
    UNION SELECT email FROM customer
    UNION SELECT email FROM dealer
    UNION SELECT email FROM company
    UNION SELECT email FROM distributor
    UNION SELECT email FROM delivery_person) temp WHERE temp.email = '{$email}'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        return true;
    }else{
        return false;
    }
}

function getImageRename($image_name,$tmp_name){
    $time  = time();
    return $time.$image_name;
}

function getImageExtension($image_name){
    $image_explode = explode('.',$image_name);
    $image_extension = end($image_explode);
    return $image_extension;
}

function isNotValidImageFormat($image_name){
    // all the valid types of images
    $extensions = ['png', 'jpg', 'jpeg', 'PNG', 'JPEG', 'JPG'];
    $image_extension = getImageExtension($image_name);
    if(in_array($image_extension,$extensions)){
        return false;
    }else{
        return true;
    }
}

function isNotConfirmedpwd($password, $confirmpassword){
    if($password == $confirmpassword){
        return false;
    }else{
        return true;
    }
}
