<?php
class UserCrypt{

    public function setPassword(string $password){
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function check_password(string $password, string $hash){
        return password_verify($password, $hash);
    }
}

?>
