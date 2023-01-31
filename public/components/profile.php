<?php
class ProfileHTML{
    function __construct($data){
        $profilemode = $data['mode'].''.$data['user'];
        $this->$profilemode($data);
    }

    function previewdealer($data){
        $row = mysqli_fetch_assoc($data['query']);
        echo '<section class="body-content">
                    <div class="content-data profile">
                        <div class="prof-nav">
                            <img src="'.BASEURL.'/public/img/profile/'.$row['image'].'" alt="">
                            <h3>'.$row['first_name'].' '.$row['last_name'].'</h3>
                            <p class="gray">'.$row['email'].'</p>
                            <ul>
                                <li>';
                                if($data['tab']=='profile'){
                                    echo '<a class="active" href="'.BASEURL.'/profile/preview/dealer/'.$row['user_id'].'/profile/'.$data['viewfolder'].'/'.$data['viewfile'].'" onclick="profile()">Profile</a>';
                                }else{
                                    echo '<a class="" href="'.BASEURL.'/profile/preview/dealer/'.$row['user_id'].'/profile/'.$data['viewfolder'].'/'.$data['viewfile'].'" onclick="profile()">Profile</a>';
                                }
                                echo '</li>
                                <li>';
                                if($data['tab'] == 'bank'){
                                    echo '<a class="active" href="'.BASEURL.'/profile/preview/dealer/'.$row['user_id'].'/bank/'.$data['viewfolder'].'/'.$data['viewfile'].'">Bank Details</a>';
                                }else{
                                    echo '<a href="'.BASEURL.'/profile/preview/dealer/'.$row['user_id'].'/bank/'.$data['viewfolder'].'/'.$data['viewfile'].'">Bank Details</a>';
                                }
                                echo '</li>
                                <li>';
                                if($data['tab'] == 'stock'){
                                    echo '<a class="active" href="'.BASEURL.'/profile/preview/dealer/'.$row['user_id'].'/stock/'.$data['viewfolder'].'/'.$data['viewfile'].'">Stock</a>';
                                }else{
                                    echo '<a href="'.BASEURL.'/profile/preview/dealer/'.$row['user_id'].'/stock/'.$data['viewfolder'].'/'.$data['viewfile'].'">Stock</a>';
                                }
                                echo '</li>
                            </ul>
                        </div>
                        <div class="prof-info">
                            <h2>Profile Information</h2>';
                        if($data['tab']== 'bank'){
                            echo '<form class="bank" action="#" method="post">
                                <div>
                                    <div class="input half"><label>Bank</label><input type="text" name="bank" placeholder="bank" value="'.$row['bank'].'" readonly></div>
                                    <div class="input half"><label>Account Number</label><input type="text" name="account_no" placeholder="account number" value="'.$row['account_no'].'" readonly></div>
                                </div>
                            </form>';
                        }else if($data['tab']=='profile'){
                            echo '<form class="profile" action="#" enctype="multipart/form-data" method="post">
                                
                                <div class="input"><label>Dealer Name</label><input type="text" name="last_name" placeholder="last name" value="'.$row['first_name'].' '.$row['last_name'].'" readonly></div>
                                <div class="input"><label>Address</label><input type="text" name="street" placeholder="address" value="'.$row['street'].', '.$row['city'].'" readonly></div>
                                <div class="input"><label>Store Name</label><input type="text" name="name" placeholder="store name" value="'.$row['store_name'].'" readonly></div>
                                <div class="input"><label>Company Working</label><input type="text" name="company" placeholder="company" value="'.$row['company'].'" readonly></div>
                                <div class="input"><label>Distributor Assigned</label><input type="text" name="distributor" placeholder="distributor" value="'.$row['distributor'].'" readonly></div>
                                <div class="input"><label>Contact Number</label><input type="text" name="contact_no" placeholder="contact number" value="'.$row['contact_no'].'" readonly></div>
                            </form>';
                        }else if($data['tab']=='stock'){
                            echo '<form class="business" action="#" method="post">';
                                do{
                                    echo '<div class="pcap"><img src="'.BASEURL.'/public/img/products/'.$row['product_image'].'" alt="">
                                    <div class="input half"><label><strong>Product Name : </strong>'.$row['product_name'].'</label><label><strong>Number of cylinders</strong></label><input type="text" name="'.$row['product_id'].'" value="'.$row['quantity'].'" readonly></div></div>';
                                }while($row = mysqli_fetch_assoc($data['query']));
                                echo '</form>';
                        }
                        echo '</div>
                    </div>
            </section>';
            
            echo '<script>';
            // echo 'const form = document.querySelector(".prof-info form");
            //     form.onsubmit = (e)=>{
            //         e.preventDefault();
            //     }';
            echo '
                document.querySelector(".file input").onchange = function(){
                    document.querySelector(".prof-nav img").src = URL.createObjectURL(this.files[0]);
                }
            </script>';
    }

