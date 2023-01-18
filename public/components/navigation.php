<?php
class Navigation {
    public function __construct($user,$active = null){
        $this->$user($active);
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
                    echo '<a href="#" class="panel-tile active stock">';
                }else{
                    echo '<a href="#" class="panel-tile stock">';
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
    public function company($active){
        echo '<section class="leftpanel">
                <div class="project-name">
                    <h1>Gasify</h1>
                </div>
                <ul class="nav-tiles">
                    <li class="nav-tile">';

                if($active == 'dashboard'){
                    echo '<a href="../dashboard/company" class="panel-tile active dashboard">';
                }else{
                    echo '<a href="../dashboard/company" class="panel-tile dashboard">';
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
                    echo '<a href="../Compny/dealer" class="panel-tile active orders">';
                }else{
                    echo '<a href="../Compny/dealer" class="panel-tile orders">';
                }

                        echo '<svg width="26" height="26" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M25.2499 15.5999V29.0621H4.58325V15.5999" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M27.8333 8.86914H2V15.6003H27.8333V8.86914Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M14.9167 29.0625V8.86914" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M14.9167 8.86905H9.10417C8.24774 8.86905 7.42639 8.51447 6.8208 7.8833C6.21521 7.25214 5.875 6.3961 5.875 5.50349C5.875 4.61089 6.21521 3.75485 6.8208 3.12369C7.42639 2.49252 8.24774 2.13794 9.10417 2.13794C13.625 2.13794 14.9167 8.86905 14.9167 8.86905Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M15 8.61759H20.8125C21.6689 8.61759 22.4903 8.263 23.0959 7.63184C23.7015 7.00067 24.0417 6.14463 24.0417 5.25203C24.0417 4.35943 23.7015 3.50339 23.0959 2.87222C22.4903 2.24106 21.6689 1.88647 20.8125 1.88647C16.2917 1.88647 15 8.61759 15 8.61759Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>Dealer</h3>
                        </a>
                    </li>
                    <li class="nav-tile">';

                if($active == 'delivery'){
                    echo '<a href="../Compny/distributor" class="panel-tile active delivery">';
                }else{
                    echo '<a href="../Compny/distributor" class="panel-tile delivery">';
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

                if($active == 'stock'){
                    echo '<a href="#" class="panel-tile active stock">';
                }else{
                    echo '<a href="#" class="panel-tile stock">';
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

                if($active == 'notifications'){
                    echo '<a href="../Compny/products" class="panel-tile active notifications">';
                }else{
                    echo '<a href="../Compny/products" class="panel-tile notifications">';
                }
                        
                        echo '<svg width="26" height="26" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.2083 14.4402V9.27352M20.6667 14.4402V9.27352M27.125 2.81519H3.875V23.4819H10.3333V28.6485L15.5 23.4819H21.9583L27.125 18.3152V2.81519Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>Products</h3>
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
    public function delivery($active){
        echo '<section class="leftpanel">
                <div class="project-name">
                    <h1>Gasify</h1>
                </div>
                <ul class="nav-tiles">
                    <li class="nav-tile">';

                if($active == 'dashboard'){
                    echo '<a href="../dashboard/delivery" class="panel-tile active dashboard">';
                }else{
                    echo '<a href="../dashboard/delivery" class="panel-tile dashboard">';
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
                    echo '<a href="../Delvery/deliveries" class="panel-tile active orders">';
                }else{
                    echo '<a href="../Delvery/deliveries" class="panel-tile orders">';
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

                if($active == 'notifications'){
                    echo '<a href="../Compny/products" class="panel-tile active notifications">';
                }else{
                    echo '<a href="../Compny/products" class="panel-tile notifications">';
                }
                        
                        echo '<svg width="26" height="26" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.2083 14.4402V9.27352M20.6667 14.4402V9.27352M27.125 2.81519H3.875V23.4819H10.3333V28.6485L15.5 23.4819H21.9583L27.125 18.3152V2.81519Z" stroke="" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>Reviews</h3>
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
    
}
?>