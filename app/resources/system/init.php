<?php
//INITIALIZE SESSION
session_start();


//CONFIG DB

define('DB_HOST', 'localhost');
define('DB_USERNAME', 'v55600_artjoker');
define('DB_PASSWORD', 'artjokerdatabase');
define('DB_NAME', 'v55600_artjoker');

//INITIALIZE Database
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$mysqli->query("set charset utf8");

//INITIALIZE CLASSES
spl_autoload_register(function ($class_name) {
    include $_SERVER['DOCUMENT_ROOT'] . '/app/resources/classes/' . $class_name . '.php';
});