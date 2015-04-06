<?php

class Recipe {
    public $recipes = array();
    public function __construct() {
        //
    }
    
    public function setRecipes($jsonFile) {
        $data = file_get_contents($jsonFile);
        $this->recipes = array_merge($this->recipes, json_decode($data, true));     
        if (count($this->recipes) == 0) {
            echo "Order Takeout";
            return false;
        }
        return $this->recipes;
        
    }
}
?>