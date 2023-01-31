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
    <link rel="stylesheet" href="<?php echo BASEURL; ?>/public/css/dashboard_company.css">
    <<link rel="stylesheet" href="<?php echo BASEURL; ?>/public/css/company.css">
    <title>Company-dashboard</title>
</head>
<script src="<?php echo BASEURL; ?>/public/js/Company/company.js"></script>

<body id="Body">
    <?php
        $sidebar = new Navigation('company',$data['navigation']);
    ?>
    <section class="body">
        <?php 
        //echo $data['navigation'];
        $bodyheader = new BodyHeader($data);
        if ($data['navigation']=='dashboard') {
            $bodycontent = new Body('companydashboard', $data);
        }elseif($data['navigation']=='dealer'){
            $bodycontent = new Body('companyDealers', $data);
        }elseif($data['navigation']=='distributor'){
            $bodycontent = new Body('companyDistributors', $data);
        }elseif($data['navigation']=='products'){
            $bodycontent = new Body('companyProducts', $data);
        }elseif($data['navigation']=='regproducts'){
            $bodycontent = new Body('companyRegProducts', $data);
        }elseif($data['navigation']=='regDealer'){
            $bodycontent = new Body('companyRegDealer', $data);
        }elseif($data['navigation']=='regDistributor'){
            $bodycontent = new Body('companyRegDistributor', $data);
        }elseif($data['navigation']=='updateProducts'){
            $bodycontent = new Body('companyUpdateProducts', $data);
        }
        
        ?>
    </section>

    
</body>
</html>