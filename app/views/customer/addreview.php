<?php
$header = new Header("customer_addreview");
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        $bodycontent = new Body('addreview', $data);
        
    ?>
</section>
<!-- <script src="<?php echo BASEURL;?>/public/js/dashboard.js"></script> -->
<script>
    // let accordion = document.querySelectorAll('.accordion .box');
    // for(i=0; i<accordion.length; i++) {
    //     accordion[i].addEventListener('click', function(){
    //         this.classList.toggle('active')
    //     })
    // }

    
</script>

<?php
$footer = new Footer();
?>