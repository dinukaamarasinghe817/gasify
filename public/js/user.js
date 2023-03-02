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

class Chart{
    constructor(type,data,index){
        this.type(data,index);
    }

    bar(data,index){
        let content = `<canvas id="bargraph${index}" ></canvas>
        <script>
        let ctx${index} = document.getElementById("bargraph${index}")
        new Chart(ctx${index}, {
            type: "bar",
            data: {
                
            labels: '.phpArrtoJs(${data['labels']}).',
            datasets: [{
                label: "${data['y']}",
                data: '.phpArrtoJs(${data['vector']}).',
                backgroundColor: "${data['color']}"
            }]
            },
            options: {
                scales: {
                    y: {
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
        </script>`;
        return content;
    }
}