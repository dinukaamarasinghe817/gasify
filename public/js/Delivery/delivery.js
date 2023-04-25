function takeJob(orderID) {
    var formData = new FormData();
    formData.append("orderID", orderID);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            location.href = "../Delvery/deliveries";
        }
    };
    xmlhttp.open("POST", "../Delvery/acceptDelivery");
    xmlhttp.send(formData);

}
function cancelJob(orderID) {
    var formData = new FormData();
    formData.append("orderID", orderID);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            location.href = "../Delvery/currentdeliveries";
        }
    };
    xmlhttp.open("POST", "../Delvery/cancelDelivery");
    xmlhttp.send(formData);

}
function deliverJob(orderID) {
    var formData = new FormData();
    formData.append("orderID", orderID);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            location.href = "../Delvery/currentdeliveries";
        }
    };
    xmlhttp.open("POST", "../Delvery/deliverJob");
    xmlhttp.send(formData);

}