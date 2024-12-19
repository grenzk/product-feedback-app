<?php

namespace App\Tests\Functional;

use Zenstruck\Browser\HttpOptions;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class UserResourceTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public function testPostToCreateUser(): void
    {
        $this->browser()
            ->post('/api/users', HttpOptions::json([
                'email' => 'john.doe@example.com',
                'fullName' => 'John Doe',
                'username' => 'johndoe',
                'password' => 'foobar'
            ]))
            ->assertStatus(201)
            ->post('/login', HttpOptions::json([
                'email' => 'john.doe@example.com',
                'password' => 'foobar'
            ]))
            ->assertSuccessful()
        ;
    }
}
