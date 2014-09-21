<?php

namespace Pinkeen\CascadaBundle\Crud\Controller;

use Pinkeen\CascadaBundle\Crud\ConfigurableTrait;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Controller which can be configured.
 *
 * The convention is that all of the options are scalars (strings, ints, ...).
 * Configuration using class instances should be done using dedicated methods - ex. ::add*().
 */
abstract class AbstractConfigurableController extends BaseController
{
    use ConfigurableTrait;

    public function __construct()
    {
        $this->resolveConfiguration($this->getConfiguration());
    }

    /**
     * Returns array of options to be set.
     *
     * This is the method the end-user controller should implement in order to configure the controller.
     *
     * @return array
     */
    abstract protected function getConfiguration();
}