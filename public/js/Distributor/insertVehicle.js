// const form = document.querySelector(".body-content form");
const form = document.querySelector(".body-content form");
const submitbtn = form.querySelector("div button");
const errText = form.querySelector(".err-txt1 p");

form.onsubmit = (e) => {
    e.preventDefault(); //prevent the form auto submitting
}

submitbtn.onclick = () => {
    let xhr  = new XMLHttpRequest(); //create new xml object

    xhr.open('POST', "../../controller/Distributor/includes/insertVehicle.inc.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            let data = xhr.response;
            if(data == "success") {
                document.querySelector("body").innerHTML = data;
                location.href="insertVehicle.php";
            }else {
                errText.textContent = data;
                errText.style.display = "block";
            }
        }
    }
    
    let formdata = new FormData(form);
    xhr.send(formdata);
} 


function viewVehicle() {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', "../../controller/Distributor/includes/insertVehicle.inc.php",true);

    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            let data = xhr.response;
            location.href="viewVehicle.php";
        }
    }
    xhr.send();
}




