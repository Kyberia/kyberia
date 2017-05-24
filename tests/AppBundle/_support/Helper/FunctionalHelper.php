<?php
namespace AppBundle\Helper;

use Codeception\Module;

class FunctionalHelper extends Module
{
    public function followRedirects($followRedirect = true)
    {
        /** @var \Codeception\Module\Symfony $symfony */
        $symfony = $this->getModule('Symfony');
        $symfony->client->followRedirects($followRedirect);
    }
}
