const navtiles = document.querySelectorAll('.nav-tile');
const tileanchor = document.querySelectorAll('.nav-tile a');

const content = document.querySelector('.body-content');
// const bodydata = document.querySelector('.body-content .content-data');
const stock = document.querySelector('.nav-tile .stock');

const topanchor = document.querySelectorAll('.top-panel ul li a');
// console.log(topanchor[0]);

const posubmitbtn = document.querySelector('.po tr td button');

// dashboardclicked();

// active nav tile
for (let i=0; i<tileanchor.length; i++) {
    // console.log(tileanchor[i]);
    tileanchor[i].onclick = function(){
        let j=0;
        while(j<tileanchor.length){
            tileanchor[j++].classList.remove('active');
            let a = tileanchor[j-1].querySelectorAll('svg path');
            for(let b=0; b<a.length; b++) {
                a[b].style.stroke = '#8A8B9F';
            }
        }
        tileanchor[i].classList.add('active');
        let a = tileanchor[i].querySelectorAll('svg path');
        for(let b=0; b<a.length; b++) {
            a[b].style.stroke = '#ffffff';
        }
        if(tileanchor[i].classList.contains('stock')){
            // stockclicked();
        }
        if(tileanchor[i].classList.contains('dashboard')){
            // dashboardclicked();
        }
        // console.log(tileanchor);
    }
}

// hover nav tile and icon color change
for (let i=0; i<navtiles.length; i++) {

    let anc = navtiles[i].querySelector('a');
    
    if(!navtiles[i].classList.contains('active')){

        // on mouse over the tile
        navtiles[i].onmouseover = function(){
            let icon = navtiles[i].querySelectorAll('a svg path');
            let j = 0;
            while(j<icon.length){
                icon[j++].style.stroke = 'white';
            }
            
        }

        // on mouse out of the tile
        navtiles[i].onmouseout = function(){
            let icon = navtiles[i].querySelectorAll('a svg path');
            let j = 0;
            while(j<icon.length){
                if(anc.classList.contains('active')){
                    j++;
                }else{
                    icon[j++].style.stroke = '#8A8B9F';
                }
            }
            
        }

    }
}

// function stockclicked(){
    
//     stockretrieve();
// }

function stockclicked(){
    let xhr = new XMLHttpRequest(); //new xml object
    xhr.open('POST', "../../controller/Dealer/stock.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            // console.log(data);
            if(data){
                // chnage innerHTML Ajax
                content.innerHTML = data;
                let stocktab = document.querySelectorAll('.top-panel ul li a');
                stocktab[0].classList.add('active');
                stocktab[1].classList.remove('active');
                stocktab[2].classList.remove('active');
                content.style.display = 'block';
            }
        }
    }
    // let formData = new FormData(form); // new form data object
    xhr.send();
}

function purchaseclicked(){
    let xhr = new XMLHttpRequest(); //new xml object
    xhr.open('POST', "../../controller/Dealer/purchase.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            if(data){
                // chnage innerHTML Ajax
                let bodydata = content.querySelector('.content-data');
                bodydata.innerHTML = data;
                let purchasetab = document.querySelectorAll('.top-panel ul li a');
                purchasetab[1].classList.add('active');
                purchasetab[0].classList.remove('active');
                purchasetab[2].classList.remove('active');
                // content.style.display = 'block';
            }
        }
    }
    // let formData = new FormData(form); // new form data object
    xhr.send();
}

for (let i=0; i<topanchor.length; i++) {
    console.log(topanchor[i]);
    topanchor[i].onmouseover = function(){
        topanchor[i].style.backgroundColor = 'black';
    }
    // topanchor[i].onclick = function(){
    //     let j=0;
    //     while(j<topanchor.length){
    //         topanchor[j++].classList.remove('active');
    //     }
    //     topanchor[i].classList.add('active');
    // }
    // console.log("after");
}

// function Hello(){
//     console.log("clicked perfectly");
// }

