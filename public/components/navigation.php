<?php
class Navigation {
    public function __construct($user,$active = null){
        $this->$user($active);
        // js
        echo "<script>
        const navtiles = document.querySelectorAll('.nav-tile');
        const tileanchor = document.querySelectorAll('.nav-tile a');
        
        // hover nav tile and icon color change
        for (let i=0; i<navtiles.length; i++) {
        
            let anc = navtiles[i].querySelector('a');
            
            if(!navtiles[i].classList.contains('active')){
        
                // on mouse over the tile
                navtiles[i].onmouseover = function(){
                    let icon = navtiles[i].querySelectorAll('a svg path');
                    let j = 0;
                    while(j<icon.length){
                        icon[j++].style.stroke = 'white';
                    }
                    
                }
        
                // on mouse out of the tile
                navtiles[i].onmouseout = function(){
                    let icon = navtiles[i].querySelectorAll('a svg path');
                    let j = 0;
                    while(j<icon.length){
                        if(anc.classList.contains('active')){
                            j++;
                        }else{
                            icon[j++].style.stroke = '#8A8B9F';
                        }
                    }
                    
                }
        
            }
        }
        
        </script>
        ";
    }

    public function dealer($active){
        echo '<section class="leftpanel">
                <div class="project-name">
                    <h1>Gasify</h1>
                </div>
                <ul class="nav-tiles">
                    <li class="nav-tile">';

                if($active == 'dashboard'){
                    echo '<a href="../dashboard/dealer" class="panel-tile active dashboard">';
                }else{
                    echo '<a href="../dashboard/dealer" class="panel-tile dashboard">';
                }
        
                        echo '<svg width="26" height="26" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.875 11.6249L15.5 2.58325L27.125 11.6249V25.8333C27.125 26.5184 26.8528 27.1755 26.3684 27.6599C25.8839 28.1444 25.2268 28.4166 24.5417 28.4166H6.45833C5.77319 28.4166 5.11611 28.1444 4.63164 27.6599C4.14717 27.1755 3.875 26.5184 3.875 25.8333V11.6249Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M11.625 28.4167V15.5H19.375V28.4167" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>Dashboard</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';

                if($active == 'orders'){
                    echo '<a href="../orders/dealer" class="panel-tile active orders">';
                }else{
                    echo '<a href="../orders/dealer" class="panel-tile orders">';
                }

                        echo '<svg width="26" height="26" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M25.2499 15.5999V29.0621H4.58325V15.5999" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M27.8333 8.86914H2V15.6003H27.8333V8.86914Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M14.9167 29.0625V8.86914" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M14.9167 8.86905H9.10417C8.24774 8.86905 7.42639 8.51447 6.8208 7.8833C6.21521 7.25214 5.875 6.3961 5.875 5.50349C5.875 4.61089 6.21521 3.75485 6.8208 3.12369C7.42639 2.49252 8.24774 2.13794 9.10417 2.13794C13.625 2.13794 14.9167 8.86905 14.9167 8.86905Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M15 8.61759H20.8125C21.6689 8.61759 22.4903 8.263 23.0959 7.63184C23.7015 7.00067 24.0417 6.14463 24.0417 5.25203C24.0417 4.35943 23.7015 3.50339 23.0959 2.87222C22.4903 2.24106 21.6689 1.88647 20.8125 1.88647C16.2917 1.88647 15 8.61759 15 8.61759Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>Orders</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';

                if($active == 'delivery'){
                    echo '<a href="#" class="panel-tile active delivery">';
                }else{
                    echo '<a href="#" class="panel-tile delivery">';
                }
                        
                        echo '<svg width="26" height="26" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_64_358)">
                                <path d="M20.6667 3.875H1.29175V20.6667H20.6667V3.875Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M20.6667 10.3333H25.8334L29.7084 14.2083V20.6666H20.6667V10.3333Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M7.10417 27.1251C8.88759 27.1251 10.3333 25.6793 10.3333 23.8959C10.3333 22.1125 8.88759 20.6667 7.10417 20.6667C5.32075 20.6667 3.875 22.1125 3.875 23.8959C3.875 25.6793 5.32075 27.1251 7.10417 27.1251Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M23.8959 27.1251C25.6793 27.1251 27.1251 25.6793 27.1251 23.8959C27.1251 22.1125 25.6793 20.6667 23.8959 20.6667C22.1125 20.6667 20.6667 22.1125 20.6667 23.8959C20.6667 25.6793 22.1125 27.1251 23.8959 27.1251Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_64_358">
                                <rect width="31" height="31" fill="white"/>
                                </clipPath>
                                </defs>
                            </svg>
                            <h3>Delivery</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';

                if($active == 'stock'){
                    echo '<a href="../stock/dealer" class="panel-tile active stock">';
                }else{
                    echo '<a href="../stock/dealer" class="panel-tile stock">';
                }
                        
                        echo '<svg width="26" height="26" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.4999 2.58325L2.58325 9.04159L15.4999 15.4999L28.4166 9.04159L15.4999 2.58325Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2.58325 21.9583L15.4999 28.4166L28.4166 21.9583" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2.58325 15.5L15.4999 21.9583L28.4166 15.5" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>Stock</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';

                if($active == 'notifications'){
                    echo '<a href="#" class="panel-tile active notifications">';
                }else{
                    echo '<a href="#" class="panel-tile notifications">';
                }
                        
                        echo '<svg width="26" height="26" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.2083 14.4402V9.27352M20.6667 14.4402V9.27352M27.125 2.81519H3.875V23.4819H10.3333V28.6485L15.5 23.4819H21.9583L27.125 18.3152V2.81519Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>Notifications</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';

                if($active == 'analysis'){
                    echo '<a href="#" class="panel-tile active analysis">';
                }else{
                    echo '<a href="#" class="panel-tile analysis">';
                }
                        
                        echo '<svg width="26" height="26" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M29 5L17.3409 22.4167L11.2045 13.25L2 27" stroke="" stroke-width="3.35444" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M21.6365 5H29.0001V16" stroke="" stroke-width="3.35444" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>Analysis</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';

                if($active == 'reports'){
                    echo '<a href="#" class="panel-tile active reports">';
                }else{
                    echo '<a href="#" class="panel-tile reports">';
                }
                        
                        echo '<svg width="26" height="26" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.5839 4.79688H4.87327C4.21322 4.79688 3.58019 5.08094 3.11346 5.58659C2.64673 6.09223 2.38452 6.77803 2.38452 7.49312V26.3668C2.38452 27.0819 2.64673 27.7677 3.11346 28.2734C3.58019 28.779 4.21322 29.0631 4.87327 29.0631H22.2945C22.9546 29.0631 23.5876 28.779 24.0544 28.2734C24.5211 27.7677 24.7833 27.0819 24.7833 26.3668V16.93" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M22.9168 2.77512C23.4118 2.2388 24.0832 1.9375 24.7833 1.9375C25.4834 1.9375 26.1549 2.2388 26.6499 2.77512C27.145 3.31143 27.4231 4.03883 27.4231 4.7973C27.4231 5.55577 27.145 6.28317 26.6499 6.81949L14.8283 19.6267L9.85083 20.9748L11.0952 15.5823L22.9168 2.77512Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>Reports</h3>
                        </a>
                    </li>
                </ul>
            </section>';
            
            
    }
 
