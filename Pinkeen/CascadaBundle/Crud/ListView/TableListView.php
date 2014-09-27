<?php

namespace Pinkeen\CascadaBundle\Crud\ListView;
use Pinkeen\CascadaBundle\Crud\View\TemplatedListView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Displays items in a table.
 */
class TableListView extends TemplatedListView
{
    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionsResolver)
    {
        $optionsResolver->setDefaults([
            'template' => 'PinkeenCascadaBundle:ListView:table.html.twig'
        ]);
    }
} 