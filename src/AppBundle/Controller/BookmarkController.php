<?php
namespace AppBundle\Controller;

use AppBundle\Service\BookmarkService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BookmarkController extends Controller
{
    /**
     * @return BookmarkService
     */
    private function getBookmarkService()
    {
        return $this->get('app.bookmark');
    }

    /**
     * @Route("/bookmarks", name="bookmark.index")
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {
        $result = $this->getBookmarkService()->getBookmarksAndCategories($this->getUser()->getId());

        return $this->render('bookmark/index.html.twig', [
            'bookmarks' => $result['bookmarks'],
            'categories' => $result['categories'],
        ]);
    }
}
