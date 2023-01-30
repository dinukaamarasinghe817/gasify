<?php
$header = new Header("dealer",$data);
$sidebar = new Navigation('dealer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new ProfileHTML($data);
    ?>
    <section class="body-content">
                <div class="content-data notifications">
                    <h2>Notifications</h2>
                    <ul>
                        <li>
                            <div class="notification">
                                <h2>Re-Order level alert</h2>
                                <p>You're runnig low stock on the following products. Hurry up and place a new purchase order. Products : (Buddy, Budget)</p>
                            </div>
                        </li>
                        <li>
                            <div class="notification">
                                <h2>Re-Order level alert</h2>
                                <p>You're runnig low stock on the following products. Hurry up and place a new purchase order. Products : (Buddy, Budget)</p>
                            </div>
                        </li>
                    </ul>
                </div>
        </section>
</section>

<?php
$footer = new Footer("dealer");
?>