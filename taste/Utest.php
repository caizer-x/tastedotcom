<?php
require_once 'Fridge.class.php';
require_once 'Recipe.class.php';

// check error on invalid csv file
$fridge = new fridge();
$exception = false;
$out = "";
ob_start();
try {
    $fridge->loadInventory($brokenInventoryPath);
} catch (Exception $e) {
    $exception = $e->getMessage();
}
$out = ob_get_contents();
ob_end_clean();
if (empty($fridge->inventory) &&  !$exception) {
    echo "Test failed to raise exception on invalid inventory file"."\n";
}
if (empty($fridge->inventory) &&  $out == "") {
    echo "No error message returned on invalid inventory file"."\n";
}
// end of check error on invalid csv file

// check error on invalid json input
$recipe = new recipe();
$exception = false;
$out = "";
$recipes = array();
ob_start();
try {
    $recipes = $recipe->setRecipes($brokenRecipePath);
} catch (Exception $e) {
    $exception = $e->getMessage();
}
$out = ob_get_contents();
ob_end_clean();
if (empty($recipes) &&  !$exception) {
    echo "Test failed to raise exception on invalid recipe file"."\n";
}
if (empty($recipes) &&  $out == "") {
    echo "No error message returned on invalid recipe file"."\n";
}
// end  of check error on invalid json input
?>