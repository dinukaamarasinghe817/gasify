<?php
$header = new Header("customer",$data);
$sidebar = new Navigation('customer','dashboard');
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        $bodycontent = new ProfileHTML($data);
    ?>
</section>

<?php
$footer = new Footer("customer");
?>