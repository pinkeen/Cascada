<?php

namespace Pinkeen\CascadaBundle\Crud\Templating;

use Symfony\Component\Templating\EngineInterface;

/**
 * Classes implementing this interface indicate that they use templating and it should be injected via setter.
 */
interface TemplatingAwareInterface
{
    /**
     * Injects templating into the class.
     *
     * @param EngineInterface $templating
     */
    public function setTemplating(EngineInterface $templating);
}