<?php

namespace App\Command;

use App\Entity\Feedback;
use App\Entity\User;
use App\Entity\FeedbackCategoryEnum;
use App\Entity\FeedbackStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:create-feedback',
    description: 'Creates a set of feedback for the application'
)]
class CreateFeedbackCommand extends Command
{
    private const FEEDBACK = [
        [
            'title' => 'Add tags for solutions',
            'detail' => 'Easier to search for solutions based on a specific stack.',
            'category' => FeedbackCategoryEnum::ENHANCEMENT,
            'status' => FeedbackStatusEnum::SUGGESTION,
            'ownedBy' => 'George Partridge'
        ],
        [
            'title' => 'Add a dark theme option',
            'detail' => 'It would help people with light sensitivities and who prefer dark mode.',
            'category' => FeedbackCategoryEnum::FEATURE,
            'status' => FeedbackStatusEnum::SUGGESTION,
            'ownedBy' => 'George Partridge'
        ],
        [
            'title' => 'Q&A within the challenge hubs',
            'detail' => 'Challenge-specific Q&A would make for easy reference.',
            'category' => FeedbackCategoryEnum::FEATURE,
            'status' => FeedbackStatusEnum::SUGGESTION,
            'ownedBy' => 'George Partridge'
        ],
        [
            'title' => 'Add image/video upload to feedback',
            'detail' => 'Images and screencasts can enhance comments on solutions.',
            'category' => FeedbackCategoryEnum::ENHANCEMENT,
            'status' => FeedbackStatusEnum::SUGGESTION,
            'ownedBy' => 'George Partridge'
        ],
        [
            'title' => 'Ability to follow others',
            'detail' => 'Stay updated on comments and solutions other people post.',
            'category' => FeedbackCategoryEnum::FEATURE,
            'status' => FeedbackStatusEnum::SUGGESTION,
            'ownedBy' => 'George Partridge'
        ],
        [
            'title' => 'Preview images not loading',
            'detail' => 'Challenge preview images are missing when you apply a filter.',
            'category' => FeedbackCategoryEnum::BUG,
            'status' => FeedbackStatusEnum::SUGGESTION,
            'ownedBy' => 'George Partridge'
        ],
    ];

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            foreach (self::FEEDBACK as $feedbackData) {
                $feedback = new Feedback();
                $feedback->setTitle($feedbackData['title']);
                $feedback->setDetail($feedbackData['detail']);
                $feedback->setCategory($feedbackData['category']);
                $feedback->setStatus($feedbackData['status']);

                $user = $this->entityManager->getRepository(User::class)->findOneBy([
                    'fullName' => $feedbackData['ownedBy']
                ]);

                if (!$user) {
                    throw new \RuntimeException(sprintf('User "%s" not found', $feedbackData['ownedBy']));
                }

                $feedback->setOwnedBy($user);

                $this->entityManager->persist($feedback);
            }

            $this->entityManager->flush();

            $output->writeln('All feedback have been created successfully!');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('Error creating feedback: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
