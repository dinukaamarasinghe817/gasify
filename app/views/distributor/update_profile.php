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

                <div class="forminfo">
                    <?php echo "Your Distributor ID : $user_id" ?>

                      
                    <form class="newform">
                        <label>Contact Number</label>
                        <input type="tele" placeholder="Contact Number">

                        <label>Address</label>
                        <input type="text" placeholder="Address">

                        <label>Capacity</label>
                        <!-- <input type="number" placeholder="Capacity"> -->
                        <?php 
                            $output = '<table class="table2">
                                <tr>
                                   
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                </tr>';
             
                            $profiles = $data['profiledata'];
                            foreach($profiles as $profile) {
                                $row1 = $profile['info'];
                            
                            $output .= '<tr>
                                            <td>'.$row1['name'].'</td> 
                                            <td>
                                                <input type="number" placeholder="Capacity">
                                            </td>                 
                                        </tr>';

                            }
                            $output .= '</table>';
                            echo $output;
                        ?>
                    </form>
                </div>

                <div class="bottom">
                    <button class="btn updateupdate" type="submit"><b>Done</b></button> 
                    <!-- <button class="btn delete"><b>Delete Profile</b></button> -->
                </div>

            </div>

        </div>
    </section>
</section>










<?php
$footer = new Footer();
?>