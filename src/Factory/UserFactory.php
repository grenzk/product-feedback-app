<?php

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<User>
 */
final class UserFactory extends PersistentProxyObjectFactory
{
    const USERS = [
        ['email' => 'elijah.moss@example.com', 'fullName' => 'Elijah Moss', 'username' => 'hexagon.bestagon',],
        ['email' => 'james.skinner@example.com', 'fullName' => 'James Skinner', 'username' => 'hummingbird1'],
        ['email' => 'anne.valentine@example.com', 'fullName' => 'Anne Valentine', 'username' => 'annev1990'],
        ['email' => 'ryan.welles@example.com', 'fullName' => 'Ryan Welles', 'username' => 'voyager.344'],
        ['email' => 'george.partridge@example.com', 'fullName' => 'George Partridge', 'username' => 'soccerviewer8']
    ];

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public static function class(): string
    {
        return User::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'email' => self::faker()->email(),
            'fullName' => self::faker()->name(),
            'username' => self::faker()->unique()->userName(),
            'password' => 'foobar123',
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            ->afterInstantiate(function (User $user): void {
                $user->setPassword($this->passwordHasher->hashPassword(
                    $user,
                    $user->getPassword()
                ));
            });
    }
}
