<?php

namespace Cascada\CoreBundle\Admin\Field\Container;
use Cascada\CoreBundle\Admin\Field\FieldInterface;

/**
 * Interface for classes which need to store a field list.
 */
interface FieldContainerInterface
{
    /**
     * Adds a field to view definition.
     *
     * @param FieldInterface $field
     * @return FieldContainerInterface
     */
    public function addField(FieldInterface $field);
} 