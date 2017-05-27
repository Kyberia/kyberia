<?php
namespace AppBundle;

use AppBundle\FunctionalTester;
use AppBundle\Page\LoginPage;

class AuthenticationCest
{
    public function _before(FunctionalTester $I)
    {
        $I->followRedirects(false);
    }

    public function formExists(FunctionalTester $I)
    {
        $I->amOnRoute(LoginPage::$route);
        $I->seeElement(LoginPage::$formSelector);
        $I->seeElement(LoginPage::$usernameFieldId);
        $I->seeElement(LoginPage::$passwordFieldId);
        $I->seeElement(LoginPage::$submitButtonId);
    }

    public function loginWithUsername(FunctionalTester $I, LoginPage $loginPage)
    {
        $loginPage->login('tester', 'password');
        $I->seeIsGranted('IS_AUTHENTICATED_FULLY');
    }

    public function loginWithId(FunctionalTester $I, LoginPage $loginPage)
    {
        $loginPage->login(1000, 'password', 'id');
        $I->seeIsGranted('IS_AUTHENTICATED_FULLY');
    }
}