    function previewdistributor($data){
        $row = mysqli_fetch_assoc($data['query']);
        echo '<section class="body-content">
                    <div class="content-data profile">
                        <div class="prof-nav">
                            <img src="'.BASEURL.'/public/img/profile/'.$row['image'].'" alt="">
                            <h3>'.$row['first_name'].' '.$row['last_name'].'</h3>
                            <p class="gray">'.$row['email'].'</p>
                            <ul>
                                <li>';
                                if($data['tab']=='profile'){
                                    echo '<a class="active" href="'.BASEURL.'/profile/preview/distributor/'.$row['user_id'].'/profile/'.$data['viewfolder'].'/'.$data['viewfile'].'" onclick="profile()">Profile</a>';
                                }else{
                                    echo '<a class="" href="'.BASEURL.'/profile/preview/distributor/'.$row['user_id'].'/profile/'.$data['viewfolder'].'/'.$data['viewfile'].'" onclick="profile()">Profile</a>';
                                }
                                echo '</li>
                                <li>';
                                if($data['tab'] == 'stock'){
                                    echo '<a class="active" href="'.BASEURL.'/profile/preview/distributor/'.$row['user_id'].'/stock/'.$data['viewfolder'].'/'.$data['viewfile'].'">Stock</a>';
                                }else{
                                    echo '<a href="'.BASEURL.'/profile/preview/distributor/'.$row['user_id'].'/stock/'.$data['viewfolder'].'/'.$data['viewfile'].'">Stock</a>';
                                }
                                echo '</li>
                            </ul>
                        </div>
                        <div class="prof-info">
                            <h2>Profile Information</h2>';
                        if($data['tab']=='profile'){
                            echo '<form class="profile" action="#" enctype="multipart/form-data" method="post">
                                
                                <div class="input"><label>Distributor Name</label><input type="text" name="last_name" placeholder="last name" value="'.$row['first_name'].' '.$row['last_name'].'" readonly></div>
                                <div class="input"><label>Address</label><input type="text" name="street" placeholder="address" value="'.$row['street'].', '.$row['city'].'" readonly></div>
                                <div class="input"><label>Company Working</label><input type="text" name="company" placeholder="company" value="'.$row['company'].'" readonly></div>
                                <div class="input"><label>Average distribute time (days)</label><input type="text" name="hold_time" placeholder="hold_time" value="'.$row['hold_time'].'" readonly></div>
                                <div class="input"><label>Contact Number</label><input type="text" name="contact_no" placeholder="contact number" value="'.$row['contact_no'].'" readonly></div>
                            </form>';
                        }else if($data['tab']=='stock'){
                            echo '<form class="business" action="#" method="post">';
                                do{
                                    echo '<div class="pcap"><img src="'.BASEURL.'/public/img/products/'.$row['product_image'].'" alt="">
                                    <div class="input half"><label><strong>Product Name : </strong>'.$row['product_name'].'</label><label><strong>Number of cylinders</strong></label><input type="text" name="'.$row['product_id'].'" value="'.$row['quantity'].'" readonly></div></div>';
                                }while($row = mysqli_fetch_assoc($data['query']));
                                echo '</form>';
                        }
                        echo '</div>
                    </div>
            </section>';
            
            echo '<script>';
            // echo 'const form = document.querySelector(".prof-info form");
            //     form.onsubmit = (e)=>{
            //         e.preventDefault();
            //     }';
            echo '
                document.querySelector(".file input").onchange = function(){
                    document.querySelector(".prof-nav img").src = URL.createObjectURL(this.files[0]);
                }
            </script>';
    }

    function previewcompany($data){
        $row = mysqli_fetch_assoc($data['query']);
        echo '<section class="body-content">
                    <div class="content-data profile">
                        <div class="prof-nav">
                            <img src="'.BASEURL.'/public/img/profile/'.$row['logo'].'" alt="">
                            <h3>'.$row['company_name'].'</h3>
                            <p class="gray">'.$row['email'].'</p>
                            <ul>
                                <li>';
                                if($data['tab']=='profile'){
                                    echo '<a class="active" href="'.BASEURL.'/profile/preview/company/'.$row['user_id'].'/profile/company/profile" onclick="profile()">Profile</a>';
                                }else{
                                    echo '<a class="" href="'.BASEURL.'/profile/preview/company/'.$row['user_id'].'/profile/company/profile" onclick="profile()">Profile</a>';
                                }
                                echo '</li>
                            </ul>
                        </div>
                        <div class="prof-info">
                            <h2>Profile Settings</h2>';
                        if($data['tab']=='profile'){
                            echo '<form class="profile" action="#" enctype="multipart/form-data" method="post">
                                <div class="input"><label>Company Name</label><input type="text" name="company" placeholder="company" value="'.$row['name'].'" readonly></div>
                                <div>
                                    <div class="input half"><label>First Name</label><input type="text" name="first_name" placeholder="first name" value="'.$row['first_name'].'" readonly></div>
                                    <div class="input half"><label>Last Name</label><input type="text" name="last_name" placeholder="last name" value="'.$row['last_name'].'" readonly></div>
                                </div>
                                <div>
                                    <div class="input half"><label>City</label><input type="text" name="city" placeholder="city" value="'.$row['city'].'" readonly></div>
                                    <div class="input half"><label>Address</label><input type="text" name="street" placeholder="address" value="'.$row['street'].'" readonly></div>
                                </div>
                            </form>';
                        }
                        echo '</div>
                    </div>
            </section>';
            
            echo '<script>';
            // echo 'const form = document.querySelector(".prof-info form");
            //     form.onsubmit = (e)=>{
            //         e.preventDefault();
            //     }';
            echo '
                document.querySelector(".file input").onchange = function(){
                    document.querySelector(".prof-nav img").src = URL.createObjectURL(this.files[0]);
                }
            </script>';
    }

