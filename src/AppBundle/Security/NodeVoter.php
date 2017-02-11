<?php
namespace AppBundle\Security;

use AppBundle\Entity\Node;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class NodeVoter extends Voter
{
    const EDIT  = 'edit';
    const VIEW  = 'r';
    const WRITE = 'w';

    /** @inheritdoc */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [static::VIEW, static::WRITE])) {
            return false;
        }

        if (!$subject instanceof Node) {
            return false;
        }

        return true;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        /**
         * @var Node $node
         * @var User $user
         */
        $node = $subject;
        $user = $token->getUser();

        // User must be logged in if node does not have external access
        if (!$node->hasExternalAccess() && !$user instanceof User) {
            return false;
        }

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($node, $user);
            case self::EDIT:
                return $this->canEdit($node, $user);
        }

        throw new \LogicException(sprintf('Invalid voter attribute "%s"', $attribute));
    }

    private function canView(Node $node, User $user = null)
    {
        // Unauthenticated users can view nodes with enabled external access
        if ($user === null && $node->hasExternalAccess()) {
            return true;
        }

        // check ban

        if ($node->isPrivate()) {
            // check node access;
            return false;
        }

        if ($node->isPublic() || $node->isModerated()) {
            return true;
        }

        return false;
    }

    private function canEdit(Node $node, User $user)
    {
        if ($node->getCreatedBy() === $user->getId()) {
            return true;
        }

        return false;
    }
}
