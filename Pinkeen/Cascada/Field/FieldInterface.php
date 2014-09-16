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
     * Returns true if the string returned by render is safe and needn't be escaped.
     *
     * @return bool
     */
    public function isSafe();

    /**
     * Returns html representation of entity's field.
     *
     * @param object|array $entity
     * @return string
     */
    public function render($entity);

    /**
     * Sets hints.
     *
     * Hints can be specials values indicating certain aspects of the environment in which the field is rendered.
     *
     * They may ignored or used by the field for adaptation.
     *
     * @param array $hints
     */
    public function setHints(array $hints);
}