
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="<?php echo BASEURL; ?>/public/css/dashboard.css">-->
    <title>Dealer-dashboard</title>
</head>
<body>

    <?php 
    $sidebar = new Navigation('dealer',$data['navigation']);
    ?>
    <section class="body">
        <?php
            // call the default header for yout interface
            $bodyheader = new BodyHeader($data);
            // call whatever the component you need to show
            $bodycontent = new Body('dealerdashboard', $data);
        ?>
    </section>
    <!-- <script src="<?php echo BASEURL;?>/public/js/dashboard.js"></script> -->
    <script>
        let accordion = document.querySelectorAll('.accordion .box');
        for(i=0; i<accordion.length; i++) {
            accordion[i].addEventListener('click', function(){
                this.classList.toggle('active')
            })
        }
    </script>
</body>
</html>