<?php

namespace Pinkeen\CascadaBundle\Crud\ItemView;

use Pinkeen\CascadaBundle\Crud\Field\AbstractField;
use Pinkeen\CascadaBundle\Crud\Field\FieldInterface;
use Pinkeen\CascadaBundle\Crud\ItemView\ItemViewInterface;
use Pinkeen\CascadaBundle\Crud\ItemView\TemplatedItemView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Renders the item as a table row.
 */
class TableRowView extends TemplatedItemView
{
    /**
     * {@inheritdoc}
     */
    public function addField(FieldInterface $field)
    {
        parent::addField($field);

        $field->addHint(AbstractField::HINT_LIMITED_HORIZONTAL_SPACE);
        $field->addHint(AbstractField::HINT_LIMITED_VERTICAL_SPACE);
        $field->addHint(AbstractField::HINT_ONE_LINE_HEIGHT);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionsResolver)
    {
        $optionsResolver->setDefaults([
            'template' => 'PinkeenCascadaBundle:ItemView:tableRow.html.twig',
        ]);
    }
} 