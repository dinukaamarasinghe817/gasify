<?php
$header = new Header("dealer");
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new Body('viewmyreservation', $data);
       
    ?>

     
</section>

<?php
$footer = new Footer();
?>