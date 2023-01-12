<?php
class BodyHeader{
    public function __construct($data){
        $image = BASEURL.'/public/img/profile/'.$data['image'];
        date_default_timezone_set("Asia/Colombo");
        $date = date('j M Y');
        // echo '<section class="body-header">
        //             <div class="body-header-left">
        //                 <p class="today">Today</p>
        //                 <p class="date">'.$date.'</p>
        //             </div>
        //             <div class="body-header-right">
        //                 <button class="bell">
        //                     <svg width="30" height="33" viewBox="0 0 30 33" fill="none" xmlns="http://www.w3.org/2000/svg">
        //                         <path d="M23.4075 10.563C23.4075 8.29194 22.5053 6.11391 20.8994 4.50804C19.2936 2.90217 17.1155 2 14.8445 2C12.5734 2 10.3954 2.90217 8.78954 4.50804C7.18366 6.11391 6.28149 8.29194 6.28149 10.563C6.28149 20.5531 2 23.4075 2 23.4075H27.689C27.689 23.4075 23.4075 20.5531 23.4075 10.563Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        //                         <path d="M17.3145 29.1157C17.0635 29.5483 16.7034 29.9073 16.2701 30.1569C15.8368 30.4065 15.3455 30.5378 14.8455 30.5378C14.3454 30.5378 13.8541 30.4065 13.4208 30.1569C12.9875 29.9073 12.6274 29.5483 12.3765 29.1157" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        //                     </svg>
        //                 </button>
        //                 <button class="profile" onclick="logoutmenu(); return false;"><img src='.$image.' alt=""></button>
        //                 <div class="logout-menu">
        //                     <ul>
        //                         <li>
        //                             <svg width="22" height="22" viewBox="0 0 19 22" fill="none" xmlns="http://www.w3.org/2000/svg">
        //                                 <path d="M18 20.125V18C18 16.8728 17.5522 15.7918 16.7552 14.9948C15.9582 14.1978 14.8772 13.75 13.75 13.75H5.25C4.12283 13.75 3.04183 14.1978 2.2448 14.9948C1.44777 15.7918 1 16.8728 1 18V20.125" stroke="#8A8B9F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        //                                 <path d="M9.5 9.5C11.8472 9.5 13.75 7.59721 13.75 5.25C13.75 2.90279 11.8472 1 9.5 1C7.15279 1 5.25 2.90279 5.25 5.25C5.25 7.59721 7.15279 9.5 9.5 9.5Z" stroke="#8A8B9F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        //                             </svg>
        //                             <a href="profile.php">Profile</a>
        //                         </li>
        //                         <li>
        //                             <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
        //                                 <path d="M7.43072 20.2922H3.14357C2.57506 20.2922 2.02984 20.0663 1.62784 19.6643C1.22584 19.2623 1 18.7171 1 18.1486V3.14357C1 2.57506 1.22584 2.02984 1.62784 1.62784C2.02984 1.22584 2.57506 1 3.14357 1H7.43072" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        //                                 <path d="M14.9336 16.005L20.2925 10.646L14.9336 5.28711" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        //                                 <path d="M20.2921 10.646H7.43066" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        //                             </svg>
        //                             <a href="" onclick ="logout(); return false;" style.color = "red">Logout</a>
        //                         </li>
        //                     </ul>
        //                 </div>
                        
        //             </div>
        //         </section>';
        // if(isset($data['error'])){
        //     echo '<div class="error-txt dashboard">
        //                 <a onclick="errorclose();">
        //                 <svg width="25" height="25" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
        //                     <path d="M17.6682 32.2388C25.9525 32.2388 32.6682 25.523 32.6682 17.2388C32.6682 8.9545 25.9525 2.23877 17.6682 2.23877C9.38391 2.23877 2.66818 8.9545 2.66818 17.2388C2.66818 25.523 9.38391 32.2388 17.6682 32.2388Z" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
        //                     <path d="M22.1682 12.7388L13.1682 21.7388" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
        //                     <path d="M13.1682 12.7388L22.1682 21.7388" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
        //                 </svg>
        //                 </a>
        //                 <p><b>ERROR : </b>'.$data['error'].'</p>
        //             </div>
        //             <script src="'.BASEURL.'/public/js/Dealer/signup.js"></script>';
        // }
        echo '<section class="body-header">
                <div class="body-header-left">
                    <p class="date">'.$data['name'].'</p>
                    <p class="today">'.$date.'</p>
                </div>
                <div class="body-header-right">
                    <button class="bell">
                        <svg width="22" height="25" viewBox="0 0 30 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.4075 10.563C23.4075 8.29194 22.5053 6.11391 20.8994 4.50804C19.2936 2.90217 17.1155 2 14.8445 2C12.5734 2 10.3954 2.90217 8.78954 4.50804C7.18366 6.11391 6.28149 8.29194 6.28149 10.563C6.28149 20.5531 2 23.4075 2 23.4075H27.689C27.689 23.4075 23.4075 20.5531 23.4075 10.563Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M17.3145 29.1157C17.0635 29.5483 16.7034 29.9073 16.2701 30.1569C15.8368 30.4065 15.3455 30.5378 14.8455 30.5378C14.3454 30.5378 13.8541 30.4065 13.4208 30.1569C12.9875 29.9073 12.6274 29.5483 12.3765 29.1157" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <button class="profile" onclick="logoutmenu(); return false;"><img src="'.$image.'" alt=""></button>
                    <div class="logout-menu">
                        <ul>
                            <li>
                                <svg width="22" height="22" viewBox="0 0 19 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18 20.125V18C18 16.8728 17.5522 15.7918 16.7552 14.9948C15.9582 14.1978 14.8772 13.75 13.75 13.75H5.25C4.12283 13.75 3.04183 14.1978 2.2448 14.9948C1.44777 15.7918 1 16.8728 1 18V20.125" stroke="#8A8B9F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9.5 9.5C11.8472 9.5 13.75 7.59721 13.75 5.25C13.75 2.90279 11.8472 1 9.5 1C7.15279 1 5.25 2.90279 5.25 5.25C5.25 7.59721 7.15279 9.5 9.5 9.5Z" stroke="#8A8B9F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <a href="profile.php">Profile</a>
                            </li>
                            <li>
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.43072 20.2922H3.14357C2.57506 20.2922 2.02984 20.0663 1.62784 19.6643C1.22584 19.2623 1 18.7171 1 18.1486V3.14357C1 2.57506 1.22584 2.02984 1.62784 1.62784C2.02984 1.22584 2.57506 1 3.14357 1H7.43072" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M14.9336 16.005L20.2925 10.646L14.9336 5.28711" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M20.2921 10.646H7.43066" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <a href="'.BASEURL.'/signout" style.color = "red">Logout</a>
                            </li>
                        </ul>
                    </div>
                    
                </div>
            </section>';
        
        // javascript functions on html elements
        // echo '<script>
        //         const navtiles = document.querySelectorAll(".nav-tile");
        //         const tileanchor = document.querySelectorAll(".nav-tile a");

        //         // click body change on nav tiles
        //         for (let i=0; i<tileanchor.length; i++) {
        //             // console.log(tileanchor[i]);
        //             tileanchor[i].onclick = function(){
        //                 let j=0;
        //                 while(j<tileanchor.length){
        //                     tileanchor[j++].classList.remove("active");
        //                     let a = tileanchor[j-1].querySelectorAll("svg path");
        //                     for(let b=0; b<a.length; b++) {
        //                         a[b].style.stroke = "#8A8B9F";
        //                     }
        //                 }
        //                 tileanchor[i].classList.add("active");
        //                 let a = tileanchor[i].querySelectorAll("svg path");
        //                 for(let b=0; b<a.length; b++) {
        //                     a[b].style.stroke = "#ffffff";
        //                 }
        //                 if(tileanchor[i].classList.contains("stock")){
                            
        //                 }
        //                 if(tileanchor[i].classList.contains("dashboard")){
                            
        //                 }
                        
        //             }
        //         }

        //         // hover effect on nav tiles
        //         for (let i=0; i<navtiles.length; i++) {

        //             let anc = navtiles[i].querySelector("a");
                    
        //             if(!navtiles[i].classList.contains("active")){
                
        //                 // on mouse over the tile
        //                 navtiles[i].onmouseover = function(){
        //                     let icon = navtiles[i].querySelectorAll("a svg path");
        //                     let j = 0;
        //                     while(j<icon.length){
        //                         icon[j++].style.stroke = "white";
        //                     }
                            
        //                 }
                
        //                 // on mouse out of the tile
        //                 navtiles[i].onmouseout = function(){
        //                     let icon = navtiles[i].querySelectorAll("a svg path");
        //                     let j = 0;
        //                     while(j<icon.length){
        //                         if(anc.classList.contains("active")){
        //                             j++;
        //                         }else{
        //                             icon[j++].style.stroke = "#8A8B9F";
        //                         }
        //                     }
                            
        //                 }
                
        //             }
        //         }

        //         function logoutmenu(){
        //             let menu = document.querySelector(".logout-menu");
                    
        //             if(menu.style.display === "flex"){
        //                 console.log("changed to none");
        //                 menu.style.display = "none";
        //             }else{
        //                 console.log("changed to flex");
        //                 menu.style.display = "flex";
        //             }
                
        //         }

        //         function logout(){
        //             location.href = "'.BASEURL.'/signout/index";
        //         }
        //     </script>';
        echo "<script>
                function logoutmenu(){
                    let menu = document.querySelector('.logout-menu');
                    menu.classList.toggle('active');
                    if(menu.style.display === 'flex'){
                        console.log('changed to none');
                        menu.style.display = 'none';
                    }else{
                        console.log('changed to flex');
                        menu.style.display = 'flex';
                    }
                    let body = document.querySelector('body');
                    body.classList.toggle('blur');
                }
                
                function logout(){
                    let xhr = new XMLHttpRequest(); //new xml object
                    xhr.open('POST', '../../controller/Dealer/logout.php', true);
                    xhr.onload = ()=>{
                        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
                            let data = xhr.response;
                            console.log(data);
                            location.href = '../../index.php';
                        }
                    }
                    xhr.send();
                }
                </script>";
    }
}
?>