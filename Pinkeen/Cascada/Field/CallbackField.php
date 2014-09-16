<?php

namespace Pinkeen\Cascada\Field;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Field which is rendered using supplied callback.
 */
class CallbackField extends AbstractField
{
    /**
     * {@inheritdoc}
     */
    public function render($entity)
    {
        return call_user_func($this->getOption('callback'), $entity);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionsResolver)
    {
        parent::configureDefaults($optionsResolver);

        $optionsResolver->setRequired([
            'callback' /* Should take exactly one argument which is the entity and shall return string. */
        ]);

        $optionsResolver->setAllowedTypes([
            'callback' => 'callable',
        ]);
    }
}