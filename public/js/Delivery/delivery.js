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

}

function fillProgress() {
    var width = document.getElementById('cprogress').clientWidth;
    console.log(width + "%");
    document.getElementById('cprogress').style.width = width + "%";
} function collapse(div, id) {
    var coll = document.getElementsByClassName("collapsible");
    var i;
    div.classList.toggle("active");
    var content = document.getElementById(id);
    if (content.style.maxHeight) {
        content.style.maxHeight = null;
        document.getElementById(id + "row").style.display = "none";
        const keyframes = [
            { transform: "rotate(180deg)" },
            { transform: "rotate(0deg)" },
        ];
        const options = {
            duration: 500,
            easing: "ease",
            fill: "forwards",
        };
        const animation = div.animate(keyframes, options);
    } else {
        document.getElementById(id + "row").style.display = "table-row";
        content.style.maxHeight = content.scrollHeight + "px";
        const keyframes = [
            { transform: "rotate(0deg)" },
            { transform: "rotate(180deg)" },
        ];
        const options = {
            duration: 500,
            easing: "ease",
            fill: "forwards",
        };
        const animation = div.animate(keyframes, options);
    }
}
