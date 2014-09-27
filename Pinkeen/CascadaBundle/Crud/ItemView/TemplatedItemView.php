<?php

namespace Pinkeen\CascadaBundle\Crud\ItemView;
use Pinkeen\CascadaBundle\Crud\Field\FieldInterface;
use Pinkeen\CascadaBundle\Crud\Templating\TemplatingAwareInterface;
use Pinkeen\CascadaBundle\Crud\Templating\TemplatingAwareTrait;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Basic item view.
 */
class TemplatedItemView extends AbstractItemView implements TemplatingAwareInterface
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