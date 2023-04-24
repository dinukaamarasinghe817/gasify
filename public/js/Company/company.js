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
    var preTotal = document.getElementById(orderID.toString() + productID.toString() + "3").getAttribute("value");
    console.log(preTotal);
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
    document.getElementById(orderID.toString() + productID.toString() + "3").innerHTML = (quantity * unitPrice).toLocaleString('en-us');
    document.getElementById(orderID.toString() + productID.toString() + "3").setAttribute("value", quantity * unitPrice);
    document.getElementById(orderID + "total").innerHTML = (document.getElementById(orderID + "total").getAttribute("value") - preTotal + (quantity * unitPrice)).toLocaleString('en-us');
    document.getElementById(orderID + "total").setAttribute("value", (document.getElementById(orderID + "total").getAttribute("value") - preTotal + (quantity * unitPrice)))
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
function addYearsToSelectBoxes(selectObject) {
    var formData = new FormData();
    formData.append("ID", selectObject.value);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var dateobj = new Date();
            var dateObject = dateobj.getFullYear();
            joinedDateArray = JSON.parse(this.responseText);
            joinedMonth = parseInt(joinedDateArray[0].joinedDate.split('-')[1]);
            joinedDate = parseInt(joinedDateArray[0].joinedDate.split('-')[0]);
            var yearFrom = document.getElementById("yearFrom");
            yearFrom.options.length = 0;
            option = document.createElement('option');
            option.value = "";
            option.text = "Year";
            option.disabled = true;
            option.setAttribute('selected', true);
            yearFrom.add(option);
            var yearTo = document.getElementById("yearTo");
            yearTo.options.length = 0;
            option = document.createElement('option');
            option.value = "";
            option.text = "Year";
            option.disabled = true;
            option.setAttribute('selected', true);
            yearTo.add(option);
            for (i = 0; i <= parseInt(dateObject - joinedDate); i += 1) {
                option = document.createElement('option');
                option.value = parseInt(joinedDate) + i;
                option.text = parseInt(joinedDate) + i;
                yearFrom.add(option);
                option = document.createElement('option');
                option.value = parseInt(joinedDate) + i;
                option.text = parseInt(joinedDate) + i;
                yearTo.add(option);
            }



        }
    };
    xmlhttp.open("POST", "../Compny/getDateRange");
    xmlhttp.send(formData);
}
function addMonthsToSelectBoxes(selectObject) {
    var yearSelectName = selectObject.getAttribute("name");
    var monthBox;
    if (yearSelectName == "yearFrom") {
        monthBox = "monthFrom";
    } else {
        monthBox = "monthTo";
    }
    var selectedYear = document.getElementById(yearSelectName).value;
    var currentYear = new Date().getFullYear();
    var currentMonth = new Date().getMonth();
    var formData = new FormData();
    formData.append("ID", document.getElementById("distNames").value);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            joinedDateArray = JSON.parse(this.responseText);
            joinedMonth = parseInt(joinedDateArray[0].joinedDate.split('-')[1]);
            joinedDate = parseInt(joinedDateArray[0].joinedDate.split('-')[0]);
            var selectMonth = document.getElementById(monthBox);
            selectMonth.options.length = 0;
            option = document.createElement('option');
            option.value = "";
            option.text = "Month";
            console.log(joinedDate)
            console.log(joinedMonth)
            option.setAttribute('selected', true);
            option.setAttribute('disabled', true);
            selectMonth.add(option);
            if (joinedDate == selectedYear) {
                for (i = joinedMonth; i <= 12; i += 1) {
                    console.log("hello");
                    option = document.createElement('option');
                    option.value = i;
                    option.text = i;
                    selectMonth.add(option);
                    //yearTo.add(option);
                }
            } else if (currentYear == selectedYear) {
                for (i = 1; i <= currentMonth + 1; i += 1) {
                    console.log("hello");
                    option = document.createElement('option');
                    option.value = i;
                    option.text = i;
                    selectMonth.add(option);
                    //yearTo.add(option);
                }
            } else {
                for (i = 1; i <= 12; i += 1) {
                    console.log("hello");
                    option = document.createElement('option');
                    option.value = i;
                    option.text = i;
                    selectMonth.add(option);
                    //yearTo.add(option);
                }

            }




        }
    };
    xmlhttp.open("POST", "../Compny/getDateRange");
    xmlhttp.send(formData);

}
function showCharts() {
    //var formData = new FormData();
    //formData.append("orderID", orderID);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //console.log(this.responseText);
        }
    };
    xmlhttp.open("POST", "../Compny/getCharts");
    xmlhttp.send();

}
function submitReport() {
    var formData = new FormData();
    formData.append("distID", document.getElementById('distNames').value);
    formData.append("from", document.getElementById('yearFrom').value + "." + document.getElementById('monthFrom').value);
    formData.append("to", document.getElementById('yearTo').value + "." + document.getElementById('monthTo').value);
    var table = document.getElementById("reporttable")
    var tableArr = [];
    for (let row of table.rows) {
        var tempArr = []
        for (let cell of row.cells) {
            tempArr.push(cell.innerText)
            //console.log(cell.innerText);
        }
        tableArr.push(tempArr);
    }
    formData.append("tableArr", JSON.stringify(tableArr));
    //console.log(formData.get("tableArr"));
    //console.log(typeof (tableArr));
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
        }
    };
    xmlhttp.open("POST", "../Reports/salesCompany");
    xmlhttp.send(formData);
}
function ooo() {
    console.log("hello world");
}