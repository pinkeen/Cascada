<?php

namespace Pinkeen\Cascada\Field;

use Pinkeen\Cascada\Field\Exception\UnexpectedFieldValueException;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Simple field for rendering \DateTime instance that relies on it's ::format() function.
 *
 * This can't do localization.
 *
 * TODO: Write LocalizedDateTimeField which uses IntlDateFormatter and/or strftime (no dates before 1970, ugh).
 */
class DateTimeField extends AbstractReflectiveField
{
    /**
     * {@inheritdoc}
     */
    public function render($item)
    {
        $date = $this->getFieldValue($item);

        if (null === $date) {
            return $this->getOption('empty_value');
        }

        if (!$date instanceof \DateTime) {
            throw new UnexpectedFieldValueException($this->getFieldName(), '\DateTime', $date);
        }

        return $date->format($this->getOption('format'));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionsResolver)
    {
        parent::configureDefaults($optionsResolver);

        $optionsResolver->setDefaults([
            'format' => 'd.m.Y H:i:s', /* As accepted by date(). There is no sane, universal and readable format. */
            'empty_value' => '',
        ]);
    }
}