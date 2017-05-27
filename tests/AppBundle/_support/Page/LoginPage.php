<?php
namespace AppBundle\Page;

use AppBundle\FunctionalTester;

class LoginPage
{
    public static $route = 'login';
    public static $url = '/login';

    public static $formSelector = 'form[name="login_form"]';
    public static $usernameFieldId = '#login_form_username';
    public static $passwordFieldId = '#login_form_password';
    public static $submitButtonId = '#login_form_submit';

    /** @var FunctionalTester */
    protected $tester;

    public function __construct(FunctionalTester $I)
    {
        $this->tester = $I;
    }

    public function login($username, $password, $type = 'name')
    {
        $I = $this->tester;

        $I->amOnRoute(self::$route);
        $I->submitForm(self::$formSelector, [
            'login_form' => [
                'username' => $username,
                'password' => $password,
                'type' => $type,
            ],
        ], self::$submitButtonId);

        return $this;
    }
}
