<?php

namespace Pinkeen\CascadaBundle\Crud\Field;

use Pinkeen\CascadaBundle\Crud\Field\Exception\UnexpectedFieldValueException;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Converts scalar values to string and displays them directly.
 *
 * Good for short strings, ints and floats if you don't need formatting.
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
    public function render($item)
    {
        $value = $this->getFieldValue($item);

        if (null !== $this->getOption('empty_value') && empty($value)) {
            return $this->getOption('empty_value');
        }

        if (!$this->isCoercibleToString($value)) {
            throw new UnexpectedFieldValueException($this->getFieldName(), 'coercible to string', $value);
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
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionsResolver)
    {
        parent::configureDefaults($optionsResolver);

        $optionsResolver->setDefaults([
            'empty_value' => null,
        ]);
    }
}