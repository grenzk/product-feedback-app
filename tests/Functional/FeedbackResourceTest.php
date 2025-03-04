<?php

namespace App\Tests\Functional;

use App\Factory\FeedbackFactory;
use App\Factory\UserFactory;
use Zenstruck\Browser\HttpOptions;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class FeedbackResourceTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public function testGetCollectionOfFeedback(): void
    {
        $user1 = UserFactory::createOne();
        $user2 = UserFactory::createOne();

        FeedbackFactory::createMany(4, [
            'ownedBy' => $user1
        ]);

        $json = $this->browser()
            ->actingAs($user2)
            ->get('/api/feedback')
            ->assertJsonMatches('totalItems', 4)
            ->assertJsonMatches('length(member)', 4)
            ->assertJson()
            ->json();

        $this->assertSame(array_keys($json->decoded()['member'][0]), [
            '@id',
            '@type',
            'id',
            'title',
            'detail',
            'category',
            'status',
            'comments',
            'ownedBy',
            'upvotes',
            'commentCount'
        ]);
    }

    public function testPostToCreateFeedback(): void
    {
        $user = UserFactory::createOne();

        $this->browser()
            ->actingAs($user)
            ->post('/api/feedback', HttpOptions::json([]))
            ->assertStatus(422)
            ->post(
                '/api/feedback',
                HttpOptions::json(
                    [
                        'title' => 'Add tags for solutions',
                        'detail' => 'Easier to search for solutions based on a specific stack.',
                        'category' => 'Enhancement',
                        'status' => 'Suggestion',
                    ]
                )
            )
            ->assertStatus(201)
            ->assertJsonMatches('title', 'Add tags for solutions')
        ;
    }

    public function testPatchToUpdateFeedback(): void
    {
        $user1 =  UserFactory::createOne();
        $feedback = FeedbackFactory::createOne(['ownedBy' => $user1]);

        $this->browser()
            ->actingAs($user1)
            ->patch(
                '/api/feedback/' . $feedback->getId(),
                HttpOptions::json([
                    'status' => 'Planned'
                ])->withHeader('Content-Type', 'application/merge-patch+json')
            )
            ->assertStatus(200)
            ->assertJsonMatches('status', 'Planned')
        ;

        $user2 = UserFactory::createOne();

        $this->browser()
            ->actingAs($user2)
            ->patch(
                '/api/feedback/' . $feedback->getId(),
                HttpOptions::json([
                    'status' => 'Live',
                    'ownedBy' => '/api/users/' . $user2->getId()
                ])->withHeader('Content-Type', 'application/merge-patch+json')
            )
            ->assertStatus(403)
        ;

        $this->browser()
            ->actingAs($user1)
            ->patch(
                '/api/feedback/' . $feedback->getId(),
                HttpOptions::json([
                    'ownedBy' => '/api/users/' . $user2->getId()
                ])->withHeader('Content-Type', 'application/merge-patch+json')
            )
            ->assertStatus(403)
        ;
    }

    public function testDeleteToRemoveFeedback(): void
    {
        $user1 = UserFactory::createOne();
        $feedback = FeedbackFactory::createOne(['ownedBy' => $user1]);

        $this->browser()
            ->actingAs($user1)
            ->delete('/api/feedback/' . $feedback->getId())
            ->assertSuccessful()
        ;

        $user2 = UserFactory::createOne();
        $feedback = FeedbackFactory::createOne(['ownedBy' => $user1]);

        $this->browser()
            ->actingAs($user2)
            ->delete('/api/feedback/' . $feedback->getId())
            ->assertStatus(403)
        ;
    }
}
