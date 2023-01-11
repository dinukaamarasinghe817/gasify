<?php
$header = new Header("distributor_settings");
$sidebar = new Navigation('distributor',$data['navigation']);

$user_id = $_SESSION['user_id'];
?>

<section class="body">
    <?php 
    // call the default header for your interface
    $bodyheader = new BodyHeader($data);
    ?>

    <section class="body-content">
        <div class="split right">
            <h1>Settings</h1>

            <div class="main">
                <div class="header">
                    <h2>Update Profile</h2>
                </div>

                <div class="con">

                    <div class="left-con">
                        <table class="detailstable">
                            <tr>
                          
                           
                            
                        </table>
                    </div>
                            





                   
                </div>

                <div class="bottom">
                    <button class="btn update"><b>Done</b></button> 
                    <!-- <button class="btn delete"><b>Delete Profile</b></button> -->
                </div>

            </div>

        </div>
    </section>
</section>










<?php
$footer = new Footer();
?>