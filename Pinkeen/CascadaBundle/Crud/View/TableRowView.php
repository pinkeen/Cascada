<?php

namespace Pinkeen\CascadaBundle\Crud\View;

use Pinkeen\CascadaBundle\Crud\Field\FieldInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Renders the item as a table row.
 */
class TableRowView extends View implements ListViewInterface
{
    /**
     * The field is being rendered in a table cell in a list.
     */
    const FIELD_HINT_TABLE_ROW = 'TABLE_ROW_CELL';

    /**
     * {@inheritdoc}
     */
    public function addField(FieldInterface $field)
    {
        parent::addField($field);

        $field->addHint(self::FIELD_HINT_TABLE_ROW);
    }

    /**
     * Renders list header.
     *
     * @return string
     */
    public function renderHeader()
    {
        return $this->renderTemplate($this->getOption('header_template'), [
            'fields' => $this->getFields()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionsResolver)
    {
        $optionsResolver->setDefault([
            'template' => 'PinkeenCascadaBundle:View:tableRow.html.twig',
            'header_template' => 'PinkeenCascadaBundle:View:tableHeader.html.twig',
        ]);
    }
} 