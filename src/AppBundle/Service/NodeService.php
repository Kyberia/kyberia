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

    /** @var PermissionService */
    private $permissionService;

    public function __construct(
        EntityManagerInterface $entityManager,
        NodeRepository $nodeRepository,
        PermissionService $permissionService
    ) {
        $this->entityManager = $entityManager;
        $this->nodeRepository = $nodeRepository;
        $this->permissionService = $permissionService;
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

    /**
     * @param Node $node
     *
     * @return Node[]
     */
    public function getChildren(Node $node)
    {
        // Read permissions required for getting children
        $this->permissionService->canViewNode($node);

        $children = $node->getChildren();

        return $children;
    }

    /**
     * @param int $id
     *
     * @return Node[]
     */
    public function getChildrenById($id)
    {
        $node = $this->getNodeById($id);

        return $this->getChildren($node);
    }
}
