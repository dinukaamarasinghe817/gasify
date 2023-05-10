<?php
$header = new Header("customer/customer_dashboard",$data);
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
        <?php
            // call the default header for yout interface
            $bodyheader = new BodyHeader($data);
            // call whatever the component you need to show
            $bodycontent = new Body('customerdashboard', $data);
        ?>
</section>
<script>
    let accordion = document.querySelectorAll('.recent_order .dropdown');
    for(i=0; i<accordion.length; i++) {
        accordion[i].addEventListener('click', function(){
            this.classList.toggle('active')
        })
    }
</script>

<?php
$footer = new Footer();
?>