<?php

namespace Pinkeen\CascadaBundle\Crud\View;

use Pinkeen\CascadaBundle\Crud\ConfigurableTrait;
use Pinkeen\CascadaBundle\Crud\Field\AbstractField;
use Pinkeen\CascadaBundle\Crud\Field\FieldInterface;
use Pinkeen\CascadaBundle\Crud\Templating\TemplatingAwareInterface;
use Pinkeen\CascadaBundle\Crud\Templating\TemplatingAwareTrait;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Base class for item views.
 */
abstract class View implements ViewInterface, TemplatingAwareInterface
{
    use TemplatingAwareTrait;
    use ConfigurableTrait;

    /**
     * Array of fields indexed by their names.
     *
     * @var AbstractField[]
     */
    private $fields = [];

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->resolveConfiguration($options);
    }

    /**
     * Returns array of fields indexed by their names.
     *
     * @return FieldInterface[]
     */
    protected function getFields()
    {
        return $this->fields;
    }

    /**
     * {@inheritdoc}
     */
    public function addField(FieldInterface $field)
    {
        if (array_key_exists($field->getFieldName(), $this->fields)) {
            throw new \LogicException("Duplicate field '{$field->getFieldName()}'.");
        }

        if ($field instanceof TemplatingAwareInterface) {
            $field->setTemplating($this->getTemplating());
        }

        $this->field[$field->getFieldName()] = $field;
    }

    /**
     * Returns a field by its name.
     *
     * @param string $fieldName
     * @return FieldInterface
     * @throws \LogicException
     */
    protected function getField($fieldName)
    {
        if (!array_key_exists($fieldName, $this->fields)) {
            throw new \LogicException("Requested non-existent field '{$fieldName}'.");
        }

        return $this->fields[$fieldName];
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionsResolver)
    {
        $optionsResolver->setRequired([
            'template'
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function render($item)
    {
        return $this->renderTemplate(
            $this->getOption('template'),
            $this->getRenderingParameters($item)
        );
    }

    /**
     * Returns parameters that are to be passed to tempalte.
     *
     * @param array|object $item
     * @return array
     */
    protected function getRenderingParameters($item)
    {
        return [
            'fields' => $this->getFields(),
            'item' => $item,
        ];
    }
}