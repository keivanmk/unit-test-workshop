<?php

namespace App\User;

class User
{


    public function __construct(
        private string $firstName,
        private string $lastName,
        private string $emailAddress,
        private string $password
    )
    {
    }

    public static function register(string $firstName, string $lastName, string $emailAddress, string $password)
    {
        return new User(
            $firstName,
            $lastName,
            $emailAddress,
            $password
        );
    }

    public function changeFirstName(string $firstName):void
    {
        $this->firstName = $firstName;
    }

    public function firstName():string
    {
        return $this->firstName;
    }


}
