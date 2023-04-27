<?php
class BodyHeader{
    public function __construct($data){
        $image = BASEURL.'/public/img/profile/'.$_SESSION['profile_image'];
        //echo $image;
        date_default_timezone_set("Asia/Colombo");
        $date = date('j M Y');
        echo '<section class="body-header">
                <div class="body-header-left">
                   
                <p class="date">'.$_SESSION['user_name'].'</p>
                <p class="today">'.userRole().'</p>
                </div>
                <div class="body-header-right">
                    <button class="bell" onclick="location.href=\''.BASEURL.'/notification\'">
                        <svg width="22" height="25" viewBox="0 0 30 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.4075 10.563C23.4075 8.29194 22.5053 6.11391 20.8994 4.50804C19.2936 2.90217 17.1155 2 14.8445 2C12.5734 2 10.3954 2.90217 8.78954 4.50804C7.18366 6.11391 6.28149 8.29194 6.28149 10.563C6.28149 20.5531 2 23.4075 2 23.4075H27.689C27.689 23.4075 23.4075 20.5531 23.4075 10.563Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M17.3145 29.1157C17.0635 29.5483 16.7034 29.9073 16.2701 30.1569C15.8368 30.4065 15.3455 30.5378 14.8455 30.5378C14.3454 30.5378 13.8541 30.4065 13.4208 30.1569C12.9875 29.9073 12.6274 29.5483 12.3765 29.1157" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span></span>
                    </button>
                    <button class="profile" onclick="logoutmenu(); return false;"><img src="'.$image.'" alt=""></button>
                    <div class="logout-menu">
                        <ul>';
                            if($_SESSION['role'] != 'admin'){
                            echo '<li>
                                <svg width="22" height="22" viewBox="0 0 19 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18 20.125V18C18 16.8728 17.5522 15.7918 16.7552 14.9948C15.9582 14.1978 14.8772 13.75 13.75 13.75H5.25C4.12283 13.75 3.04183 14.1978 2.2448 14.9948C1.44777 15.7918 1 16.8728 1 18V20.125" stroke="#8A8B9F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9.5 9.5C11.8472 9.5 13.75 7.59721 13.75 5.25C13.75 2.90279 11.8472 1 9.5 1C7.15279 1 5.25 2.90279 5.25 5.25C5.25 7.59721 7.15279 9.5 9.5 9.5Z" stroke="#8A8B9F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <a href="'.BASEURL.'/profile/edit/'.$_SESSION['role'].'/'.$_SESSION['user_id'].'/profile/'.$_SESSION['role'].'/profile">Profile</a>
                            </li>';
                            }
                            echo '<li>
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