    function previewdelivery($data){
        $row = mysqli_fetch_assoc($data['query']);
        echo '<section class="body-content">
                    <div class="content-data profile">
                        <div class="prof-nav">
                            <img src="'.BASEURL.'/public/img/profile/'.$row['image'].'" alt="">
                            <h3>'.$row['first_name'].' '.$row['last_name'].'</h3>
                            <p class="gray">'.$row['email'].'</p>
                            <ul>
                                <li>';
                                if($data['tab']=='profile'){
                                    echo '<a class="active" href="'.BASEURL.'/profile/preview/delivery/'.$row['user_id'].'/profile/delivery/profile" onclick="profile()">Profile</a>';
                                }else{
                                    echo '<a class="" href="'.BASEURL.'/profile/preview/delivery/'.$row['user_id'].'/profile/delivery/profile" onclick="profile()">Profile</a>';
                                }
                                echo '</li>
                            </ul>
                        </div>
                        <div class="prof-info">
                            <h2>Profile Settings</h2>';
                        if($data['tab']=='profile'){
                            echo '<form class="profile" action="#" enctype="multipart/form-data" method="post">
                                <div>
                                    <div class="input half"><label>First Name</label><input type="text" name="first_name" placeholder="first name" value="'.$row['first_name'].'" readonly></div>
                                    <div class="input half"><label>Last Name</label><input type="text" name="last_name" placeholder="last name" value="'.$row['last_name'].'" readonly></div>
                                </div>
                                <div>
                                    <div class="input half"><label>City</label><input type="text" name="city" placeholder="city" value="'.$row['city'].'" readonly></div>
                                    <div class="input half"><label>Address</label><input type="text" name="street" placeholder="address" value="'.$row['street'].'" readonly></div>
                                </div>
                                <div>
                                    <div class="input half"><label>Vehicle Type</label><input type="text" name="vehicle_type" placeholder="vehicle type" value="'.$row['vehicle_type'].'" readonly></div>
                                    <div class="input half"><label>Vehicle Number</label><input type="text" name="vehicle_no" placeholder="vehicle number" value="'.$row['vehicle_no'].'" readonly></div>
                                </div>
                                <div>
                                    <div class="input half"><label>Weight Limit</label><input type="number" name="weight_limit" placeholder="weight limit" min=0 step=1 value="'.$row['weight_limit'].'" readonly></div>
                                    <div class="input half"><label>Cost per km</label><input type="number" name="cost_per_km" placeholder="cost per km" min=0 step=1 value="'.$row['cost_per_km'].'" readonly></div>
                                </div>
                            </form>';
                        }
                        echo '</div>
                    </div>
            </section>';
            
            echo '<script>';
            // echo 'const form = document.querySelector(".prof-info form");
            //     form.onsubmit = (e)=>{
            //         e.preventDefault();
            //     }';
            echo '
                document.querySelector(".file input").onchange = function(){
                    document.querySelector(".prof-nav img").src = URL.createObjectURL(this.files[0]);
                }
            </script>';
    }

    function previewcustomer($data){
        $row = mysqli_fetch_assoc($data['query']);
        echo '<section class="body-content">
                    <div class="content-data profile">
                        <div class="prof-nav">
                            <img src="'.BASEURL.'/public/img/profile/'.$row['image'].'" alt="">
                            <h3>'.$row['first_name'].' '.$row['last_name'].'</h3>
                            <p class="gray">'.$row['email'].'</p>
                            <ul>
                                <li>';
                                if($data['tab']=='profile'){
                                    echo '<a class="active" href="'.BASEURL.'/profile/preview/customer/'.$row['user_id'].'/profile/'.$data['viewfolder'].'/'.$data['viewfile'].'" onclick="profile()">Profile</a>';
                                }else{
                                    echo '<a class="" href="'.BASEURL.'/profile/preview/customer/'.$row['user_id'].'/profile/'.$data['viewfolder'].'/'.$data['viewfile'].'" onclick="profile()">Profile</a>';
                                }
                                echo '</li>
                            </ul>
                        </div>
                        <div class="prof-info">
                            <h2>Profile Information</h2>';
                        if($data['tab']=='profile'){
                            echo '<form class="profile" action="#" enctype="multipart/form-data" method="post">
                                <div class="input"><label>Customer Name</label><input type="text" name="first_name" placeholder="first name" value="'.$row['first_name'].' '.$row['last_name'].'" readonly></div>
                                <div class="input"><label>Address</label><input type="text" name="street" placeholder="address" value="'.$row['street'].', '.$row['city'].'" readonly></div>
                                <div class="input"><label>Contact Number</label><input type="text" name="contact_no" placeholder="contact number" value="'.$row['contact_no'].'" readonly></div>
                                <div class="input"><label>User Type</label><input type="text" name="type" placeholder="user type" value="'.$row['type'].'" readonly></div>
                            </form>';
                        }
                        echo '</div>
                    </div>
            </section>';
            
            echo '<script>';
            // echo 'const form = document.querySelector(".prof-info form");
            //     form.onsubmit = (e)=>{
            //         e.preventDefault();
            //     }';
            echo '
                document.querySelector(".file input").onchange = function(){
                    document.querySelector(".prof-nav img").src = URL.createObjectURL(this.files[0]);
                }
            </script>';
    }

