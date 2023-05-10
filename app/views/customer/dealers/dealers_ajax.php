<!-- changing part of dealers table -->
<div class="table">
    <table>
        <thead><tr id="first_row"><th>Dealer</th><th>Brand</th><th>Street</th><th>Contact No</th><th></th></tr></thead><tbody>
        <?php

            if(isset($data["dealers"])){
                $result = $data["dealers"];
                //if no dealers found selected city and brand
                if(mysqli_num_rows($result)==0){
                    echo ' <tr><td> </td><td> </td><td><strong>No Dealers Found!</strong></td><td> </td><td> </td></tr>';
                }
                while($dealer = mysqli_fetch_assoc($result)){
                    $url = BASEURL.'/profile/preview/dealer/'.$dealer['dealer_id'].'/profile/customer/viewdealerprofile';
                    echo ' <tr><td>'.$dealer["d_name"].'</td><td>'.$dealer["c_name"].'</td><td>'.$dealer["address"].'</td><td>'.$dealer["contact_no"].'</td><td><button type="submit" class="More_details" onclick = "location.href=\''.$url.'\'">More Details</button></td></tr>';
                }
            
            }
        ?>
       </tbody> 
    </table>
</div>