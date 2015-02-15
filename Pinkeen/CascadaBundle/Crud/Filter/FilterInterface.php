<?php

namespace Pinkeen\CascadaBundle\Crud\Filter;

use Pinkeen\CascadaBundle\Crud\Request\RequestAwareInterface;
use Pinkeen\CascadaBundle\Crud\Templating\TemplatingAwareInterface;

/**
 * Interface for filter objects.
 *
 * A filter is responsible for rendering an UI control for filtering an item list and performing the actual filtering.
 */
interface FilterInterface extends RequestAwareInterface, TemplatingAwareInterface
{
    /**
     * Applies the filter to the query.
     *
     * @param mixed $queryBuilder
     */
    public function apply($queryBuilder);

    /**
     * Renders the filter widget.
     *
     * @return string
     */
    public function render();

    /**
     * Returns the name of the filter.
     *
     * The name is used as an id and as a name of the query parameter.
     *
     * @return string
     */
    public function getName();
}