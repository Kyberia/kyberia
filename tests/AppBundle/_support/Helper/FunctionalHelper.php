<?php
namespace AppBundle\Helper;

class FunctionalHelper extends AbstractSymfonyHelper
{
    /**
     * Sets whether to automatically follow redirects or not
     *
     * @param bool $followRedirect
     */
    public function followRedirects($followRedirect = true)
    {
        $this->getSymfonyModule()->client->followRedirects($followRedirect);
    }
}
