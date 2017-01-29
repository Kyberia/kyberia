<?php
namespace AppBundle\Menu;

use AppBundle\Security\AuthenticatedUserAwareInterface;
use AppBundle\Security\AuthenticatedUserAwareTrait;
use Knp\Menu\FactoryInterface;

class MenuBuilder implements AuthenticatedUserAwareInterface
{
    use AuthenticatedUserAwareTrait;

    /** @var FactoryInterface */
    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Home', ['route' => 'homepage'])
            ->setExtra('icon', 'home fa-lg');
        $menu->addChild('Bookmarks', ['uri' => '#'])
            ->setExtra('icon', 'bookmark');
        $mailItem = $menu->addChild('Mail', ['route' => 'mail.index'])
            ->setExtra('icon', 'envelope');
        $menu->addChild('K', ['uri' => '#'])
            ->setExtra('icon', 'newspaper-o');

        if (($mailCount = $this->authenticatedUser->getMailCount())) {
            $mailItem->setExtra('label', [
                'content' => $mailCount,
            ]);
        }

        return $menu;
    }
}
