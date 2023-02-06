<?php
$header = new Header("admin",$data);
$sidebar = new Navigation('admin','customers');
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new ProfileHTML($data);
    ?>
    <div class="body-content">
                <div class="content-data customers">
                    <div>
                        <h2>Customer account verifications</h2>
                        <button class="ceb" onclick="window.open('https://payment.ceb.lk/instantpay', '_blank')">Head Over To CEB</button>
                    </div>
                    <ul>
                        <?php
                            $query = $data['customers'];
                            if(mysqli_num_rows($query) > 0) {
                                while($row = mysqli_fetch_assoc($query)){
                                    echo '<li>
                                                <div class="person">
                                                    <img class="smallerimg" src="'.BASEURL.'/public/img/profile/'.$row['image'].'" alt="">
                                                    <div>
                                                        <h3>'.$row['first_name'].' '.$row['last_name'].'</h3>
                                                        <p class="gray">e-bill number : '.$row['ebill_no'].'</p>
                                                    </div>
                                                    <div class="buttons">
                                                        <button onclick="location.href=\''.BASEURL.'/users/validate/'.$row['user_id'].'/verified"class="btn-blue ">Valid</button>
                                                        <button onclick="location.href=\''.BASEURL.'/users/validate/'.$row['user_id'].'/unverified"class="btn-blue red">Invalid</button>
                                                        <button onclick="location.href=\''.BASEURL.'/profile/preview/customer/'.$row['user_id'].'/profile/admin/customerprofile\'"class="btn-blue">View profile</button>
                                                    <div>
                                                </div>
                                            </li>';
                                }
                            }else{
                                // display image no data
                            }
                        ?>
                        
                    </ul>
                </div>
    </div>
</section>

<?php
$footer = new Footer("admin");
?>