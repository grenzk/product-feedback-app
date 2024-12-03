<?php

namespace App\DataFixtures;

use App\Factory\ApiTokenFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach (UserFactory::USERS as $user) {
            UserFactory::createOne([
                'email' => $user['email'],
                'username' => $user['username'],
            ]);
        }

        ApiTokenFactory::createMany(10, function () {
            return [
                'ownedBy' => UserFactory::random(),
            ];
        });
    }
}