    public function customer($active){
        echo 
        '<section class="leftpanel">
        <div class="project-name">
            <h1>Gasify</h1>
        </div>
        <ul class="nav-tiles">
            <li class="nav-tile">';
            if($active=="dashboard"){
                echo '<a href="../dashboard/customer" class="panel-tile active dashboard">';
            }else{
                echo '<a href="../dashboard/customer" class="panel-tile dashboard">';
            }
    
                
            echo        '<svg width="26" height="26" viewBox="0 0 40 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.8208 31H5.93278V15.5H0L19.7759 0L39.5519 15.5H33.6191V31H23.7311V21.7H15.8208V31Z" fill=""/>
                    </svg>
                    <h3>Dashboard</h3>
                </a>
            </li>
            <li class="nav-tile">';
            if($active=="placereservation"){
                echo ' <a href="#" class="panel-tile active place_reservation">';
            }else{
                echo ' <a href="#" class="panel-tile place_reservation">';
            }
               
            echo        '<svg width="26" height="26" viewBox="0 0 36 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.91898 0.00888084C1.32213 0.101743 0.787668 0.421359 0.433159 0.897418C0.0786496 1.37348 -0.0668626 1.96698 0.0286329 2.54737C0.124128 3.12775 0.452809 3.64748 0.942369 3.99221C1.43193 4.33695 2.04227 4.47844 2.63911 4.38558H9.39036L9.79543 5.47976L11.6408 10.9506L13.4861 16.4215C13.6661 16.9905 14.4313 17.5157 15.0164 17.5157H30.7693C31.3994 17.5157 32.1195 16.9905 32.2996 16.4215L35.9452 5.47976C36.1253 4.91079 35.8552 4.38558 35.2251 4.38558H15.2414L13.5311 1.23436C13.349 0.872664 13.0677 0.566869 12.7183 0.350647C12.3688 0.134424 11.9649 0.0161615 11.5508 0.00888084L2.5491 0.00888084C2.41435 -0.00296028 2.27877 -0.00296028 2.14402 0.00888084C2.05409 0.00362406 1.96391 0.00362406 1.87397 0.00888084L1.91898 0.00888084ZM16.1416 21.8924C14.8814 21.8924 13.8912 22.8553 13.8912 24.0807C13.8912 25.3062 14.8814 26.2691 16.1416 26.2691C17.4018 26.2691 18.392 25.3062 18.392 24.0807C18.392 22.8553 17.4018 21.8924 16.1416 21.8924ZM29.6441 21.8924C28.3839 21.8924 27.3937 22.8553 27.3937 24.0807C27.3937 25.3062 28.3839 26.2691 29.6441 26.2691C30.9043 26.2691 31.8945 25.3062 31.8945 24.0807C31.8945 22.8553 30.9043 21.8924 29.6441 21.8924Z" fill=""/>
                    </svg>
                    <h3>Place Reservation</h3>
                </a>
            </li>
            <li class="nav-tile">';
            if($active=="myreservation"){
                echo ' <a href="../orders/customer" class="panel-tile active my_reservation">';
            }else{
                echo '<a href="../orders/customer" class="panel-tile my_reservation"> ';
            }
                
            echo    '<svg width="26" height="26" viewBox="0 0 27 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16.885 0H9.835C8.275 0 7 1.085 7 2.42833V3.6425C7 4.98583 8.26 6.07083 9.82 6.07083H16.885C18.445 6.07083 19.705 4.98583 19.705 3.6425V2.42833C19.72 1.085 18.445 0 16.885 0Z" fill=""/>
                    <path d="M20.925 6.02335C20.925 8.0771 18.975 9.75627 16.59 9.75627H9.54C7.155 9.75627 5.205 8.0771 5.205 6.02335C5.205 5.30002 4.305 4.84794 3.555 5.18377C2.48063 5.67644 1.58219 6.41155 0.955937 7.31034C0.329688 8.20912 -0.000760945 9.2377 1.31577e-06 10.2859V22.4404C1.31577e-06 25.6179 3.015 28.2142 6.705 28.2142H19.425C23.115 28.2142 26.13 25.6179 26.13 22.4404V10.2859C26.13 8.0771 24.69 6.15252 22.575 5.18377C21.825 4.84794 20.925 5.30002 20.925 6.02335V6.02335ZM13.635 21.6913H7.065C6.45 21.6913 5.94 21.2521 5.94 20.7225C5.94 20.1929 6.45 19.7538 7.065 19.7538H13.635C14.25 19.7538 14.76 20.1929 14.76 20.7225C14.76 21.2521 14.25 21.6913 13.635 21.6913ZM17.565 16.5246H7.065C6.45 16.5246 5.94 16.0854 5.94 15.5559C5.94 15.0263 6.45 14.5871 7.065 14.5871H17.565C18.18 14.5871 18.69 15.0263 18.69 15.5559C18.69 16.0854 18.18 16.5246 17.565 16.5246Z" fill=""/>
                    </svg>
                    <h3> My Reservations</h3>
                </a>
            </li>
            <li class="nav-tile">';
            if($active=="quota"){
                echo ' <a href="#" class="panel-tile active quota">';
            }else{
                echo ' <a href="#" class="panel-tile quota">';
            }
               
               
            echo    '<svg width="26" height="26" viewBox="0 0 33 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.4375 0C10.4362 0 6.8475 1.35 4.24875 3.47625L16.5 13.5V0.10125C15.84 0.03375 15.1388 0 14.4375 0V0ZM20.625 3.5775V15.0862L9.405 24.2663C11.9213 25.9538 15.0562 27 18.5625 27C26.5238 27 33 21.7013 33 15.1875C33 9.2475 27.5963 4.42125 20.625 3.5775ZM3.75375 7.99875C1.44375 9.82125 0 12.3525 0 15.1875C0 18.4275 1.8975 21.2288 4.785 23.085L13.5712 15.8962L3.75375 7.99875Z" fill=""/>
                    </svg>
                    <h3> Quota</h3>
                </a>
            </li>
            <li class="nav-tile">';
            if($active=="dealers"){
                echo ' <a href="#" class="panel-tile active dealers">';
            }else{
                echo '<a href="#" class="panel-tile dealers">';
            }
                
               
            echo    '<svg width="26" height="26" viewBox="0 0 32 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M29.9146 14.805V30H2.08698V14.805C3.84841 15.1731 5.70527 14.9703 7.30465 14.235V21H24.6969V14.25C26.299 14.9788 28.1552 15.1763 29.9146 14.805ZM3.8262 0H10.7831L9.61782 9.045C9.42726 10.2613 8.73881 11.3788 7.67676 12.1957C6.61471 13.0127 5.24901 13.4753 3.8262 13.5C0.939089 13.5 -0.660997 11.595 0.260792 9.225L3.8262 0ZM12.5223 0H19.4792L20.6967 9.45C20.9923 11.7 19.114 13.5 16.4878 13.5H15.5138C14.9142 13.5134 14.3184 13.4143 13.7677 13.2095C13.2169 13.0047 12.7243 12.6992 12.324 12.314C11.9237 11.9288 11.6252 11.4731 11.4493 10.9786C11.2733 10.4841 11.224 9.96255 11.3049 9.45L12.5223 0ZM21.2184 0H28.1753L31.7408 9.225C32.6625 11.595 31.0451 13.5 28.1753 13.5C26.7515 13.4783 25.3839 13.0168 24.3211 12.1993C23.2583 11.3818 22.5709 10.2626 22.3837 9.045L21.2184 0Z" fill=""/>
                    </svg>
                    <h3> Dealers</h3>
                      
                </a>
            </li>
            <li class="nav-tile">';
            if($active=="help"){
                echo '  <a href="#" class="panel-tile active help">';
            }else{
                echo ' <a href="#" class="panel-tile help">';
            }
               
            echo     '<svg width="26" height="26" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.8333 2.83496H8.16665C4.66665 2.83496 2.33331 5.16829 2.33331 8.66829V15.6683C2.33331 19.1683 4.66665 21.5016 8.16665 21.5016V23.9866C8.16665 24.92 9.20498 25.48 9.97498 24.955L15.1666 21.5016H19.8333C23.3333 21.5016 25.6666 19.1683 25.6666 15.6683V8.66829C25.6666 5.16829 23.3333 2.83496 19.8333 2.83496ZM14 17.0333C13.7679 17.0333 13.5454 16.9411 13.3813 16.777C13.2172 16.6129 13.125 16.3904 13.125 16.1583C13.125 15.9262 13.2172 15.7037 13.3813 15.5396C13.5454 15.3755 13.7679 15.2833 14 15.2833C14.232 15.2833 14.4546 15.3755 14.6187 15.5396C14.7828 15.7037 14.875 15.9262 14.875 16.1583C14.875 16.3904 14.7828 16.6129 14.6187 16.777C14.4546 16.9411 14.232 17.0333 14 17.0333ZM15.47 12.1916C15.015 12.495 14.875 12.6933 14.875 13.02V13.265C14.875 13.7433 14.4783 14.14 14 14.14C13.5216 14.14 13.125 13.7433 13.125 13.265V13.02C13.125 11.6666 14.1166 11.0016 14.49 10.745C14.9216 10.4533 15.0616 10.255 15.0616 9.95163C15.0616 9.36829 14.5833 8.88996 14 8.88996C13.4166 8.88996 12.9383 9.36829 12.9383 9.95163C12.9383 10.43 12.5416 10.8266 12.0633 10.8266C11.585 10.8266 11.1883 10.43 11.1883 9.95163C11.1883 8.39996 12.4483 7.13996 14 7.13996C15.5516 7.13996 16.8116 8.39996 16.8116 9.95163C16.8116 11.2816 15.8316 11.9466 15.47 12.1916Z" fill=""/>
                    </svg>
                    <h3>Help</h3>
                </a>
            </li>
            <li class="nav-tile">
        </ul>
        </section>';
    }


