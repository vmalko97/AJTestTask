<?php
class Territory {

    private $data;

    public function getRegions(){
        global $mysqli;
        $this->data = $mysqli->query("SELECT * FROM t_koatuu_tree WHERE ter_type_id = 0")->fetch_all(MYSQLI_ASSOC);
        return $this->data;
    }
    public function getDistrictsAndCitiesByRegion($region_id){
        global $mysqli;
        $this->data = $mysqli->query("SELECT * FROM t_koatuu_tree WHERE reg_id = ".$region_id." AND ter_type_id IN (1,2) ORDER BY ter_type_id ASC")->fetch_all(MYSQLI_ASSOC);
        return $this->data;
    }
    public function getLocalitiesByDistrict($district_id){
        global $mysqli;
        $this->data = $mysqli->query("SELECT * FROM t_koatuu_tree WHERE ter_pid = '$district_id' AND ter_type_id IN (1,4,5,6)")->fetch_all(MYSQLI_ASSOC);
        return $this->data;
    }
    public function getTerritoryName($t_id){
        global $mysqli;
        $this->data = $mysqli->query("SELECT * FROM t_koatuu_tree WHERE ter_id = '$t_id'")->fetch_all(MYSQLI_ASSOC);
        return $this->data[0]['ter_name'];
    }
}