<?php

namespace App\Tests\Functional;

use App\Factory\FeedbackFactory;
use App\Factory\UpvoteFactory;
use App\Factory\UserFactory;
use Zenstruck\Browser\HttpOptions;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class UpvoteResourceTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public function testPostToUpvote(): void
    {
        $user = UserFactory::createOne();
        $feedback = FeedbackFactory::createOne();

        $this->browser()
            ->actingAs($user)
            ->post('/api/upvotes', HttpOptions::json([
                'feedback' => '/api/feedback/' . $feedback->getId()
            ]))
            ->assertSuccessful()
            ->get('/api/feedback/' . $feedback->getId())
            ->assertJsonMatches('upvoteCount', 1)
        ;

        $this->browser()
            ->actingAs($user)
            ->post('/api/upvotes', HttpOptions::json([
                'feedback' => '/api/feedback/' . $feedback->getId()
            ]))
            ->assertStatus(500)
            ->get('/api/feedback/' . $feedback->getId())
            ->assertJsonMatches('upvoteCount', 1)

        ;
    }

    public function testPostToUpvoteMultipleFeedback()
    {
        $user = UserFactory::createOne();
        $feedback1 = FeedbackFactory::createOne();
        $feedback2 = FeedbackFactory::createOne();

        $this->browser()
            ->actingAs($user)
            ->post('/api/upvotes', HttpOptions::json([
                'feedback' => '/api/feedback/' . $feedback1->getId(),
            ]))
            ->get('/api/feedback/' . $feedback1->getId())
            ->assertJsonMatches('upvoteCount', 1)
            ->post('/api/upvotes', HttpOptions::json([
                'feedback' => '/api/feedback/' . $feedback2->getId(),
            ]))
            ->get('/api/feedback/' . $feedback2->getId())
            ->assertJsonMatches('upvoteCount', 1)
        ;
    }

    public function testCanFeedbackBeUpvotedByMultipleUsers()
    {
        $user1 = UserFactory::createOne();
        $user2 = UserFactory::createOne();
        $feedback = FeedbackFactory::createOne();

        $this->browser()
            ->actingAs($user1)
            ->post('/api/upvotes', HttpOptions::json([
                'feedback' => '/api/feedback/' . $feedback->getId(),
            ]))
        ;

        $this->browser()
            ->actingAs($user2)
            ->post('/api/upvotes', HttpOptions::json([
                'feedback' => '/api/feedback/' . $feedback->getId(),
            ]))
            ->assertSuccessful()
            ->get('/api/feedback/' . $feedback->getId())
            ->assertJsonMatches('upvoteCount', 2)
        ;
    }

    public function testDeleteToRemoveUpvote()
    {
        $user = UserFactory::createOne();
        $feedback = FeedbackFactory::createOne();
        $upvote = UpvoteFactory::createOne([
            'feedback' => $feedback,
            'ownedBy' => $user
        ]);

        $this->browser()
            ->actingAs($user)
            ->get('/api/feedback/' . $feedback->getId())
            ->assertJsonMatches('upvoteCount', 1)
            ->delete('/api/upvotes/' . $upvote->getId())
            ->assertSuccessful()
            ->get('/api/feedback/' . $feedback->getId())
            ->assertJsonMatches('upvoteCount', 0)
        ;
    }
}
