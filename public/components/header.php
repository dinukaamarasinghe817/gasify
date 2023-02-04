<?php
class Header{
    public function __construct($user,$data=null){
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet"> 
            <link rel="icon" href="'.BASEURL.'/public/icons/favicon.ico">
            <link rel="stylesheet" href="'.BASEURL.'/public/css/dashboard.css">
            <link rel="stylesheet" href="'.BASEURL.'/public/css/'.$user.'.css">';
            if(isset($_SESSION['role'])){
                echo '<title>Gasify - '.ucwords($_SESSION['role']).'</title>';
            }else{
                echo '<title>Gasify</title>';
            }
            
        echo '</head>
        <body>';

        if(isset($data['toast'])){
            $error = new Prompt('toast',$data['toast']);
            echo '<script>
                showToast();
            </script>';
        }else if(isset($data['verification'])){
            $prompt = new Prompt("verification",$data);
        }
    }
}
?>