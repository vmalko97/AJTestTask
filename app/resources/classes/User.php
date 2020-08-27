<?php

class User
{
    private $data;

    public function add($name, $email, $territory)
    {
        global $mysqli;
        $this->data = $mysqli->query("INSERT INTO t_users (name, email, territory) VALUES ('$name','$email','$territory')")->fetch_all(MYSQLI_ASSOC);
        return $this->data;
    }
}