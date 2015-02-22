<?php

namespace Cascada\AdminCoreBundle\Crud\ListView;

use Cascada\AdminCoreBundle\Crud\Field\Container\FieldContainerInterface;
use Cascada\AdminCoreBundle\Crud\Field\FieldInterface;
use Cascada\AdminCoreBundle\Crud\Templating\TemplatingAwareInterface;

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