<?php

namespace App\Command;

use App\Entity\Upvote;
use App\Entity\User;
use App\Entity\Feedback;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-upvotes',
    description: 'Creates a set of upvotes for the application'
)]
class CreateUpvotesCommand extends Command
{
    private const UPVOTES = [
        'Add tags for solutions' => 6,
        'Add a dark theme option' => 5,
        'Q&A within the challenge hubs' => 4,
        'Add image/video upload to feedback' => 3,
        'Ability to follow others' => 2,
        'Preview images not loading' => 1
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
            $userCount = 1;
            $feedbacks = $this->entityManager->getRepository(Feedback::class)->findAll();

            foreach ($feedbacks as $feedback) {
                $targetUpvotes = self::UPVOTES[$feedback->getTitle()];

                for ($i = 0; $i < $targetUpvotes; $i++) {
                    $randomUser = new User();
                    $randomUser->setEmail("upvoter{$userCount}@example.com");
                    $randomUser->setFullName("Random Upvoter {$userCount}");
                    $randomUser->setUsername("upvoter{$userCount}");
                    $randomUser->setPassword($this->passwordHasher->hashPassword($randomUser, 'foobar123'));

                    $this->entityManager->persist($randomUser);

                    $randomUpvote = new Upvote();
                    $randomUpvote->setFeedback($feedback);
                    $randomUpvote->setOwnedBy($randomUser);

                    $this->entityManager->persist($randomUpvote);

                    $userCount++;
                }
            }

            $this->entityManager->flush();

            $output->writeln('All upvotes have been created successfully!');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('Error creating upvotes: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
