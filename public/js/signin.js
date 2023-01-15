const form = document.querySelector('.form form');
// const continuebtn = form.querySelector('button');
// const error = document.querySelector('.error-txt');
// const errorclose = document.querySelector('.error-txt a');
// form.onsubmit = (e)=>{
//     e.preventDefault();
// }

// continuebtn.onclick = ()=>{
//     let xhr = new XMLHttpRequest(); //new xml object
//     xhr.open('POST', "../../controller/Dealer/login.php", true);
//     xhr.onload = ()=>{
//         if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
//             let data = xhr.response;
//             if(data == 'success'){
//                 location.href = 'dashboard.php';
//             }else{
//                 if(data == 'too many login attempts, you might want to reset your password'){
//                     const forgotpwd = form.querySelector('.forgotpwd a');
//                     forgotpwd.innerHTML = 'forgot password';
//                     forgotpwd.style.display = 'flex';
//                 }
//                 const message = error.querySelector('p');
//                 message.innerHTML = data;
//                 error.style.display = 'flex';
                
                
//             }
//         }
//     }
//     let formData = new FormData(form); // new form data object
//     xhr.send(formData);
// }

errorclose.onclick = () =>{
    let error = document.querySelector('.error-txt');
    console.log("cancel clicked");
    error.style.display = 'none';
}

function forgetpassword(url){
    let form = document.querySelector('.form form')
    let xhr = new XMLHttpRequest(); //new xml object
    xhr.open('POST', url, true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            if(data){
                let f = document.querySelector('.form');
                f.innerHTML = "<?php $fp = new ForgotPWD('reset'); ?>";
            }
        }
    }
    let formData = new FormData(form); // new form data object
    xhr.send(formData);
}
