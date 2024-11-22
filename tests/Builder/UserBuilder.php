<?php

namespace Tests\Builder;

use App\User\User;

class UserBuilder
{
    public function __construct(
        private string $firstName,
        private string $lastName,
        private string $emailAddress,
        private string $password
    )
    {
    }

    public function whoseFirstNameIs(string $firstName):self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function whoseLastNameIs(string $lastName):self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function whoseEmailAddressIs(string $emailAddress):self
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    public function whosePasswordIs(string $password):self
    {
        $this->password = $password;
        return $this;
    }

    public function build():User
    {
        return new User(
            $this->firstName,
            $this->lastName,
            $this->emailAddress,
            $this->password
        );
    }

    public static function anUser():UserBuilder
    {
        return new UserBuilder(
            fake()->firstName(),
            fake()->lastName(),
            fake()->email(),
            fake()->password(),
        );
    }
}
