<?php

namespace Cascada\CoreBundle\Admin\ListView;

use Cascada\CoreBundle\Admin\ConfigurableTrait;
use Cascada\CoreBundle\Admin\Field\Container\FieldContainer;
use Cascada\CoreBundle\Admin\Field\FieldInterface;
use Cascada\CoreBundle\Admin\Templating\TemplatingAwareTrait;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * An abstract list view.
 */
abstract class AbstractListView extends FieldContainer implements ListViewInterface
{
    use ConfigurableTrait;
    use TemplatingAwareTrait;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->resolveConfiguration($options);
    }

    /**
     * {@inheritdoc}
     */
    public function addField(FieldInterface $field)
    {
        $this->injectTemplatingInto($field);

        parent::addField($field);
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