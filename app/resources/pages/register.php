<?php
error_reporting(E_ALL);
$territory = new Territory();
?>
<script type="text/javascript">
    function verifyForm() {
        // let nameElem = $("#name");
        // let emailElem = $("#email");
        // let email = emailElem.val();
        // let name = nameElem.val();
        // if(email.length >= 0 && (email.match(/.+?\@.+/g) || []).length != 1){
        //     emailElem.addClass('is-invalid');
        // }else{
        //     emailElem.addClass('is-valid');
        // }
        // if (name.length <= 3){
        //     nameElem.addClass('is-invalid');
        // }else{
        //     nameElem.addClass('is-valid');
        // }
    }
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Реєстрація</div>
                <div class="card-body" id="regForm">
                    <div id="">
                        <div class="form-group">
                            <label for="name">ПІБ</label>
                            <input class="form-control" type="text" id="name" name="name" required>
                            <div class="error-box">
                                &nbsp;
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">E-Mail</label>
                            <input class="form-control" type="email" id="email" name="email" required>
                            <div class="error-box">
                                &nbsp;
                            </div>
                        </div>
                        <div class="form-group" id="regionBlock">
                            <label for="region">Облаcть</label>
                            <select data-placeholder="Виберіть область..." class="form-control chosen-select"
                                    tabindex="2"
                                    id="region" name="region">
                                <option territory="" value=""></option>
                                <?php

                                $region = $territory->getRegions();

                                for ($i = 0; $i < count($region); $i++) {
                                    echo '<option territory="' . $region[$i]['ter_id'] . '" value="' . $region[$i]['reg_id'] . '">' . $region[$i]['ter_name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group" id="districtCityBlock" style="display: none">
                            <label for="districtCity">Місто / Район</label>
                            <select data-placeholder="Виберіть місто/район..." class="form-control chosen-select"
                                    tabindex="2"
                                    id="districtCity" name="districtCity" required>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group" id="localityBlock" style="display: none">
                            <label for="locality">Населений пункт</label>
                            <select data-placeholder="Виберіть населений пункт..." class="form-control chosen-select"
                                    tabindex="2" id="locality" name="locality" required>
                                <option value=""></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-block btn-primary" id="submitForm">Зареєструватися
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card" id="cardBlock" style="display: none;">
                <div class="card-header">Картка користувача</div>
                <div class="card-body" id="userCard">

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
            let userCardElem = $("#userCard");
            let regFormElem = $("#regForm");
            let districtCityElem = $("#districtCity");
            let regionElem = $("#region");
            let localityElem = $("#locality");
            let submitFormElem = $("#submitForm");
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
            let errors = true;
            $('input#name, input#email').unbind().blur(function () {
                let id = $(this).attr('id');
                let val = $(this).val();
                switch (id) {
                    case 'name':
                        let rv_name = /^[a-zA-Zа-яА-ЯІЇії\s]+$/;

                        if (val.length > 2 && val != '' && rv_name.test(val)) {
                            errors = false;
                            $(this).addClass('not_error');
                            $(this).next('.error-box').text('Принято')
                                .css('color', 'green')
                                .animate({'paddingLeft': '10px'}, 400)
                                .animate({'paddingLeft': '5px'}, 400);
                        } else {
                            errors = true;
                            $(this).removeClass('not_error').addClass('error');
                            $(this).next('.error-box').html('&bull; поле "ПІБ" обов\'язкове для заповнення<br> &bull; довжина ПІБ повинна складатися не менше ніж з двох символів<br> &bull; поле повинно містити тільки символи кирилиці та латиниці')
                                .css('color', 'red')
                                .animate({'paddingLeft': '10px'}, 400)
                                .animate({'paddingLeft': '5px'}, 400);
                        }
                        break;
                    case 'email':
                        let rv_email = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
                        if (val != '' && rv_email.test(val)) {
                            errors = false;
                            $(this).addClass('not_error');
                            $(this).next('.error-box').text('Принято')
                                .css('color', 'green')
                                .animate({'paddingLeft': '10px'}, 400)
                                .animate({'paddingLeft': '5px'}, 400);
                        } else {
                            errors = true;
                            $(this).removeClass('not_error').addClass('error');
                            $(this).next('.error-box').html('&bull; поле "Email" обов\'язкове для заповнення<br> &bull; поле повинно мати корректну email-адресу<br> (наприклад: example123@mail.ua)')
                                .css('color', 'red')
                                .animate({'paddingLeft': '10px'}, 400)
                                .animate({'paddingLeft': '5px'}, 400);
                        }
                        break;
                }
            });

            submitFormElem.click(function () {
                    let name = $("input[name=name]").val();
                    let email = $("input[name=email]").val();
                    let territory = "";
                    if ($('option:selected', 'select[name=locality]').attr('territory') != undefined && $('option:selected', 'select[name=locality]').attr('territory') != "" && $('option:selected', 'select[name=region]').attr('territory') != "") {
                        territory = $('option:selected', 'select[name=locality]').attr('territory');
                    } else if ($('option:selected', 'select[name=districtCity]').attr('territory') != "" && $('option:selected', 'select[name=region]').attr('territory') != "" && ($('option:selected', 'select[name=locality]').attr('territory') == undefined || $('option:selected', 'select[name=locality]').attr('territory') == "")) {
                        territory = $('option:selected', 'select[name=districtCity]').attr('territory');
                    } else {
                        errors = true;
                    }
                    let asyncv = "getCard";
                    if (errors === false) {
                        $.ajax({
                            url: "/app/resources/system/async.php",
                            type: "POST",
                            data:
                                {
                                    async:
                                        JSON.stringify({
                                            function: asyncv,
                                            async_data: {
                                                email: email
                                            }
                                        })
                                },
                            success: function (data) {
                                if(data !== "0") {
                                    $("#cardBlock").show();
                                    userCardElem.html(data);
                                }else{
                                    let async = "userRegister";
                                    if (errors === false) {
                                        $.ajax({
                                            url: "/app/resources/system/async.php",
                                            type: "POST",
                                            data:
                                                {
                                                    async:
                                                        JSON.stringify({
                                                            function: async,
                                                            async_data: {
                                                                name: name,
                                                                email: email,
                                                                territory: territory
                                                            }
                                                        })
                                                },
                                            success: function (data) {
                                                regFormElem.html(data);
                                            }
                                        });
                                    }
                                }
                            }
                        });
                    }
                }
            );
        }
    )
</script>