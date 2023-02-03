<?php
$header = new Header("admin",$data);
$sidebar = new Navigation('admin','customers');
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
$footer = new Footer("admin");
?>