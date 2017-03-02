<?php
namespace AppBundle\Security;

use AppBundle\Form\Type\LoginFormType;
use AppBundle\Service\UserService;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class FormAuthenticator extends AbstractGuardAuthenticator
{
    /** @var FormFactoryInterface */
    private $formFactory;

    /** @var RouterInterface */
    private $router;

    /** @var UserService */
    private $userService;

    public function __construct(FormFactoryInterface $formFactory, RouterInterface $router, UserService $userService)
    {
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->userService = $userService;
    }

    //region GuardAuthenticatorInterface

    //region AuthenticationEntryPointInterface

    /**
     * @inheritdoc
     *
     * @param Request $request The request that resulted in an AuthenticationException
     * @param AuthenticationException $authException The exception that started the authentication process
     *
     * @return Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse($this->getLoginPath());
    }

    //endregion

    /**
     * @inheritdoc
     *
     * @param Request $request
     *
     * @return UserCredentials|null
     */
    public function getCredentials(Request $request)
    {
        if (!$request->isMethod('POST')) {
            return null;
        }

        if ($request->getPathInfo() !== $this->getLoginPath()) {
            return null;
        }

        $form = $this->formFactory->create(LoginFormType::class, null, []);
        $form->handleRequest($request);

        $username = $form->get('username')->getData();
        $this->setLastAuthenticationUsername($request, $username);

        $credentials = new UserCredentials(
            $username,
            $form->get('password')->getData(),
            $form->get('type')->getData()
        );

        return $credentials;
    }

    /**
     * @inheritdoc
     *
     * @param UserCredentials $credentials
     * @param UserProviderInterface $userProvider
     *
     * @throws AuthenticationException
     *
     * @return UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials->getUsernameCompound());
    }

    /**
     * @inheritdoc
     *
     * @param UserCredentials $credentials
     * @param UserInterface $user
     *
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->userService->validatePassword($user, $credentials->getPassword());
    }

    /**
     * Called when authentication executed, but failed (e.g. wrong username password).
     *
     * @inheritdoc
     *
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return Response|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $this->setLastAuthenticationError($request, $exception);

        return new RedirectResponse($this->getLoginPath());
    }

    /**
     * Called when authentication executed and was successful!
     *
     * @inheritdoc
     *
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey The provider (i.e. firewall) key
     *
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $targetPath = $this->getTargetPath($request, $providerKey);

        if (empty($targetPath)) {
            $targetPath = $this->getHomepagePath();
        }

        return new RedirectResponse($targetPath);
    }

    /**
     * Authenticator supports "remember me" functionality
     *
     * @return bool
     */
    public function supportsRememberMe()
    {
        return true;
    }

    //endregion

    //region Page URLs

    /**
     * Homepage URI
     *
     * @return string
     */
    private function getHomepagePath()
    {
        return $this->router->generate('homepage');
    }

    /**
     * Login page URI
     *
     * @return string
     */
    private function getLoginPath()
    {
        return $this->router->generate('login');
    }

    //endregion

    //region Authentication utils

    private function getTargetPath(Request $request, $providerKey)
    {
        return $request->getSession()->get('_security.'.$providerKey.'.target_path');
    }

    private function setLastAuthenticationError(Request $request, AuthenticationException $exception)
    {
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
    }

    private function setLastAuthenticationUsername(Request $request, $username)
    {
        $request->getSession()->set(Security::LAST_USERNAME, $username);
    }

    //endregion
}
