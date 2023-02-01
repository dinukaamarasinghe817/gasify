<?php
$header = new Header("delivery",$data);
$sidebar = new Navigation('delivery',$data['navigation']);
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
$footer = new Footer("delivery");
?>