<?php

namespace Pinkeen\CascadaBundle\Crud\Field;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Field which is rendered using supplied callback.
 */
class CallbackField extends AbstractField
{
    /**
     * {@inheritdoc}
     */
    public function render($item)
    {
        return call_user_func($this->getOption('callback'), $item);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionsResolver)
    {
        parent::configureDefaults($optionsResolver);

        $optionsResolver->setRequired([
            'callback' /* Should take exactly one argument which is the item and shall return string. */
        ]);

        $optionsResolver->setAllowedTypes([
            'callback' => 'callable',
        ]);
    }
}