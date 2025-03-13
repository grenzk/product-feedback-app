<?php

namespace App\Command;

use App\Entity\Comment;
use App\Entity\Feedback;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:create-comments',
    description: 'Creates a set of comments for the application'
)]
class CreateCommentsCommand extends Command
{
    private const COMMENTS = [
        [
            'body' => 'Awesome idea! Trying to find framework-specific projects within the hubs can be tedious.',
            'feedback' => 'Add tags for solutions',
            'ownedBy' => 'Suzanne Chang'
        ],
        [
            'body' => 'Please use fun, color-coded labels to easily identify them at a glance.',
            'feedback' => 'Add tags for solutions',
            'ownedBy' => 'Thomas Hood'
        ],
        [
            'body' => 'Also, please allow styles to be applied based on system preferences. ' .
                'I would love to be able to browse Frontend Mentor in the evening ' .
                'after my device\'s dark mode turns on without the bright background it currently has.',
            'feedback' => 'Add a dark theme option',
            'ownedBy' => 'Elijah Moss'
        ],
        [
            'body' => 'Second this! I do a lot of late night coding and reading. ' .
                'Adding a dark theme can be great for preventing eye strain and the headaches that result. ' .
                'It\'s also quite a trend with modern apps and apparently saves battery life.',
            'feedback' => 'Add a dark theme option',
            'ownedBy' => 'James Skinner',
        ],
        [
            'body' => 'While waiting for dark mode, there are browser extensions that will also do the job. ' .
                'Search for "dark theme" followed by your browser. ' .
                'There might be a need to turn off the extension for sites with naturally black backgrounds though.',
            'feedback' => 'Add a dark theme option',
            'parentComment' => 'Second this! I do a lot of late night coding and reading. ' .
                'Adding a dark theme can be great for preventing eye strain and the headaches that result. ' .
                'It\'s also quite a trend with modern apps and apparently saves battery life.',
            'ownedBy' => 'Anne Valentine'
        ],
        [
            'body' => 'Good point! Using any kind of style extension is great and can be highly customizable, like the ability to change contrast and brightness. ' .
                'I\'d prefer not to use one of such extensions, however, for security and privacy reasons.',
            'feedback' => 'Add a dark theme option',
            'parentComment' =>  'While waiting for dark mode, there are browser extensions that will also do the job. ' .
                'Search for "dark theme" followed by your browser. ' .
                'There might be a need to turn off the extension for sites with naturally black backgrounds though.',
            'ownedBy' => 'Ryan Welles'
        ],
        [
            'body' => 'Much easier to get answers from devs who can relate, since they\'ve either finished the challenge themselves or are in the middle of it.',
            'feedback' => 'Q&A within the challenge hubs',
            'ownedBy' => 'George Partridge'
        ],
        [
            'body' => 'Right now, there is no ability to add images while giving feedback which isn\'t ideal because I have to use another app to show what I mean.',
            'feedback' => 'Add image/video upload to feedback',
            'ownedBy' => 'Javier Pollard'
        ],
        [
            'body' => 'Yes I\'d like to see this as well. Sometimes I want to add a short video or gif to explain the site\'s behavior.',
            'feedback' => 'Add image/video upload to feedback',
            'ownedBy' => 'Roxanne Travis'
        ],
        [
            'body' => 'I also want to be notified when devs I follow submit projects on FEM. Is in-app notification also in the pipeline?',
            'feedback' => 'Ability to follow others',
            'ownedBy' => 'Victoria Mejia'
        ],
        [
            'body' => 'Bumping this. It would be good to have a tab with a feed of people I follow so it\'s easy to see what challenges they\'ve done lately. ' .
                'I learn a lot by reading good developers\' code.',
            'feedback' => 'Ability to follow others',
            'parentComment' => 'I also want to be notified when devs I follow submit projects on FEM. Is in-app notification also in the pipeline?',
            'ownedBy' => 'Zena Kelley'
        ],
        [
            'body' => 'I\'ve been saving the profile URLs of a few people and I check what they\'ve been doing from time to time. Being able to follow them solves that.',
            'feedback' => 'Ability to follow others',
            'ownedBy' => 'Jackson Barker'
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
            foreach (self::COMMENTS as $commentData) {
                $comment = new Comment();
                $comment->setBody($commentData['body']);

                $feedback = $this->entityManager->getRepository(Feedback::class)->findOneBy([
                    'title' => $commentData['feedback']
                ]);

                if (!$feedback) {
                    throw new \RuntimeException(sprintf('Feedback "%s" not found', $commentData['feedback']));
                }

                $comment->setFeedback($feedback);

                $user = $this->entityManager->getRepository(User::class)->findOneBy([
                    'fullName' => $commentData['ownedBy']
                ]);

                if (!$user) {
                    throw new \RuntimeException(sprintf('User "%s" not found', $commentData['ownedBy']));
                }

                $comment->setOwnedBy($user);

                if (isset($commentData['parentComment'])) {
                    $parentComment = $this->entityManager->getRepository(Comment::class)->findOneBy([
                        'body' => $commentData['parentComment']
                    ]);

                    $comment->setParentComment($parentComment);
                }

                $this->entityManager->persist($comment);
            }

            $this->entityManager->flush();

            $output->writeln('All comments have been created successfully!');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('Error creating comments: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
