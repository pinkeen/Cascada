<?php

namespace Pinkeen\CascadaBundle\Crud\View;

use Pinkeen\CascadaBundle\Crud\Field\FieldInterface;

/**
 * Interface for classes which responsibility is to render a single item.
 */
interface ViewInterface
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

    /**
     * Adds a field to view definition.
     *
     * @param FieldInterface $field
     */
    public function addField(FieldInterface $field);
}