    public function distributor($active){
        echo '<section class="leftpanel">
                <div class="project-name">
                    <h1>Gasify</h1>
                </div>
                <ul class="nav-tiles">
                    <li class="nav-tile">';


                if($active == 'dashboard'){
                    echo '<a href="../dashboard/distributor" class="panel-tile active dashboard">';
                }else{
                    echo '<a href="../dashboard/distributor" class="panel-tile dashboard">';
                }
        
                        echo '<svg width="26" height="26" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.875 11.6249L15.5 2.58325L27.125 11.6249V25.8333C27.125 26.5184 26.8528 27.1755 26.3684 27.6599C25.8839 28.1444 25.2268 28.4166 24.5417 28.4166H6.45833C5.77319 28.4166 5.11611 28.1444 4.63164 27.6599C4.14717 27.1755 3.875 26.5184 3.875 25.8333V11.6249Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M11.625 28.4167V15.5H19.375V28.4167" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>Dashboard</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';


                if($active == 'distributions'){
                    echo '<a href="#" class="panel-tile active distributions">';
                }else{
                    echo '<a href="#" class="panel-tile distributions">';
                }

                        echo '<svg width="29" height="22" viewBox="0 0 29 22" fill="" xmlns="http://www.w3.org/2000/svg">
                                <path d="M28.0643 10.5719L25.0677 4.00937C24.9912 3.83992 24.8633 3.69534 24.6999 3.59365C24.5365 3.49196 24.3448 3.43765 24.1487 3.4375H21.1521V1.5625C21.1521 1.31386 21.0469 1.0754 20.8596 0.899588C20.6722 0.723772 20.4182 0.625 20.1532 0.625H1.17465C0.909737 0.625 0.655669 0.723772 0.468344 0.899588C0.281019 1.0754 0.175781 1.31386 0.175781 1.5625V17.5C0.175781 17.7486 0.281019 17.9871 0.468344 18.1629C0.655669 18.3387 0.909737 18.4375 1.17465 18.4375H3.31224C3.54227 19.2319 4.04442 19.9332 4.74123 20.4332C5.43804 20.9332 6.29078 21.2041 7.16789 21.2041C8.04501 21.2041 8.89775 20.9332 9.59456 20.4332C10.2914 19.9332 10.7935 19.2319 11.0235 18.4375H17.2965C17.5265 19.2319 18.0286 19.9332 18.7255 20.4332C19.4223 20.9332 20.275 21.2041 21.1521 21.2041C22.0292 21.2041 22.882 20.9332 23.5788 20.4332C24.2756 19.9332 24.7777 19.2319 25.0078 18.4375H27.1454C27.4103 18.4375 27.6643 18.3387 27.8517 18.1629C28.039 17.9871 28.1442 17.7486 28.1442 17.5V10.9375C28.144 10.8118 28.1168 10.6875 28.0643 10.5719ZM21.1521 5.3125H23.4895L25.6271 10H21.1521V5.3125ZM7.16789 19.375C6.77278 19.375 6.38653 19.265 6.05801 19.059C5.72948 18.853 5.47342 18.5601 5.32222 18.2175C5.17101 17.8749 5.13145 17.4979 5.20853 17.1342C5.28562 16.7705 5.47588 16.4364 5.75527 16.1742C6.03466 15.912 6.39063 15.7334 6.77815 15.661C7.16568 15.5887 7.56736 15.6258 7.9324 15.7677C8.29744 15.9096 8.60944 16.15 8.82896 16.4583C9.04847 16.7666 9.16564 17.1292 9.16564 17.5C9.16564 17.9973 8.95516 18.4742 8.58051 18.8258C8.20586 19.1775 7.69773 19.375 7.16789 19.375ZM17.2965 16.5625H11.0235C10.7935 15.7681 10.2914 15.0668 9.59456 14.5668C8.89775 14.0668 8.04501 13.7959 7.16789 13.7959C6.29078 13.7959 5.43804 14.0668 4.74123 14.5668C4.04442 15.0668 3.54227 15.7681 3.31224 16.5625H2.17353V2.5H19.1544V14.275C18.6995 14.5228 18.3013 14.8524 17.9825 15.2449C17.6636 15.6375 17.4305 16.0852 17.2965 16.5625ZM21.1521 19.375C20.757 19.375 20.3708 19.265 20.0422 19.059C19.7137 18.853 19.4576 18.5601 19.3064 18.2175C19.1552 17.8749 19.1157 17.4979 19.1928 17.1342C19.2698 16.7705 19.4601 16.4364 19.7395 16.1742C20.0189 15.912 20.3749 15.7334 20.7624 15.661C21.1499 15.5887 21.5516 15.6258 21.9166 15.7677C22.2817 15.9096 22.5937 16.15 22.8132 16.4583C23.0327 16.7666 23.1499 17.1292 23.1499 17.5C23.1499 17.9973 22.9394 18.4742 22.5647 18.8258C22.1901 19.1775 21.682 19.375 21.1521 19.375ZM26.1465 16.5625H25.0078C24.7869 15.7596 24.2886 15.048 23.591 14.5391C22.8934 14.0302 22.0357 13.7527 21.1521 13.75V11.875H26.1465V16.5625Z" fill=""/>
                                </svg>
                            <h3>Gas Distributions</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';


                if($active == 'orders'){
                    echo '<a href="#" class="panel-tile active orders">';
                }else{
                    echo '<a href="#" class="panel-tile orders">';
                }

                        echo ' <svg width="33" height="30" viewBox="0 0 33 30" fill="" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.4268 13.75H20.4177M16.4223 6.25V2.5M16.4223 2.5H15.0904M16.4223 2.5H17.7541M12.4268 10C12.4268 9.00544 12.8477 8.05161 13.597 7.34835C14.3463 6.64509 15.3626 6.25 16.4223 6.25V6.25C17.4819 6.25 18.4982 6.64509 19.2475 7.34835C19.9968 8.05161 20.4177 9.00544 20.4177 10V26.75C20.4177 26.8485 20.3971 26.946 20.3569 27.037C20.3168 27.128 20.2579 27.2107 20.1837 27.2803C20.1095 27.35 20.0214 27.4052 19.9244 27.4429C19.8275 27.4806 19.7236 27.5 19.6186 27.5H13.2259C13.1209 27.5 13.017 27.4806 12.9201 27.4429C12.8231 27.4052 12.735 27.35 12.6608 27.2803C12.5866 27.2107 12.5277 27.128 12.4876 27.037C12.4474 26.946 12.4268 26.8485 12.4268 26.75V10Z" stroke="#8A8B9F" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                            <h3>Gas Orders</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';


                if($active == 'vehicles'){
                    echo '<a href="#" class="panel-tile active delivery">';
                }else{
                    echo '<a href="#" class="panel-tile delivery">';
                }
                        
                        echo ' <svg width="33" height="30" viewBox="0 0 33 30" fill="" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.2952 17.3438C13.2952 17.7167 13.1374 18.0744 12.8564 18.3381C12.5754 18.6018 12.1943 18.75 11.7969 18.75C11.3995 18.75 11.0184 18.6018 10.7374 18.3381C10.4565 18.0744 10.2986 17.7167 10.2986 17.3438C10.2986 16.9708 10.4565 16.6131 10.7374 16.3494C11.0184 16.0857 11.3995 15.9375 11.7969 15.9375C12.1943 15.9375 12.5754 16.0857 12.8564 16.3494C13.1374 16.6131 13.2952 16.9708 13.2952 17.3438ZM20.7868 18.75C21.1841 18.75 21.5652 18.6018 21.8462 18.3381C22.1272 18.0744 22.2851 17.7167 22.2851 17.3438C22.2851 16.9708 22.1272 16.6131 21.8462 16.3494C21.5652 16.0857 21.1841 15.9375 20.7868 15.9375C20.3894 15.9375 20.0083 16.0857 19.7273 16.3494C19.4463 16.6131 19.2885 16.9708 19.2885 17.3438C19.2885 17.7167 19.4463 18.0744 19.7273 18.3381C20.0083 18.6018 20.3894 18.75 20.7868 18.75ZM14.2941 19.6875C14.2941 19.4389 14.3993 19.2004 14.5867 19.0246C14.774 18.8488 15.0281 18.75 15.293 18.75H17.2907C17.5556 18.75 17.8097 18.8488 17.997 19.0246C18.1844 19.2004 18.2896 19.4389 18.2896 19.6875C18.2896 19.9361 18.1844 20.1746 17.997 20.3504C17.8097 20.5262 17.5556 20.625 17.2907 20.625H15.293C15.0281 20.625 14.774 20.5262 14.5867 20.3504C14.3993 20.1746 14.2941 19.9361 14.2941 19.6875ZM5.70379 1.875C4.80307 1.875 3.93924 2.21082 3.30233 2.8086C2.66543 3.40637 2.30762 4.21712 2.30762 5.0625V21.9375C2.30762 22.2576 2.37479 22.5746 2.50531 22.8703C2.63582 23.166 2.82712 23.4347 3.06828 23.6611C3.30944 23.8874 3.59574 24.067 3.91083 24.1895C4.22592 24.312 4.56364 24.375 4.90469 24.375H6.30311V25.6875C6.30311 26.334 6.57673 26.954 7.06377 27.4111C7.55082 27.8682 8.21139 28.125 8.90018 28.125H11.697C12.3858 28.125 13.0464 27.8682 13.5334 27.4111C14.0205 26.954 14.2941 26.334 14.2941 25.6875V24.375H18.2896V25.6875C18.2896 26.334 18.5632 26.954 19.0503 27.4111C19.5373 27.8682 20.1979 28.125 20.8867 28.125H23.6835C24.3723 28.125 25.0329 27.8682 25.5199 27.4111C26.007 26.954 26.2806 26.334 26.2806 25.6875V24.375H27.679C28.02 24.375 28.3578 24.312 28.6729 24.1895C28.9879 24.067 29.2742 23.8874 29.5154 23.6611C29.7566 23.4347 29.9479 23.166 30.0784 22.8703C30.2089 22.5746 30.2761 22.2576 30.2761 21.9375V5.0625C30.2761 4.21712 29.9183 3.40637 29.2814 2.8086C28.6444 2.21082 27.7806 1.875 26.8799 1.875H5.70379ZM20.2873 25.6875V24.375H24.2828V25.6875C24.2828 25.7614 24.2673 25.8345 24.2372 25.9028C24.2071 25.971 24.1629 26.033 24.1073 26.0852C24.0516 26.1375 23.9856 26.1789 23.9129 26.2072C23.8401 26.2355 23.7622 26.25 23.6835 26.25H20.8867C20.808 26.25 20.73 26.2355 20.6573 26.2072C20.5846 26.1789 20.5185 26.1375 20.4629 26.0852C20.4072 26.033 20.3631 25.971 20.333 25.9028C20.3028 25.8345 20.2873 25.7614 20.2873 25.6875ZM12.2963 24.375V25.6875C12.2963 25.7614 12.2808 25.8345 12.2507 25.9028C12.2206 25.971 12.1765 26.033 12.1208 26.0852C12.0652 26.1375 11.9991 26.1789 11.9264 26.2072C11.8537 26.2355 11.7757 26.25 11.697 26.25H8.90018C8.82148 26.25 8.74354 26.2355 8.67083 26.2072C8.59812 26.1789 8.53205 26.1375 8.47639 26.0852C8.42074 26.033 8.3766 25.971 8.34648 25.9028C8.31636 25.8345 8.30086 25.7614 8.30086 25.6875V24.375H12.2963ZM4.30536 5.0625C4.30536 4.7144 4.4527 4.38056 4.71495 4.13442C4.97721 3.88828 5.3329 3.75 5.70379 3.75H26.8799C27.2508 3.75 27.6065 3.88828 27.8687 4.13442C28.131 4.38056 28.2783 4.7144 28.2783 5.0625V21.9375C28.2783 22.0114 28.2628 22.0845 28.2327 22.1528C28.2026 22.221 28.1584 22.283 28.1028 22.3352C28.0471 22.3875 27.9811 22.4289 27.9083 22.4572C27.8356 22.4855 27.7577 22.5 27.679 22.5H26.2806V14.55C26.2804 14.1268 26.2076 13.7064 26.0648 13.305L24.5965 9.16687C24.4241 8.68129 24.0932 8.25897 23.6507 7.95978C23.2082 7.66059 22.6766 7.49973 22.1313 7.5H10.4524C9.90708 7.49973 9.37548 7.66059 8.93301 7.95978C8.49053 8.25897 8.15962 8.68129 7.98721 9.16687L6.51887 13.305C6.37613 13.7064 6.30328 14.1268 6.30311 14.55V22.5H4.90469C4.74574 22.5 4.5933 22.4407 4.4809 22.3352C4.36851 22.2298 4.30536 22.0867 4.30536 21.9375V5.0625ZM8.30086 22.5V15H24.2828V22.5H8.30086ZM8.68842 13.125L9.88307 9.75937C9.92294 9.6473 9.99939 9.54985 10.1016 9.48086C10.2038 9.41187 10.3265 9.37483 10.4524 9.375H22.1313C22.2571 9.37483 22.3799 9.41187 22.4821 9.48086C22.5843 9.54985 22.6607 9.6473 22.7006 9.75937L23.8953 13.125H8.68842Z" fill=""/>
                                </svg>
                            <h3>Vehicles</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';


                if($active == 'dealers'){
                    echo '<a href="#" class="panel-tile active dealers">';
                }else{
                    echo '<a href="#" class="panel-tile dealers">';
                }
                        
                        echo ' <svg width="34" height="31" viewBox="0 0 34 31" fill="" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.3173 15.1522C18.9688 15.1522 20.5527 14.5643 21.7205 13.5178C22.8883 12.4714 23.5443 11.0521 23.5443 9.57219C23.5443 8.09228 22.8883 6.67298 21.7205 5.62653C20.5527 4.58008 18.9688 3.99219 17.3173 3.99219C15.6658 3.99219 14.0819 4.58008 12.9142 5.62653C11.7464 6.67298 11.0903 8.09228 11.0903 9.57219C11.0903 11.0521 11.7464 12.4714 12.9142 13.5178C14.0819 14.5643 15.6658 15.1522 17.3173 15.1522ZM21.4687 9.57219C21.4687 10.5588 21.0313 11.505 20.2528 12.2026C19.4742 12.9003 18.4183 13.2922 17.3173 13.2922C16.2163 13.2922 15.1604 12.9003 14.3819 12.2026C13.6033 11.505 13.166 10.5588 13.166 9.57219C13.166 8.58558 13.6033 7.63939 14.3819 6.94175C15.1604 6.24411 16.2163 5.85219 17.3173 5.85219C18.4183 5.85219 19.4742 6.24411 20.2528 6.94175C21.0313 7.63939 21.4687 8.58558 21.4687 9.57219ZM29.7714 24.4522C29.7714 26.3122 27.6957 26.3122 27.6957 26.3122H6.93895C6.93895 26.3122 4.86328 26.3122 4.86328 24.4522C4.86328 22.5922 6.93895 17.0122 17.3173 17.0122C27.6957 17.0122 29.7714 22.5922 29.7714 24.4522ZM27.6957 24.4447C27.6936 23.9872 27.376 22.6108 25.9687 21.3497C24.6154 20.137 22.0685 18.8722 17.3173 18.8722C12.564 18.8722 10.0193 20.137 8.66591 21.3497C7.25861 22.6108 6.94311 23.9872 6.93895 24.4447H27.6957Z" fill=""/>
                                </svg>
                            <h3>Dealers</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';


                if($active == 'reports'){
                    echo '<a href="#" class="panel-tile active reports">';
                }else{
                    echo '<a href="#" class="panel-tile reports">';
                }
                        
                        echo '<svg width="33" height="30" viewBox="0 0 33 30" fill="" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.30732 15C2.30732 16.4551 2.54663 17.8467 3.02526 19.1748C3.50388 20.5029 4.18541 21.7236 5.06983 22.8369C5.95424 23.9502 7.01034 24.9121 8.23813 25.7227C9.46591 26.5332 10.8185 27.1484 12.296 27.5684V29.502C10.5376 29.0723 8.92485 28.3984 7.45776 27.4805C5.99066 26.5625 4.72646 25.459 3.66516 24.1699C2.60386 22.8809 1.78187 21.46 1.19919 19.9072C0.616516 18.3545 0.319975 16.7188 0.30957 15C0.30957 13.623 0.496859 12.2949 0.871436 11.0156C1.24601 9.73633 1.78707 8.54492 2.49461 7.44141C3.20214 6.33789 4.03453 5.32715 4.99179 4.40918C5.94904 3.49121 7.02595 2.70508 8.22252 2.05078C9.41909 1.39648 10.6937 0.893555 12.0463 0.541992C13.399 0.19043 14.814 0.00976562 16.2915 0C17.6962 0 19.0488 0.161133 20.3495 0.483398C21.6501 0.805664 22.8779 1.26953 24.0328 1.875C25.1878 2.48047 26.2439 3.20801 27.2011 4.05762C28.1584 4.90723 28.996 5.84961 29.7139 6.88477C30.4318 7.91992 31.0041 9.04297 31.4307 10.2539C31.8573 11.4648 32.1226 12.7197 32.2267 14.0186L29.8232 11.7627C29.4278 10.3174 28.8035 8.98926 27.9503 7.77832C27.0971 6.56738 26.067 5.52246 24.86 4.64355C23.653 3.76465 22.3264 3.08594 20.8801 2.60742C19.4338 2.12891 17.9043 1.88477 16.2915 1.875C15.0013 1.875 13.7631 2.03125 12.577 2.34375C11.3908 2.65625 10.2827 3.0957 9.25261 3.66211C8.22252 4.22852 7.27567 4.91699 6.41206 5.72754C5.54845 6.53809 4.82011 7.42188 4.22703 8.37891C3.63395 9.33594 3.16052 10.3809 2.80675 11.5137C2.45299 12.6465 2.28651 13.8086 2.30732 15ZM16.2915 7.5C15.1886 7.5 14.1533 7.69531 13.1857 8.08594C12.218 8.47656 11.3752 9.01367 10.6573 9.69727C9.93933 10.3809 9.36706 11.1768 8.94046 12.085C8.51386 12.9932 8.30056 13.9648 8.30056 15C8.30056 16.0059 8.49825 16.9629 8.89364 17.8711C9.28902 18.7793 9.8717 19.5898 10.6417 20.3027L9.22139 21.6357C8.27454 20.7471 7.5514 19.7314 7.05196 18.5889C6.55253 17.4463 6.30281 16.25 6.30281 15C6.30281 14.1406 6.42247 13.3105 6.66178 12.5098C6.90109 11.709 7.23405 10.9619 7.66065 10.2686C8.08726 9.5752 8.6075 8.94531 9.22139 8.37891C9.83528 7.8125 10.5116 7.32422 11.2504 6.91406C11.9891 6.50391 12.7851 6.18652 13.6383 5.96191C14.4915 5.7373 15.3759 5.625 16.2915 5.625C17.0719 5.625 17.8367 5.70801 18.5858 5.87402C19.335 6.04004 20.0477 6.28906 20.724 6.62109C21.4004 6.95312 22.0403 7.34375 22.6438 7.79297C23.2472 8.24219 23.7779 8.76953 24.2357 9.375H21.52C20.7917 8.76953 19.9853 8.30566 19.1009 7.9834C18.2165 7.66113 17.28 7.5 16.2915 7.5ZM25.7028 11.25L32.2735 17.417V30H14.2938V11.25H25.7028ZM26.2803 14.458V16.875H28.8555L26.2803 14.458ZM30.2758 28.125V18.75H24.2825V13.125H16.2915V28.125H30.2758ZM28.278 20.625V26.25H26.2803V20.625H28.278ZM18.2893 26.25V18.75H20.287V26.25H18.2893ZM22.2848 26.25V22.5H24.2825V26.25H22.2848Z" fill=""/>
                                </svg>
                            <h3>Reports</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';


                if($active == 'settings'){
                    echo '<a href="#" class="panel-tile active settings">';
                }else{
                    echo '<a href="#" class="panel-tile settings">';
                }
                        
                        echo ' <svg width="33" height="30" viewBox="0 0 33 30" fill="" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.3216 27.5H14.4738C14.17 27.5 13.8754 27.4026 13.6387 27.2239C13.402 27.0452 13.2376 26.796 13.1726 26.5175L12.6305 24.1625C11.9074 23.8651 11.2218 23.4933 10.5862 23.0538L8.13958 23.785C7.84999 23.8717 7.53753 23.8628 7.25408 23.7598C6.97062 23.6568 6.73324 23.4659 6.58134 23.2188L4.15208 19.28C4.00178 19.0327 3.94536 18.7448 3.99205 18.4634C4.03875 18.1821 4.18579 17.924 4.40912 17.7313L6.30698 16.1063C6.22068 15.3701 6.22068 14.6274 6.30698 13.8912L4.40912 12.27C4.18547 12.0772 4.03823 11.8188 3.99153 11.5372C3.94483 11.2556 4.00144 10.9675 4.15208 10.72L6.57601 6.77875C6.72791 6.53164 6.9653 6.34074 7.24875 6.23773C7.5322 6.13473 7.84467 6.12583 8.13426 6.2125L10.5808 6.94375C10.9058 6.71875 11.2441 6.50875 11.593 6.31875C11.93 6.14125 12.2762 5.98 12.6305 5.83625L13.1739 3.48375C13.2386 3.20525 13.4028 2.95586 13.6392 2.77694C13.8756 2.59801 14.1701 2.5003 14.4738 2.5H19.3216C19.6253 2.5003 19.9198 2.59801 20.1562 2.77694C20.3927 2.95586 20.5568 3.20525 20.6215 3.48375L21.1702 5.8375C21.8929 6.13487 22.5781 6.50674 23.2132 6.94625L25.6611 6.215C25.9506 6.12865 26.2627 6.13771 26.5459 6.2407C26.8291 6.34369 27.0662 6.53441 27.2181 6.78125L29.642 10.7225C29.951 11.2312 29.8444 11.875 29.3849 12.2713L27.4871 13.8962C27.5734 14.6324 27.5734 15.3751 27.4871 16.1112L29.3849 17.7362C29.8444 18.1337 29.951 18.7763 29.642 19.285L27.2181 23.2262C27.0662 23.4734 26.8288 23.6643 26.5453 23.7673C26.2619 23.8703 25.9494 23.8792 25.6598 23.7925L23.2132 23.0612C22.5781 23.5004 21.8929 23.8719 21.1702 24.1687L20.6215 26.5175C20.5565 26.7958 20.3923 27.0449 20.1559 27.2236C19.9195 27.4022 19.6252 27.4998 19.3216 27.5ZM11.0643 20.2863L12.1564 21.0363C12.4028 21.2063 12.6585 21.3625 12.9249 21.505C13.1752 21.6413 13.4309 21.7638 13.696 21.875L14.9386 22.3862L15.5472 25H18.2508L18.8595 22.385L20.1021 21.8738C20.6441 21.6488 21.1596 21.37 21.6377 21.0413L22.7298 20.2913L25.4494 21.1037L26.8012 18.9062L24.6929 17.1025L24.8421 15.8375C24.9087 15.2838 24.9087 14.725 24.8421 14.1725L24.6929 12.9075L26.8025 11.1L25.4494 8.90125L22.7311 9.71375L21.6377 8.96375C21.1593 8.63336 20.6445 8.35217 20.1021 8.125L18.8595 7.61375L18.2508 5H15.5472L14.9346 7.615L13.696 8.125C13.1528 8.34826 12.6378 8.62747 12.1604 8.9575L11.0669 9.7075L8.35001 8.895L6.99554 11.1L9.10383 12.9012L8.95466 14.1675C8.88807 14.7212 8.88807 15.28 8.95466 15.8325L9.10383 17.0975L6.99554 18.9013L8.34735 21.0987L11.0643 20.2863ZM16.8924 20C15.4795 20 14.1245 19.4732 13.1254 18.5355C12.1263 17.5979 11.5651 16.3261 11.5651 15C11.5651 13.6739 12.1263 12.4021 13.1254 11.4645C14.1245 10.5268 15.4795 10 16.8924 10C18.3053 10 19.6603 10.5268 20.6594 11.4645C21.6584 12.4021 22.2197 13.6739 22.2197 15C22.2197 16.3261 21.6584 17.5979 20.6594 18.5355C19.6603 19.4732 18.3053 20 16.8924 20ZM16.8924 12.5C16.3708 12.5005 15.8608 12.6447 15.4257 12.9148C14.9907 13.1848 14.6497 13.5688 14.445 14.0191C14.2403 14.4694 14.1811 14.9662 14.2745 15.4478C14.3679 15.9295 14.61 16.3747 14.9706 16.7284C15.3312 17.0821 15.7946 17.3287 16.3031 17.4375C16.8117 17.5463 17.3431 17.5125 17.8314 17.3405C18.3197 17.1684 18.7434 16.8655 19.05 16.4694C19.3566 16.0734 19.5326 15.6016 19.556 15.1125V15.6125V15C19.556 14.337 19.2754 13.7011 18.7759 13.2322C18.2763 12.7634 17.5988 12.5 16.8924 12.5Z" fill=""/>
                                </svg>
                            <h3>Settings</h3>
                        </a>
                    </li>
                    <li class="nav-tile">
                </ul>
                </section>';            
            
    }




















}
?>