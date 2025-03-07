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
            'password' => 'password123'
        ],
        [
            'email' => 'james.skinner@example.com',
            'fullName' => 'James Skinner',
            'username' => 'hummingbird1',
            'password' => 'password123'
        ],
        [
            'email' => 'anne.valentine@example.com',
            'fullName' => 'Anne Valentine',
            'username' => 'annev1990',
            'password' => 'password123'
        ],
        [
            'email' => 'john.doe@example.com',
            'fullName' => 'John Doe',
            'username' => 'johndoe',
            'password' => 'password123'
        ]
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
            foreach (self::USERS as $userData) {
                $user = new User();
                $user->setEmail($userData['email']);
                $user->setFullName($userData['fullName']);
                $user->setUsername($userData['username']);
                $user->setPassword($this->passwordHasher->hashPassword($user, $userData['password']));

                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $output->writeln(sprintf('Creating user: %s', $userData['username']));
            }

            $output->writeln('All users have been created successfully!');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('Error creating users: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
