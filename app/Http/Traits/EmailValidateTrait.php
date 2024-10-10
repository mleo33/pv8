<?php


namespace App\Http\Traits;


trait EmailValidateTrait {

    function is_valid_email($email) {
        return preg_match("/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/", $email);
    }
}