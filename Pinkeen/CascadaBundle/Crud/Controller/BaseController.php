<?php

namespace Pinkeen\CascadaBundle\Crud\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Provides common convenience methods for controllers.
 */
class BaseController extends ContainerAware
{
    /**
     * @var RouterInterface
     */
    private $router = null;

    /**
     * @var RequestStack
     */
    private $requestStack = null;

    /**
     * @var HttpKernelInterface
     */
    private $kernel = null;

    /**
     * @var CsrfTokenManagerInterface
     */
    private $csrfTokenManager = null;

    /**
     * @var EngineInterface
     */
    private $templating = null;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory = null;

    /**
     * @var SecurityContextInterface
     */
    private $securityContext = null;

    /**
     * @var TranslatorInterface
     */
    private $translator = null;

    /**
     * Returns router service.
     *
     * @return null|RouterInterface
     */
    protected function getRouter()
    {
        if (null === $this->router) {
            $this->router = $this->getService('routing');
        }

        return $this->router;
    }

    /**
     * Returns the request stack service.
     *
     * @return null|RequestStack
     */
    protected function getRequestStack()
    {
        if (null === $this->requestStack) {
            $this->requestStack = $this->getService('request_stack');
        }

        return $this->requestStack;
    }

    /**
     * Returns current request.
     *
     * @return null|Request
     */
    protected function getRequest()
    {
        return $this->getRequestStack()->getCurrentRequest();
    }

    /**
     * @return null|Session
     */
    protected function getSession()
    {
        return $this->getRequest()->getSession();
    }

    /**
     * Returns CSRF token manager service.
     *
     * @return null|CsrfTokenManagerInterface
     */
    protected function getCsrfTokenManager()
    {
        if (null === $this->csrfTokenManager) {
            $this->csrfTokenManager = $this->getService('security.csrf.token_manager');
        }

        return $this->csrfTokenManager;
    }

    /**
     * Returns templating service.
     *
     * @return null|EngineInterface
     */
    protected function getTemplating()
    {
        if (null === $this->templating) {
            $this->templating = $this->getService('templating');
        }

        return $this->templating;
    }

    /**
     * Returns kernel service.
     *
     * @return null|HttpKernelInterface
     */
    protected function getKernel()
    {
        if (null === $this->kernel) {
            $this->kernel = $this->getService('http_kernel');
        }

        return $this->kernel;
    }

    /**
     * Returns form factory service.
     *
     * @return null|FormFactoryInterface
     */
    protected function getFormFactory()
    {
        if (null === $this->formFactory) {
            $this->formFactory = $this->getService('security.context');
        }

        return $this->formFactory;
    }

    /**
     * Returns security context service.
     *
     * @return null|SecurityContextInterface
     */
    protected function getSecurityContext()
    {
        if (null === $this->securityContext) {
            $this->securityContext = $this->getService('form.factory');
        }

        return $this->securityContext;
    }

    /**
     * Returns security translator service.
     *
     * @return null|TranslatorInterface
     */
    protected function getTranslator()
    {
        if (null === $this->translator) {
            $this->translator = $this->getService('translator');
        }

        return $this->translator;
    }

    /**
     * Returns service by name from the DIC.
     *
     * @param string $name
     * @return object|null
     */
    protected function getService($name)
    {
        return $this->container->get($name);
    }

    /**
     * Tests if service exists in the DIC.
     *
     * @param $name
     * @return bool
     */
    protected function hasService($name)
    {
        return $this->container->has($name);
    }

    /**
     * Creates not found exception.
     *
     * @param $message
     * @return NotFoundHttpException
     */
    protected function createNotFoundException($message)
    {
        return new NotFoundHttpException($message);
    }

    /**
     * Creates access denied exception.
     *
     * @param $message
     * @return AccessDeniedException
     */
    protected function createAccessDeniedException($message)
    {
        return new AccessDeniedException($message);
    }

