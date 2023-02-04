<?php
class Prompt{
    function __construct($type,$data){
        $this->$type($data);
    }

    public function verification($data){
        echo '<div class="verification">
                <h1>Verification Status</h1>
                <div class="box">
                    <div>
                        <h2>Stock</h2>
                        <p>pending</p>
                    </div>
                    <img src="'.BASEURL.'/public/img/icons/accept.png" alt="">
                </div>
                <div class="box">
                    <div>
                        <h2>Payment</h2>
                        <p>pending</p>
                    </div>
                    <img src="'.BASEURL.'/public/img/icons/pending.png" alt="">
                </div>
                <button onclick="viewinfo(); return false;">OK</button>
            </div>';
    }

    // public function moreinfo($data){
    //     echo '<div class="verification">
    //             <h1>Purchase Order Includes</h1>'
    //                 .$data.
    //             '<button onclick="viewinfo(); return false;">OK</button>
    //         </div>';
    // }

    // public function confirm_cancel_reservation(){
    //     echo '<div class="verification">
    //             <h1>Verification Status</h1>
    //             <div class="box">
    //                 <div>
    //                     <h2>Stock</h2>
    //                     <p>pending</p>
    //                 </div>
    //                 <img src="'.BASEURL.'/public/img/icons/accept.png" alt="">
    //             </div>
    //             <div class="box">
    //                 <div>
    //                     <h2>Payment</h2>
    //                     <p>pending</p>
    //                 </div>
    //                 <img src="'.BASEURL.'/public/img/icons/pending.png" alt="">
    //             </div>
    //             <button onclick="viewinfo(); return false;">OK</button>
    //         </div>';
    // }
    public function toast($toast){
        echo '<div id="toast" class="'.$toast['type'].'">
                <div class="container-1">';
                if($toast['type'] == 'error'){
                    echo '<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.1894 31.3166C24.5961 31.3166 31.4111 24.5016 31.4111 16.0949C31.4111 7.68826 24.5961 0.873291 16.1894 0.873291C7.78274 0.873291 0.967773 7.68826 0.967773 16.0949C0.967773 24.5016 7.78274 31.3166 16.1894 31.3166Z" fill="#FF4D4D"/>
                        <path d="M20.756 11.5286L11.623 20.6616" stroke="white" stroke-width="3.04433" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M11.623 11.5286L20.756 20.6616" stroke="white" stroke-width="3.04433" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>';
                }else if($toast['type'] == 'success') {
                    echo '<svg style="color: rgb(0, 255, 64);" width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#47d764" d="M512 64a448 448 0 1 1 0 896 448 448 0 0 1 0-896zm-55.808 536.384-99.52-99.584a38.4 38.4 0 1 0-54.336 54.336l126.72 126.72a38.272 38.272 0 0 0 54.336 0l262.4-262.464a38.4 38.4 0 1 0-54.272-54.336L456.192 600.384z"></path>
                    </svg>';
                }
            echo '</div>
                <div class="container-2">
                    <p>'.ucfirst($toast['type']).'</p>
                    <p>'.$toast['message'].'</p>
                </div>
                <button id="close" onclick="closeToast()">
                    &times;
                </button>
            </div>';
        
        echo '<script>
                let x;
                let toast = document.getElementById("toast");
                function showToast(){
                    clearTimeout(x);
                    toast.style.transform = "translateX(0)";
                    x = setTimeout(()=>{
                        toast.style.transform = "translateX(600px)"
                    }, 6000);
                }
                function closeToast(){
                    toast.style.transform = "translateX(600px)";
                }
            </script>';
    }


    public function customerconfirmation($data){

        echo '<div class="confirmation">
            </div>';
    }
}
?>