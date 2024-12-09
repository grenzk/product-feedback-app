<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Feedback;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator('api_platform.doctrine.orm.state.persist_processor')]
class FeedbackSetOwnerProcessor implements ProcessorInterface
{
    public function __construct(private ProcessorInterface $innerProcessor, private Security $security) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Feedback
    {
        if ($data instanceof Feedback && $data->getOwnedBy() === null && $this->security->getUser()) {
            $data->setOwnedBy($this->security->getUser());
        }

        return $this->innerProcessor->process($data, $operation, $uriVariables, $context);
    }
}
