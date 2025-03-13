<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-users',
    description: 'Creates a set of users for the application'
)]
class CreateUsersCommand extends Command
{
    private const USERS = [
        [
            'email' => 'elijah.moss@example.com',
            'fullName' => 'Elijah Moss',
            'username' => 'hexagon.bestagon',
            'password' => 'foobar123'
        ],
        [
            'email' => 'james.skinner@example.com',
            'fullName' => 'James Skinner',
            'username' => 'hummingbird1',
            'password' => 'foobar123'
        ],
        [
            'email' => 'anne.valentine@example.com',
            'fullName' => 'Anne Valentine',
            'username' => 'annev1990',
            'password' => 'foobar123'
        ],
        [
            'email' => 'ryan.welles@example.com',
            'fullName' => 'Ryan Welles',
            'username' => 'voyager.344',
            'password' => 'foobar123'
        ],
        [
            'email' => 'suzanne.chang@example.com',
            'fullName' => 'Suzanne Chang',
            'username' => 'upbeat1811',
            'password' => 'foobar123'
        ],
        [
            'email' => 'thomas.hood@example.com',
            'fullName' => 'Thomas Hood',
            'username' => 'brawnybrave',
            'password' => 'foobar123'
        ],
        [
            'email' => 'george.partridge@example.com',
            'fullName' => 'George Partridge',
            'username' => 'soccerviewer8',
            'password' => 'foobar123'
        ],
        [
            'email' => 'javier.pollard@example.com',
            'fullName' => 'Javier Pollard',
            'username' => 'warlikeduke',
            'password' => 'foobar123'
        ],
        [
            'email' => 'roxanne.travis@example.com',
            'fullName' => 'Roxanne Travis',
            'username' => 'peppersprime32',
            'password' => 'foobar123'
        ],
        [
            'email' => 'victoria.mejia@example.com',
            'fullName' => 'Victoria Mejia',
            'username' => 'arlen_the_marlin',
            'password' => 'foobar123'
        ],
        [
            'email' => 'zena.kelley@example.com',
            'fullName' => 'Zena Kelley',
            'username' => 'velvetround',
            'password' => 'foobar123'
        ],
        [
            'email' => 'jackson.barker@example.com',
            'fullName' => 'Jackson Barker',
            'username' => 'countryspirit',
            'password' => 'foobar123'
        ],

    ];

    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->entityManager->createQuery('DELETE FROM App\Entity\Upvote')->execute();
            $this->entityManager->createQuery('DELETE FROM App\Entity\Comment')->execute();
            $this->entityManager->createQuery('DELETE FROM App\Entity\Feedback')->execute();
            $this->entityManager->createQuery('DELETE FROM App\Entity\User')->execute();

            $output->writeln('All existing data has been cleared.');

            foreach (self::USERS as $userData) {
                $user = new User();
                $user->setEmail($userData['email']);
                $user->setFullName($userData['fullName']);
                $user->setUsername($userData['username']);
                $user->setPassword($this->passwordHasher->hashPassword($user, $userData['password']));

                $this->entityManager->persist($user);
            }

            $this->entityManager->flush();

            $output->writeln('All users have been created successfully!');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('Error creating users: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
