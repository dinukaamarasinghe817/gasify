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
}
?>