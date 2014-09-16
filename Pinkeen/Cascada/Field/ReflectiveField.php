<?php

namespace Pinkeen\Cascada\Field;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Retrieves the field's data using reflection and renders it as a string.
 */
class ReflectiveField extends AbstractField
{
    /**
     * @var PropertyAccessor
     */
    private static $propertyAccessor = null;

    /**
     * {@inheritdoc}
     */
    public function __construct($fieldName, array $options = [])
    {
        parent::__construct($fieldName, $options);

        if (null === self::$propertyAccessor) {
            self::$propertyAccessor = PropertyAccess::createPropertyAccessor();
        }
    }

    /**
     * Returns html representation of entity's field.
     *
     * @param object|array $entity
     * @return string
     * @throws \DomainException
     */
    public function render($entity)
    {
        $value = $this->getFieldValue($entity);

        if (null !== $this->getOption('empty_value') && empty($value)) {
            return $this->getOption('empty_value');
        }

        if (!$this->isCoercibleToString($value)) {
            throw new \DomainException("Value of field '{$this->getName()}' cannot be converted to string.");
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

    /**
     * Retrieves the value of entity's field based on property_path option.
     *
     * @param array|object $entity
     * @return mixed
     */
    protected function getFieldValue($entity)
    {
        return self::$propertyAccessor->getValue($entity, $this->getOption('property_path'));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionsResolver)
    {
        parent::configureDefaults($optionsResolver);

        $optionsResolver->setDefaults([
            'property_path' => $this->getFieldName(),
            'empty_value' => null,
        ]);
    }
}