function customerprompt(variant=null,forwardlink=null,backwardlink=null){
    let body = '';
    if(variant == 'confirmdelivery'){
        body = `<h2>Confirm Delivery Option</h2>
        <img src="wallet.png" alt="">
        <p>Your're delivery charges Rs:500.00<br>Confirm your delivery.</p>
        <div class="buttons">
            <button onclick="location.href='${backwardlink}'">Cancel</button>
            <button onclick="location.href='${forwardlink}'">Confirm</button>
        </div>`;
    }else if(variant == 'cancelorder'){
        body = `<h2>Canceled</h2>
        <img src="rejected.png" alt="">
        <p>Contact the dealer for refunding</p>
        <div class="buttons">
            <button onclick="location.href='${forwardlink}'">OK</button>
        </div>`;
    }else if(variant == 'thankyou'){
        body = `<h2>Thank You</h2>
        <img src="accept.png" alt="">
        <p>Order placed successfully</p>
        <div class="buttons">
            <button onclick="location.href='${forwardlink}'">OK</button>
        </div>`;
    }else if(variant == 'success'){
        body = `<h2>Success</h2>
        <img src="accept.png" alt="">
        <p>Review added successfully</p>
        <div class="buttons">
            <button onclick="location.href='${forwardlink}'">OK</button>
        </div>`;
    }else if(variant == 'changecollectmethod'){
        body = `<h2>Changing Collecing Method</h2>
        <img src="operation.png" alt="">
        <p>Your order might be delayed to deliver. Do you want to change your collecting method to pickup</p>
        <div class="buttons">
            <button onclick="location.href='${backwardlink}'">No</button>
            <button onclick="location.href='${forwardlink}'">Yes</button>
        </div>`;
    }else if(variant == 'recievedorder'){
        body = `<h2>Order Status</h2>
        <img src="orderstatus.png" alt="">
        <p>Did you recieve your order. press 'Yes' if recieved and 'No' if didn't and contact the Dealer</p>
        <div class="buttons">
            <button onclick="location.href='${backwardlink}'">No</button>
            <button onclick="location.href='${forwardlink}'">Yes</button>
        </div>`;
    }else if(variant == 'confirmcancellation'){
        body = `<h2>Order Cancellation</h2>
        <img src="cancelorder.png" alt="">
        <p>Are you sure you want to cancel the order? Confirm it and you're done.</p>
        <div class="buttons">
            <button onclick="location.href='${backwardlink}'">Cancel</button>
            <button onclick="location.href='${forwardlink}'">Confirm</button>
        </div>`;
    }else if(variant == 'readyorder'){
        body = `<h2>Your Order is Ready</h2>
        <img src="accept.png" alt="">
        <p>Your order is ready, you can pick it up.</p>
        <div class="buttons">
            <button onclick="location.href='${forwardlink}'">OK</button>
        </div>`;
    }else{
        body = ``;
    }

    let accorinfo = document.querySelector(".confirmation");
    accorinfo.innerHTML = body;
    accorinfo.classList.toggle("active");
    document.querySelector("body").classList.toggle("blur");
}