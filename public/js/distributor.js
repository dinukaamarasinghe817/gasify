function changeqty(id, unitprice) {
    id = parseInt(id);
    unitprice = parseFloat(unitprice);
    let inputstring = `.data${id} td input`;
    let input = document.querySelector(inputstring);
    let inputvalue = input.value;
    let subtotaltring = `.data${id} .subtotal`;
    let subtotal = document.querySelector(subtotaltring);
    subtotal.innerHTML = "Rs. "+(unitprice * inputvalue).toLocaleString('en-US')+".00";
    let total = document.querySelector('.total .amount');

    let totalvalue = gettotal();
    total.innerHTML = "Rs. " + totalvalue + " .00";
    // total.innerHTML = "Rs. "+(totalvalue).toLocaleString('en-US')+".00";

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
    return total.toLocaleString('en-US');
    // return total;
}