    function editdealer($data){
        $row = mysqli_fetch_assoc($data['query']);
        echo '<section class="body-content">
                    <div class="content-data profile">
                        <div class="prof-nav">
                            <img src="'.BASEURL.'/public/img/profile/'.$row['image'].'" alt="">
                            <h3>'.$row['first_name'].' '.$row['last_name'].'</h3>
                            <p class="gray">'.$row['email'].'</p>
                            <ul>
                                <li>';
                                if($data['tab']=='profile'){
                                    echo '<a class="active" href="'.BASEURL.'/profile/edit/dealer/'.$row['user_id'].'/profile/dealer/profile" onclick="profile()">Profile</a>';
                                }else{
                                    echo '<a class="" href="'.BASEURL.'/profile/edit/dealer/'.$row['user_id'].'/profile/dealer/profile" onclick="profile()">Profile</a>';
                                }
                                echo '</li>
                                <li>';
                                if($data['tab'] == 'bank'){
                                    echo '<a class="active" href="'.BASEURL.'/profile/edit/dealer/'.$row['user_id'].'/bank/dealer/profile">Bank Details</a>';
                                }else{
                                    echo '<a href="'.BASEURL.'/profile/edit/dealer/'.$row['user_id'].'/bank/dealer/profile">Bank Details</a>';
                                }
                                echo '</li>
                                <li>';
                                if($data['tab'] == 'capacity'){
                                    echo '<a class="active" href="'.BASEURL.'/profile/edit/dealer/'.$row['user_id'].'/capacity/dealer/profile">Capacity</a>';
                                }else{
                                    echo '<a href="'.BASEURL.'/profile/edit/dealer/'.$row['user_id'].'/capacity/dealer/profile">Capacity</a>';
                                }
                                echo '</li>
                                <li>';
                                if($data['tab'] == 'security'){
                                    echo '<a class="active" href="'.BASEURL.'/profile/edit/dealer/'.$row['user_id'].'/security/dealer/profile">Security</a>';
                                }else{
                                    echo '<a href="'.BASEURL.'/profile/edit/dealer/'.$row['user_id'].'/security/dealer/profile">Security</a>';
                                }
                                echo '</li>
                            </ul>
                        </div>
                        <div class="prof-info">
                            <h2>Profile Settings</h2>';
                        if($data['tab']== 'bank'){
                            echo '<form class="bank" action="'.BASEURL.'/profile/update/bank" method="post">
                                <div>
                                    <div class="input half"><label>Bank</label>
                                    <select id="city" class="dropdowndate" name="bank" class="half">';
                                        $banks = BANKS;
                                        foreach($banks as $bank){
                                            if($bank == $row['bank']){
                                                echo '<option value="'.$bank.'" selected >'.$bank.'</option>';
                                            }else{
                                                echo '<option value="'.$bank.'">'.$bank.'</option>';
                                            }
                                        }
                                echo '</select>
                                    </div>
                                    <div class="input half"><label>Account Number</label><input type="text" name="account_no" placeholder="account number" value="'.$row['account_no'].'"></div>
                                </div>
                                <div class="input"><label>Payhere merchant ID</label><input type="text" name="merchant_id" placeholder="merchant id" value="'.$row['merchant_id'].'"></div>
                                <button class="button" type="submit">Save</button>
                            </form>';
                        }else if($data['tab']=='profile'){
                            echo '<form class="profile" action="'.BASEURL.'/profile/update/profile" enctype="multipart/form-data" method="post">
                                <div>
                                    <div class="input half"><label>First Name</label><input type="text" name="first_name" placeholder="first name" value="'.$row['first_name'].'"></div>
                                    <div class="input half"><label>Last Name</label><input type="text" name="last_name" placeholder="last name" value="'.$row['last_name'].'"></div>
                                </div>
                                <div>
                                    <div class="input half"><label>City</label><input type="text" name="city" placeholder="city" value="'.$row['city'].'"></div>
                                    <div class="input half"><label>Address</label><input type="text" name="street" placeholder="address" value="'.$row['street'].'"></div>
                                </div>
                                <div class="input"><label>Store Name</label><input type="text" name="name" placeholder="store name" value="'.$row['store_name'].'"></div>
                                <div class="input"><label>Company</label><input type="text" name="company" placeholder="company" value="'.$row['company'].'" readonly></div>
                                <div class="input"><label>Distributor</label><input type="text" name="distributor" placeholder="distributor" value="'.$row['distributor'].'" readonly></div>
                                <div class="input"><label>Contact Number</label><input type="text" name="contact_no" placeholder="contact number" value="'.$row['contact_no'].'"></div>
                                <div class="input file"><label>Profile Image</label><input type="file" name="image" accept=".png, .jpg, .jpeg"></div>
                                <button class="button" type="submit">Save</button>
                            </form>';
                        }else if($data['tab']=='security'){
                            echo '<form class="passwords" action="'.BASEURL.'/profile/update/security" method="post">
                                <div class="input"><label>Current Password</label><input type="password" name="current_password" placeholder="Enter current password"></div>
                                <div>
                                    <div class="input half"><label>New Password</label><input type="password" name="new_password" placeholder="Enter new password"></div>
                                    <div class="input half"><label>Confirm New Password</label><input type="password" name="confirm_password" placeholder="Confirm new password" ></div>
                                </div>
                                <button class="button">Save</button>
                            </form>';
                        }else if($data['tab']=='capacity'){
                            echo '<form class="business" action="'.BASEURL.'/profile/update/capacity" method="post">';
                                do{
                                    echo '<div class="pcap"><img src="'.BASEURL.'/public/img/products/'.$row['product_image'].'" alt="">
                                    <div class="input half"><label>'.$row['product_name'].'</label><input type="number" name="'.$row['product_id'].'" min='.$row['capacity'].' step=1 value="'.$row['capacity'].'"></div></div>';
                                }while($row = mysqli_fetch_assoc($data['query']));
                                echo '<button class="button" type="submit">Save</button>
                            </form>';
                        }
                        echo '</div>
                    </div>
            </section>';
            
            echo '<script>';
            // echo 'const form = document.querySelector(".prof-info form");
            //     form.onsubmit = (e)=>{
            //         e.preventDefault();
            //     }';
            echo '
                document.querySelector(".file input").onchange = function(){
                    document.querySelector(".prof-nav img").src = URL.createObjectURL(this.files[0]);
                }
            </script>';
    }

