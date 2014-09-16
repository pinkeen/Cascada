<?php

namespace Pinkeen\Cascada\Field;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Can retrieve the field's data using reflection.
 */
abstract class AbstractReflectiveField extends AbstractField
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