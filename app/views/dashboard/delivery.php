    <?php 
        $header = new Header("delivery",$data);
        $sidebar = new Navigation('delivery',$data['navigation']);
    ?>
    <section class="body">
    <script src="http://localhost/mvc/public/js/Delivery/delivery.js"></script>
        <?php 
        $bodyheader = new BodyHeader($data);
        if ($data['navigation']=='dashboard') {
            $bodycontent = new Body('deliverydashboard', $data);
        }elseif($data['navigation']=='deliveries'){
            $bodycontent = new Body('gasdeliveries', $data);
        }elseif($data['navigation']=='currentgasdeliveries'){
            $bodycontent = new Body('currentgasdeliveries', $data);
        }elseif($data['navigation']=='reviews'){
            $bodycontent = new Body('viewReviews', $data);
        }elseif($data['navigation']=='reports'){
            $bodycontent = new Body('deliveryAnalysis', $data);
        }
        
        ?>
    </section>
    <?php
        $footer = new Footer("delivery");
    ?>