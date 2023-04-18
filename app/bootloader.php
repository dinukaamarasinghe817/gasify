<?php
    require_once 'core/App.php';
    require_once 'core/Controller.php';
    require_once 'core/DataBase.php';
    require_once 'core/Model.php';
    require_once 'library/fpdf/fpdf.php';
    require_once 'config/Config.php';
    require_once '../public/components/components.php';
    //for phpmailer
    require_once 'library/vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    //for stripe gateway
    require_once 'library/stripe/vendor/autoload.php';
    //for ebill verification selenium
    require_once 'functions/functions.php';
?>