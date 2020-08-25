<?php
error_reporting(E_ALL);

$territory = new Territory();

?>
<div class="row-fluid">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Реєстрація</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name">ПІБ</label>
                    <input class="form-control" type="text" id="name">
                </div>
                <div class="form-group">
                    <label for="email">E-Mail</label>
                    <input class="form-control" type="email"id="email">
                </div>
                <div class="form-group">
                    <label for="region">Облаcть</label>
                <select data-placeholder="Виберіть область..." class="form-control chosen-select" tabindex="2" id="region">
                    <option value=""></option>
                    <?php

                    $region = $territory->getRegions();

                    for ($i = 0; $i < count($region); $i++) {
                        echo '<option value="' . $region[$i]['reg_id'] . '">' . $region[$i]['ter_name'] . '</option>';
                    }
                    ?>
                </select>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
            $(".chosen-select").chosen();
        }
    )
</script>