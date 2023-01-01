<?php
$header = new Header("distributor_orders");
$sidebar = new Navigation('distributor',$data['navigation']);
?>


<section class="body">
    <?php 
    $bodyheader = new BodyHeader($data);
    ?>

    <section class="body-content">

    <div class="split right">
        
        <h1>Gas Orders</h1>

        <div class="top">
            <ul>
                <li>
                    <a href="#" class="place"><b>Place an Order</b></a>
                </li>
                <li>
                    <a href="#" class="placedlist"><b>Placed Order List</b></a>
                </li>
            </ul>
        </div>

        <div>
            <div class="middle">
                <p>Order ID : 03</p> <br>

                <table>
                    <tr>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Unit Price (Rs.)</th>
                        <th>Quantity</th>
                        <th>Price (Rs. )</th>
                    </tr>

                    <tr>
                        <td>1</td>
                        <td>Buddy</td>
                        <td>815.00</td>
                        <td>1000</td>
                        <td>815000.00</td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Budget</td>
                        <td>1750.00</td>
                        <td>500</td>
                        <td>875000.00</td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>Regular</td>
                        <td>4360.00</td>
                        <td>100</td>
                        <td>436000.00</td>
                    </tr>
                </table>

                <div class="total">
                    <p>Total Price : Rs.2126000.00</p>
                </div>

                <div class="btnclz">
                    <button class="btn2-1">Submit</button>
                    <button class="btn2-2">Back</button>
                </div>
            </div>
        </div>
    </div>

    </section>
</section>

<?php
$footer = new Footer();
?>