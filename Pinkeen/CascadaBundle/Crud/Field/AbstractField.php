<?php

namespace Pinkeen\CascadaBundle\Crud\Field;

use Pinkeen\CascadaBundle\Crud\ConfigurableTrait;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Base class for field views.
 */
abstract class AbstractField implements FieldInterface
{
    use ConfigurableTrait;

    /**
     * @var string
     */
    private $fieldName;

    /**
     * @var array
     */
    private $hints = [];

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
     * {@inheritdoc}
     */
    public function isSafe()
    {
        return $this->getOption('is_safe');
    }

    /**
     * {@inheritdoc}
     */
    public function setHints(array $hints)
    {
        $this->hints = $hints;
    }

    /**
     * Returns array of hints.
     *
     * @return array
     */
    protected function getHints()
    {
        return $this->hints;
    }

    /**
     * Checks whether the field has certain hint.
     *
     * @param string $hint
     * @return bool
     */
    protected function hasHint($hint)
    {
        return in_array($hint, $this->hints);
    }

    /**
     * {@inheritdoc}
     */
    public function addHint($hint)
    {
        if ($this->hasHint($hint)) {
            return;
        }

        $this->hints[] = $hint;
    }

    /**
     * Configures the options resolver setting default options, etc.
     *
     * @param OptionsResolverInterface $optionResolver
     */
    protected function configureDefaults(OptionsResolverInterface $optionResolver)
    {
        $optionResolver->setDefaults([
            'label' => ucfirst($this->fieldName),
            'is_safe' => false, /* Whether the rendered string is safe and doesn't need escaping or not. */
        ]);
    }
}