    function editdistributor($data){
        $row = mysqli_fetch_assoc($data['query']);
        echo '<section class="body-content">
                    <div class="content-data profile">
                        <div class="prof-nav">
                            <img src="'.BASEURL.'/public/img/profile/'.$row['image'].'" alt="">
                            <h3>'.$row['first_name'].' '.$row['last_name'].'</h3>
                            <p class="gray">'.$row['email'].'</p>
                            <ul>
                                <li>';
                                if($data['tab']=='profile'){
                                    echo '<a class="active" href="'.BASEURL.'/profile/edit/distributor/'.$row['user_id'].'/profile/distributor/profile" onclick="profile()">Profile</a>';
                                }else{
                                    echo '<a class="" href="'.BASEURL.'/profile/edit/distributor/'.$row['user_id'].'/profile/distributor/profile" onclick="profile()">Profile</a>';
                                }
                                echo '</li>
                                <li>';
                                if($data['tab'] == 'capacity'){
                                    echo '<a class="active" href="'.BASEURL.'/profile/edit/distributor/'.$row['user_id'].'/capacity/distributor/profile">Capacity</a>';
                                }else{
                                    echo '<a href="'.BASEURL.'/profile/edit/distributor/'.$row['user_id'].'/capacity/distributor/profile">Capacity</a>';
                                }
                                echo '</li>
                                <li>';
                                if($data['tab'] == 'security'){
                                    echo '<a class="active" href="'.BASEURL.'/profile/edit/distributor/'.$row['user_id'].'/security/distributor/profile">Security</a>';
                                }else{
                                    echo '<a href="'.BASEURL.'/profile/edit/distributor/'.$row['user_id'].'/security/distributor/profile">Security</a>';
                                }
                                echo '</li>
                            </ul>
                        </div>
                        <div class="prof-info">
                            <h2>Profile Settings</h2>';
                        if($data['tab']=='profile'){
                            echo '<form class="profile" action="'.BASEURL.'/profile/update/profile" enctype="multipart/form-data" method="post">
                                <div>
                                    <div class="input half"><label>First Name</label><input type="text" name="first_name" placeholder="first name" value="'.$row['first_name'].'"></div>
                                    <div class="input half"><label>Last Name</label><input type="text" name="last_name" placeholder="last name" value="'.$row['last_name'].'"></div>
                                </div>
                                <div>
                                    <div class="input half"><label>City</label><input type="text" name="city" placeholder="city" value="'.$row['city'].'" readonly></div>
                                    <div class="input half"><label>Address</label><input type="text" name="street" placeholder="address" value="'.$row['street'].'"></div>
                                </div>
                                <div class="input"><label>Contact Number</label><input type="text" name="contact_no" placeholder="contact number" value="'.$row['contact_no'].'"></div>
                                <div class="input"><label>Company</label><input type="text" name="company" placeholder="company" value="'.$row['company'].'" readonly></div>
                                <div class="input"><label>Average Distribute time (days)</label><input type="number" name="hold_time" placeholder="average distribute time" value="'.$row['hold_time'].'" readonly></div>
                                <div class="input file"><label>Profile Image</label><input type="file" name="image" accept=".png, .jpg, .jpeg"></div>
                                <button class="button" type="submit">Save</button>
                            </form>';
                        }else if($data['tab']=='security'){
                            echo '<form class="passwords" action="'.BASEURL.'/profile/update/security" method="post">
                                <div class="input"><label>Current Password</label><input type="password" name="current_password" placeholder="Enter current password"></div>
                                <div>
                                    <div class="input half"><label>New Password</label><input type="password" name="new_password" placeholder="Enter new password"></div>
                                    <div class="input half"><label>Confirm New Password</label><input type="password" name="confirm_password" placeholder="Confirm new password" ></div>
                                </div>
                                <button class="button">Save</button>
                            </form>';
                        }else if($data['tab']=='capacity'){
                            echo '<form class="business" action="'.BASEURL.'/profile/update/capacity" method="post">';
                                do{
                                    echo '<div class="pcap"><img src="'.BASEURL.'/public/img/products/'.$row['product_image'].'" alt="">
                                    <div class="input half"><label>'.$row['product_name'].'</label><input type="number" name="'.$row['product_id'].'" min='.$row['capacity'].' step=1 value="'.$row['capacity'].'"></div></div>';
                                }while($row = mysqli_fetch_assoc($data['query']));
                                echo '<button class="button" type="submit">Save</button>
                            </form>';
                        }
                        echo '</div>
                    </div>
            </section>';
            
            echo '<script>';
            // echo 'const form = document.querySelector(".prof-info form");
            //     form.onsubmit = (e)=>{
            //         e.preventDefault();
            //     }';
            echo '
                document.querySelector(".file input").onchange = function(){
                    document.querySelector(".prof-nav img").src = URL.createObjectURL(this.files[0]);
                }
            </script>';
    }

