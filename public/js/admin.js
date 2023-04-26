function adminprompt(variant=null,forwardlink=null,backwardlink=null){
    console.log("called");
    let body = ``;
    if(variant == 'confirmation'){
        body = `<h1>Confirm Action</h1>
        <p>Are you sure you want to do this?</p>
        <div class="buttons">
        <button onclick="adminprompt()" class="button red">Cancel</button>
        <button onclick="location.href='${forwardlink}'" class="button">Yes</button>
        </div>
        `;
    }

    let accorinfo = document.querySelector(".verification");
    accorinfo.innerHTML = body;
    accorinfo.classList.toggle("active");
    document.querySelector("body").classList.toggle("blur");
}