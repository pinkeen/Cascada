<?php

namespace Pinkeen\CascadaBundle\Crud\ListView;

use Pinkeen\CascadaBundle\Crud\Field\Container\FieldContainerInterface;
use Pinkeen\CascadaBundle\Crud\Field\FieldInterface;
use Pinkeen\CascadaBundle\Crud\Templating\TemplatingAwareInterface;

/**
 * View for displaying a list of items.
 */
interface ListViewInterface extends FieldContainerInterface, TemplatingAwareInterface
{
    /**
     * Renders the item list
     *
     * @param array $items
     * @return string
     */
    public function render(array $items);
}