    function editcompany($data){
        $row = mysqli_fetch_assoc($data['query']);
        echo '<section class="body-content">
                    <div class="content-data profile">
                        <div class="prof-nav">
                            <img src="'.BASEURL.'/public/img/profile/'.$row['logo'].'" alt="">
                            <h3>'.$row['name'].'</h3>
                            <p class="gray">'.$row['email'].'</p>
                            <ul>
                                <li>';
                                if($data['tab']=='profile'){
                                    echo '<a class="active" href="'.BASEURL.'/profile/edit/company/'.$row['user_id'].'/profile/company/profile" onclick="profile()">Profile</a>';
                                }else{
                                    echo '<a class="" href="'.BASEURL.'/profile/edit/company/'.$row['user_id'].'/profile/company/profile" onclick="profile()">Profile</a>';
                                }
                                echo '</li>
                                <li>';
                                if($data['tab'] == 'security'){
                                    echo '<a class="active" href="'.BASEURL.'/profile/edit/company/'.$row['user_id'].'/security/company/profile">Security</a>';
                                }else{
                                    echo '<a href="'.BASEURL.'/profile/edit/company/'.$row['user_id'].'/security/company/profile">Security</a>';
                                }
                                echo '</li>
                            </ul>
                        </div>
                        <div class="prof-info">
                            <h2>Profile Settings</h2>';
                        if($data['tab']=='profile'){
                            echo '<form class="profile" action="'.BASEURL.'/profile/update/profile" enctype="multipart/form-data" method="post">
                                <div class="input"><label>Company Name</label><input type="text" name="company_name" placeholder="company name" value="'.$row['name'].'"></div>
                                <div>
                                    <div class="input half"><label>First Name</label><input type="text" name="first_name" placeholder="first name" value="'.$row['first_name'].'"></div>
                                    <div class="input half"><label>Last Name</label><input type="text" name="last_name" placeholder="last name" value="'.$row['last_name'].'"></div>
                                </div>
                                <div>
                                    <div class="input half"><label>City</label>
                                    <select id="city" class="dropdowndate" name="city" class="half">';
                                        $cities = CITIES;
                                        foreach($cities as $city){
                                            if($city == $row['city']){
                                                echo '<option value="'.$city.'" selected >'.$city.'</option>';
                                            }else{
                                                echo '<option value="'.$city.'">'.$city.'</option>';
                                            }
                                        }
                                echo '</select>
                                    </div>
                                    <div class="input half"><label>Address</label><input type="text" name="street" placeholder="address" value="'.$row['street'].'"></div>
                                </div>
                                <div class="input file"><label>Profile Image</label><input type="file" name="image" accept=".png, .jpg, .jpeg"></div>
                                <button class="button" type="submit">Save</button>
                            </form>';
                        }else if($data['tab']=='security'){
                            echo '<form class="passwords" action="'.BASEURL.'/profile/update/security" method="post">
                                <div class="input"><label>Current Password</label><input type="password" name="current_password" placeholder="Enter current password"></div>
                                <div>
                                    <div class="input half"><label>New Password</label><input type="password" name="new_password" placeholder="Enter new password"></div>
                                    <div class="input half"><label>Confirm New Password</label><input type="password" name="confirm_password" placeholder="Confirm new password" ></div>
                                </div>
                                <button class="button">Save</button>
                            </form>';
                        }
                        echo '</div>
                    </div>
            </section>';
            
            echo '<script>';
            // echo 'const form = document.querySelector(".prof-info form");
            //     form.onsubmit = (e)=>{
            //         e.preventDefault();
            //     }';
            echo '
                document.querySelector(".file input").onchange = function(){
                    document.querySelector(".prof-nav img").src = URL.createObjectURL(this.files[0]);
                }
            </script>';
    }

