<?php
class Header{
    public function __construct($user){
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet"> 
            <link rel="stylesheet" href="'.BASEURL.'/public/css/dashboard.css">
            <link rel="stylesheet" href="'.BASEURL.'/public/css/'.$user.'.css">
            <title>'.$user.'</title>
        </head>
        <body>';
    }
}
?>