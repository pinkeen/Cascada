<?php

namespace Cascada\AdminCoreBundle\Crud\Filter;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Filters the data based on predefined set of choices.
 */
class ChoiceFilter extends AbstractFilter
{
    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionResolver)
    {
        $optionResolver->setDefaults([
            'default_label' => null,
            'template' => 'PinkeenCascadaBundle:Filter:choiceTabbed.html.twig',
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