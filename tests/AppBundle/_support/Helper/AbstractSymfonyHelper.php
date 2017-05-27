<?php
namespace AppBundle\Helper;

use Codeception\Module;

abstract class AbstractSymfonyHelper extends Module
{
    /**
     * @return Module\Symfony
     */
    protected function getSymfonyModule()
    {
        /** @var \Codeception\Module\Symfony $symfony */
        $symfony = $this->getModule('Symfony');

        return $symfony;
    }
}
