<?php


class Router
{
    static function start()
    {
        $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!empty($page) && file_exists("./app/resources" . '/pages/' . $page . '.php')) {
            require_once "./app/resources/pages/" . $page . ".php";
        } elseif (empty($page)) {
            echo "<script type='text/javascript'>location.replace('/?page=main')</script>";
        } else {
            require_once "./app/resources/pages/404.php";
        }
    }
}