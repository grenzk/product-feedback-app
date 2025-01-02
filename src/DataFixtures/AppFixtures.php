<?php

namespace App\DataFixtures;

use App\Entity\FeedbackCategoryEnum;
use App\Entity\FeedbackStatusEnum;
use App\Factory\CommentFactory;
use App\Factory\FeedbackFactory;
use App\Factory\UpvoteFactory;
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
                'fullName' => $user['fullName'],
                'username' => $user['username'],
            ]);
        }

        $user1 = UserFactory::createOne([
            'email' => 'john.doe@example.com',
            'fullName' => 'John Doe',
            'username' => 'johndoe'
        ]);

        $user2 = UserFactory::repository()->findOneBy(['email' => 'elijah.moss@example.com']);
        $user3 = UserFactory::repository()->findOneBy(['email' => 'james.skinner@example.com']);
        $user4 = UserFactory::repository()->findOneBy(['email' => 'anne.valentine@example.com']);

        $feedback1 = FeedbackFactory::createOne([
            'title' => 'Add tags for solutions',
            'detail' => 'Easier to search for solutions based on a specific stack.',
            'category' => FeedbackCategoryEnum::ENHANCEMENT,
            'status' => FeedbackStatusEnum::SUGGESTION,
            'ownedBy' => $user1,
        ]);

        UpvoteFactory::createMany(112, [
            'feedback' => $feedback1
        ]);

        $feedback2 = FeedbackFactory::createOne([
            'title' => 'Add a dark theme option',
            'detail' => 'It would help people with light sensitivities and who prefer dark mode.',
            'category' => FeedbackCategoryEnum::FEATURE,
            'status' => FeedbackStatusEnum::SUGGESTION,
            'ownedBy' => $user1,
        ]);

        UpvoteFactory::createMany(99, [
            'feedback' => $feedback2
        ]);

        $feedback3 = FeedbackFactory::createOne([
            'title' => 'Q&A within the challenge hubs',
            'detail' => 'Challenge-specific Q&A would make for easy reference.',
            'category' => FeedbackCategoryEnum::FEATURE,
            'status' => FeedbackStatusEnum::SUGGESTION,
            'ownedBy' => $user1
        ]);

        UpvoteFactory::createMany(65, [
            'feedback' => $feedback3
        ]);

        $feedback4 = FeedbackFactory::createOne([
            'title' => 'Allow image/video upload to feedback',
            'detail' => 'Images and screencasts can enhance comments on solutions.',
            'category' => FeedbackCategoryEnum::ENHANCEMENT,
            'status' => FeedbackStatusEnum::SUGGESTION,
            'ownedBy' => $user1
        ]);

        UpvoteFactory::createMany(51, [
            'feedback' => $feedback4
        ]);

        CommentFactory::createOne([
            'body' => 'Also, please allow styles to be applied based on system preferences. ' .
                'I would love to be able to browse Frontend Mentor in the evening ' .
                'after my device\'s dark mode turns on without the bright background it currently has.',
            'feedback' => $feedback2,
            'ownedBy' => $user2,
        ]);

        $comment = CommentFactory::createOne([
            'body' => 'Second this! I do a lot of late night coding and reading. ' .
                'Adding a dark theme can be great for preventing eye strain and the headaches that result. ' .
                'It\'s also quite a trend with modern apps and apparently saves battery life.',
            'feedback' => $feedback2,
            'ownedBy' => $user3,
        ]);

        CommentFactory::createOne([
            'body' => 'While waiting for dark mode, there are browser extensions that will also do the job. ' .
                'Search for "dark theme" followed by your browser. ' .
                'There might be a need to turn off the extension for sites with naturally black backgrounds though.',
            'feedback' => $feedback2,
            'parentComment' => $comment,
            'ownedBy' => $user4
        ]);
    }
}
