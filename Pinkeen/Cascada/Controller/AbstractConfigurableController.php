<?php

namespace Pinkeen\Cascada\Controller;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Controller which can be configured.
 *
 * The convention is that all of the options are scalars (strings, ints, ...).
 * Configuration using class instances should be done using dedicated methods - ex. ::add*().
 */
abstract class AbstractConfigurableController
{
    /**
     * Array of resolved options.
     *
     * Private so nobody directly messes with this stuff.
     *
     * @var array
     */
    private $options;

    /**
     * Sets up the options array.
     */
    public function __construct()
    {
        $optionResolver = new OptionsResolver();
        $this->configureDefaults($optionResolver);
        $optionResolver->resolve($this->getConfiguration());
    }

    /**
     * Returns array of resolved options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return $this->options;
    }

    /**
     * Returns an option by name.
     *
     * @param $name
     * @throws \LogicException
     * @return string
     */
    protected function getOption($name)
    {
        if (!array_key_exists($name, $this->options)) {
            throw new \LogicException("Requested an option '{$name}' which does not exist.");
        }

        return $this->options[$name];
    }

    /**
     * Returns array of options to be set.
     *
     * This is the method the end-user controller should implement in order to configure the controller.
     *
     * @return array
     */
    abstract protected function getConfiguration();

    /**
     * Configures the options resolver setting default options, etc.
     *
     * @param OptionsResolverInterface $optionResolver
     */
    abstract protected function configureDefaults(OptionsResolverInterface $optionResolver);
} 