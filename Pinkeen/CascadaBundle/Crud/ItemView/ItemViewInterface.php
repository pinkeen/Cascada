<?php

namespace Pinkeen\CascadaBundle\Crud\ItemView;

use Pinkeen\CascadaBundle\Crud\Field\Container\FieldContainerInterface;

/**
 * Interface for classes which responsibility is to render a single item.
 */
interface ItemViewInterface extends FieldContainerInterface
{
    /**
     * Renders an item.
     *
     * Must always return 'safe' html, meaning it has to take care of escaping unsafe values itself.
     *
     * @param array|object $item
     * @return string
     */
    public function render($item);
}