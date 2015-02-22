<?php

namespace Cascada\AdminCoreBundle\Crud\Field;

use Cascada\AdminCoreBundle\Crud\ConfigurableTrait;
use Cascada\AdminCoreBundle\Utilities\StringUtilities;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Base class for field views.
 */
abstract class AbstractField implements FieldInterface
{
    use ConfigurableTrait;

    /**
     * This hint tells the field that there's a limited vertical space, like in a table list row so the field should
     * limit it's height if possible
     */
    const HINT_LIMITED_VERTICAL_SPACE = 'LIMITED_V_SPACE';

    /**
     * This hint tells the field that there's not much horizontal space, so the field should ex. limit it's length,
     * fit the width of the parent container, break long lines, etc.
     *
     * Also the field could hide itself on mobile using media queries if it's not crucial.
     */
    const HINT_LIMITED_HORIZONTAL_SPACE = 'LIMITED_H_SPACE';

    /**
     * The field's height should be that of one line of text. Ex. in case of the text field it should not break, but
     * rather limit it's length or use ellipsis. In case of images a mouse-over preview may be necessary, etc.
     */
    const HINT_ONE_LINE_HEIGHT = 'ONE_LINE';

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
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionResolver)
    {
        $optionResolver->setDefaults([
            'label' => StringUtilities::humanize($this->fieldName),
            'is_safe' => false, /* Whether the rendered string is safe and doesn't need escaping or not. */
        ]);
    }
}