<?php

class SelectUser{
    public function __construct($url){
        $this->generatehtml($url);
    }

    public function generatehtml($url){
        echo '<div class="wrapper">

                <div class="topic">
                    <h1>Select User Type</h1>
                    <p>To continue, please select your user type</p>
                </div>

                <form action="'.$url.'" method="post">

                    <select name="user" class="custom-select">
                        <option value="admin"></option>
                        <option value="company"></option>
                        <option value="distributor"></option>
                        <option value="customer"></option>
                        <option value="dealer"></option>
                        <option value="deliveryperson"></option>
                    </select>
                    
                    <button type="submit">
                        Next
                        <svg width="25" height="25" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.22949 19.2158H34.2295" stroke="white" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M19.2295 4.21582L34.2295 19.2158L19.2295 34.2158" stroke="white" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>

            </div>
            
            
            <script>
                class CustomSelect {
                
                constructor(originalSelect){
                    const tiles = [];
                    tiles[0]= "<img src="'.BASEURL.'/public/img/people/admin.png" alt=""><p>Admin</p>";
                    tiles[1]= "<img src="'.BASEURL.'/public/img/people/company.png" alt=""><p>Company</p>";
                    tiles[2]= "<img src="'.BASEURL.'/public/img/people/distributor.png" alt=""><p>Distributor</p>";
                    tiles[3]= "<img src="'.BASEURL.'/public/img/people/customer.png" alt=""><p>Customer</p>";
                    tiles[4]= "<img src="'.BASEURL.'/public/img/people/dealer.png" alt=""><p>Dealer</p>";
                    tiles[5]= "<img src="'.BASEURL.'/public/img/people/deliveryperson.png" alt=""><p>Delivery Person</p>";

                    this.originalSelect = originalSelect;
                    this.customSelect = document.createElement("div");
                    this.customSelect.classList.add("users");

                    this.originalSelect.querySelectorAll("option").forEach((optionElement,index) => {
                        const itemElement = document.createElement("div");
                        itemElement.classList.add("user");
                        itemElement.innerHTML = tiles[index];
                        console.log(index);
                        // itemElement.textContent = optionElement.textContent;
                        this.customSelect.appendChild(itemElement);

                        if(optionElement.selected){
                            this.select(itemElement);
                        }

                        itemElement.addEventListener("click", ()=>{
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

            document.querySelectorAll(".custom-select").forEach(selectElement => {
                new CustomSelect(selectElement);
            });
        </script>';
    }

    public function generatejavascript(){
        echo '<script>
                let BASEURL = "<?php echo BASEURL; ?>";
                    class CustomSelect {
                    
                    constructor(originalSelect){
                        const tiles = [];
                        tiles[0]= "<img src="'.BASEURL.'/public/img/people/admin.png" alt=""><p>Admin</p>";
                        tiles[1]= "<img src="'.BASEURL.'/public/img/people/company.png" alt=""><p>Company</p>";
                        tiles[2]= "<img src="'.BASEURL.'/public/img/people/distributor.png" alt=""><p>Distributor</p>";
                        tiles[3]= "<img src="'.BASEURL.'/public/img/people/customer.png" alt=""><p>Customer</p>";
                        tiles[4]= "<img src="'.BASEURL.'/public/img/people/dealer.png" alt=""><p>Dealer</p>";
                        tiles[5]= "<img src="'.BASEURL.'/public/img/people/deliveryperson.png" alt=""><p>Delivery Person</p>";

                        this.originalSelect = originalSelect;
                        this.customSelect = document.createElement("div");
                        this.customSelect.classList.add("users");

                        this.originalSelect.querySelectorAll("option").forEach((optionElement,index) => {
                            const itemElement = document.createElement("div");
                            itemElement.classList.add("user");
                            itemElement.innerHTML = tiles[index];
                            console.log(index);
                            // itemElement.textContent = optionElement.textContent;
                            this.customSelect.appendChild(itemElement);

                            if(optionElement.selected){
                                this.select(itemElement);
                            }

                            itemElement.addEventListener("click", ()=>{
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

                document.querySelectorAll(".custom-select").forEach(selectElement => {
                    new CustomSelect(selectElement);
                });
            </script>';
    }
}