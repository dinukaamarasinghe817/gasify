function takeJob(orderID) {
    var formData = new FormData();
    formData.append("orderID", orderID);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            location.href = "../Delvery/redirectToPoolFromOrderDispatched";
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
            location.href = "../Delvery/redirectToPoolFromOrderCancelled";
        }
    };
    xmlhttp.open("POST", "../Delvery/cancelDelivery");
    xmlhttp.send(formData);

}
function deliverJob(orderID, charge) {
    var formData = new FormData();
    formData.append("orderID", orderID);
    formData.append("charge", charge);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            location.href = "../Delvery/redirectToPoolFromOrderDelivered";
        }
    };
    xmlhttp.open("POST", "../Delvery/deliverJob");
    xmlhttp.send(formData);

}
function addMonthsToSelectBoxes(div, joinedDate, joinedMonth) {
    var yearSelectName = div.getAttribute("name");
    var monthBox;
    if (yearSelectName == "yearFrom") {
        monthBox = "monthFrom";
    } else {
        monthBox = "monthTo";
    }
    var currentYear = new Date().getFullYear();
    var currentMonth = new Date().getMonth();
    if (div.value == joinedDate && div.value == currentYear) {
        var selectMonth = document.getElementById(monthBox);
        selectMonth.options.length = 0;
        option = document.createElement('option');
        option.value = "";
        option.text = "Month";
        option.setAttribute('selected', true);
        option.setAttribute('disabled', true);
        selectMonth.add(option);
        for (i = joinedMonth; i <= currentMonth + 1; i++) {
            option = document.createElement('option');
            option.value = i;
            option.text = i;
            selectMonth.add(option);
            //yearTo.add(option);
        }
    } else if (div.value == joinedDate) {
        var selectMonth = document.getElementById(monthBox);
        selectMonth.options.length = 0;
        option = document.createElement('option');
        option.value = "";
        option.text = "Month";
        option.setAttribute('selected', true);
        option.setAttribute('disabled', true);
        selectMonth.add(option);
        for (i = joinedMonth; i <= 12; i++) {
            option = document.createElement('option');
            option.value = i;
            option.text = i;
            selectMonth.add(option);
            //yearTo.add(option);
        }
    } else if (currentYear == div.value) {
        var selectMonth = document.getElementById(monthBox);
        selectMonth.options.length = 0;
        option = document.createElement('option');
        option.value = "";
        option.text = "Month";
        option.setAttribute('selected', true);
        option.setAttribute('disabled', true);
        selectMonth.add(option);
        for (i = 1; i <= currentMonth + 1; i++) {
            option = document.createElement('option');
            option.value = i;
            option.text = i;
            selectMonth.add(option);
            //yearTo.add(option);
        }

    } else {
        var selectMonth = document.getElementById(monthBox);
        selectMonth.options.length = 0;
        option = document.createElement('option');
        option.value = "";
        option.text = "Month";
        option.setAttribute('selected', true);
        option.setAttribute('disabled', true);
        selectMonth.add(option);
        for (i = 1; i <= 12; i += 1) {
            console.log("hello");
            option = document.createElement('option');
            option.value = i;
            option.text = i;
            selectMonth.add(option);
            //yearTo.add(option);
        }

    }
    console.log(monthBox);
}
function showCharts() {
    //var formData = new FormData();
    //formData.append("orderID", orderID);
    %3CmxGraphModel%3E%3Croot%3E%3CmxCell%20id%3D%220%22%2F%3E%3CmxCell%20id%3D%221%22%20parent%3D%220%22%2F%3E%3CmxCell%20id%3D%222%22%20value%3D%22%22%20style%3D%22group%22%20vertex%3D%221%22%20connectable%3D%220%22%20parent%3D%221%22%3E%3CmxGeometry%20x%3D%22369.5%22%20y%3D%22720%22%20width%3D%2240%22%20height%3D%2240%22%20as%3D%22geometry%22%2F%3E%3C%2FmxCell%3E%3CmxCell%20id%3D%223%22%20value%3D%22%22%20style%3D%22ellipse%3BwhiteSpace%3Dwrap%3Bhtml%3D1%3Baspect%3Dfixed%3B%22%20vertex%3D%221%22%20parent%3D%222%22%3E%3CmxGeometry%20width%3D%2240%22%20height%3D%2240%22%20as%3D%22geometry%22%2F%3E%3C%2FmxCell%3E%3CmxCell%20id%3D%224%22%20value%3D%22%22%20style%3D%22endArrow%3Dnone%3Bhtml%3D1%3BentryX%3D0%3BentryY%3D0%3BentryDx%3D0%3BentryDy%3D0%3BexitX%3D1%3BexitY%3D1%3BexitDx%3D0%3BexitDy%3D0%3B%22%20edge%3D%221%22%20parent%3D%222%22%20source%3D%223%22%20target%3D%223%22%3E%3CmxGeometry%20width%3D%2250%22%20height%3D%2250%22%20relative%3D%221%22%20as%3D%22geometry%22%3E%3CmxPoint%20x%3D%22-30%22%20y%3D%22-30%22%20as%3D%22sourcePoint%22%2F%3E%3CmxPoint%20x%3D%2220%22%20y%3D%22-80%22%20as%3D%22targetPoint%22%2F%3E%3C%2FmxGeometry%3E%3C%2FmxCell%3E%3CmxCell%20id%3D%225%22%20value%3D%22%22%20style%3D%22endArrow%3Dnone%3Bhtml%3D1%3BentryX%3D1%3BentryY%3D0%3BentryDx%3D0%3BentryDy%3D0%3BexitX%3D0%3BexitY%3D1%3BexitDx%3D0%3BexitDy%3D0%3B%22%20edge%3D%221%22%20parent%3D%222%22%20source%3D%223%22%20target%3D%223%22%3E%3CmxGeometry%20width%3D%2250%22%20height%3D%2250%22%20relative%3D%221%22%20as%3D%22geometry%22%3E%3CmxPoint%20x%3D%2244.14213562373095%22%20y%3D%22-40.85786437626905%22%20as%3D%22sourcePoint%22%2F%3E%3CmxPoint%20x%3D%2215.857864376268935%22%20y%3D%22-69.14213562373106%22%20as%3D%22targetPoint%22%2F%3E%3C%2FmxGeometry%3E%3C%2FmxCell%3E%3C%2Froot%3E%3C%2FmxGraphModel%3E

}

function fillProgress() {
    var width = document.getElementById('cprogress').clientWidth;
    console.log(width + "%");
    document.getElementById('cprogress').style.width = width + "%";
}