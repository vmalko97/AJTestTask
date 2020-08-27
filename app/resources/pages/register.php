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
                    <input class="form-control" type="email" id="email">
                </div>
                <div class="form-group" id="regionBlock">
                    <label for="region">Облаcть</label>
                    <select data-placeholder="Виберіть область..." class="form-control chosen-select" tabindex="2"
                            id="region" name="region">
                        <option value=""></option>
                        <?php

                        $region = $territory->getRegions();

                        for ($i = 0; $i < count($region); $i++) {
                            echo '<option value="' . $region[$i]['reg_id'] . '">' . $region[$i]['ter_name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group" id="districtCityBlock" style="display: none">
                    <label for="districtCity">Місто / Район</label>
                    <select data-placeholder="Виберіть місто/район..." class="form-control chosen-select" tabindex="2"
                            id="districtCity" name="districtCity">
                        <option value=""></option>
                    </select>
                </div>
                <div class="form-group" id="localityBlock" style="display: none">
                    <label for="locality">Населений пункт</label>
                    <select data-placeholder="Виберіть населений пункт..." class="form-control chosen-select"
                            tabindex="2" id="locality" name="locality">
                        <option value=""></option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-block btn-primary">Зареєструватися</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
            let districtCityElem = $("#districtCity");
            let regionElem = $("#region");
            let localityElem = $("#locality");
            regionElem.chosen();
            regionElem.change(function () {
                let region_id = $("select[name=region]").val();
                let async = "getDistrictsAndCitiesByRegion";
                if (region_id !== '') {
                    $.ajax({
                        url: "/app/resources/system/async.php",
                        type: "POST",
                        data:
                            {
                                async:
                                    JSON.stringify({
                                        function: async,
                                        async_data: {
                                            region_id: region_id,
                                        }
                                    })
                            },
                        success: function (data) {
                            districtCityElem.html(data);
                            if (data === "") {
                                $("div[id=districtCityBlock]").hide();
                            } else {
                                $("div[id=districtCityBlock]").show();
                            }
                            districtCityElem.chosen();
                            districtCityElem.trigger("chosen:updated");
                        }
                    });
                }
            });
            districtCityElem.change(function () {
                let district_id = $("select[name=districtCity]").val();
                let async = "getLocalitiesByDistrict";
                if (district_id !== '') {
                    $.ajax({
                        url: "/app/resources/system/async.php",
                        type: "POST",
                        data:
                            {
                                async:
                                    JSON.stringify({
                                        function: async,
                                        async_data: {
                                            district_id: district_id,
                                        }
                                    })
                            },
                        success: function (data) {
                            localityElem.html(data);
                            if (data === "") {
                                $("div[id=localityBlock]").hide();
                            } else {
                                $("div[id=localityBlock]").show();
                            }
                            localityElem.chosen();
                            localityElem.trigger("chosen:updated");

                        }
                    });
                }
            });
        }
    )
</script>