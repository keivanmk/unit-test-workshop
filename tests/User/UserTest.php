<?php

namespace Tests\User;

use App\User\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Builder\UserBuilder;
use Tests\TestCase;
use Tests\Users;

class UserTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function user_registration(): void
    {
        //arrange
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        $emailAddress = $this->faker->email();
        $password = $this->faker->password();

        //act
        $sut = User::register($firstName,$lastName,$emailAddress,$password);

        $this->assertInstanceOf(User::class,$sut);
    }

    /** @test */
    public function changing_first_name(): void
    {

        //arrange
        $sut = UserBuilder::anUser()
            ->whoseFirstNameIs(Users::MOHAMMAD)
            ->build();

        //act
        $sut->changeFirstName(Users::ALI);

        //assert
        $this->assertEquals(Users::ALI,$sut->firstName());

    }

}
