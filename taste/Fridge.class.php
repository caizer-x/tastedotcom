<?php
class Fridge {
    public $inventory = array();
    public $inventoryIndex = array();
    public function __construct() {
        //
    }
    
    public function loadInventory($filePath) {
        $handle = fopen($filePath,'r');
        $arr = array();
        while($data = fgetcsv($handle)) {
            $arr['item'] = $data[0];
            $arr['amount'] = $data[1];
            $arr['unit'] = $data[2];
            $arr['use-by'] = str_replace('/', '-', $data[3]);
            $this->inventory[] = $arr; 
            if (isset($this->inventoryIndex[$arr['item']])) {
                $this->inventoryIndex[$arr['item']]['total'] += $arr['amount'];
                if (isset($this->inventoryIndex[$arr['item']]['closestExpiry']) && 
                        strtotime($this->inventoryIndex[$arr['item']]['closestExpiry']) > strtotime($arr['use-by']) && 
                        strtotime($arr['use-by']) > strtotime('now'))
                $this->inventoryIndex[$arr['item']]['closestExpiry'] = $arr['use-by'];
            }
            else {
                $this->inventoryIndex[$arr['item']]['total'] = $arr['amount'];
                $this->inventoryIndex[$arr['item']]['closestExpiry'] = $arr['use-by'];
            }

        }
        fclose($handle);
    }
    
    public function getInventory() {
        return $this->inventory;
    }
    
    public function getInventoryIndex() {
        return $this->inventoryIndex;
    }
}

?>