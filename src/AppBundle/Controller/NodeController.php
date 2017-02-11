<?php
namespace AppBundle\Controller;

use AppBundle\Service\NodeService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NodeController extends Controller
{
    /**
     * @Route("/id/{id}", name="node.view")
     */
    public function viewAction(Request $request, $id)
    {
        $node = $this->getNodeService()->viewNode($id);

        return $this->render('node/view.html.twig', [
            'node' => $node,
        ]);
    }

    public function editAction(Request $request, $id)
    {
        $node = $this->getNodeService()->viewNode($id);

        return $this->render('node/view.html.twig', [
            'node' => $node,
        ]);
    }

    /**
     * @return NodeService
     */
    private function getNodeService()
    {
        return $this->get('app.node');
    }
}
