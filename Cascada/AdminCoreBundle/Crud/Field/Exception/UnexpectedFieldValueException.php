<?php

namespace Cascada\AdminCoreBundle\Crud\Field\Exception;

class UnexpectedFieldValueException extends \Exception
{
    /**
     * @var string
     */
    protected $fieldName;

    /**
     * @param string $fieldName
     * @param string $expectedType
     * @param mixed $value
     * @param \Exception $previous
     */
    public function __construct($fieldName, $expectedType, $value, \Exception $previous = null)
    {
        $this->fieldName = $fieldName;

        $message = sprintf("Expected the value of field '%s' to be of type '%s' but got '%s' instead.",
            $fieldName,
            $expectedType,
            is_object($value) ? get_class($value) : gettype($value)
        );

        parent::__construct($message, 0, $previous);
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }
}