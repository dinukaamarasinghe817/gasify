<?php
$header = new Header("company",$data);
$sidebar = new Navigation('company',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        $body = new Body('notifications',$data);
    ?>

<?php
$footer = new Footer("company");
?>