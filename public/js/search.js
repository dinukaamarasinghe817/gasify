// function tablesearch(){
//     let input,filter,table,tr,td,ncol,textvalue;

//     //intializing variables
//     input = document.getElementById('searchbar');
//     filter = input.ariaValueMax.toUpperCase();
//     table = document.querySelector('.styled-table');
//     tr = table.getElementsByTagName('td');
//     ncol = tr[0].cells.length;

//     //perform search
//     for(let i=0; i<tr.length; i++){
//         let flag = false;
//         for(let j=0; j<ncol; j++){
//             td = tr[i].getElementsByTagName('td')[j];
//             if(td){
//                 textvalue = td.textContent || td.innerText;
//                 if(textvalue.toUpperCase().indexOf(filter) > -1){
//                     // tr[i].style.display = '';
//                     flag = true;
//                 }else{
//                     // tr[i].style.display = 'none';
//                 }
//             }
//         }
//         if(flag){
//             tr[i].style.display = '';
//         }else{
//             tr[i].style.display = 'none';
//         }
//     }
// }

async function tablesearch(indexes){
    let input,filter,table,tr,td,ncol,textvalue;
    
    //intializing variables
    input = document.getElementById('searchbar');
    filter = input.value.toUpperCase();
    table = document.querySelector('table.styled-table');
    tr = table.getElementsByTagName('tr');
    ncol = tr[0].cells.length;
    let rowsDisplayed = 0;

    //hide all first
    await hidetable();

    //perform search
    for(let i=0; i<tr.length; i++){
      console.log("hello");
      for(let j=0; j<ncol; j++){
        td = tr[i].getElementsByTagName('td')[j];
        if(td){
            textvalue = td.textContent || td.innerText;
            console.log(td.textContent);
            if(textvalue.toUpperCase().indexOf(filter) > -1 && indexes.includes(j)){
              tr[i].style.display = '';
              rowsDisplayed++;
            }
        }
      }
    }

    // Add "No results found" row if no rows were displayed
    let noResultsMsg = document.getElementById("no-results-msg");
    if (!noResultsMsg) {
        noResultsMsg = document.createElement("div");
        noResultsMsg.id = "no-results-msg";
        table.parentElement.appendChild(noResultsMsg);
        noResultsMsg.style.padding = "10px";
        noResultsMsg.style.textAlign = "center"; 
    }
    if (rowsDisplayed === 0) {
        noResultsMsg.textContent = "No results found";
        noResultsMsg.style.display = "block";
    } else {
        noResultsMsg.textContent = "";
        noResultsMsg.style.display = "none";
    }
}

async function hidetable(){
  let input,filter,table,tr,td,ncol,textvalue;
    
  //intializing variables
  input = document.getElementById('searchbar');
  filter = input.value.toUpperCase();
  table = document.querySelector('table.styled-table');
  tr = table.getElementsByTagName('tr');
  ncol = tr[0].getElementsByTagName('td').length;

  for(let i=1; i<tr.length; i++){
    tr[i].style.display = 'none'
  }
  console.log("should print first");
}