<?php

namespace Cascada\CoreBundle\Admin\Field\Container;
use Cascada\CoreBundle\Admin\Field\AbstractField;
use Cascada\CoreBundle\Admin\Field\FieldInterface;
use Cascada\CoreBundle\Admin\Templating\TemplatingAwareInterface;

/**
 * Common code for classes which need to store a field list.
 */
trait FieldContainerTrait
{
    /**
     * Array of fields indexed by their names.
     *
     * @var FieldInterface[]
     */
    private $fields = [];

    /**
     * Returns array of fields indexed by their names.
     *
     * @return FieldInterface[]
     */
    protected function getFields()
    {
        return $this->fields;
    }

    /**
     * {@inheritdoc}
     */
    public function addField(FieldInterface $field)
    {
        if (array_key_exists($field->getFieldName(), $this->fields)) {
            throw new \LogicException("Duplicate field '{$field->getFieldName()}'.");
        }

        $this->fields[$field->getFieldName()] = $field;

        return $this;
    }

    /**
     * Returns a field by its name.
     *
     * @param string $fieldName
     * @return FieldInterface
     * @throws \LogicException
     */
    protected function getField($fieldName)
    {
        if (!array_key_exists($fieldName, $this->fields)) {
            throw new \LogicException("Requested non-existent field '{$fieldName}'.");
        }

        return $this->fields[$fieldName];
    }
} 