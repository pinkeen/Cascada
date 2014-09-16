<?php

namespace Pinkeen\Cascada\Field;

use Pinkeen\Cascada\Configurable;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Base class for field views.
 */
abstract class AbstractField implements FieldInterface
{
    use Configurable;

    /**
     * @var string
     */
    private $fieldName;

    /**
     * @param string $fieldName
     * @param array $options
     */
    public function __construct($fieldName, array $options = [])
    {
        $this->fieldName = $fieldName;

        $this->resolveConfiguration($options);
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return $this->getOption('label');
    }

    /**
     * Configures the options resolver setting default options, etc.
     *
     * @param OptionsResolverInterface $optionResolver
     */
    protected function configureDefaults(OptionsResolverInterface $optionResolver)
    {
        $optionResolver->setDefaults([
            'label' => ucfirst($this->fieldName)
        ]);
    }
}