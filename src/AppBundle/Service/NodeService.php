<?php
namespace AppBundle\Service;

use AppBundle\Entity\Node;
use AppBundle\Entity\Repository\NodeRepository;
use Doctrine\ORM\EntityManagerInterface;

class NodeService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var NodeRepository */
    private $nodeRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->nodeRepository = $entityManager->getRepository(Node::class);
    }

    /**
     * @param int $id
     *
     * @return Node
     *
     * @throws \Exception
     */
    public function getNodeById($id)
    {
        $node = $this->nodeRepository->findOneBy(['id' => $id]);

        if ($node === null) {
            throw new \Exception(sprintf('Node "%d" does not exists', $id));
        }

        return $node;
    }

    /**
     * @param int $id
     *
     * @return Node
     */
    public function viewNode($id)
    {
        $node = $this->getNodeById($id);

        $node->incrementViews();
        $this->entityManager->persist($node);
        $this->entityManager->flush();

        return $node;
    }
}
