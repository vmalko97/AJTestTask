<?php

require_once("app/resources/system/init.php"); //Initialize app

require_once("app/Router.php"); //Initialize Router

/*Header*/
require_once("app/resources/template/header.php");

Router::start(); //Start Routing

/*Footer*/
require_once("app/resources/template/footer.php");