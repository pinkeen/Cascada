<?php

namespace Pinkeen\CascadaBundle\Crud\View;

use Pinkeen\CascadaBundle\Crud\ConfigurableTrait;
use Pinkeen\CascadaBundle\Crud\Field\AbstractField;
use Pinkeen\CascadaBundle\Crud\Field\Container\FieldContainerTrait;
use Pinkeen\CascadaBundle\Crud\Field\FieldInterface;
use Pinkeen\CascadaBundle\Crud\ListView\AbstractListView;
use Pinkeen\CascadaBundle\Crud\ListView\ListViewInterface;
use Pinkeen\CascadaBundle\Crud\Templating\TemplatingAwareInterface;
use Pinkeen\CascadaBundle\Crud\Templating\TemplatingAwareTrait;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Base class for templated item list views.
 */
abstract class TemplatedListView extends AbstractListView implements TemplatingAwareInterface
{
    use TemplatingAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function addField(FieldInterface $field)
    {
        parent::addField($field);

        if ($field instanceof TemplatingAwareInterface) {
            $field->setTemplating($this->getTemplating());
        }
    }

    /**
     * {@inheritDoc}
     */
    public function render(array $items)
    {
        return $this->renderTemplate(
            $this->getOption('template'),
            $this->getRenderingParameters($items)
        );
    }

    /**
     * Returns parameters that are to be passed to tempalte.
     *
     * @param array $items
     * @return array
     */
    protected function getRenderingParameters($items)
    {
        return [
            'fields' => $this->getFields(),
            'items' => $items,
        ];
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
}