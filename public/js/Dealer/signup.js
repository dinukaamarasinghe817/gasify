const form = document.querySelector('.form form');
// const continuebtn = form.querySelector('button');
// const errorclose = document.querySelector('.error-txt a');
// form.onsubmit = (e)=>{
//     e.preventDefault();
// }

console.log('loaded');

// continuebtn.onclick = ()=>{
    //     let xhr = new XMLHttpRequest(); //new xml object
    //     xhr.open('POST', "../../controller/Dealer/signup.php", true);
    //     xhr.onload = ()=>{
        //         if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            //             let data = xhr.response;
//             if(data == 'success'){
    //                 location.href = 'dashboard.php';
//             }else{
    //                 const message = error.querySelector('p')
    //                 message.innerHTML = data;
    //                 error.style.display = 'flex';
    //             }
    //         }
    //     }
    //     let formData = new FormData(form); // new form data object
    //     xhr.send(formData);
    // }
    
function errorclose(){
    let error = document.querySelector('.error-txt');
    console.log("cancel clicked");
    error.style.display = 'none';
}

function main(){
    console.log('submitted');
}