const form = document.querySelector('form');
const btn = document.querySelector('form button');
const error = document.querySelector('.error-txt');
const errorclose = document.querySelector('.error-txt a');
form.onsubmit = (e)=>{
    e.preventDefault();
}
btn.onclick = () =>{
    console.log("clicked");
    let xhr = new XMLHttpRequest(); //new xml object
    xhr.open('POST', "../../controller/Dealer/resetpwd.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            if(data == 'success'){
                // location.href = 'index.php';
                const message = error.querySelector('p');
                message.innerHTML = "We have sent you a password reset email, please check your email";
                error.classList.add("success");
                error.style.display = 'flex';
            }else{
                console.log(data);
                const message = error.querySelector('p');
                message.innerHTML = data;
                error.style.display = 'flex';
            }
        }
    }
    let formData = new FormData(form); // new form data object
    xhr.send(formData);
}

errorclose.onclick = () =>{
    console.log("cancel clicked");
    error.style.display = 'none';
}