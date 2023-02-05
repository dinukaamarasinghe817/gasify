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
    <div class="body-content">
                <form action="" class="filters">
                    <div class="input half select"><label>Filter By City</label>
                        <select id="period" name="option" onchange="this.form.submit()" class="dropdowndate">
                            <?php
                                $cities = CITIES;
                                echo '<option  value="none" selected hidden>Select a city</option>';
                                foreach($cities as $city){
                                    echo '<option  value="'.$city.'">'.$city.'</option>';
                                }
                            ?>
                        </select>
                    </div>
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
                            echo '<tr>
                                    <td>3</td>
                                    <td>Kamal Satharasinghe</td>
                                    <td>Homagama</td>
                                    <td>5</td>
                                    <td><a class="anchor-button" href="'.BASEURL.'/profile/preview/delivery/12/profile/admin/deliveryprofile" >View Profile</a></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Kamal Satharasinghe</td>
                                    <td>Homagama</td>
                                    <td>5</td>
                                    <td><a class="anchor-button" href="'.BASEURL.'/profile/preview/delivery/12/profile/admin/deliveryprofile" >View Profile</a></td>
                                </tr>';
                            ?>
                        </tbody>
                    </table>
                </div>
    </div>
</section>

<?php
$footer = new Footer("admin");
?>