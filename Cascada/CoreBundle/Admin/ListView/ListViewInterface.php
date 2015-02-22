<?php

namespace Cascada\CoreBundle\Admin\ListView;

use Cascada\CoreBundle\Admin\Field\Container\FieldContainerInterface;
use Cascada\CoreBundle\Admin\Field\FieldInterface;
use Cascada\CoreBundle\Admin\Templating\TemplatingAwareInterface;

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