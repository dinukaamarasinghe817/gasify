<?php
$header = new Header("admin",$data);
$sidebar = new Navigation('admin','companies');
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new ProfileHTML($data);
    ?>
    <div class="body-content">
                <form action="<?php echo BASEURL ?>/users/companies" class="filters" method="POST">
                    <div class="input half select"><label>Sort By</label>
                        <select id="period" name="option" onchange="this.form.submit()" class="dropdowndate">
                            <?php if($data['option'] == 'stock') : ?> 
                                <option  value="stock" selected>Gas Stock</option>
                            <?php else : ?>
                                <option  value="stock">Gas Stock</option>
                            <?php endif;if($data['option'] == 'distributor') : ?> 
                                <option  value="distributor" selected>No of Distributors</option>
                            <?php else : ?>
                                <option  value="distributor" >No of Distributors</option>
                            <?php endif;if($data['option'] == 'dealer') : ?> 
                                <option  value="dealer" selected>No of Dealers</option>
                            <?php else : ?>
                                <option  value="dealer">No of Dealers</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </form>
                <div class="content-data">
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Company ID</th>
                                <th>Name</th>
                                <th>No of Distributors</th>
                                <th>No of Dealers</th>
                                <th>Stock on terminals</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $companies = $data['companies'];
                            while($company = mysqli_fetch_assoc($companies)){
                                echo '<tr>
                                <td>'.$company['user_id'].'</td>
                                <td>'.$company['name'].'</td>
                                <td>'.$company['distributor_count'].'</td>
                                <td>'.$company['dealer_count'].'</td>
                                <td>'.number_format($company['quantity'],2).' Kg</td>
                                <td><a class="anchor-button" href="'.BASEURL.'/profile/preview/company/'.$company['user_id'].'/profile/admin/companyprofile" >View Profile</a></td>
                            </tr>';
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