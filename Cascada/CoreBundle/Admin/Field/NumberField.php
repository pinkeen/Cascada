<?php

namespace Cascada\CoreBundle\Admin\Field;

use Cascada\CoreBundle\Admin\Field\Exception\UnexpectedFieldValueException;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * For displaying formatted numbers.
 */
class NumberField extends AbstractReflectiveField
{
    /**
     * {@inheritdoc}
     */
    public function render($item)
    {
        $value = $this->getFieldValue($item);

        if (null === $value) {
            return $this->getOption('empty_value');
        }

        if (!is_numeric($value)) {
            throw new UnexpectedFieldValueException($this->getFieldName(), '\DateTime', $value);
        }

        return number_format(
            $value,
            $this->getOption('decimals'),
            $this->getOption('decimal_point'),
            $this->getOption('thousands_separator')
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionsResolver)
    {
        parent::configureDefaults($optionsResolver);

        $optionsResolver->setDefaults([
            'empty_value' => '',
            'decimals' => 2,
            'decimal_point' => '.',
            'thousands_separator' => ' ',
        ]);
    }
} 