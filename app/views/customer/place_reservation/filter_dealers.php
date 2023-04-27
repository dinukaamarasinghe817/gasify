<!-- changing part dealer dropdown after select city and brand -->
<div class="img">
    <svg width="106" height="166" viewBox="0 0 124 111" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M31 27.75C31 20.3902 34.2661 13.3319 40.0797 8.12779C45.8933 2.92365 53.7783 0 62 0C70.2217 0 78.1067 2.92365 83.9203 8.12779C89.7339 13.3319 93 20.3902 93 27.75V38.85C93 46.2098 89.7339 53.2681 83.9203 58.4722C78.1067 63.6763 70.2217 66.6 62 66.6C53.7783 66.6 45.8933 63.6763 40.0797 58.4722C34.2661 53.2681 31 46.2098 31 38.85V27.75ZM0 92.574C18.8388 82.8063 40.2293 77.6746 62 77.7C84.568 77.7 105.772 83.0835 124 92.574V111H0V92.574Z" fill=""/>
    </svg>
</div>
<div class="title">Dealer</div>
<div class="drop-down">
    <div class="dealer_dropdown">
        <select name="dealer" id="dealer" class="dealerdropdown dropdowndate" onchange = "get_dealer_value('dealer');">
            
            <?php
                if(isset($data["dealers"])){
                    $result1 = $data["dealers"];
                    //check previous selected city is already exists
                    if(isset($_SESSION['dealer_id'])){
                        $old_dealer_id = $_SESSION['dealer_id'];  //take exist dealer_id from session
                        while($dealers = mysqli_fetch_assoc($result1)){    
                            $name = $dealers["d_name"];
                            $dealer_id = $dealers["dealer_id"];
                            //display that exist brand as selected value in dropdown
                            if($dealer_id==$old_dealer_id){
                                echo "<option value = $old_dealer_id id= $old_dealer_id> $name </option>";
                                //after that unset past session variable
                                unset($_SESSION['dealer_id']);
                            }
                            //display other brands as options in dropdown list 
                            else{
                                $dealer_id = $dealers["dealer_id"];
                                echo "<option value = $dealer_id id= $dealer_id> $name </option>"; 
                            }

                        }

                    }
                    //if there is no previous selected brand
                    else{
                        echo '<option value="-1" selected disabled hidden>Select Dealer</option>';
                        //if no dealers found according to selected city and brand(no previous selected dealer also)
                        if(mysqli_num_rows($result1)==0){
                            echo '<option value="-1" disabled>No Dealers Found!</option>';
                        }else{
                            while($dealers = mysqli_fetch_assoc($result1)){    
                                $name = $dealers["d_name"];
                                $dealer_id = $dealers["dealer_id"];
                                echo "<option value = $dealer_id id= $dealer_id> $name </option>";
                            }
                        }
                    }
                }
            ?>
    
        </select>
    </div>
</div>