    function editdelivery($data){
        $row = mysqli_fetch_assoc($data['query']);
        echo '<section class="body-content">
                    <div class="content-data profile">
                        <div class="prof-nav">
                            <img src="'.BASEURL.'/public/img/profile/'.$row['image'].'" alt="">
                            <h3>'.$row['first_name'].' '.$row['last_name'].'</h3>
                            <p class="gray">'.$row['email'].'</p>
                            <ul>
                                <li>';
                                if($data['tab']=='profile'){
                                    echo '<a class="active" href="'.BASEURL.'/profile/edit/delivery/'.$row['user_id'].'/profile/delivery/profile" onclick="profile()">Profile</a>';
                                }else{
                                    echo '<a class="" href="'.BASEURL.'/profile/edit/delivery/'.$row['user_id'].'/profile/delivery/profile" onclick="profile()">Profile</a>';
                                }
                                echo '</li>
                                <li>';
                                if($data['tab'] == 'security'){
                                    echo '<a class="active" href="'.BASEURL.'/profile/edit/delivery/'.$row['user_id'].'/security/delivery/profile">Security</a>';
                                }else{
                                    echo '<a href="'.BASEURL.'/profile/edit/delivery/'.$row['user_id'].'/security/delivery/profile">Security</a>';
                                }
                                echo '</li>
                            </ul>
                        </div>
                        <div class="prof-info">
                            <h2>Profile Settings</h2>';
                        if($data['tab']=='profile'){
                            echo '<form class="profile" action="'.BASEURL.'/profile/update/profile" enctype="multipart/form-data" method="post">
                                <div>
                                    <div class="input half"><label>First Name</label><input type="text" name="first_name" placeholder="first name" value="'.$row['first_name'].'"></div>
                                    <div class="input half"><label>Last Name</label><input type="text" name="last_name" placeholder="last name" value="'.$row['last_name'].'"></div>
                                </div>
                                <div>
                                    <div class="input half"><label>City</label>
                                    <select id="city" class="dropdowndate" name="city" class="half">';
                                        $cities = CITIES;
                                        foreach($cities as $city){
                                            if($city == $row['city']){
                                                echo '<option value="'.$city.'" selected >'.$city.'</option>';
                                            }else{
                                                echo '<option value="'.$city.'">'.$city.'</option>';
                                            }
                                        }
                                echo '</select>
                                    </div>
                                    <div class="input half"><label>Address</label><input type="text" name="street" placeholder="address" value="'.$row['street'].'"></div>
                                </div>
                                <div>
                                    <div class="input half"><label>Vehicle Type</label>
                                    <select id="city" class="dropdowndate" name="vehicle_type" class="half">';
                                        $vehicles = VEHICLES;
                                        foreach($vehicles as $vehicle){
                                            if($vehicle == $row['vehicle_type']){
                                                echo '<option value="'.$vehicle.'" selected >'.$vehicle.'</option>';
                                            }else{
                                                echo '<option value="'.$vehicle.'">'.$vehicle.'</option>';
                                            }
                                        }
                                echo '</select>
                                    </div>
                                    <div class="input half"><label>Vehicle Number</label><input type="text" name="vehicle_no" placeholder="vehicle number" value="'.$row['vehicle_no'].'"></div>
                                </div>
                                <div>
                                    <div class="input half"><label>Weight Limit</label><input type="number" name="weight_limit" placeholder="weight limit" min=0 step=1 value="'.$row['weight_limit'].'"></div>
                                    <div class="input half"><label>Cost per km</label><input type="number" name="cost_per_km" placeholder="cost per km" min=0 step=1 value="'.$row['cost_per_km'].'"></div>
                                </div>
                                <div class="input file"><label>Profile Image</label><input type="file" name="image" accept=".png, .jpg, .jpeg"></div>
                                <button class="button" type="submit">Save</button>
                            </form>';
                        }else if($data['tab']=='security'){
                            echo '<form class="passwords" action="'.BASEURL.'/profile/update/security" method="post">
                                <div class="input"><label>Current Password</label><input type="password" name="current_password" placeholder="Enter current password"></div>
                                <div>
                                    <div class="input half"><label>New Password</label><input type="password" name="new_password" placeholder="Enter new password"></div>
                                    <div class="input half"><label>Confirm New Password</label><input type="password" name="confirm_password" placeholder="Confirm new password" ></div>
                                </div>
                                <button class="button">Save</button>
                            </form>';
                        }
                        echo '</div>
                    </div>
            </section>';
            
            echo '<script>';
            // echo 'const form = document.querySelector(".prof-info form");
            //     form.onsubmit = (e)=>{
            //         e.preventDefault();
            //     }';
            echo '
                document.querySelector(".file input").onchange = function(){
                    document.querySelector(".prof-nav img").src = URL.createObjectURL(this.files[0]);
                }
            </script>';
    }

