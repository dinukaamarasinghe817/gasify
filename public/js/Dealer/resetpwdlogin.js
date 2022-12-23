const form = document.querySelector('form');
const btn = document.querySelector('form button');
const error = document.querySelector('.error-txt');
const errorclose = document.querySelector('.error-txt a');

form.onsubmit = (e)=>{
    e.preventDefault();
}

function sub(email,token){
    let xhr = new XMLHttpRequest(); //new xml object
    let link = "../../controller/Dealer/resetpwdentered.php?email="+email+"&token="+token;
    xhr.open('POST', link , true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            console.log(data);
            if(data == 'success'){
                location.href = 'index.php';
            }else{
                const message = error.querySelector('p')
                console.log(data);
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