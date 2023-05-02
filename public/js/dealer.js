function changeqty(id, unitprice) {
    id = parseInt(id);
    unitprice = parseFloat(unitprice);
    let inputstring = `.data${id} td input`;
    let input = document.querySelector(inputstring);
    let inputvalue = input.value;
    let subtotaltring = `.data${id} .subtotal`;
    let subtotal = document.querySelector(subtotaltring);
    subtotal.innerHTML = "Rs. "+(unitprice* inputvalue).toLocaleString('en-US');
    let total = document.querySelector('.total .amount');

    let totalvalue = gettotal();
    total.innerHTML = "Rs. "+totalvalue;
}

function gettotal() {
    let total = 0.00;
    let subtotals = document.querySelectorAll('.po  tr .subtotal');
    for(let i = 0; i < subtotals.length; i++) {
        let sub = subtotals[i].innerHTML;
        sub = sub.substring(4);
        sub = parseFloat(sub.replace(/,/g, ''));
        total += sub;
    }
    // parseFloat("2,299.00".replace(/,/g, ''))
    return total.toLocaleString('en-US');
}

function poinfo(poid) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://localhost/mvc/stock/dealerpoinfo/'+poid, true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            if(data){
                console.log(data);
                let bodycontent = document.querySelector('.content-data');
                bodycontent.innerHTML = data;
            }
        }
    }
    xhr.send();
}

function callthisfunc_onclick() {
    let form = document.querySelector("div form");
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://localhost/mvc/controller/method/', true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            if(data){
                // do what ever you want to do with the data
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}

function orderverification(payments,stock){
    console.log("hello");
    let boxes = '';
    if(payments == 'verified'){
        if(stock == 'available'){
            boxes = `<div class="box">
                        <div>
                            <h2>Stock</h2>
                            <p>available</p>
                        </div>
                        <img src="http://localhost/mvc/public/img/icons/accept.png" alt="">
                    </div>
                    <div class="box">
                        <div>
                            <h2>Payment</h2>
                            <p>verified</p>
                        </div>
                        <img src="http://localhost/mvc/public/img/icons/accept.png" alt="">
                    </div>`;
        }else{
            boxes = `<div class="box">
                        <div>
                            <h2>Stock</h2>
                            <p>not available</p>
                        </div>
                        <img src="http://localhost/mvc/public/img/icons/notavailable.png" alt="">
                    </div>
                    <div class="box">
                        <div>
                            <h2>Payment</h2>
                            <p>verified</p>
                        </div>
                        <img src="http://localhost/mvc/public/img/icons/accept.png" alt="">
                    </div>`;
        }
    }else if(payments == 'pending'){
        if(stock == 'available'){
            boxes = `<div class="box">
                        <div>
                            <h2>Stock</h2>
                            <p>available</p>
                        </div>
                        <img src="http://localhost/mvc/public/img/icons/accept.png" alt="">
                    </div>
                    <div class="box">
                        <div>
                            <h2>Payment</h2>
                            <p>pending</p>
                        </div>
                        <img src="http://localhost/mvc/public/img/icons/pending.png" alt="">
                    </div>`;
        }else{
            boxes = `<div class="box">
                        <div>
                            <h2>Stock</h2>
                            <p>not available</p>
                        </div>
                        <img src="http://localhost/mvc/public/img/icons/notavailable.png" alt="">
                    </div>
                    <div class="box">
                        <div>
                            <h2>Payment</h2>
                            <p>pending</p>
                        </div>
                        <img src="http://localhost/mvc/public/img/icons/pending.png" alt="">
                    </div>`;
        }
    }else{
        if(stock == 'available'){
            boxes = `<div class="box">
                        <div>
                            <h2>Stock</h2>
                            <p>available</p>
                        </div>
                        <img src="http://localhost/mvc/public/img/icons/accept.png" alt="">
                    </div>
                    <div class="box">
                        <div>
                            <h2>Payment</h2>
                            <p>rejected</p>
                        </div>
                        <img src="http://localhost/mvc/public/img/icons/rejected.png" alt="">
                    </div>`;
        }else{
            boxes = `<div class="box">
                        <div>
                            <h2>Stock</h2>
                            <p>not available</p>
                        </div>
                        <img src="http://localhost/mvc/public/img/icons/notavailable.png" alt="">
                    </div>
                    <div class="box">
                        <div>
                            <h2>Payment</h2>
                            <p>rejected</p>
                        </div>
                        <img src="http://localhost/mvc/public/img/icons/rejected.png" alt="">
                    </div>`;
        }
    }
    // let body = `<h1>Verification Status</h1>${boxes}
    // <button onclick="viewinfo(); return false;">OK</button>`;
    let body = `<div onclick="viewinfo(); return false;" style = " display:flex; width:100%; justify-content:right;">
    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M16.1894 31.3166C24.5961 31.3166 31.4111 24.5016 31.4111 16.0949C31.4111 7.68826 24.5961 0.873291 16.1894 0.873291C7.78274 0.873291 0.967773 7.68826 0.967773 16.0949C0.967773 24.5016 7.78274 31.3166 16.1894 31.3166Z" fill="#FF4D4D"/>
    <path d="M20.756 11.5286L11.623 20.6616" stroke="white" stroke-width="3.04433" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M11.623 11.5286L20.756 20.6616" stroke="white" stroke-width="3.04433" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
</div>
    <h1>Verification Status</h1>${boxes}`;

    let accorinfo = document.querySelector(".verification");
    accorinfo.innerHTML = body;
    accorinfo.classList.toggle("active");
    document.querySelector("body").classList.toggle("blur");
}

function dealerprompt(name=null,forewardlink=null,backwardlink=null,formurl=null){
    let body = ``;
    if(name == 'orderrefund'){
        body = `<h1>Select Payment Slip</h1>
        <form method="post" action="${formurl}" enctype="multipart/form-data">
        <div class="input"><label>Payslip</label><input type="file" name="payslip" accept=".png, .jpg, .jpeg, .pdf">
        </form>
        <div class="buttons">
        <button onclick="${backwardlink}" class="button red">Cancel</button>
        <button onclick="${forewardlink}" class="button">Submit</button>
        </div>
        `;
    }

    let accorinfo = document.querySelector(".verification");
    accorinfo.innerHTML = body;
    accorinfo.classList.toggle("active");
    document.querySelector("body").classList.toggle("blur");
}