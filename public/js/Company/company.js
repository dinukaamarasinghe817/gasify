function showImage(event) {
    let imgPreview = document.getElementById('ff');
    imgPreview.src = URL.createObjectURL(event.files[0]);
}
function setQuota() {
    /*var formData = new FormData();
    formData.append("customer", customer);
    formData.append("quota", "r");*/
    console.log("customer");
    /*var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
    }
};
xmlhttp.open("POST", "../Compny/setQuota");
xmlhttp.send();*/
}
function resetQuota() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
        }
    };
    xmlhttp.open("POST", "../Compny/resetQuota");
    xmlhttp.send();
}