<?php
$header = new Header("admin",$data);
$sidebar = new Navigation('admin','dealers');
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new ProfileHTML($data);
    ?>
    <div class="body-content">
                <form action="<?php echo BASEURL?>/users/dealers" class="filters" method='post'>
                    <div class="input half select"><label>Filter By City</label>
                        <select id="period" name="option1" onchange="this.form.submit()" class="dropdowndate">
                            <?php
                                $cities = CITIES;
                                echo '<option  value="all" selected>All</option>';
                                foreach($cities as $city){
                                    if($city == $data['option1']){
                                        echo '<option  value="'.$city.'" selected>'.$city.'</option>';
                                    }else{
                                        echo '<option  value="'.$city.'">'.$city.'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="input half select"><label>Filter By Company</label>
                        <select id="period" name="option2" onchange="this.form.submit()" class="dropdowndate">
                            <option  value="all" selected >All</option>
                            <?php
                                $companies = $data['companies'];
                                while($row = mysqli_fetch_assoc($companies)){
                                    if($row['company_id'] == $data['option2']){
                                        echo '<option value="'.$row['company_id'].'" selected>'.$row['name'].'</option>';
                                    }else{
                                        echo '<option value="'.$row['company_id'].'">'.$row['name'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </form>
                <div class="content-data">
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Dealer ID</th>
                                <th>Name</th>
                                <th>City</th>
                                <th>Company</th>
                                <th>No of orders</th>
                                <th>Current Gas stock</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $dealers = $data['dealers'];
                                if(mysqli_num_rows($dealers) > 0){
                                    while($row = mysqli_fetch_assoc($dealers)){
                                        echo '<tr>
                                                <td>'.$row['user_id'].'</td>
                                                <td>'.$row['name'].'</td>
                                                <td>'.$row['city'].'</td>
                                                <td>'.$row['company'].'</td>
                                                <td>'.$row['orders_count'].'</td>
                                                <td>'.number_format($row['quantity'],2).' Kg</td>
                                                <td><a class="anchor-button" href="'.BASEURL.'/profile/preview/dealer/'.$row['user_id'].'/profile/admin/dealerprofile" >View Profile</a></td>
                                            </tr>';
                                    }
                                }else{
                                    echo '<tr><td colspan="7" style="text-align: center">No records found</td></tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
    </div>
</section>

<?php
$footer = new Footer("admin");
?>