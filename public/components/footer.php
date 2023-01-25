<?php
class Footer{
    public function __construct($user=null){
        echo '
        <script src="'.BASEURL.'/public/js/'.$user.'.js"></script>
        </body>
        </html>';
    }
}
?>