// posubmitbtn.onclick = () =>{
//     let xhr = new XMLHttpRequest(); //new xml object
//     xhr.open('POST', "../../controller/Dealer/purchaseorder.php", true);
//     xhr.onload = ()=>{
//         if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
//             let data = xhr.response;
//             if(data == 'success'){// redirect to history tab
//                 // location.href = 'history.php';
//             }else{
//                 // // const message = error.querySelector('p')
//                 // bodydata.innerHTML = data;
//                 // error.style.display = 'flex';
//             }
//         }
//     }
//     let formData = new FormData(form); // new form data object
//     xhr.send(formData);
// }

// const poinputs = document.querySelectorAll('.po tr td input');
// const posubtotals = document.querySelectorAll('.po tr .subtotal');

// change inline subtotals
// for(let i = 0; i < poinputs.length; i++){
//     poinputs[i].onchange = function(){
//         posubtotals[i].innerHTML = "Rs"+(poinputs[i].value);
//     }
// }


function pobuttonclicked(){
    const form = document.querySelector('.po');
    // var link = "../../controller/Dealer/purchaseorder.php?size="+numarray.length;
    // for (let i = 0; i < numarray.length; i++) {
    //     link = link+"&"+i+"="+numarray[i];
    // }
    // link = link.slice(0,-1);
    console.log("clicked");
    let xhr = new XMLHttpRequest(); //new xml object
    xhr.open('POST', "../../controller/Dealer/purchaseorder.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            // console.log(data);
            // redirect to history tab
            // if(data == 'success'){
            if(data == 'success'){
                // location.href = 'history.php';
                // console.log("outside func");
                // console.log(data);
                // historyclicked();
                location.href = 'showporeport.php';
            }else{
                // const message = error.querySelector('p')
                // bodydata.innerHTML = data;
                // error.style.display = 'flex';
            }
        }
    }
    let formData = new FormData(form); // new form data object
    xhr.send(formData);
}

function historyclicked(){
    let history = document.querySelector('.content-data');
    console.log("inside func");
    let xhr = new XMLHttpRequest(); //new xml object
    xhr.open('POST', "../../controller/Dealer/pohistory.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            console.log(data);
            // redirect to history tab
            if(data){
                // location.href = 'history.php';
                // historyclicked();
                history.innerHTML = data;
                let purchasetab = document.querySelectorAll('.top-panel ul li a');
                purchasetab[2].classList.add('active');
                purchasetab[1].classList.remove('active');
                purchasetab[0].classList.remove('active');
                // console.log(data);
            }else{
                // const message = error.querySelector('p')
                // bodydata.innerHTML = data;
                // error.style.display = 'flex';
            }
        }
    }
    // let formData = new FormData(form); // new form data object
    xhr.send();
}


// function changeqty(productid, unitprice){

// }
// let profile = document.querySelector('.body .profile');
// profile.onlcick = ()=>{
//     console.log('clicked');
// }

function logoutmenu(){
    let menu = document.querySelector('.logout-menu');
    
    if(menu.style.display === 'flex'){
        console.log('changed to none');
        menu.style.display = 'none';
    }else{
        console.log('changed to flex');
        menu.style.display = 'flex';
    }

}

function logout(){
    location.href = "'.BASEURL.'/signout/index";
}

function updatechart(){
    let variable = document.querySelector('.variable');
    let option = document.getElementById('period');
    // variable.innerHTML = '';
    console.log(option.value);
}

function dashboardclicked(){
    let xhr = new XMLHttpRequest(); //new xml object
    xhr.open('POST', "../../controller/Dealer/dashboard.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            console.log(data);
            if(data){
                // chnage innerHTML Ajax
                content.innerHTML = data;
                // let stocktab = document.querySelectorAll('.top-panel ul li a');
                // stocktab[0].classList.add('active');
                // stocktab[1].classList.remove('active');
                // stocktab[2].classList.remove('active');
                // content.style.display = 'flex';
            }
        }
    }
    // let formData = new FormData(form); // new form data object
    xhr.send();
}