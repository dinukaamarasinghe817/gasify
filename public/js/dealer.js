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
    let body = `<h1>Verification Status</h1>${boxes}
    <button onclick="viewinfo(); return false;">OK</button>`;

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