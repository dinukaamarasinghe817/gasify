<?php 

class Vehicles_Comp {
    public function __construct($active) {
        $output = '';

        if($active == "add") {
            $output .= '<li><a href="#" class="add active"><b>Add Vehicle</b></a></li>'; 
        }else {
            $output .= '<li><a href="#" class="add"><b>Add Vehicle</b></a></li>'; 
        }

        if($active == "update") {
            $output .= '<li><a href="#" class="update active"><b>Update Vehicle</b></a></li>'; 
        }else {
            $output .= '<li><a href="#" class="update"><b>Update Vehicle</b></a></li>'; 
        }

        if($active == "view") {
            $output .= '<li><a href="#" class="view active"><b>View Vehicle</b></a></li>'; 
        }else {
            $output .= '<li><a href="#" class="view"><b>View Vehicle</b></a></li>'; 
        }

        echo '
            <div class="top">
                <ul>'.$output.'</ul>
            </div> 
        ';

        // $row = $data['row'];
        // $vehicles = $data['vehicles'];
        // js
    }
}

?>