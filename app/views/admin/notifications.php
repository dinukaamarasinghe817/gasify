<?php
$header = new Header("admin",$data);
$sidebar = new Navigation('admin',$data['navigation']);
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
                        <?php
                            if(mysqli_num_rows($data['notifications']) > 0){
                                while($notification = mysqli_fetch_assoc($data['notifications'])){
                                    echo '<li>
                                            <div class="notification">
                                                <h2>'.$notification['type'].'</h2>
                                                <p>'.$notification['message'].'</p>
                                            </div>
                                        </li>';
                                }
                            }
                        ?>
                        <!-- <li>
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
                        </li> -->
                    </ul>
                </div>
        </section>
</section>

<?php
$footer = new Footer("admin");
?>