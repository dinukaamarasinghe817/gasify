<<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="<?php echo BASEURL; ?>/public/css/dashboard_delivery.css">
    <<link rel="stylesheet" href="<?php echo BASEURL; ?>/public/css/delivery.css">
    <title>Company-dashboard</title>
    <!--<link rel="stylesheet" href="./CSS/company.css">  -->
</head>
<script src="../../controller/Delivery/delivery.js" >

</script>

<body id="Body">
    <?php 
        $sidebar = new Navigation('delivery',$data['navigation']);
    ?>
    <section class="body">
        <?php 
        //echo $data['navigation'];
        $bodyheader = new BodyHeader($data);
        if ($data['navigation']=='dashboard') {
            $bodycontent = new Body('deliverydashboard', $data);
        }elseif($data['navigation']=='deliveries'){
            $bodycontent = new Body('gasdeliveries', $data);
        }elseif($data['navigation']=='currentgasdeliveries'){
            $bodycontent = new Body('currentgasdeliveries', $data);
        }/*elseif($data['navigation']=='products'){
            $bodycontent = new Body('companyProducts', $data);
        }elseif($data['navigation']=='regproducts'){
            $bodycontent = new Body('companyRegProducts', $data);
        }*/
        
        ?>
    </section>

</body>

</html>