function showImage(event) {
    console.log("hello");
    let imgPreview = document.getElementById('ff');
    imgPreview.src = URL.createObjectURL(event.files[0]);
}
function setQuota(div) {
    var customerName = div.getAttribute("key");
    var formData = new FormData();
    formData.append("customer", customerName);
    formData.append("quota", document.getElementById(customerName.toLowerCase()).value);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById(customerName.toLowerCase()).value = "";
        }
    };
    xmlhttp.open("POST", "../Compny/setQuota");
    xmlhttp.send(formData);
}
function resetQuota(div) {
    var customerName = div.getAttribute("key");
    var formData = new FormData();
    formData.append("customer", customerName);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
        }
    };
    xmlhttp.open("POST", "../Compny/resetQuota");
    xmlhttp.send(formData);
}
function removeStyles(div) {
    console.log("heas");
    div.style.removeProperty('display');

}
function issueOrder(div) {
    var orderID = div.getAttribute("key");
    var formData = new FormData();
    formData.append("orderID", orderID);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
        }
    };
    xmlhttp.open("POST", "../Compny/issueOrder");
    xmlhttp.send(formData);

}
function delayOrder(div) {
    var orderID = div.getAttribute("key");
    var formData = new FormData();
    formData.append("orderID", orderID);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
        }
    };
    xmlhttp.open("POST", "../Compny/delayOrder");
    xmlhttp.send(formData);

}
function changeOrderDetails(productID, unitPrice, stockQty, orderID, resultArray) {
    console.log(orderID);
    var quantity = document.getElementById(productID + "1").value;
    if (quantity < stockQty) {
        document.getElementById(productID + "2").src = "http://localhost/mvc/public/icons/check.png";
    } else {
        document.getElementById(productID + "2").src = "http://localhost/mvc/public/icons/warning.png";
    }
    document.getElementById(productID + "3").innerHTML = (quantity * unitPrice).toLocaleString('en-us');
}