    function editcustomer($data){
        $row = mysqli_fetch_assoc($data['query']);
        echo '<section class="body-content">
                    <div class="content-data profile">
                        <div class="prof-nav">
                            <img src="'.BASEURL.'/public/img/profile/'.$row['image'].'" alt="">
                            <h3>'.$row['first_name'].' '.$row['last_name'].'</h3>
                            <p class="gray">'.$row['email'].'</p>
                            <ul>
                                <li>';
                                if($data['tab']=='profile'){
                                    echo '<a class="active" href="'.BASEURL.'/profile/edit/customer/'.$row['user_id'].'/profile/customer/profile" onclick="profile()">Profile</a>';
                                }else{
                                    echo '<a class="" href="'.BASEURL.'/profile/edit/customer/'.$row['user_id'].'/profile/customer/profile" onclick="profile()">Profile</a>';
                                }
                                echo '</li>
                                <li>';
                                if($data['tab'] == 'security'){
                                    echo '<a class="active" href="'.BASEURL.'/profile/edit/customer/'.$row['user_id'].'/security/customer/profile">Security</a>';
                                }else{
                                    echo '<a href="'.BASEURL.'/profile/edit/customer/'.$row['user_id'].'/security/customer/profile">Security</a>';
                                }
                                echo '</li>
                            </ul>
                        </div>
                        <div class="prof-info">
                            <h2>Profile Settings</h2>';
                        if($data['tab']=='profile'){
                            echo '<form class="profile" action="'.BASEURL.'/profile/update/profile" enctype="multipart/form-data" method="post">
                                <div>
                                    <div class="input half"><label>First Name</label><input type="text" name="first_name" placeholder="first name" value="'.$row['first_name'].'"></div>
                                    <div class="input half"><label>Last Name</label><input type="text" name="last_name" placeholder="last name" value="'.$row['last_name'].'"></div>
                                </div>
                                <div>
                                    <div class="input half"><label>City</label>
                                    <select id="city" class="dropdowndate" name="city" class="half">';
                                        $cities = CITIES;
                                        foreach($cities as $city){
                                            if($city == $row['city']){
                                                echo '<option value="'.$city.'" selected >'.$city.'</option>';
                                            }else{
                                                echo '<option value="'.$city.'">'.$city.'</option>';
                                            }
                                        }
                                echo '</select>
                                    </div>
                                    <div class="input half"><label>Address</label><input type="text" name="street" placeholder="address" value="'.$row['street'].'"></div>
                                </div>
                                <div class="input"><label>Contact Number</label><input type="text" name="contact_no" placeholder="contact number" value="'.$row['contact_no'].'"></div>
                                <div class="input"><label>User Type</label><input type="text" name="type" placeholder="user type" value="'.$row['type'].'" readonly></div>
                                <div class="input file"><label>Profile Image</label><input type="file" name="image" accept=".png, .jpg, .jpeg"></div>
                                <button class="button" type="submit">Save</button>
                            </form>';
                        }else if($data['tab']=='security'){
                            echo '<form class="passwords" action="'.BASEURL.'/profile/update/security" method="post">
                                <div class="input"><label>Current Password</label><input type="password" name="current_password" placeholder="Enter current password"></div>
                                <div>
                                    <div class="input half"><label>New Password</label><input type="password" name="new_password" placeholder="Enter new password"></div>
                                    <div class="input half"><label>Confirm New Password</label><input type="password" name="confirm_password" placeholder="Confirm new password" ></div>
                                </div>
                                <button class="button">Save</button>
                            </form>';
                        }
                        echo '</div>
                    </div>
            </section>';
            
            echo '<script>';
            // echo 'const form = document.querySelector(".prof-info form");
            //     form.onsubmit = (e)=>{
            //         e.preventDefault();
            //     }';
            echo '
                document.querySelector(".file input").onchange = function(){
                    document.querySelector(".prof-nav img").src = URL.createObjectURL(this.files[0]);
                }
            </script>';
    }
}
?>