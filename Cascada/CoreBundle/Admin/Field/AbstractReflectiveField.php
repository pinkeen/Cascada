<?php

namespace Cascada\CoreBundle\Admin\Field;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Can retrieve the field's data using reflection
 * or with user-supplied callback.
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
     * Retrieves the value of item's field based on property_path option.
     *
     * @param array|object $item
     * @return mixed
     */
    protected function getFieldValue($item)
    {
        if ($this->hasOption('callback')) {
            return call_user_func($this->getOption('callback'), $item);
        }

        return self::$propertyAccessor->getValue($item, $this->getOption('property_path'));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionsResolver)
    {
        parent::configureDefaults($optionsResolver);

        $optionsResolver->setDefaults([
            'property_path' => $this->getFieldName(),
        ]);

        $optionsResolver->setOptional([
            'callback'
        ]);

        $optionsResolver->setAllowedTypes([
            'callback' => 'callable',
        ]);
    }
}