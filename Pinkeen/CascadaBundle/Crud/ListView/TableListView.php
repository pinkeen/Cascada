<?php

namespace Pinkeen\CascadaBundle\Crud\ListView;

use Pinkeen\CascadaBundle\Crud\Field\FieldInterface;
use Pinkeen\CascadaBundle\Crud\ItemView\ItemViewInterface;
use Pinkeen\CascadaBundle\Crud\ItemView\TableRowView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Displays items in a table.
 */
class TableListView extends TemplatedListView
{
    /**
     * @var ItemViewInterface
     */
    private $rowView;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);

        $this->rowView = $this->createRowView();
    }

    /**
     * {@inheritdoc}
     */
    public function addField(FieldInterface $field)
    {
        parent::addField($field);

        $this->rowView->addField($field);
    }

    /**
     * Creates a new instance of view for rendering a row.
     *
     * Override this method if you want to use a custom row view.
     *
     * @return ItemViewInterface
     */
    protected function createRowView()
    {
        return new TableRowView();
    }

    /**
     * Returns item view for rendering a row.
     *
     * @return ItemViewInterface
     */
    protected function getRowView()
    {
        $this->injectTemplatingInto($this->rowView);

        return $this->rowView;
    }

    /**
     * {@inheritdoc}
     */
    protected function getRenderingParameters($items)
    {
        return array_merge(parent::getRenderingParameters($items), [
            'row_view' => $this->getRowView()
        ]);
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