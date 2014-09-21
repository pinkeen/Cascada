<?php

namespace Pinkeen\CascadaBundle\Crud\Field;

use Pinkeen\CascadaBundle\Crud\Templating\TemplatingAwareInterface;
use Pinkeen\CascadaBundle\Crud\Templating\TemplatingAwareTrait;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * A field that is rendered using a template.
 */
class TemplatedField extends AbstractReflectiveField implements TemplatingAwareInterface
{
    use TemplatingAwareTrait;

    /**
     * {@inheritDoc}
     */
    public function render($item)
    {
        return $this->renderTemplate(
            $this->getOption('template'),
            $this->getRenderingParameters($item)
        );
    }

    /**
     * Returns parameters that are to be passed to tempalte.
     *
     * @param array|object $item
     * @return array
     */
    protected function getRenderingParameters($item)
    {
        return array_merge([
            'value' => $this->getFieldValue($item),
            'item' => $item,
            'label' => $this->getLabel(),
            'hints' => $this->getHints(),
        ], $this->getOption('parameters'));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionsResolver)
    {
        parent::configureDefaults($optionsResolver);

        $optionsResolver->setDefaults([
            'parameters' => [], /* Additional parameters to be passed to template. */
        ]);

        $optionsResolver->replaceDefaults([
            'is_safe' => true /* The templating engine should now handle the escaping, we want to output html. */
        ]);

        $optionsResolver->setRequired([
            'template'
        ]);
    }
}