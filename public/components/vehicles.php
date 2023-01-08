<?php 

class Vehicles_Comp {
    public function __construct($active) {
        $output = '';

        if($active == "add") {
            $output .= '<li><a href="../vehicles/distributor" class="add active"><b>Add Vehicle</b></a></li>'; 
        }else {
            $output .= '<li><a href="../vehicles/distributor" class="add"><b>Add Vehicle</b></a></li>'; 
        }

        if($active == "update") {
            $output .= '<li><a href="../vehicles/updatevehicle" class="update active"><b>Update Vehicle</b></a></li>'; 
        }else {
            $output .= '<li><a href="../vehicles/updatevehicle" class="update"><b>Update Vehicle</b></a></li>'; 
        }

        if($active == "view") { 
            $output .= '<li><a href="../vehicles/viewvehicle" class="view active"><b>View Vehicle</b></a></li>'; 
        }else {
            $output .= '<li><a href="../vehicles/viewvehicle" class="view"><b>View Vehicle</b></a></li>'; 
        }

        echo '
            <div class="top">
                <ul>'.$output.'</ul>
            </div> 
        ';
    }
}

?>