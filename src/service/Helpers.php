<?php

namespace App\service;

use App\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class Helpers
{

    public function __construct(private LoggerInterface $logger, private Security $security) {}

    public function getUser(): ?User {
        if($this->security->isGranted('ROLE_ADMIN')) {
            $user = $this->security->getUser();
            if ($user instanceof User) {
                return $user;
            }
        }
        return null;
    }
}