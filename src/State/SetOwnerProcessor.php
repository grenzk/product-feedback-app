<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Feedback;
use App\Entity\Comment;
use App\Entity\Upvote;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator('api_platform.doctrine.orm.state.persist_processor')]
class SetOwnerProcessor implements ProcessorInterface
{
    public function __construct(private ProcessorInterface $innerProcessor, private Security $security) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (($data instanceof Feedback || $data instanceof Comment || $data instanceof Upvote) &&
            $data->getOwnedBy() === null && $this->security->getUser()
        ) {
            $data->setOwnedBy($this->security->getUser());
        }

        return $this->innerProcessor->process($data, $operation, $uriVariables, $context);
    }
}
