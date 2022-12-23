<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo BASEURL ?>/public/css/style.css">
</head>
<body>

    <?php
    $select_user = new SelectUser($data['url']);
    ?>
    <script>
        let BASEURL = "<?php echo BASEURL; ?>";
            class CustomSelect {
            
            constructor(originalSelect){
                const tiles = [];
                tiles[0]= '<img src="'+BASEURL+'/public/img/people/admin.png" alt=""><p>Admin</p>';
                tiles[1]= '<img src="'+BASEURL+'/public/img/people/company.png" alt=""><p>Company</p>';
                tiles[2]= '<img src="'+BASEURL+'/public/img/people/distributor.png" alt=""><p>Distributor</p>';
                tiles[3]= '<img src="'+BASEURL+'/public/img/people/customer.png" alt=""><p>Customer</p>';
                tiles[4]= '<img src="'+BASEURL+'/public/img/people/dealer.png" alt=""><p>Dealer</p>';
                tiles[5]= '<img src="'+BASEURL+'/public/img/people/deliveryperson.png" alt=""><p>Delivery Person</p>';

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
    </script>
</body>
</html>