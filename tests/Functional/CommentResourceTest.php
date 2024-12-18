<?php

namespace App\Tests\Functional;

use App\Factory\CommentFactory;
use App\Factory\FeedbackFactory;
use App\Factory\UserFactory;
use Zenstruck\Browser\HttpOptions;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class CommentResourceTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public function testPostToCreateComment()
    {
        $user = UserFactory::createOne();
        $feedback = FeedbackFactory::createOne();

        $this->browser()
            ->actingAs($user)
            ->post('/api/comments', HttpOptions::json([
                'feedback' => '/api/feedback/' . $feedback->getId(),
                'body' => 'This is a sample comment.',
            ]))
            ->assertSuccessful()
            ->assertJsonMatches('feedback', '/api/feedback/1')
        ;
    }

    public function testPatchToUpdateComment(): void
    {
        $user1 =  UserFactory::createOne();
        $comment = CommentFactory::createOne(['ownedBy' => $user1]);

        $this->browser()
            ->actingAs($user1)
            ->patch(
                '/api/comments/' . $comment->getId(),
                HttpOptions::json([
                    'body' => 'Changed my own comment.',
                ])->withHeader('Content-Type', 'application/merge-patch+json')
            )
            ->assertSuccessful()
            ->assertJsonMatches('body', 'Changed my own comment.')
        ;

        $user2 = UserFactory::createOne();

        $this->browser()
            ->actingAs($user2)
            ->patch(
                '/api/comments/' . $comment->getId(),
                HttpOptions::json([
                    'body' => 'Changed the comment by another user.',
                    'ownedBy' => '/api/users/' . $user2->getId()
                ])->withHeader('Content-Type', 'application/merge-patch+json')
            )
            ->assertStatus(403)
        ;

        $this->browser()
            ->actingAs($user1)
            ->patch(
                '/api/comments/' . $comment->getId(),
                HttpOptions::json([
                    'ownedBy' => '/api/users/' . $user2->getId()
                ])->withHeader('Content-Type', 'application/merge-patch+json')
            )
            ->assertStatus(403)
        ;
    }

    public function testDeleteComment()
    {
        $user1 = UserFactory::createOne();
        $comment = CommentFactory::createOne(['ownedBy' => $user1]);

        $this->browser()
            ->actingAs($user1)
            ->delete('/api/comments/' . $comment->getId())
            ->assertSuccessful()
        ;

        $user2 = UserFactory::createOne();
        $comment = CommentFactory::createOne(['ownedBy' => $user1]);

        $this->browser()
            ->actingAs($user2)
            ->delete('/api/comments/' . $comment->getId())
            ->assertStatus(403)
        ;
    }
}
