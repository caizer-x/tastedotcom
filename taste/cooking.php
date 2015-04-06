<?php
date_default_timezone_set('Australia/Sydney');
require_once 'Fridge.class.php';
require_once 'Recipe.class.php';

$fridge = new fridge();
$recipe = new recipe();

$inventoryPath = $argv[1];
$recipePath = $argv[2];

$fridge->loadInventory($inventoryPath);
$inventory = $fridge->getInventoryIndex();

if ($recipes = $recipe->setRecipes($recipePath)) {
    foreach ($recipes as $r) {
        $notMet = false;
        if(isset($r['ingredients']) && is_array($r['ingredients'])) {
            foreach ($r['ingredients'] as $ing) { 
                if (in_array($ing['item'],array_keys($inventory)) && 
                        $inventory[$ing['item']]['total'] > $ing['amount'] &&
                        strtotime($inventory[$ing['item']]['closestExpiry']) > strtotime('now')) {
                    // enough ingredients
                } else {
                    // not enough ingredients
                    $notMet = true;
                }
            }
        }
        if ($notMet) {
            echo $r['name']."\n";
        }
    }
}
?>