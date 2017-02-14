<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\User;
use AppBundle\Entity\UserRelation;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * Find all user's followers
     *
     * @param int $userId
     *
     * @return User[]
     */
    public function findAllFollowers($userId)
    {
        $dql = sprintf(
            'SELECT u FROM %s u
JOIN %s ur WITH ur.userId = u.id
WHERE ur.nodeId = :userId
  AND ur.type = :type',
            User::class,
            UserRelation::class
        );

        $query = $this->_em->createQuery($dql)
            ->setParameters([
                'userId' => $userId,
                'type' => UserRelation::TYPE_FRIEND,
            ]);

        return $query->getResult();
    }

    /**
     * Find all users followed by user
     *
     * @param int $userId
     *
     * @return User[]
     */
    public function findAllFollowing($userId)
    {
        $dql = sprintf(
            'SELECT u FROM %s u
JOIN %s ur WITH ur.nodeId = u.id
WHERE ur.userId = :userId
  AND ur.type = :type',
            User::class,
            UserRelation::class
        );

        $query = $this->_em->createQuery($dql)
            ->setParameters([
                'userId' => $userId,
                'type' => UserRelation::TYPE_FRIEND,
            ]);

        return $query->getResult();
    }
}
