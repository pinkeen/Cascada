<?php

namespace Pinkeen\CascadaBundle\Crud\View;

/**
 * View for displaying and item in a list.
 */
interface ListViewInterface extends ViewInterface
{
    /**
     * Renders list header.
     *
     * @return string
     */
    public function renderHeader();
} 