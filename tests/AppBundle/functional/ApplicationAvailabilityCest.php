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

    public function accessHomepage(FunctionalTester $I)
    {
        $I->amOnRoute('homepage');
        $I->expect('redirect to kyberia.sk');
        $I->seeResponseCodeIs(302);
        $I->haveHttpHeader('Location', 'https://kyberia.sk');
    }

    /**
     * @example {"url": "/login"}
     */
    public function accessGuestPages(FunctionalTester $I, Example $example)
    {
        $I->amOnPage($example['url']);
        $I->seeResponseCodeIs(200);
    }
}
