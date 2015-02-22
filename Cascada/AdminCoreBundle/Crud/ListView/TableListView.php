<?php

namespace Cascada\AdminCoreBundle\Crud\ListView;

use Cascada\AdminCoreBundle\Crud\Field\AbstractField;
use Cascada\AdminCoreBundle\Crud\Field\FieldInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Displays items in a table.
 */
class TableListView extends AbstractListView
{
    /**
     * {@inheritdoc}
     */
    public function addField(FieldInterface $field)
    {
        $field->addHint(AbstractField::HINT_ONE_LINE_HEIGHT);
        $field->addHint(AbstractField::HINT_LIMITED_HORIZONTAL_SPACE);
        $field->addHint(AbstractField::HINT_LIMITED_VERTICAL_SPACE);

        parent::addField($field);

        return $this;
    }

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