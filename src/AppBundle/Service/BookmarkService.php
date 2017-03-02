<?php
namespace AppBundle\Service;

use AppBundle\Entity\Repository\NodeAccessRepository;

class BookmarkService
{
    private $nodeAccessRepository;

    public function __construct(NodeAccessRepository $nodeAccessRepository)
    {
        $this->nodeAccessRepository = $nodeAccessRepository;
    }

    /**
     * Return list of bookmark NodeAccess-es with preloaded node and bookmark category node
     *
     * @param int $userId
     *
     * @return \AppBundle\Entity\NodeAccess[]
     */
    public function getBookmarks($userId)
    {
        $bookmarks = $this->nodeAccessRepository->findBookmarksByUserId($userId);

        return $bookmarks;
    }

    /**
     * Return array with array of category Nodes and array of bookmarks grouped by category ID
     *
     * @param int $userId
     *
     * @return array
     */
    public function getBookmarksAndCategories($userId)
    {
        $bookmarks = $this->getBookmarks($userId);

        $result = [
            'bookmarks' => [],
            'categories' => [],
        ];

        foreach ($bookmarks as $bookmark) {
            $categoryId = $bookmark->getBookmarkCategoryNodeId();

            if (!isset($result['categories'][$categoryId])) {
                $result['categories'][$categoryId] = $bookmark->getBookmarkCategory();
            }

            if (!isset($result['bookmarks'][$categoryId])) {
                $result['bookmarks'][$categoryId] = [];
            }

            $result['bookmarks'][$categoryId][] = $bookmark;
        }

        return $result;
    }
}
