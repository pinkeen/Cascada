<?php

namespace Cascada\CoreBundle\Admin\Filter;

use Cascada\CoreBundle\Admin\Exception\MethodNotImplemented;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Filters the data based on predefined set of choices.
 */
class ChoiceFilter extends AbstractFilter
{
    /**
     * @param $queryBuilder
     */
    protected function handleApply($queryBuilder)
    {
        throw new MethodNotImplemented($this, 'handleApply', 'Extend this filter and implement this method or provide a callback.');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionResolver)
    {
        $optionResolver->setDefaults([
            'template' => 'CascadaCoreBundle:Filter:choiceTabbed.html.twig',
            'empty_label' => function (Options $options) {
                return $options['default_value'];
            },
            'empty_value' => null,
        ]);

        $optionResolver->setRequired([
            'choices',
        ]);

        $optionResolver->setAllowedTypes([
            'choices' => 'array',
        ]);

        parent::configureDefaults($optionResolver);
    }
}