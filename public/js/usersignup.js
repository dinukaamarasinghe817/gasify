const form = document.querySelector('form');
form.onsubmit = (e)=>{
    e.preventDefault();
}

class CustomSelect {
    
    constructor(originalSelect){

        const tiles = [];
        // tiles[0]= '<img src="public/img/people/admin.png" alt=""><p>Admin</p>';
        tiles[0]= '<img src="http://localhost/mvc/public/img/people/company.png" alt=""><p>Company</p>';
        // tiles[2]= '<img src="public/img/people/distributor.png" alt=""><p>Distributor</p>';
        tiles[1]= '<img src="http://localhost/mvc/public/img/people/customer.png" alt=""><p>Customer</p>';
        // tiles[4]= '<img src="public/img/people/dealer.png" alt=""><p>Dealer</p>';
        tiles[2]= '<img src="http://localhost/mvc/public/img/people/deliveryperson.png" alt=""><p>Delivery Person</p>';

        this.originalSelect = originalSelect;
        this.customSelect = document.createElement("div");
        this.customSelect.classList.add("users");

        this.originalSelect.querySelectorAll("option").forEach((optionElement,index) => {
            const itemElement = document.createElement("div");
            itemElement.classList.add("user");
            itemElement.innerHTML = tiles[index];
            
            this.customSelect.appendChild(itemElement);

            if(optionElement.selected){
                this.select(itemElement);
            }

            itemElement.addEventListener('click', ()=>{
                if(this.originalSelect.multiple && itemElement.classList.contains("selected")){
                    this.deselect(itemElement);
                }else{
                    this.select(itemElement);
                }
            });
        });

        this.originalSelect.insertAdjacentElement("afterend", this.customSelect);
        this.originalSelect.style.display = "none";
    }

    select(itemElement){
        const index = Array.from(this.customSelect.children).indexOf(itemElement);

        if(!this.originalSelect.multiple){
            this.customSelect.querySelectorAll(".selected").forEach(el => {
                el.classList.remove("selected");
            });
        }

        this.originalSelect.querySelectorAll("option")[index].selected = true;
        itemElement.classList.add("selected");
    }
    
    deselect(itemElement){
        const index = Array.from(this.customSelect.children).indexOf(itemElement);
    
        this.originalSelect.querySelectorAll("option")[index].selected = true;
        itemElement.classList.remove("selected");

    }
}

document.querySelectorAll('.custom-select').forEach(selectElement => {
    new CustomSelect(selectElement);
});


// function redirecttouserSignin(){
//     let user = document.querySelector('.custom-select').value;
//     switch(user){
//         case 'admin':
//             location.href = 'view/Admin/index.php';
//             break;
//         case 'company':
//             location.href = 'view/Company/login.php';
//             break;
//         case 'distributor':
//             location.href = 'view/Distributor/login.php';
//             break;
//         case 'customer':
//             location.href = 'view/Customer/login.php';
//             break;
//         case 'dealer':
//             location.href = 'view/Dealer/index.php';
//             break;
//         case 'deliveryperson':
//             location.href = 'view/Delivery/login.php';
//             break;
//         default:
//             break;
//     }
// }

function redirecttouserSignup(){
    let user = document.querySelector('.custom-select').value;
    switch(user){
        case 'company': // can't found
            location.href = 'http://localhost/mvc/signup/company';
            break;
        case 'customer':
            location.href = 'http://localhost/mvc/signup/customer';
            break;
        case 'deliveryperson': // can't found
            location.href = 'http://localhost/mvc/signup/deliveryperson';
            break;
        default:
            break;
    }
}
