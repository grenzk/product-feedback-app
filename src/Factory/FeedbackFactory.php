<?php

namespace App\Factory;

use App\Entity\Feedback;
use App\Entity\FeedbackCategoryEnum;
use App\Entity\FeedbackStatusEnum;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Feedback>
 */
final class FeedbackFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct() {}

    public static function class(): string
    {
        return Feedback::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'category' => self::faker()->randomElement(FeedbackCategoryEnum::cases()),
            'detail' => self::faker()->text(),
            'status' => self::faker()->randomElement(FeedbackStatusEnum::cases()),
            'title' => self::faker()->text(50),
            'ownedBy' => UserFactory::new()
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Feedback $feedback): void {})
        ;
    }
}
