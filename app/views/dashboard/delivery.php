    <?php 
        $header = new Header("company");
        $sidebar = new Navigation('delivery',$data['navigation']);
    ?>
    <section class="body">
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
        }/*elseif($data['navigation']=='regproducts'){
            $bodycontent = new Body('companyRegProducts', $data);
        }*/
        
        ?>
    </section>
    <?php
        $footer = new Footer("delivery");
    ?>