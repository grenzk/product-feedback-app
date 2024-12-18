<?php

namespace App\DataFixtures;

use App\Entity\FeedbackCategoryEnum;
use App\Entity\FeedbackStatusEnum;
use App\Factory\CommentFactory;
use App\Factory\FeedbackFactory;
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

        $user1 = UserFactory::createOne([
            'email' => 'john.doe@example.com',
            'username' => 'johndoe'
        ]);

        $user2 = UserFactory::repository()->findOneBy(['email' => 'james.skinner@example.com']);

        FeedbackFactory::createOne([
            'title' => 'Add tags for solutions',
            'detail' => 'Easier to search for solutions based on a specific stack.',
            'category' => FeedbackCategoryEnum::ENHANCEMENT,
            'status' => FeedbackStatusEnum::SUGGESTION,
            'ownedBy' => $user1
        ]);

        FeedbackFactory::createOne([
            'title' => 'Add a dark theme option',
            'detail' => 'It would help people with light sensitivities and who prefer dark mode.',
            'category' => FeedbackCategoryEnum::FEATURE,
            'status' => FeedbackStatusEnum::SUGGESTION,
            'ownedBy' => $user1
        ]);

        FeedbackFactory::createOne([
            'title' => 'Q&A within the challenge hubs',
            'detail' => 'Challenge-specific Q&A would make for easy reference.',
            'category' => FeedbackCategoryEnum::FEATURE,
            'status' => FeedbackStatusEnum::SUGGESTION,
            'ownedBy' => $user1
        ]);

        FeedbackFactory::createOne([
            'title' => 'Allow image/video upload to feedback',
            'detail' => 'Images and screencasts can enhance comments on solutions.',
            'category' => FeedbackCategoryEnum::ENHANCEMENT,
            'status' => FeedbackStatusEnum::SUGGESTION,
            'ownedBy' => $user1
        ]);

        $feedback = FeedbackFactory::repository()->findOneBy(['title' => 'Add a dark theme option']);

        CommentFactory::createOne([
            'body' => 'Second this! I do a lot of late night coding and reading. ' .
                'Adding a dark theme can be great for preventing eye strain and the headaches that result. ' .
                'It’s also quite a trend with modern apps and apparently saves battery life.',
            'feedback' => $feedback,
            'ownedBy' => $user2,
        ]);
    }
}
