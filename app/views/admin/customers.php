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
                <form action="<?php echo BASEURL?>/users/customers" class="filters" method='post'>
                    <div class="input half select"><label>Filter By City</label>
                        <select id="period" name="option" onchange="this.form.submit()" class="dropdowndate">
                            <?php
                                $cities = CITIES;
                                echo '<option  value="all" selected>All</option>';
                                foreach($cities as $city){
                                    if($city == $data['option']){
                                        echo '<option  value="'.$city.'" selected>'.$city.'</option>';
                                    }else{
                                        echo '<option  value="'.$city.'">'.$city.'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <?php 
                        $search = new Search([0,1,4]);
                    ?>
                </form>
                <div class="content-data">
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Customer ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Contact No</th>
                                <th>Monthly Usage</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $customers = $data['customers'];
                            if(mysqli_num_rows($customers) > 0){
                                while($row = mysqli_fetch_assoc($customers)){
                                    $usage = ($row['months'] == 0) ? 0 : number_format($row['quantity']/$row['months'],2);
                                    echo '<tr>
                                            <td>'.$row['user_id'].'</td>
                                            <td>'.$row['name'].'</td>
                                            <td>'.$row['address'].'</td>
                                            <td>'.$row['city'].'</td>
                                            <td>'.$row['contact_no'].'</td>
                                            <td>'.$usage.' Kg</td>
                                            <td><a class="anchor-button" href="'.BASEURL.'/profile/preview/customer/'.$row['user_id'].'/profile/admin/customerprofile" >Profile</a></td>
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