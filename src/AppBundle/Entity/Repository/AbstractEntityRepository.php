<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\AbstractEntity;
use Doctrine\ORM\EntityRepository;

abstract class AbstractEntityRepository extends EntityRepository
{
    /**
     * Persist and flush entity
     *
     * @param AbstractEntity $entity
     */
    public function persist(AbstractEntity $entity)
    {
        $entityClass = get_class($entity);
        if ($this->getEntityName() !== $entity) {
            $msg = sprintf('Entity "%s" does not belong to this repository', $entityClass);
            throw new \InvalidArgumentException($msg);
        }

        $this->_em->persist($entity);
        $this->_em->flush($entity);
    }
}
