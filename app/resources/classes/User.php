<?php

class User
{
    private $data;

    public function add($name, $email, $territory)
    {
        global $mysqli;
        $this->data = $mysqli->query("INSERT INTO t_users (name, email, territory) VALUES ('$name','$email','$territory')");
        return $this->data;
    }
    public function getAll()
    {
        global $mysqli;
        $this->data = $mysqli->query("SELECT * FROM t_users")->fetch_all(MYSQLI_ASSOC);
        return $this->data;
    }
    public function getByEmail($email)
    {
        global $mysqli;
        $this->data = $mysqli->query("SELECT * FROM t_users WHERE email = '$email'")->fetch_all(MYSQLI_ASSOC);
        if (count($this->data) == 0) {
            return 0;
        } else {
            return $this->data;
        }
    }
}