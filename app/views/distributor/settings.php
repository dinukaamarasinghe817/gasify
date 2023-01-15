<?php
$header = new Header("distributor_settings");
$sidebar = new Navigation('distributor',$data['navigation']);

$user_id = $_SESSION['user_id'];
?>

<section class="body">
    <?php 
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
                                <th class="th1"><b>Your Details : </b></th>
                                <th class="th2"></th>
                            </tr>
                            <tr>
                                <?php
                                    $output = '<td>Distributor ID </td>
                                                <td>'.$user_id.'</td>
                            </tr>';

                            $profiles = $data['profile'];

                            foreach($profiles as $profile) {
                                $row1 = $profile['profileinfo'];
                                $capacities = $profile['capacities'];
                                $output .= '
                            <tr>
                                <td>Name</td>
                                
                            </tr>

                            <tr>
                                <td>Email Address</td>
                              
                                                           
                            </tr>

                            <tr>
                                <td>Contact Number</td>
                                <td>'.$row1['contact_no'].'</td>
                                
                            </tr>

                            <tr>
                                <td>Address</td>
                                <td>'.$row1['address'].'</td>
                            </tr>

                            <tr>
                                <td>Capacities</td>
                                <td>
                                    <table class="table2">
                                        <tr>
                                            <th class="tablet1">Product Name</th>
                                            <th class="tablet2">Capacity</th>
                                         </tr>
                                ';
                                foreach($capacities as $capacity) {
                                    $row3 = $capacity;
                                    $output .= '
                                        <tr>
                                            <td>'.$row3['product_name'].'</td>
                                            <td>'.$row3['capacity'].'</td>
                                        </tr>';
                                }
                                    $output .= '</table>
                                </td>
                            </tr>';        
                            }
                            $output .= '</table>';
                            echo $output;

                                ?>
                        </table>
                    </div>

                    <div class="right-con">
                        <ul>
                            <li><b>Profile Picture</b></li>
                            <?php
                                $image = BASEURL.'/public/img/profile/'.$data['image'];
                                $output1 = '
                                <img src="'.$image.'" alt="" class="ppimg"> ';
                                echo $output1;
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="bottom">
                    <button class="btn update" onclick="document.location.href='../settings/updateprofile';"><b>Update Profile</b></button> 
                    <!-- <button class="btn update" onclick="<?php echo BASEURL;?>/settings/updateprofile"><b>Update Profile</b></button>  -->
                    <button class="btn delete"><b>Delete Profile</b></button>
                </div>

            </div>

        </div>
    </section>
</section>




<?php
$footer = new Footer();
?>