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