<?php

class Search{

    public function __construct($indexes){
        echo '<div class="searchbox">';
        echo '<img src="'.BASEURL.'/public/img/icons/search.png" >';
        echo '<input class="searchbar" type="text" name="search" id="searchbar" onkeyup="tablesearch('.json_encode($indexes).')" placeholder="Search..."/>';
        echo '</div>';
        echo '<script src="'.BASEURL.'/public/js/search.js"> </script>';
    }

}