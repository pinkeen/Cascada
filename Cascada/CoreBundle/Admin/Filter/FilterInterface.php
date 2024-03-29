<?php

namespace Cascada\CoreBundle\Admin\Filter;

use Cascada\CoreBundle\Admin\Request\RequestAwareInterface;
use Cascada\CoreBundle\Admin\Templating\TemplatingAwareInterface;

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

    /**
     * Label - used during rendering.
     *
     * May be used as a header, input placeholder etc.
     *
     * @return string
     */
    public function getLabel();
}