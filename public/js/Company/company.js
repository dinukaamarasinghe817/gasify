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
            location.href = "../Compny/limitquota";
        }
    };
    xmlhttp.open("POST", "../Compny/setQuota");
    xmlhttp.send(formData);
}
function resetQuota(div) {
    var cutomerType = div.getAttribute("key");
    if (div.checked) {
        var formData = new FormData();
        formData.append("customer", cutomerType);
        formData.append("state", "ON");
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                location.href = "../Compny/limitquota";
            }
        };
        xmlhttp.open("POST", "../Compny/resetQuota");
        xmlhttp.send(formData);
    } else {
        var formData = new FormData();
        formData.append("customer", cutomerType);
        formData.append("state", "OFF");
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                location.href = "../Compny/limitquota";
            }
        };
        xmlhttp.open("POST", "../Compny/resetQuota");
        xmlhttp.send(formData);
    }

    /*var customerName = div.getAttribute("key");
    var formData = new FormData();
    formData.append("customer", customerName);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
        }
    };
    xmlhttp.open("POST", "../Compny/resetQuota");
    xmlhttp.send(formData);*/
}
function removeStyles(div) {
    console.log("heas");
    div.style.removeProperty('display');

}
function issue(productCount, orderID) {
    var formData = new FormData();
    var length = 0;
    for (let index = 1; index < productCount; index++) {
        var element = document.getElementById(orderID + String(index) + "1");
        if (typeof (element) != 'undefined' && element != null) {
            formData.append(element.getAttribute("key"), element.value);
            length += 1;
        }

    }
    for (var pair of formData.entries()) {
        var newFormData = new FormData();
        var count = 0;
        newFormData.append(pair[0], pair[1]);
        newFormData.append('key', pair[0]);
        newFormData.append('orderID', orderID);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                count += 1;
                if (count == length) {
                    location.href = "../Compny/orders";
                }
            }
        };
        xmlhttp.open("POST", "../Compny/issueOrder");
        xmlhttp.send(newFormData);
    }

}
function issueOrder(div) {
    var orderID = div.getAttribute("key");
    var productCountArray = [];
    var productCount = 0;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            productCountArray = JSON.parse(this.responseText);
            productCount = parseInt(productCountArray[0].count) + 1;
            issue(productCount, orderID);
        }
    };
    xmlhttp.open("POST", "../Compny/ProductCount");
    xmlhttp.send();
}
function delayOrder(div) {
    var orderID = div.getAttribute("key");
    var formData = new FormData();
    formData.append("orderID", orderID);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            location.href = "../Compny/orders";
        }
    };
    xmlhttp.open("POST", "../Compny/delayOrder");
    xmlhttp.send(formData);

}
function changeOrderDetails(imgIndex, imgCount, orderID, productID, unitPrice, stockQty, orderID, resultArray) {

    var quantity = document.getElementById(orderID + String(imgIndex) + "1").value;
    if (quantity.length == 0) {
        document.getElementById(orderID + String(imgIndex) + "1").value = 0;
        quantity = 0;
    };
    if (quantity <= stockQty) {
        document.getElementById(orderID + String(imgIndex) + "2").src = "http://localhost/mvc/public/icons/check.png";
    } else {
        document.getElementById(orderID + String(imgIndex) + "2").src = "http://localhost/mvc/public/icons/warning.png";
    }
    document.getElementById(productID + "3").innerHTML = (quantity * unitPrice).toLocaleString('en-us');
    checkIFOrderIsClean(orderID, resultArray, imgCount);

}
function checkIFOrderIsClean(orderID, resultArray, imgCount) {
    var imageIDs = resultArray.split(" ");
    imageIDs.pop();
    var isclean = true;
    for (let index = 0; index < imgCount; index++) {
        if (document.getElementById(orderID + String(index + 1) + 2).src == "http://localhost/mvc/public/icons/warning.png") {
            isclean = false;
        }

    }
    if (isclean) {
        document.getElementById(orderID + 'issue').style.pointerEvents = "auto";
        document.getElementById(orderID + 'issue').style.backgroundColor = "dodgerblue";
    } else {
        document.getElementById(orderID + 'issue').style.pointerEvents = "none";
        document.getElementById(orderID + 'issue').style.backgroundColor = "#80B3FF";
    }
}