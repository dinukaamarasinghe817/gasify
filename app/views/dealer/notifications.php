<?php
$header = new Header("dealer",$data);
$sidebar = new Navigation('dealer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        $body = new Body('notifications',$data);
    ?>

<?php
$footer = new Footer("dealer");
?>