<?php

namespace Pinkeen\Cascada\Field;

/**
 * Converts scalar values to string and displays them directly.
 */
class ScalarField extends AbstractReflectiveField
{
    /**
     * {@inheritdoc}
     *
     * Throws exception if the field cannot be coerced to string.
     *
     * @throws \UnexpectedValueException
     */
    public function render($entity)
    {
        $value = $this->getFieldValue($entity);

        if (null !== $this->getOption('empty_value') && empty($value)) {
            return $this->getOption('empty_value');
        }

        if (!$this->isCoercibleToString($value)) {
            throw new \UnexpectedValueException("Value of field '{$this->getName()}' cannot be converted to string.");
        }

        return strval($value);
    }

    /**
     * Checks whether value can be converted to string.
     *
     * @param mixed $value
     * @return bool
     */
    private function isCoercibleToString($value)
    {
        if (is_scalar($value)) {
            return true;
        }

        if (is_object($value) && method_exists($value, '__toString')) {
            return true;
        }

        return false;
    }
} 