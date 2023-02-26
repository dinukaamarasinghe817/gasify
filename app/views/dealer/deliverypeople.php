<?php
$header = new Header("dealer",$data);
$sidebar = new Navigation('dealer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new Body($data);
    ?>
    <section class="body-content">
                <div class="top-panel">
                    <ul>
                        <?php
                        if($data['option'] == 'all'){
                            echo '<li><a href="'.BASEURL.'/delvery/getdeliverypeople/all" class="current active">All delivery people</a></li>
                            <li><a href="'.BASEURL.'/delvery/getdeliverypeople/current" class="current">Ongoing delivery people</a></li>';
                        }else{
                            echo '<li><a href="'.BASEURL.'/delvery/getdeliverypeople/all" class="current">All delivery people</a></li>
                            <li><a href="'.BASEURL.'/delvery/getdeliverypeople/current" class="current active">Ongoing delivery people</a></li>';
                        }
                        ?>
                    </ul>
                </div>
                <div class="content-data">
                    <ul>
                        <?php
                            $query = $data['query'];
                            if(mysqli_num_rows($query) > 0) {
                                while($row = mysqli_fetch_assoc($query)){
                                    echo '<li>
                                                <div class="person">
                                                    <img src="'.BASEURL.'/public/img/profile/'.$row['image'].'" alt="">
                                                    <div>
                                                        <h3>'.$row['first_name'].' '.$row['last_name'].'</h3>
                                                        <p class="gray">contact : '.$row['contact_no'].'</p>
                                                    </div>
                                                    <button onclick="location.href=\''.BASEURL.'/profile/preview/delivery/'.$row['user_id'].'/profile/dealer/deliveryprofile\'"class="btn-blue">View profile</button>
                                                </div>
                                            </li>';
                                }
                            }else{
                                // display image no data
                            }
                        ?>
                        
                    </ul>
                </div>
    </section>
</section>

<?php
$footer = new Footer("dealer");
?>