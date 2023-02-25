setInterval(refreshnotification, 1000);
function refreshnotification(){
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://localhost/mvc/notification/count', true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            if(data){
                let bell = document.querySelector('.body-header-right .bell span');
                if(data != 0){
                    bell.innerHTML = `<p class='active'>`+data+`</p>`;
                }else{
                    bell.innerHTML = ``;
                }
            }
        }
    }
    xhr.send();
}