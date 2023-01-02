<?php
$header = new Header("vehicles");
$sidebar = new Navigation('distributor',$data['navigation']);

// session_start();
$user_id = $_SESSION['user_id'];
 ?>

<section class="body">
    <?php 
    // call the default header for your interface
    $bodyheader = new BodyHeader($data);
    ?>
 
    <section class="body-content">
        <h2>Vehicles</h2>

        <?php 
          $result = new Vehicles_Comp("view");
        ?>

        <?php
        echo "Your Distributor ID - $user_id".'<br><br>';
        echo "Your Vehicles' Details : "; 
        
        ?>

        <div class="main2">
            <table class="table1">
                <tr>
                    <th>Vehicle Number</th>
                    <th>Vehicle Type</th>
                    <th>Weight Limit</th>
                    <th>Fuel Consumption</th>
                    <th>Availability</th>
                    <th></th>
                </tr>
            </table>
        </div>
    </section>
</section>

<?php
$footer = new Footer();
?>