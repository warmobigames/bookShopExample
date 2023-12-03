<?php

namespace App\Security\Voter;

use App\Entity\Chapter;
use App\Repository\PurchaseRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ChapterVoter extends Voter
{
    public const VIEW = 'CHAPTER_VIEW';
    public const CREATE = 'CHAPTER_CREATE';

    public function __construct(
        private PurchaseRepository $purchaseRepository,
    )
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::VIEW, self::CREATE])
            && $subject instanceof \App\Entity\Chapter;
    }

    /**
     * @param string $attribute
     * @param Chapter $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::VIEW:
                if (!$subject->getPurchaseRequired() or $user === $subject->getBook()->getUser()) {
                    return true;
                }

                return (bool)$this->purchaseRepository->findOneBy([
                    'user' => $user,
                    'book' => $subject->getBook()
                ]);
                break;
            case self::CREATE:
                return $subject->getBook()->getUser() === $user;
                break;
        }

        return false;
    }
}
