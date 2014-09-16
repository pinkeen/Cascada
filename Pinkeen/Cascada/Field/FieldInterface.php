<?php

namespace Pinkeen\Cascada\Field;

/**
 * A field view purpose is to render a html representation of an entity's field and store other metadata that is needed
 * for this purpose.
 */
interface FieldInterface
{
    /**
     * Returns the name of the field.
     *
     * @return string
     */
    public function getFieldName();

    /**
     * Returns the label of the field.
     *
     * @return string
     */
    public function getLabel();

    /**
     * Returns html representation of entity's field.
     *
     * @param object|array $entity
     * @return string
     */
    public function render($entity);
}