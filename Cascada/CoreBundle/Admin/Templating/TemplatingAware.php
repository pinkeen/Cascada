<?php

namespace Cascada\CoreBundle\Admin\Templating;

/**
 * Base for classes that need templating injected.
 *
 * If cannot extend this class then implement TemplatingAwareInterface and use TemplatingAwareTrait instead.
 */
class TemplatingAware implements TemplatingAwareInterface
{
    use TemplatingAwareTrait;
} 