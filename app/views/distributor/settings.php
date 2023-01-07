<?php
$header = new Header("distributor_settings");
$sidebar = new Navigation('distributor',$data['navigation']);
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
                    <h2>Profile</h2>
                </div>

                <div class="con">
                    <div class="left-con">
                        <table class="detailstable">
                            <tr>
                                <td>Distributor ID </td>
                                <td>26</td>
                            </tr>
                            <tr>
                                <td>Distributor Name</td>
                                <td>Mr. Saman Perera</td>
                            </tr>
                            <tr>
                                <td>Email Address</td>
                                <td>saman@gmail.com</td>
                            </tr>
                            <tr>
                                <td>Contact Number</td>
                                <td>0778901221</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>No: 20, Back Street, Nugegoda</td>
                            </tr>
                        </table>
                    </div>

                    <div class="right-con">
                        <ul>
                            <li><b>Profile Picture</b></li>

                            <!-- <li><a href='../settings/profileimg'>img</a></li> -->
                        </ul>

                    </div>
                </div>

                <div class="bottom">
                    <button class="btn update"><b>Update Profile</b></button> 
                    <button class="btn delete"><b>Delete Profile</b></button>
                </div>

            </div>

        </div>
    </section>
</section>




<?php
$footer = new Footer();
?>