    /**
     * Returns currently logged in user or null.
     *
     * @return UserInterface|null
     */
    public function getUser()
    {
        $token = $token = $this->getSecurityContext()->getToken();

        if (null === $token) {
            return null;
        }

        $user = $token->getUser();

        if (!is_object($user)) {
            return null;
        }

        return $user;
    }

    /**
     * Checks whether the supplied token value is valid for the selected intent.
     *
     * @param string $intent
     * @param string $token
     * @return bool
     */
    protected function isCsrfTokenValid($intent, $token)
    {
        return $this->getCsrfTokenManager()->isTokenValid(new CsrfToken($intent, $token));
    }

    /**
     * Creates a redirect response.
     *
     * @param $url
     * @return RedirectResponse
     */
    protected function createRedirect($url)
    {
        return new RedirectResponse($url);
    }

    /**
     * Generates url for the named route.
     *
     * @param string $route
     * @param array $params
     * @param bool $absolute
     * @return string
     */
    protected function generateUrl($route, array $params = [], $absolute = false)
    {
        return $this->getRouter()->generate($route, $params, $absolute);
    }

    /**
     * Returns a redirect with url generated from route.
     *
     * @param string $route
     * @param array $params
     * @return RedirectResponse
     */
    protected function createRouteRedirect($route, $params = [])
    {
        return $this->createRedirect(
            $this->generateUrl($route, $params)
        );
    }

    /**
     * Generates redirect to the referer if present or the the altRoute otherwise.
     *
     * It will also redirect to altRoute if the referer is an external url (doesn't contain the current baseUrl).
     *
     * @param string $altRoute
     * @return RedirectResponse
     */
    protected function createBackRedirect($altRoute)
    {
        $request = $this->getRequest();

        $referer = $request->headers->get('referer');

        if (null !== $referer && strpos($referer, $request->getBaseUrl()) === 0) {
            return $this->createRedirect($referer);
        }

        return $this->createRouteRedirect($altRoute);
    }

    /**
     * Renders template and wraps it in a Response object.
     *
     * @param string $template
     * @param array $parameters
     * @param int $status
     * @return Response
     */
    protected function renderResponse($template, array $parameters = [], $status = 200)
    {
        return new Response($this->getTemplating()->render($template, $parameters), $status);
    }

    /**
     * Checks whether currently logged in user is granted a role.
     *
     * @param $role
     * @return bool
     */
    protected function isUserGranted($role)
    {
        return $this->getSecurityContext()->isGranted($role);
    }

    /**
     * Asserts that currently logged in user is granted a role.
     *
     * If not an access denied exception is thrown.
     *
     * @param $role
     * @return bool
     * @throws AccessDeniedException
     */
    protected function assertUserIsGranted($role)
    {
        if (!$this->getSecurityContext()->isGranted($role)) {
            throw $this->createAccessDeniedException("User should be granted '{$role}.'");
        }
    }

    /**
     * Translates the message.
     *
     * @param string $id
     * @param array $params
     * @param string $domain
     * @return string
     */
    protected function trans($id, array $params = [], $domain = 'cascada_admin')
    {
        return $this->getTranslator()->trans($id, $params, $domain);
    }

    /**
     * Adds flash message.
     *
     * @param string $message
     * @param string $type
     */
    protected function addFlash($message, $type = 'info')
    {
        $this->getSession()->getFlashBag()->add($type, $message);
    }

    /**
     * Adds error flash message.
     *
     * @param $message
     */
    protected function addErrorFlash($message)
    {
        $this->addFlash($message, 'error');
    }

    /**
     * Adds info flash message.
     *
     * @param $message
     */
    protected function addInfoFlash($message)
    {
        $this->addFlash($message, 'info');
    }

    /**
     * Adds warning flash message.
     *
     * @param $message
     */
    protected function addWarningFlash($message)
    {
        $this->addFlash($message, 'warning');
    }

    /**
     * Adds success flash message.
     *
     * @param $message
     */
    protected function addSuccessFlash($message)
    {
        $this->addFlash($message, 'success');
    }
}