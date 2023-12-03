<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
#[AsDecorator('api_platform.doctrine.orm.state.persist_processor')]
final class SetCurrentUser implements ProcessorInterface
{
    public function __construct(
        private readonly ProcessorInterface $processor,
        private readonly Security $security
    )
    {
    }

    public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if (method_exists($data,'setUser')) {
            if ($data->getUser() === null) {
                $data->setUser($this->security->getUser());
            }
        }

        return $this->processor->process($data, $operation, $uriVariables, $context);
    }
}