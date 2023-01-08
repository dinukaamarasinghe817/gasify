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
                    <h2>Profile</h2>
                </div>

                <div class="con">

                    <div class="left-con">
                        <table class="detailstable">
                            <tr>
                            <?php
                                $output = '<td>Distributor ID </td>
                                            <td>'.$user_id.'</td>
                            </tr>';
                                
                              




                                echo $output;

                            ?>
                            

                            <!-- <tr>
                                <td>First Name</td>
                                <td>'.$row1['first'].'</td>
                            </tr>
                            <tr>
                                <td>Last Name</td>
                                <td>'.$row1['last'].'</td>
                            </tr>
                            <tr>
                                <td>Email Address</td>
                                <td>'.$row1['email'].'</td>
                            </tr>
                            <tr>
                                <td>Contact Number</td>
                                <td>'.$row1['contact_no'].'</td>
                            </tr>
                            <tr>
                                <td>City</td>
                                <td>'.$row1['city'].'</td>
                            </tr>
                            <tr>
                                <td>Street</td>
                                <td>'.$row1['street'].'</td>
                            </tr>'; -->
                            
                        </table>
                    </div>
                            





                    <div class="right-con">
                        <ul>
                            <li><b>Profile Picture</b></li>
                            <?php
                                $image = BASEURL.'/public/img/profile/'.$data['image'];
                                $output1 = '
                                <img src="'.$image.'" alt=""> ';
                                echo $output1;
                            ?>
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