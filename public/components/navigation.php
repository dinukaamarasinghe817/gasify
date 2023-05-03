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
                    echo '<a href="'.BASEURL.'/dashboard/dealer" class="panel-tile active dashboard">';
                }else{
                    echo '<a href="'.BASEURL.'/dashboard/dealer" class="panel-tile dashboard">';
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
                    echo '<a href="'.BASEURL.'/orders/dealer/pending" class="panel-tile active orders">';
                }else{
                    echo '<a href="'.BASEURL.'/orders/dealer/pending" class="panel-tile orders">';
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
                    echo '<a href="'.BASEURL.'/delvery/getdeliverypeople/all" class="panel-tile active delivery">';
                }else{
                    echo '<a href="'.BASEURL.'/delvery/getdeliverypeople/all" class="panel-tile delivery">';
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
                    echo '<a href="'.BASEURL.'/stock/dealer/currentstock" class="panel-tile active stock">';
                }else{
                    echo '<a href="'.BASEURL.'/stock/dealer/currentstock" class="panel-tile stock">';
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

                // if($active == 'notifications'){
                //     echo '<a href="'.BASEURL.'/" class="panel-tile active notifications">';
                // }else{
                //     echo '<a href="'.BASEURL.'/" class="panel-tile notifications">';
                // }
                        
                //         echo '<svg width="26" height="26" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                //                 <path d="M14.2083 14.4402V9.27352M20.6667 14.4402V9.27352M27.125 2.81519H3.875V23.4819H10.3333V28.6485L15.5 23.4819H21.9583L27.125 18.3152V2.81519Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                //             </svg>
                //             <h3>Notifications</h3>
                //         </a>
                //     </li>
                //     <li class="nav-tile">';

                if($active == 'analysis'){
                    echo '<a href="'.BASEURL.'/analysis/dealer" class="panel-tile active analysis">';
                }else{
                    echo '<a href="'.BASEURL.'/analysis/dealer" class="panel-tile analysis">';
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
                    echo '<a href="'.BASEURL.'/reports/dealer" class="panel-tile active reports">';
                }else{
                    echo '<a href="'.BASEURL.'/reports/dealer" class="panel-tile reports">';
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
                echo '<a href= "'.BASEURL.'/dashboard/customer" class="panel-tile active dashboard">';
            }else{
                echo '<a href="'.BASEURL.'/dashboard/customer" class="panel-tile dashboard">';
            }
    
                
            echo        '<svg width="26" height="26" viewBox="0 0 158 173" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 62.9642L78.6682 8L149.336 62.9642V149.336C149.336 153.501 147.682 157.496 144.737 160.441C141.792 163.386 137.797 165.04 133.632 165.04H23.704C19.5391 165.04 15.5447 163.386 12.5996 160.441C9.65453 157.496 8 153.501 8 149.336V62.9642Z" stroke="" stroke-width="15.704" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M55.1094 165.041V86.5205H102.222V165.041" stroke="" stroke-width="15.704" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
                    <h3>Dashboard</h3>
                </a>
            </li>
            <li class="nav-tile">';
            if($active=="placereservation"){
                echo ' <a href="'.BASEURL.'/Orders/select_brand_city_dealer" class="panel-tile active place_reservation">';
            }else{
                echo ' <a href="'.BASEURL.'/Orders/select_brand_city_dealer"  class="panel-tile place_reservation">';
            }
               
            echo        '<svg width="26" height="26" viewBox="0 0 192 184" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M71.8395 175.582C76.2467 175.582 79.8196 172.009 79.8196 167.602C79.8196 163.195 76.2467 159.622 71.8395 159.622C67.4322 159.622 63.8594 163.195 63.8594 167.602C63.8594 172.009 67.4322 175.582 71.8395 175.582Z" stroke="" stroke-width="15.9602" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M159.621 175.582C164.028 175.582 167.601 172.009 167.601 167.602C167.601 163.195 164.028 159.622 159.621 159.622C155.213 159.622 151.641 163.195 151.641 167.602C151.641 172.009 155.213 175.582 159.621 175.582Z" stroke="" stroke-width="15.9602" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8 8H39.9204L61.307 114.853C62.0367 118.527 64.0355 121.828 66.9533 124.177C69.8711 126.525 73.5221 127.773 77.2672 127.701H154.834C158.579 127.773 162.23 126.525 165.148 124.177C168.065 121.828 170.064 118.527 170.794 114.853L183.562 47.9004H47.9004" stroke="" stroke-width="15.9602" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    <h3>Place Reservation</h3>
                </a>
            </li>
            <li class="nav-tile">';
            if($active=="myreservation"){
                echo ' <a href="'.BASEURL.'/Orders/customer_allreservations" class="panel-tile active my_reservation">';
            }else{
                echo '<a href="'.BASEURL.'/Orders/customer_allreservations" class="panel-tile my_reservation"> ';
            }
                
            echo    '<svg width="26" height="26" viewBox="0 0 177 216" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M107.886 10H29.5771C24.385 10 19.4054 12.0626 15.734 15.734C12.0626 19.4054 10 24.385 10 29.5771V186.194C10 191.386 12.0626 196.366 15.734 200.037C19.4054 203.709 24.385 205.771 29.5771 205.771H147.04C152.232 205.771 157.212 203.709 160.883 200.037C164.554 196.366 166.617 191.386 166.617 186.194V68.7314L107.886 10Z" stroke="black" stroke-width="19.5771" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M107.883 10V68.7314H166.614" stroke="" stroke-width="19.5771" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M127.465 117.674H49.1562" stroke="" stroke-width="19.5771" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M127.465 156.828H49.1562" stroke="" stroke-width="19.5771" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M68.7334 78.5195H58.9448H49.1562" stroke="" stroke-width="19.5771" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
            
                    <h3> My Reservations</h3>
                </a>
            </li>
            <li class="nav-tile">';
            if($active=="quota"){
                echo ' <a href="'.BASEURL.'/Orders/customer_quota" class="panel-tile active quota">';
            }else{
                echo ' <a href="'.BASEURL.'/Orders/customer_quota" class="panel-tile quota">';
            }
               
               
            echo    '<svg width="26" height="26" viewBox="0 0 157 157" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M143.754 106.157C139.258 116.789 132.226 126.157 123.274 133.444C114.321 140.73 103.719 145.712 92.3962 147.955C81.073 150.198 69.3729 149.632 58.3186 146.308C47.2644 142.985 37.1926 137.004 28.984 128.888C20.7753 120.773 14.6795 110.77 11.2297 99.7543C7.77994 88.7387 7.08108 77.0458 9.19428 65.6977C11.3075 54.3497 16.1684 43.692 23.352 34.6566C30.5356 25.6211 39.8233 18.483 50.4029 13.8662" stroke="" stroke-width="14.1334" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M149.331 78.6668C149.331 69.3867 147.503 60.1975 143.952 51.6238C140.4 43.0501 135.195 35.2598 128.633 28.6978C122.071 22.1358 114.281 16.9305 105.707 13.3792C97.1334 9.82785 87.9442 8 78.6641 8V78.6668H149.331Z" stroke="" stroke-width="14.1334" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
                    <h3> Quota</h3>
                </a>
            </li>
            <li class="nav-tile">';
            if($active=="dealers"){
                echo ' <a href="'.BASEURL.'/Dealers/customer_dealers" class="panel-tile active dealers">';
            }else{
                echo '<a href="'.BASEURL.'/Dealers/customer_dealers" class="panel-tile dealers">';
            }
                
               
            echo    '<svg width="26" height="26" viewBox="0 0 172 144" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M121.903 136.141V121.904C121.903 114.351 118.903 107.108 113.563 101.768C108.223 96.4279 100.98 93.4277 93.4275 93.4277H36.4758C28.9236 93.4277 21.6806 96.4279 16.3404 101.768C11.0001 107.108 8 114.351 8 121.904V136.141" stroke="black" stroke-width="14.2379" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M64.9524 64.9517C80.6792 64.9517 93.4282 52.2026 93.4282 36.4758C93.4282 20.7491 80.6792 8 64.9524 8C49.2256 8 36.4766 20.7491 36.4766 36.4758C36.4766 52.2026 49.2256 64.9517 64.9524 64.9517Z" stroke="black" stroke-width="14.2379" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M164.615 136.141V121.903C164.61 115.594 162.51 109.464 158.644 104.478C154.779 99.4914 149.367 95.9299 143.258 94.3525" stroke="" stroke-width="14.2379" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M114.781 8.9248C120.907 10.4931 126.336 14.0554 130.213 19.0502C134.09 24.0449 136.194 30.1879 136.194 36.5108C136.194 42.8336 134.09 48.9766 130.213 53.9714C126.336 58.9661 120.907 62.5284 114.781 64.0967" stroke="" stroke-width="14.2379" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
            
                    <h3> Dealers</h3>
                      
                </a>
            </li>';
            echo '<li class="nav-tile">';
            if($active=="help"){
                echo '  <a href="'.BASEURL.'/Support/customer_support"  class="panel-tile active help">';
            }else{
                echo ' <a href="'.BASEURL.'/Support/customer_support" class="panel-tile help">';
            }
               
            echo     '<svg width="26" height="26" viewBox="0 0 158 173" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M70.8162 78.6682V47.2601M110.076 78.6682V47.2601M149.336 8H8V133.632H47.2601V165.04L78.6682 133.632H117.928L149.336 102.224V8Z" stroke="" stroke-width="15.704" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
                    <h3>Help</h3>
                </a>
            </li>';
        echo '</ul>
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
                    echo '<a href="'.BASEURL.'/dashboard/distributor" class="panel-tile active dashboard">';
                }else{
                    echo '<a href="'.BASEURL.'/dashboard/distributor" class="panel-tile dashboard">';
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
                    echo '<a href="'.BASEURL.'/gasdistributions/pending_distributions" class="panel-tile active distributions">';
                }else{
                    echo '<a href="'.BASEURL.'/gasdistributions/pending_distributions" class="panel-tile distributions">';
                }

                        echo '<svg width="28" height="28" viewBox="0 0 34 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 2L2 8.66667V32C2 32.8841 2.35119 33.7319 2.97631 34.357C3.60143 34.9821 4.44928 35.3333 5.33333 35.3333H28.6667C29.5507 35.3333 30.3986 34.9821 31.0237 34.357C31.6488 33.7319 32 32.8841 32 32V8.66667L27 2H7Z" stroke="#8A8B9F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 8.66602H32" stroke="#8A8B9F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M23.6668 15.334C23.6668 17.1021 22.9644 18.7978 21.7142 20.048C20.464 21.2983 18.7683 22.0007 17.0002 22.0007C15.2321 22.0007 13.5364 21.2983 12.2861 20.048C11.0359 18.7978 10.3335 17.1021 10.3335 15.334" stroke="#8A8B9F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>                        
                        
                            <h3>Gas Distributions</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';


                if($active == 'orders'){
                    echo '<a href="'.BASEURL.'/orders/distributor" class="panel-tile active orders">';
                }else{
                    echo '<a href="'.BASEURL.'/orders/distributor" class="panel-tile orders">';
                }

                        echo ' <svg width="28" height="28" viewBox="0 0 31 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M25.9996 5H4.99996C3.34313 5 2 6.34313 2 7.99996V28.9996C2 30.6565 3.34313 31.9996 4.99996 31.9996H25.9996C27.6565 31.9996 28.9996 30.6565 28.9996 28.9996V7.99996C28.9996 6.34313 27.6565 5 25.9996 5Z" stroke="#8A8B9F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21.4995 2V7.99991" stroke="#8A8B9F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9.5 2V7.99991" stroke="#8A8B9F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 14H28.9996" stroke="#8A8B9F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        
                            <h3>Gas Orders</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';


                if($active == 'vehicles'){
                    echo '<a href="'.BASEURL.'/vehicles/distributor" class="panel-tile active delivery">';
                }else{
                    echo '<a href="'.BASEURL.'/vehicles/distributor" class="panel-tile delivery">';
                }
                        
                        echo ' <svg width="30" height="30" viewBox="0 0 41 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M27.0003 2H2V23.6669H27.0003V2Z" stroke="#8A8B9F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M27.0005 10.334H33.6672L38.6673 15.334V23.6675H27.0005V10.334Z" stroke="#8A8B9F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9.49973 31.9995C11.8009 31.9995 13.6664 30.134 13.6664 27.8327C13.6664 25.5315 11.8009 23.666 9.49973 23.666C7.19851 23.666 5.33301 25.5315 5.33301 27.8327C5.33301 30.134 7.19851 31.9995 9.49973 31.9995Z" stroke="#8A8B9F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M31.1672 31.9995C33.4684 31.9995 35.3339 30.134 35.3339 27.8327C35.3339 25.5315 33.4684 23.666 31.1672 23.666C28.866 23.666 27.0005 25.5315 27.0005 27.8327C27.0005 30.134 28.866 31.9995 31.1672 31.9995Z" stroke="#8A8B9F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                            <h3>Vehicles</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';


                if($active == 'dealers'){
                    echo '<a href="'.BASEURL.'/dealers/distributor_dealers" class="panel-tile active dealers">';
                }else{
                    echo '<a href="'.BASEURL.'/dealers/distributor_dealers" class="panel-tile dealers">';
                }
                        
                        echo ' <svg width="30" height="30" viewBox="0 0 39 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g filter="url(#filter0_d_540_1002)">
                        <path d="M32.667 32.0001V28.6667C32.667 26.8986 31.9646 25.2029 30.7143 23.9526C29.4641 22.7024 27.7684 22 26.0002 22H12.6667C10.8986 22 9.2029 22.7024 7.95264 23.9526C6.70239 25.2029 6 26.8986 6 28.6667V32.0001" stroke="#8A8B9F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19.3332 15.3335C23.0152 15.3335 26 12.3487 26 8.66675C26 4.9848 23.0152 2 19.3332 2C15.6513 2 12.6665 4.9848 12.6665 8.66675C12.6665 12.3487 15.6513 15.3335 19.3332 15.3335Z" stroke="#8A8B9F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs>
                        <filter id="filter0_d_540_1002" x="0.5" y="0.5" width="37.667" height="41" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                        <feOffset dy="4"/>
                        <feGaussianBlur stdDeviation="2"/>
                        <feComposite in2="hardAlpha" operator="out"/>
                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_540_1002"/>
                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_540_1002" result="shape"/>
                        </filter>
                        </defs>
                        </svg>
                        
                        
                            <h3>Dealers</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';


                if($active == 'reports'){
                    echo '<a href="'.BASEURL.'/reports/distributor" class="panel-tile active reports">';
                }else{
                    echo '<a href="'.BASEURL.'/reports/distributor" class="panel-tile reports">';
                }
                        
                        echo '<svg width="28" height="28" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.4186 5.16211H4.98191C4.19106 5.16211 3.4326 5.47627 2.87338 6.03549C2.31416 6.59471 2 7.35317 2 8.14402V29.0174C2 29.8083 2.31416 30.5667 2.87338 31.1259C3.4326 31.6851 4.19106 31.9993 4.98191 31.9993H25.8553C26.6461 31.9993 27.4046 31.6851 27.9638 31.1259C28.523 30.5667 28.8372 29.8083 28.8372 29.0174V18.5807" stroke="#8A8B9F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M26.6008 2.92636C27.194 2.33322 27.9984 2 28.8373 2C29.6761 2 30.4806 2.33322 31.0737 2.92636C31.6668 3.5195 32.0001 4.32397 32.0001 5.16279C32.0001 6.00162 31.6668 6.80609 31.0737 7.39923L16.9096 21.5633L10.9458 23.0543L12.4368 17.0904L26.6008 2.92636Z" stroke="#8A8B9F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        
                            <h3>Reports</h3>
                        </a>
                    </li>
                   
                </ul>
                </section>';            
            
    }

    public function admin($active){
        echo '<section class="leftpanel">
                <div class="project-name">
                    <h1>Gasify</h1>
                </div>
                <ul class="nav-tiles">
                    <li class="nav-tile">';

                if($active == 'dashboard'){
                    echo '<a href="'.BASEURL.'/dashboard/admin" class="panel-tile active dashboard">';
                }else{
                    echo '<a href="'.BASEURL.'/dashboard/admin" class="panel-tile dashboard">';
                }
        
                        echo '<svg width="26" height="26" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.875 11.6249L15.5 2.58325L27.125 11.6249V25.8333C27.125 26.5184 26.8528 27.1755 26.3684 27.6599C25.8839 28.1444 25.2268 28.4166 24.5417 28.4166H6.45833C5.77319 28.4166 5.11611 28.1444 4.63164 27.6599C4.14717 27.1755 3.875 26.5184 3.875 25.8333V11.6249Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M11.625 28.4167V15.5H19.375V28.4167" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>Dashboard</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';

                if($active == 'companies'){
                    echo '<a href="'.BASEURL.'/users/companies" class="panel-tile active companies">';
                }else{
                    echo '<a href="'.BASEURL.'/users/companies" class="panel-tile companies">';
                }

                        echo '<svg width="27" height="28" viewBox="0 0 29 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M26.9607 30.0809V26.9609C26.9607 25.3059 26.3032 23.7187 25.133 22.5484C23.9627 21.3781 22.3755 20.7207 20.7205 20.7207H8.24016C6.58517 20.7207 4.99796 21.3781 3.8277 22.5484C2.65744 23.7187 2 25.3059 2 26.9609V30.0809" stroke="#8A8B9F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14.4804 14.4803C17.9267 14.4803 20.7206 11.6865 20.7206 8.24016C20.7206 4.79382 17.9267 2 14.4804 2C11.0341 2 8.24023 4.79382 8.24023 8.24016C8.24023 11.6865 11.0341 14.4803 14.4804 14.4803Z" stroke="#8A8B9F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                            <h3>Companies</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';

                if($active == 'distributors'){
                    echo '<a href="'.BASEURL.'/users/distributors" class="panel-tile active distributors">';
                }else{
                    echo '<a href="'.BASEURL.'/users/distributors" class="panel-tile distributors">';
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
                            <h3>Distributors</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';

                if($active == 'dealers'){
                    echo '<a href="'.BASEURL.'/users/dealers" class="panel-tile active dealers">';
                }else{
                    echo '<a href="'.BASEURL.'/users/dealers" class="panel-tile dealers">';
                }
                        
                        echo '<svg width="26" height="26" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.4999 2.58325L2.58325 9.04159L15.4999 15.4999L28.4166 9.04159L15.4999 2.58325Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2.58325 21.9583L15.4999 28.4166L28.4166 21.9583" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2.58325 15.5L15.4999 21.9583L28.4166 15.5" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>Dealers</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';

                if($active == 'delivery'){
                    echo '<a href="'.BASEURL.'/users/deliveries" class="panel-tile active delivery">';
                }else{
                    echo '<a href="'.BASEURL.'/users/deliveries" class="panel-tile delivery">';
                }
                        
                        echo '<svg width="26" height="26" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M25.2499 15.5999V29.0621H4.58325V15.5999" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M27.8333 8.86914H2V15.6003H27.8333V8.86914Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M14.9167 29.0625V8.86914" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M14.9167 8.86905H9.10417C8.24774 8.86905 7.42639 8.51447 6.8208 7.8833C6.21521 7.25214 5.875 6.3961 5.875 5.50349C5.875 4.61089 6.21521 3.75485 6.8208 3.12369C7.42639 2.49252 8.24774 2.13794 9.10417 2.13794C13.625 2.13794 14.9167 8.86905 14.9167 8.86905Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M15 8.61759H20.8125C21.6689 8.61759 22.4903 8.263 23.0959 7.63184C23.7015 7.00067 24.0417 6.14463 24.0417 5.25203C24.0417 4.35943 23.7015 3.50339 23.0959 2.87222C22.4903 2.24106 21.6689 1.88647 20.8125 1.88647C16.2917 1.88647 15 8.61759 15 8.61759Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>Delivery</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';

                if($active == 'customers'){
                    echo '<a href="'.BASEURL.'/users/customers" class="panel-tile active customers">';
                }else{
                    echo '<a href="'.BASEURL.'/users/customers" class="panel-tile customers">';
                }
                        
                        echo '<svg width="25" height="29" viewBox="0 0 34 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.8182 26.5451V23.8178C23.8182 22.3712 23.2435 20.9838 22.2206 19.9609C21.1976 18.938 19.8103 18.3633 18.3636 18.3633H7.45454C6.00791 18.3633 4.62052 18.938 3.5976 19.9609C2.57467 20.9838 2 22.3712 2 23.8178V26.5451" stroke="#8A8A8A" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12.9091 12.9091C15.9216 12.9091 18.3637 10.467 18.3637 7.45454C18.3637 4.44208 15.9216 2 12.9091 2C9.89667 2 7.45459 4.44208 7.45459 7.45454C7.45459 10.467 9.89667 12.9091 12.9091 12.9091Z" stroke="#8A8A8A" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M32.0001 26.5456V23.8183C31.9992 22.6097 31.5969 21.4357 30.8565 20.4805C30.1161 19.5254 29.0794 18.8432 27.9092 18.541" stroke="#8A8A8A" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22.4546 2.17676C23.6279 2.47717 24.6678 3.15953 25.4105 4.11627C26.1531 5.07301 26.5562 6.2497 26.5562 7.46084C26.5562 8.67198 26.1531 9.84868 25.4105 10.8054C24.6678 11.7622 23.6279 12.4445 22.4546 12.7449" stroke="#8A8A8A" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                            <h3>Customers</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';
                if($active == 'payments'){
                    echo '<a href="'.BASEURL.'/orders/validatepayments/regular" class="panel-tile active payments">';
                }else{
                    echo '<a href="'.BASEURL.'/orders/validatepayments/regular" class="panel-tile payments">';
                }
                        
                        echo '<svg width="25" height="25" viewBox="0 0 30 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M25.6364 2H4.36364C3.05824 2 2 3.17525 2 4.625V20.375C2 21.8247 3.05824 23 4.36364 23H25.6364C26.9418 23 28 21.8247 28 20.375V4.625C28 3.17525 26.9418 2 25.6364 2Z" stroke="#8A8A8A" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 9.875H28" stroke="#8A8A8A" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                            <h3>Payments</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';
                if($active == 'analysis'){
                    echo '<a href="'.BASEURL.'/analysis/admin" class="panel-tile active analysis">';
                }else{
                    echo '<a href="'.BASEURL.'/analysis/admin" class="panel-tile analysis">';
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
                    echo '<a href="'.BASEURL.'/reports/admin" class="panel-tile active reports">';
                }else{
                    echo '<a href="'.BASEURL.'/reports/admin" class="panel-tile reports">';
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
    public function company($active){
        echo '<section class="leftpanel">
                <div class="project-name">
                    <h1>Gasify</h1>
                </div>
                <ul class="nav-tiles">
                    <li class="nav-tile">';

                if($active == 'dashboard'){
                    echo '<a href="'.BASEURL.'/dashboard/company" class="panel-tile active dashboard">';
                }else{
                    echo '<a href="'.BASEURL.'/dashboard/company" class="panel-tile dashboard">';
                }
        
                        echo '<svg width="26" height="26" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.875 11.6249L15.5 2.58325L27.125 11.6249V25.8333C27.125 26.5184 26.8528 27.1755 26.3684 27.6599C25.8839 28.1444 25.2268 28.4166 24.5417 28.4166H6.45833C5.77319 28.4166 5.11611 28.1444 4.63164 27.6599C4.14717 27.1755 3.875 26.5184 3.875 25.8333V11.6249Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M11.625 28.4167V15.5H19.375V28.4167" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>Dashboard</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';

                if($active == 'dealer'|| $active == 'regDealer'){
                    echo '<a href="'.BASEURL.'/Compny/dealer" class="panel-tile active orders">';
                }else{
                    echo '<a href="'.BASEURL.'/Compny/dealer" class="panel-tile orders">';
                }

                        echo '<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.1639 21.5966V19.5966C20.1639 18.5357 19.7425 17.5183 18.9924 16.7681C18.2422 16.018 17.2248 15.5966 16.1639 15.5966H8.16394C7.10307 15.5966 6.08566 16.018 5.33551 16.7681C4.58537 17.5183 4.16394 18.5357 4.16394 19.5966V21.5966" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12.1639 11.5966C14.3731 11.5966 16.1639 9.8057 16.1639 7.59656C16.1639 5.38742 14.3731 3.59656 12.1639 3.59656C9.9548 3.59656 8.16394 5.38742 8.16394 7.59656C8.16394 9.8057 9.9548 11.5966 12.1639 11.5966Z" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        
                        
                            <h3>Dealer</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';

                if($active == 'distributor' || $active == 'companyRegDistributor'){
                    echo '<a href="'.BASEURL.'/Compny/distributor" class="panel-tile active delivery">';
                }else{
                    echo '<a href="'.BASEURL.'/Compny/distributor" class="panel-tile delivery">';
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
                            <h3>Distributor</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';

                if($active == 'orders' || $active == 'delayedorders'|| $active == 'issuedorders'|| $active == 'limitquota'){
                    echo '<a href="'.BASEURL.'/Compny/orders" class="panel-tile active stock">';
                }else{
                    echo '<a href="'.BASEURL.'/Compny/orders" class="panel-tile stock">';

                }
                        
                        echo '<svg width="26" height="26" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.4999 2.58325L2.58325 9.04159L15.4999 15.4999L28.4166 9.04159L15.4999 2.58325Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2.58325 21.9583L15.4999 28.4166L28.4166 21.9583" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2.58325 15.5L15.4999 21.9583L28.4166 15.5" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>Orders</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';


                if($active == 'products' || $active == 'updateProducts' || $active == 'regproducts'){
                    echo '<a href="'.BASEURL.'/Compny/products" class="panel-tile active notifications">';
                }else{
                    echo '<a href="'.BASEURL.'/Compny/products" class="panel-tile notifications">';
                }
                        
                        echo '<svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_101_10)">
                        <path d="M22.75 8.66663V22.75H3.25V8.66663" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M24.9167 3.25H1.08333V8.66667H24.9167V3.25Z" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10.8333 13H15.1667" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_101_10">
                        <rect width="26" height="26" fill="white"/>
                        </clipPath>
                        </defs>
                        </svg>
                        
                        
                            <h3>Products</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';

                if($active == 'analysis'){
                    echo '<a href="'.BASEURL.'/Compny/analysis" class="panel-tile active analysis">';
                }else{
                    echo '<a href="'.BASEURL.'/Compny/analysis" class="panel-tile analysis">';
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
                    echo '<a href="'.BASEURL.'/Compny/reports" class="panel-tile active reports">';
                }else{
                    echo '<a href="'.BASEURL.'/Compny/reports" class="panel-tile reports">';
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
    public function delivery($active){
        echo '<section class="leftpanel">
                <div class="project-name">
                    <h1>Gasify</h1>
                </div>
                <ul class="nav-tiles">
                    <li class="nav-tile">';

                if($active == 'dashboard'){
                    echo '<a href="'.BASEURL.'/dashboard/delivery" class="panel-tile active dashboard">';
                }else{
                    echo '<a href="'.BASEURL.'/dashboard/delivery" class="panel-tile dashboard">';
                }
        
                        echo '<svg width="26" height="26" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.875 11.6249L15.5 2.58325L27.125 11.6249V25.8333C27.125 26.5184 26.8528 27.1755 26.3684 27.6599C25.8839 28.1444 25.2268 28.4166 24.5417 28.4166H6.45833C5.77319 28.4166 5.11611 28.1444 4.63164 27.6599C4.14717 27.1755 3.875 26.5184 3.875 25.8333V11.6249Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M11.625 28.4167V15.5H19.375V28.4167" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>Dashboard</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';

                if($active == 'deliveries'||$active == 'currentgasdeliveries'){
                    echo '<a href="'.BASEURL.'/Delvery/deliveries" class="panel-tile active orders">';
                }else{
                    echo '<a href="'.BASEURL.'/Delvery/deliveries" class="panel-tile orders">';
                }

                        echo '
                        <svg width="34" height="28" viewBox="0 0 34 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.6667 1H1V19.7778H22.6667V1Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M22.6665 8.22241H28.4443L32.7776 12.5557V19.778H22.6665V8.22241Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7.50027 26.9998C9.49463 26.9998 11.1114 25.3831 11.1114 23.3887C11.1114 21.3943 9.49463 19.7776 7.50027 19.7776C5.50591 19.7776 3.88916 21.3943 3.88916 23.3887C3.88916 25.3831 5.50591 26.9998 7.50027 26.9998Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M26.2776 26.9998C28.272 26.9998 29.8887 25.3831 29.8887 23.3887C29.8887 21.3943 28.272 19.7776 26.2776 19.7776C24.2833 19.7776 22.6665 21.3943 22.6665 23.3887C22.6665 25.3831 24.2833 26.9998 26.2776 26.9998Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                            <h3>Gas Deliveries</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';

                if($active == 'reviews'){
                    echo '<a href="'.BASEURL.'/Delvery/reviews" class="panel-tile active notifications">';
                }else{
                    echo '<a href="'.BASEURL.'/Delvery/reviews" class="panel-tile notifications">';
                }
                        
                        echo '<svg width="26" height="26" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.2083 14.4402V9.27352M20.6667 14.4402V9.27352M27.125 2.81519H3.875V23.4819H10.3333V28.6485L15.5 23.4819H21.9583L27.125 18.3152V2.81519Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>Reviews</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';
                if($active == 'reports'){
                    echo '<a href="'.BASEURL.'/Delvery/deliveryReports" class="panel-tile active reports">';
                }else{
                    echo '<a href="'.BASEURL.'/Delvery/deliveryReports" class="panel-tile reports">';
                }
                        
                        echo '<svg width="26" height="26" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.5839 4.79688H4.87327C4.21322 4.79688 3.58019 5.08094 3.11346 5.58659C2.64673 6.09223 2.38452 6.77803 2.38452 7.49312V26.3668C2.38452 27.0819 2.64673 27.7677 3.11346 28.2734C3.58019 28.779 4.21322 29.0631 4.87327 29.0631H22.2945C22.9546 29.0631 23.5876 28.779 24.0544 28.2734C24.5211 27.7677 24.7833 27.0819 24.7833 26.3668V16.93" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M22.9168 2.77512C23.4118 2.2388 24.0832 1.9375 24.7833 1.9375C25.4834 1.9375 26.1549 2.2388 26.6499 2.77512C27.145 3.31143 27.4231 4.03883 27.4231 4.7973C27.4231 5.55577 27.145 6.28317 26.6499 6.81949L14.8283 19.6267L9.85083 20.9748L11.0952 15.5823L22.9168 2.77512Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>Analysis</h3>
                        </a>
                    </li>
                </ul>
            </section>';
    }
    
}
?>