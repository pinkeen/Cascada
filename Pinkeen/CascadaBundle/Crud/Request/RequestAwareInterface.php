<?php

namespace Pinkeen\CascadaBundle\Crud\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Classes implementing this interface should be injected with request stack.
 */
interface RequestAwareInterface 
{
    /**
     * Injects request stack.
     *
     * @param RequestStack $requestStack
     */
    public function setRequestStack(RequestStack $requestStack);
}