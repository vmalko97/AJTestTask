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
        if (count($data) > 0) {
            $response = "<option territory=\"\" value=\"\"></option>";
        }
        for ($i = 0; $i < count($data); $i++) {
            $response .= '<option territory="' . $data[$i]['ter_id'] . '" value="' . $data[$i]['ter_id'] . '">' . $data[$i]['ter_name'] . '</option>';
        }
        echo $response;
        break;
    case "getLocalitiesByDistrict":
        $territory = new Territory();
        $district_id = $async_data->{'district_id'};
        $data = $territory->getLocalitiesByDistrict($district_id);
        if (count($data) > 0) {
            $response = "<option territory=\"\" value=\"\"></option>";
        }
        for ($j = 0; $j < count($data); $j++) {
            $response .= '<option territory="' . $data[$j]['ter_id'] . '" value="' . $data[$j]['ter_id'] . '">' . $data[$j]['ter_name'] . '</option>';
        }
        echo $response;
        break;
    case "userRegister":
        $user = new User();
        $name = $async_data->{'name'};
        $email = $async_data->{'email'};
        $territory = $async_data->{'territory'};
        $user->add($name, $email, $territory);
        echo "<div class=\"alert alert-success\" role=\"alert\">
 Ви успішно зареєструвались!
</div>";
        break;
    case "getCard":
        $user = new User();
        $territory = new Territory();
        $email = $async_data->{'email'};
        $data = $user->getByEmail($email);
        if ($data !== 0) {
            echo "<div class=\"alert alert-danger\" role=\"alert\">
        Користувач з таким E-mail уже існує!
            </div>
    <table class='table table-bordered'>
        <tr>
            <td>ID:</td>
            <td>" . $data[0]['id'] . "</td>
        </tr>
        <tr>
            <td>ПІБ:</td>
            <td>" . $data[0]['name'] . "</td>
        </tr>
        <tr>
            <td>E-mail:</td>
            <td>" . $data[0]['email'] . "</td>
        </tr>
        <tr>
            <td>Адреса:</td>
            <td>" . $territory->getTerritoryName($data[0]['territory']) . "</td>
        </tr>
</table>
";
        } else {
            echo 0;
        }
        break;
    default:
        echo $async_function;
        break;
}