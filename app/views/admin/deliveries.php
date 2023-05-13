<?php
$header = new Header("admin",$data);
$sidebar = new Navigation('admin','delivery');
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new ProfileHTML($data);
    ?>
    <div class="body-content deliveries">
        <div class="top-panel">
            <ul>
                <li><a href="<?php echo BASEURL; ?>/users/deliveries" class="current active">Delivery People</a></li>
                <li><a href="<?php echo BASEURL; ?>/users/deliveries/charges" class="current">Delivery Charges</a></li>
            </ul>
        </div>
        <form action="<?php echo BASEURL?>/users/deliveries" class="filters" method='post'>
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
                $search = new Search([0,1,2]);
            ?>
        </form>
        <div class="content-data">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Delivery ID</th>
                        <th>Name</th>
                        <th>City</th>
                        <th>Completed orders</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $delivery_people = $data['delivery_people'];
                        if(mysqli_num_rows($delivery_people) > 0){
                            while($row = mysqli_fetch_assoc($delivery_people)){
                                echo '<tr>
                                        <td>'.$row['user_id'].'</td>
                                        <td>'.$row['name'].'</td>
                                        <td>'.$row['city'].'</td>
                                        <td>'.$row['orders_count'].'</td>
                                        <td><a class="anchor-button" href="'.BASEURL.'/profile/preview/delivery/'.$row['user_id'].'/profile/admin/deliveryprofile" >Profile</a></td>
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