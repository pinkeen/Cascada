<?php

namespace Pinkeen\CascadaBundle\Crud\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use LogicException;

/**
 * Base implementation and convenience methods for RequestAwareInterface.
 */
trait RequestAwareTrait
{
    /**
     * @var RequestStack
     */
    private $requestStack = null;

    /**
     * @param RequestStack $requestStack
     */
    public function setRequestStack(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @return Request|null
     */
    protected function getCurrentRequest()
    {
        if (null === $this->requestStack) {
            throw new LogicException('Current request needed but request stack not injected.');
        }

        return $this->requestStack->getCurrentRequest();
    }
}