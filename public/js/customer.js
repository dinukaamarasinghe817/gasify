function customerprompt(variant=null,forwardlink=null,backwardlink=null){
    let body = '';
    if(variant == 'confirmdelivery'){
        body = `<h2>Confirm Delivery Option</h2>
        <img src="http://localhost/mvc/public/img/icons/wallet.png" alt="">
        <p>Your're delivery charges Rs:500.00<br>Confirm your delivery.</p>
        <div class="buttons">
            <button onclick="location.href='${backwardlink}'">Cancel</button>
            <button onclick="location.href='${forwardlink}'">Confirm</button>
        </div>`;
    }else if(variant == 'cancelorder'){
        body = `<h2>Canceled</h2>
        <img src="http://localhost/mvc/public/img/icons/rejected.png" alt="">
        <p>Contact the dealer for refunding</p>
        <div class="buttons">
            <button onclick="location.href='${forwardlink}'">OK</button>
        </div>`;
    }else if(variant == 'thankyou'){
        body = `<h2>Thank You</h2>
        <img src="http://localhost/mvc/public/img/icons/accept.png" alt="">
        <p>Order placed successfully</p>
        <div class="buttons">
            <button onclick="location.href='${forwardlink}'">OK</button>
        </div>`;
    }else if(variant == 'success'){
        body = `<h2>Success</h2>
        <img src="http://localhost/mvc/public/img/icons/accept.png" alt="">
        <p>Review added successfully</p>
        <div class="buttons">
            <button onclick="location.href='${forwardlink}'">OK</button>
        </div>`;
    }else if(variant == 'changecollectmethod'){
        body = `<h2>Changing Collecing Method</h2>
        <img src="http://localhost/mvc/public/img/icons/operation.png" alt="">
        <p>Your order might be delayed to deliver. Do you want to change your collecting method to pickup</p>
        <div class="buttons">
            <button onclick="location.href='${backwardlink}'">No</button>
            <button onclick="location.href='${forwardlink}'">Yes</button>
        </div>`;
    }else if(variant == 'recievedorder'){
        body = `<h2>Order Status</h2>
        <img src="http://localhost/mvc/public/img/icons/orderstatus.png" alt="">
        <p>Did you recieve your order. press 'Yes' if recieved and 'No' if didn't and contact the Dealer</p>
        <div class="buttons">
            <button onclick="location.href='${backwardlink}'">No</button>
            <button onclick="location.href='${forwardlink}'">Yes</button>
        </div>`;
    }else if(variant == 'confirmcancellation'){
        body = `<h2>Order Cancellation</h2>
        <img src="http://localhost/mvc/public/img/icons/cancelorder.png" alt="">
        <p>Are you sure you want to cancel the order? Confirm it and you're done.</p>
        <div class="buttons">
            <button onclick="location.href='${backwardlink}'">Cancel</button>
            <button onclick="submitcancelorder()">Confirm</button>
        </div>`;
    }else if(variant == 'readyorder'){
        body = `<h2>Your Order is Ready</h2>
        <img src="http://localhost/mvc/public/img/icons/accept.png" alt="">
        <p>Your order is ready, you can pick it up.</p>
        <div class="buttons">
            <button onclick="location.href='${forwardlink}'">OK</button>
        </div>`;
    }
    //pop up for select collecting method pickup or delivery 
    else if(variant == 'deliverymethod'){
        body = `<h2>Select Collecting Method</h2>
        <img src="http://localhost/mvc/public/img/icons/collecting_method.png" alt="">
        <p>Select the collecting method you need</p>
        <div class="buttons">
            <button onclick="customerprompt();customerprompt('selectpickup');">
            <svg width="35" height="35" viewBox="0 0 37 29" fill="white" xmlns="http://www.w3.org/2000/svg">
            <path d="M1.93924 0.0096914C1.3361 0.111029 0.795985 0.459816 0.437733 0.979325C0.0794802 1.49883 -0.0675687 2.14651 0.0289353 2.77987C0.125439 3.41322 0.457591 3.98039 0.95232 4.35658C1.44705 4.73278 2.06383 4.88719 2.66698 4.78585H9.48952L9.89887 5.9799L11.7637 11.9501L13.6285 17.9203C13.8105 18.5412 14.5837 19.1143 15.175 19.1143H31.0942C31.731 19.1143 32.4587 18.5412 32.6406 17.9203L36.3248 5.9799C36.5068 5.35899 36.2338 4.78585 35.5971 4.78585H15.4024L13.674 1.34702C13.4899 0.952312 13.2057 0.618607 12.8526 0.38265C12.4995 0.146693 12.0912 0.0176366 11.6727 0.00969139L2.57601 0.0096914C2.43984 -0.00323046 2.30284 -0.00323047 2.16666 0.00969139C2.07578 0.00395483 1.98465 0.00395483 1.89376 0.00969139L1.93924 0.0096914ZM16.312 23.8905C15.0385 23.8905 14.0379 24.9413 14.0379 26.2786C14.0379 27.6159 15.0385 28.6667 16.312 28.6667C17.5856 28.6667 18.5862 27.6159 18.5862 26.2786C18.5862 24.9413 17.5856 23.8905 16.312 23.8905ZM29.9571 23.8905C28.6836 23.8905 27.6829 24.9413 27.6829 26.2786C27.6829 27.6159 28.6836 28.6667 29.9571 28.6667C31.2307 28.6667 32.2313 27.6159 32.2313 26.2786C32.2313 24.9413 31.2307 23.8905 29.9571 23.8905Z" fill=""/>
            </svg>
            <div>Pick up</div></button>
            <button onclick="customerprompt();customerprompt('deliverychargeandaddress');">
            <svg width="35" height="35" viewBox="0 0 35 35" fill="white" xmlns="http://www.w3.org/2000/svg">
            <path d="M30.5313 20.6587L24.0083 15.2834V11.6224C24.043 10.8886 23.7923 10.1707 23.3112 9.62605C22.83 9.08138 22.1577 8.7544 21.4416 8.7168H5.27593C4.56488 8.76177 3.89975 9.09196 3.42465 9.63581C2.94954 10.1797 2.70271 10.8934 2.73763 11.6224V26.1503C2.72447 26.7272 2.87929 27.2951 3.18235 27.7815C3.4854 28.2679 3.92298 28.6509 4.43929 28.8815C4.17813 29.5361 4.07635 30.2459 4.14273 30.9498C4.2091 31.6536 4.44164 32.3303 4.82027 32.9216C5.19891 33.5128 5.71227 34.0007 6.31607 34.3433C6.91986 34.6859 7.59595 34.8729 8.286 34.888C8.97605 34.9032 9.65933 34.7461 10.2769 34.4303C10.8945 34.1145 11.4278 33.6495 11.8308 33.0755C12.2338 32.5014 12.4944 31.8355 12.5901 31.1352C12.6859 30.4349 12.6139 29.7213 12.3803 29.0559H21.3991C21.1659 29.7142 21.0909 30.4204 21.1806 31.1146C21.2703 31.8089 21.5219 32.4708 21.9143 33.0443C22.3066 33.6178 22.8281 34.086 23.4345 34.4092C24.0409 34.7325 24.7144 34.9012 25.398 34.9012C26.0815 34.9012 26.755 34.7325 27.3615 34.4092C27.9679 34.086 28.4893 33.6178 28.8816 33.0443C29.274 32.4708 29.5256 31.8089 29.6153 31.1146C29.705 30.4204 29.6301 29.7142 29.3968 29.0559H29.6805C30.0565 29.0559 30.4172 28.9028 30.6832 28.6304C30.9491 28.3579 31.0985 27.9884 31.0985 27.6031V21.7919C31.0942 21.5713 31.0408 21.3546 30.9425 21.1583C30.8443 20.9619 30.7036 20.7911 30.5313 20.6587V20.6587ZM28.2624 22.4893V26.1503H24.0083V19.0026L28.2624 22.4893ZM9.82785 30.5087C9.82785 30.796 9.74468 31.0769 9.58887 31.3158C9.43305 31.5547 9.21158 31.7409 8.95247 31.8509C8.69335 31.9608 8.40823 31.9896 8.13316 31.9336C7.85809 31.8775 7.60542 31.7391 7.4071 31.536C7.20878 31.3328 7.07373 31.0739 7.01901 30.7921C6.9643 30.5103 6.99238 30.2182 7.09971 29.9527C7.20703 29.6873 7.38879 29.4604 7.62198 29.3007C7.85518 29.1411 8.12934 29.0559 8.40981 29.0559C8.7859 29.0559 9.14658 29.2089 9.41251 29.4814C9.67845 29.7538 9.82785 30.1234 9.82785 30.5087ZM26.8444 30.5087C26.8444 30.796 26.7612 31.0769 26.6054 31.3158C26.4496 31.5547 26.2281 31.7409 25.969 31.8509C25.7099 31.9608 25.4247 31.9896 25.1497 31.9336C24.8746 31.8775 24.6219 31.7391 24.4236 31.536C24.2253 31.3328 24.0902 31.0739 24.0355 30.7921C23.9808 30.5103 24.0089 30.2182 24.1162 29.9527C24.2236 29.6873 24.4053 29.4604 24.6385 29.3007C24.8717 29.1411 25.1459 29.0559 25.4263 29.0559C25.8024 29.0559 26.1631 29.2089 26.429 29.4814C26.695 29.7538 26.8444 30.1234 26.8444 30.5087Z" fill=""/>
            </svg>
            <div>Delivery</div></button>
        </div>`;
    }
    //confirm pop up for pickup collecting method
    else if(variant == 'selectpickup'){
        body = `<h2>Pick Up Option</h2>
        <img src="http://localhost/mvc/public/img/icons/pickup.jpg" alt="">
        <p>Confirm pick up option as your collecting method!</p>
        <div class="buttons">
            <button  class= "btn-red" onclick="customerprompt();customerprompt('deliverymethod');">Cancel</button>
            <button class="btn-blue" onclick="customerprompt();customerprompt('thankyou','http://localhost/mvc/Orders/getcollecting_method/Pickup/');">Confirm</button>   
        </div> `; 
    }
    //dashbord toast
    //pop up after select delivery method with delivery address and charge 
    else if (variant == 'deliverychargeandaddress') {
        let home_city = document.querySelector("input.home_city").value;
        let home_street = document.querySelector("input.home_street").value;
        let d_charge = document.querySelector("input.d_charge").value;
        console.log(d_charge);
        body = `<h2>Delivery Address And Charges</h2>
        <img src="http://localhost/mvc/public/img/icons/delivery.png" alt="">
         
        <label class="delivery_charge_label">Delivery Address:</label>
        <input class="delivery_charge_textbox" name="new_street" value ="${home_street}, ${home_city}" readonly>
        <label class="delivery_charge_label">Delivery Charge:</label>
        <input class="delivery_charge_textbox" name="dcharge" value ="Rs.${d_charge}" readonly >
        <p style="color:green;">If you need to edit delivery address click Edit.</p>
        <div class="buttons">
            <button  class= "btn-red" onclick="customerprompt();customerprompt('deliverymethod');">Cancel</button>
            <button  class= "btn-blue" onclick="customerprompt();customerprompt('changedeliveryaddress','http://localhost/mvc/Orders/change_delivery_address');">Edit</button>
            <button class="btn-blue" onclick="customerprompt();customerprompt('selectdelivery','http://localhost/mvc/Orders/getcollecting_method/Delivery/${home_city}/${home_street}/${d_charge}');">Ok</button>
        </div> `;

    }
    //change delivery address pop up
    //have to take selected city as new city and store new city and street
    else if(variant == 'changedeliveryaddress'){
        let cities = JSON.parse(document.querySelector("input.cities").value);
        console.log(cities);
        let home_city = document.querySelector("input.home_city").value;
        let home_street = document.querySelector("input.home_street").value;

        body = `<h2>Change Delivery Address</h2>
        <img src="http://localhost/mvc/public/img/icons/delivery.png" alt="">
        <p>Give your new delivery address,Enter correct street and cty!</p>
        <form  id="delivery_details_form" action="${forwardlink}" method="POST"> 
            <label class="delivery_charge_label">New Street:</label>
            <input id="new_street" name="new_street" placeholder="New Street" value="${home_street}" required>
            <label class="delivery_charge_label">New City:</label>
            <select id="new_city" name="new_city" class="dropdowndate" required>`;
            cities.forEach(city => {
                if(home_city == city) {
                    body += `<option value="${home_city}" selected>${home_city}</option>`;
                }else{
                    body += `<option value="${city}">${city}</option>`;
                }
            });  
        body +=  `</select> 
        </form>
        <div class="buttons">
            <button class= "btn-red" onclick="customerprompt();customerprompt('deliverychargeandaddress');">Cancel</button>
            <button class="btn-blue" onclick = "changechargeandaddress();">OK</button>
        </div> `;

    } 
     //confirm pop up for pickup collecting method 
    else if(variant == 'selectdelivery'){
        body = `<h2>Delivery Option</h2>
        <img src="http://localhost/mvc/public/img/icons/deliverycar.png" alt="">
        <p>Confirm delivery option as your collecting method!</p>
        <div class="buttons">
            <button  class= "btn-red" onclick="customerprompt();customerprompt('deliverymethod');">Cancel</button>
            <button class="btn-blue" onclick="customerprompt();customerprompt('thankyou','${forwardlink}');">Confirm</button>   
        </div>  `;
    }
    else{
        body = ``;
    }

    let accorinfo = document.querySelector(".confirmation");
    accorinfo.innerHTML = body;
    accorinfo.classList.toggle("active");
    document.querySelector("body").classList.toggle("blur");



    
}




function changechargeandaddress(){
    let form = document.querySelector("#delivery_details_form");
    let city = document.querySelector("input.home_city");
    let street = document.querySelector("input.home_street");
    let charge = document.querySelector("input.d_charge");
    
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://localhost/mvc/Orders/change_delivery_address', true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            if(data){
                // now we have the new address and the relevent charge
                data = JSON.parse(data);
                if(data.hasOwnProperty('error')){
                    console.log("hasproperty");
                    let toast = document.querySelectorAll('#toast .container-2 p');
                    document.querySelector('#toast').style.borderLeft = '8px solid #ec4d4d';
                    toast[0].textContent = "Error";
                    toast[1].textContent = data['error'];
                    showToast();
                }else{
                    // data = JSON.parse(data);
                    console.log(data);
                    street.value = data['street'];
                    city.value = data['city'];
                    charge.value = data['delivery_charge'];
                    console.log(data['delivery_charge']);
                    console.log(data['error']);
                    customerprompt();
                    customerprompt('deliverychargeandaddress');
                }
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}

function submitcancelorder(){
    document.getElementById("bank_details_form").submit();
}