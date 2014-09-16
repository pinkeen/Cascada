<?php

namespace Pinkeen\Cascada\Controller;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Storage layer agnostic controller that provides basic CRUD functionality.
 *
 * Among others provides the actions: create, edit, list, delete, show.
 */
abstract class AbstractCrudController extends AbstractConfigurableController
{
    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionsResolver)
    {
        $optionResolver->setDefaults([

        ]);
    }
}