<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\NodeAccess;

class NodeAccessRepository extends AbstractEntityRepository
{
    /**
     * @param int $userId
     *
     * @return NodeAccess[]
     */
    public function findBookmarksByUserId($userId)
    {
        $query = $this->createQueryBuilder('na')
            ->select('na', 'n', 'bc')
            ->innerJoin('na.node', 'n')
            ->leftJoin('na.bookmarkCategory', 'bc')
            ->where('na.userId = :userId AND na.bookmark = :bookmark')
            ->orderBy('n.name', 'ASC')
            ->setParameters([
                'bookmark' => NodeAccess::BOOKMARK_YES,
                'userId' => $userId,
            ])
            ->getQuery();

        return $query->getResult();
    }
}
