<?php

require_once('init.php');

$async = json_decode(filter_input(INPUT_POST, 'async')); // Async JSON input
$async_function = $async->{'function'}; //Async execute function
$async_data = $async->{'async_data'}; //Async data

switch ($async_function) {

    case "getDistrictsAndCitiesByRegion":
        $territory = new Territory();
        $region_id = $async_data->{'region_id'};
        $data = $territory->getDistrictsAndCitiesByRegion($region_id);
        $response = "";
        for ($i = 0; $i < count($data); $i++) {
            $response .= '<option value="' . $data[$i]['ter_id'] . '">' . $data[$i]['ter_name'] . '</option>';
        }
        echo $response;
        break;
    case "getLocalitiesByDistrict":
        $territory = new Territory();
        $district_id = $async_data->{'district_id'};
        $data = $territory->getLocalitiesByDistrict($district_id);
        for ($i = 0; $i < count($data); $i++) {
            $response .= '<option value="' . $data[$i]['ter_id'] . '">' . $data[$i]['ter_name'] . '</option>';
        }
        echo $response;
        break;
    case "userRegister":
        $user = new User();
        $name = $async_data->{'name'};
        $email = $async_data->{'email'};
        $territory = $async_data->{'territory'};
        $user->add($name, $email, $territory);
        echo "success";
        break;
    default:
        echo $async_function;
        break;
}