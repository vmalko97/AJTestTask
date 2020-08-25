<?php
class Territory {

    private $data;

    public function getRegions(){
        global $mysqli;
        $this->data = $mysqli->query("SELECT * FROM t_koatuu_tree WHERE ter_type_id = 0")->fetch_all(MYSQLI_ASSOC);
        return $this->data;
    }
    public function getCitiesByRegion($region_id){

    }

}