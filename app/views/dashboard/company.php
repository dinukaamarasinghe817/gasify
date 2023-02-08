<?php
    /*session_start();
    if (!(isset($_SESSION["userID"]))){
        header("Location:login.php");
    }*/
    ?>
    <?php 
        $header = new Header("company");
        $sidebar = new Navigation('company',$data['navigation']);
    ?>
    <section class="body">
        <?php 
        //echo $data['navigation'];
        $bodyheader = new BodyHeader($data);
        if ($data['navigation']=='dashboard') {
            $bodycontent = new Body('companydashboard', $data);
        }elseif($data['navigation']=='dealer'){
            $bodycontent = new Body('companyDealers', $data);
        }elseif($data['navigation']=='distributor'){
            $bodycontent = new Body('companyDistributors', $data);
        }elseif($data['navigation']=='products'){
            $bodycontent = new Body('companyProducts', $data);
        }elseif($data['navigation']=='regproducts'){
            $bodycontent = new Body('companyRegProducts', $data);
        }elseif($data['navigation']=='regDealer'){
            $bodycontent = new Body('companyRegDealer', $data);
        }elseif($data['navigation']=='regDistributor'){
            $bodycontent = new Body('companyRegDistributor', $data);
        }elseif($data['navigation']=='updateProducts'){
            $bodycontent = new Body('companyUpdateProducts', $data);
        }elseif($data['navigation']=='orders'){
            $bodycontent = new Body('companyOrders', $data);
        }elseif($data['navigation']=='limitquota'){
            $bodycontent = new Body('companyLimitQuota', $data);
        }elseif($data['navigation']=='analysis'){
            $bodycontent = new Body('companyAnalysis', $data);
        }elseif($data['navigation']=='reports'){
            $bodycontent = new Body('companyReports', $data);
        }elseif($data['navigation']=='reports'){
            $bodycontent = new Body('reportsCompany', $data);
        }
        
        ?>
    </section>
    <?php
        $footer = new Footer("company");
    ?>
