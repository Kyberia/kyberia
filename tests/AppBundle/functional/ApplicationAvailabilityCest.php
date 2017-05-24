<?php
namespace AppBundle;

use AppBundle\FunctionalTester;
use Codeception\Example;

class ApplicationAvailabilityCest
{
    public function _before(FunctionalTester $I)
    {
        $I->followRedirects(false);
    }

    /**
     * @example {"url": "/login"}
     */
    public function accessGuestPages(FunctionalTester $I, Example $example)
    {
        $I->followRedirects(false);
        $I->amOnPage($example['url']);
        $I->seeResponseCodeIs(200);
    }
}
