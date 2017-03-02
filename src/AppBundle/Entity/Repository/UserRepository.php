<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\User;
use AppBundle\Entity\UserRelation;

/**
 * @method null|User findOneBy(array $criteria, array $orderBy = null)
 */
class UserRepository extends AbstractEntityRepository
{
    /**
     * Find all active users followed by user
     *
     * @param int $userId
     *
     * @return User[]
     */
    public function findActiveFollowing($userId)
    {
        $dql = sprintf(
            'SELECT u FROM %s u
JOIN %s ur WITH ur.nodeId = u.id
WHERE ur.userId = :userId
  AND ur.type = :type
  AND u.lastAction IS NOT NULL
ORDER BY u.login ASC',
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
  AND ur.type = :type
ORDER BY u.login ASC',
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
  AND ur.type = :type
ORDER BY u.login ASC',
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
