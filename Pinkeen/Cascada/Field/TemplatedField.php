<?php

namespace Pinkeen\Cascada\Field;

use Pinkeen\Cascada\Templating\TemplatingAwareInterface;
use Pinkeen\Cascada\Templating\TemplatingAwareTrait;
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
    public function render($entity)
    {
        return $this->renderTemplate(
            $this->getOption('template'),
            $this->getRenderingParameters($entity)
        );
    }

    /**
     * Returns parameters that are to be passed to tempalte.
     *
     * @param array|object $entity
     * @return array
     */
    protected function getRenderingParameters($entity)
    {
        return [
            'value' => $this->getFieldValue($entity),
            'entity' => $entity,
            'label' => $this->getLabel(),
            'hints' => $this->getHints(),
        ];
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