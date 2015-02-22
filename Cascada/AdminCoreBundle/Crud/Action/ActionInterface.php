<?php

namespace Cascada\AdminCoreBundle\Crud\ Action;

/**
 * Interface for actions.
 *
 * Actions are actions in the UI sense meaning they represent a widget/control in UI that allows user to perform
 * an action on an item.
 */
interface ActionInterface
{
    /**
     * Returns html representation of an item's action.
     *
     * @param object|array $item
     * @return string
     */
    public function render($item);
}