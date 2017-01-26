<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Mail;
use Doctrine\ORM\EntityRepository;

class MailRepository extends EntityRepository
{
    /**
     * @param int $authenticatedUserId
     *
     * @return array
     */
    public function getAllLastMailIdAndRecipientUserId($authenticatedUserId)
    {
        $query = $this->createQueryBuilder('m')
            ->select([
                'MAX(m.id) AS lastMailId',
                'IF(m.userIdFrom = :authenticatedUserId AND m.userId = :authenticatedUserId, m.userIdTo, m.userIdFrom) AS recipientUserId',
            ])
            ->where('m.userId = :authenticatedUserId')
            ->groupBy('recipientUserId')
            ->orderBy('lastMailId', 'DESC')
            ->setParameter('authenticatedUserId', $authenticatedUserId)
            ->getQuery();

        return $query->getArrayResult();
    }

    /**
     * @param int $authenticatedUserId
     * @param int $recipientUserId
     *
     * @return Mail[]
     */
    public function findAllMessagesBetweenUsers($authenticatedUserId, $recipientUserId)
    {
        $qb = $this->createQueryBuilder('m');

        $where = $qb->expr()->orX(
            'm.userIdFrom = :authenticatedUserId AND m.userIdTo = :recipientUserId',
            'm.userIdFrom = :recipientUserId AND m.userIdTo = :authenticatedUserId'
        );

        $query = $qb->where($where)
            ->andWhere('m.userId = :authenticatedUserId')
            ->setParameters([
                'authenticatedUserId' => $authenticatedUserId,
                'recipientUserId' => $recipientUserId,
            ])
            ->orderBy('m.id', 'DESC')
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @param int $userId
     *
     * @return int
     */
    public function countUnreadMail($userId)
    {
        $query = $this->createQueryBuilder('m')
            ->select('COUNT(m.id)')
            ->where('m.userId = :userId AND m.userIdTo = :userId AND m.isRead = :isRead')
            ->setParameters([
                'userId' => $userId,
                'isRead' => 'no',
            ])
            ->getQuery();

        return (int) $query->getSingleScalarResult();
    }

    /**
     * @param int $userIdFrom
     * @param int $userIdTo
     *
     * @return mixed
     */
    public function markMailsAsRead($userIdFrom, $userIdTo)
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->update(Mail::class, 'm')
            ->set('m.isRead', $this->getEntityManager()->getConnection()->quote('yes'))
            ->where('m.userIdFrom = :userIdFrom AND m.userIdTo = :userIdTo AND m.isRead = :isRead')
            ->setParameters([
                'userIdFrom' => $userIdFrom,
                'userIdTo' => $userIdTo,
                'isRead' => 'no',
            ])
            ->getQuery();

        return $query->execute();
    }
}
