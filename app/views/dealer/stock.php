<?php
$header = new Header("dealer");
if(isset($data['error'])){
    $error = new Prompt('error',$data);
    echo '<script>
        showToast();
    </script>';
}
$sidebar = new Navigation('dealer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        $bodycontent = new Body('dealerstock', $data);
    ?>
</section>

<?php
$footer = new Footer("dealer");
?>