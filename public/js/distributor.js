
// Purchase Order => calculate subtotals and totals according to quantities 
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
    return total.toLocaleString('en-US');
}

// pending distributions => toggle button 
    function Animatedtoggle() {
        let toggle = document.querySelector('.toggle');
        let text = document.querySelector('.text');

        toggle.classList.toggle('active');

        if(toggle.classList.contains('active')) {
            text.innerHTML = "Enable";
        }else {
            text.innerHTML = "Disable";
        }
    }

    // vehicle open & close popups
    
    // function openPopup() {
    //     let popup = document.getElementById("popup");
    //     popup.classList.add("open-popup");

    // }
    // function closePopup() {
    //     let popup = document.getElementById("popup");
    //     popup.classList.remove("open-popup");

    // }



 