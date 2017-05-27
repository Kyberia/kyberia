<?php
namespace AppBundle;

use AppBundle\FunctionalTester;
use Codeception\Example;

class RoutingCest
{
    /**
     * @example {"route": "homepage", "uri": "/"}
     * @example {"route": "login", "uri": "/login"}
     * @example {"route": "logout", "uri": "/logout"}
     */
    public function resolveRouteToUri(FunctionalTester $I, Example $example)
    {
        $I->followRedirects(false);
        $I->amOnRoute($example['route']);
        $I->seeCurrentUrlEquals($example['uri']);
    }
}
