<?php

namespace Cascada\CoreBundle\Admin\Filter;

use Cascada\CoreBundle\Admin\Request\RequestAwareTrait;
use Cascada\CoreBundle\Admin\Templating\TemplatingAwareTrait;
use Cascada\CoreBundle\Admin\ConfigurableTrait;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Base for filter classes.
 */
abstract class AbstractFilter implements FilterInterface
{
    use TemplatingAwareTrait;
    use ConfigurableTrait;
    use RequestAwareTrait;

    /**
     * Name of the filter that doubles as an id and
     * a name of the query parameter.
     *
     * @var string
     */
    private $name;

    /**
     * @param string $name
     * @param array $options
     */
    public function __construct($name, array $options = [])
    {
        $this->name = $name;

        $this->resolveConfiguration($options);
    }

    /**
     * {@inheritdoc}
     */
    public function apply($queryBuilder)
    {
        /* Shit, another diamond problem. What about ORM, DBAL, callback handling here?
         * Using something like an injectable or configurabel strategy??? */

        if (null === $this->getOption('callback')) {
            return false;
        }

        return call_user_func($this->getOption('callback'), $queryBuilder, $this->getValue());
    }

    /**
     * Returns the value of the filter parameter.
     *
     * @return string
     */
    protected function getValue()
    {
        $value = $this->getCurrentRequest()->query->get($this->name);

        if (null === $value) {
            return $this->getOption('default_value');
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns parameters that are to be passed to tempalte.
     *
     * @return array
     */
    protected function getRenderingParameters()
    {
        return array_merge([
            'name' => $this->getName(),
            'value' => $this->getValue(),
            'options' => $this->getOptions()
        ], $this->getOption('parameters'));
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return $this->renderTemplate(
            $this->getOption('template'),
            $this->getRenderingParameters()
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionResolver)
    {
        $optionResolver->setDefaults([
            'callback' => null,
            'parameters' => [], /* Additional parameters to be passed to template. */
            'default_value' => null,
        ]);

        $optionResolver->setRequired([
            'template',
        ]);

        $optionResolver->setAllowedTypes([
            'callback' => 'callable',
            'template' => 'string',
            'parameters' => 'array',
        ]);
    }
}