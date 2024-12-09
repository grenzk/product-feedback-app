<?php

namespace App\Tests\Functional;

use App\Entity\ApiToken;
use App\Factory\ApiTokenFactory;
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
        FeedbackFactory::createMany(4);

        $json = $this->browser()
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
            'ownedBy'
        ]);
    }

    public function testPostToCreateFeedback(): void
    {
        $user =  UserFactory::createOne();

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
                        'category' => 'enhancement',
                        'status' => 'suggestion',
                    ]
                )
            )
            ->assertStatus(201)
            ->assertJsonMatches('title', 'Add tags for solutions')
        ;
    }

    public function testPostToCreateFeedbackWithApiKey(): void
    {
        $token = ApiTokenFactory::createOne([
            'scopes' => [ApiToken::SCOPE_FEEDBACK_CREATE]
        ]);

        $this->browser()
            ->post('/api/feedback', HttpOptions::json([])
                ->withHeader('Authorization', 'Bearer ' . $token->getToken()))
            ->assertStatus(422)
        ;
    }

    public function testPostToCreateFeedbackDeniedWithoutScope(): void
    {
        $token = ApiTokenFactory::createOne([
            'scopes' => [ApiToken::SCOPE_FEEDBACK_EDIT]
        ]);

        $this->browser()
            ->post('/api/feedback', HttpOptions::json([])
                ->withHeader('Authorization', 'Bearer ' . $token->getToken()))
            ->assertStatus(403)
        ;
    }

    public function testPatchToUpdateFeedback(): void
    {
        $user =  UserFactory::createOne();
        $feedback = FeedbackFactory::createOne(['ownedBy' => $user]);

        $this->browser()
            ->actingAs($user)
            ->patch(
                '/api/feedback/' . $feedback->getId(),
                HttpOptions::json([
                    'status' => 'planned'
                ])->withHeader('Content-Type', 'application/merge-patch+json')
            )
            ->assertStatus(200)
            ->assertJsonMatches('status', 'planned')
        ;

        $user2 = UserFactory::createOne();

        $this->browser()
            ->actingAs($user2)
            ->patch(
                '/api/feedback/' . $feedback->getId(),
                HttpOptions::json([
                    'status' => 'live',
                    'ownedBy' => '/api/users/' . $user2->getId()
                ])->withHeader('Content-Type', 'application/merge-patch+json')
            )
            ->assertStatus(403)
        ;

        $this->browser()
            ->actingAs($user)
            ->patch(
                '/api/feedback/' . $feedback->getId(),
                HttpOptions::json([
                    'ownedBy' => '/api/users/' . $user2->getId()
                ])->withHeader('Content-Type', 'application/merge-patch+json')
            )
            ->assertStatus(403)
        ;
    }
}
