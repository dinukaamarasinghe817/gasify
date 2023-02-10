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
                                                        <p class="gray">e-bill number : '.$row['ebill_no'].'
                                                        <input class="copy-text" type="hidden" value="'.$row['ebill_no'].'">
                                                        <a><svg width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M19 8.34961H10C8.89543 8.34961 8 9.28981 8 10.4496V19.8996C8 21.0594 8.89543 21.9996 10 21.9996H19C20.1046 21.9996 21 21.0594 21 19.8996V10.4496C21 9.28981 20.1046 8.34961 19 8.34961Z" stroke="#D6D6D6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M4 14.65H3C2.46957 14.65 1.96086 14.4287 1.58579 14.0349C1.21071 13.6411 1 13.107 1 12.55V3.1C1 2.54305 1.21071 2.0089 1.58579 1.61508C1.96086 1.22125 2.46957 1 3 1H12C12.5304 1 13.0391 1.22125 13.4142 1.61508C13.7893 2.0089 14 2.54305 14 3.1V4.15" stroke="#D6D6D6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg></a>
                                                        </p>
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
<script>

    let copies = document.querySelectorAll(".person div a");
    let copytextvalues = document.querySelectorAll(".person div .copy-text");
    for(i=0; i<copies.length; i++) {
        let j = i;
        copies[j].addEventListener("click", function(){
            // console.log(copies[j]);
            navigator.clipboard.writeText(copytextvalues[j].value);
        })
    }
</script>
<?php
$footer = new Footer("admin");
?>