<?php
    /*session_start();
    if (!(isset($_SESSION["userID"]))){
        header("Location:login.php");
    }*/
    ?>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="<?php echo BASEURL; ?>/public/css/dashboard.css">-->
    <title>Company-dashboard</title>
    <!--<link rel="stylesheet" href="./CSS/company.css">  -->
</head>
<!--<script src="../../controller/Company/company.js" >
</script>-->

<body id="Body"  >
<?php 
    $sidebar = new Navigation('dealer',$data['navigation']);
    ?>
    
</body>
</html>