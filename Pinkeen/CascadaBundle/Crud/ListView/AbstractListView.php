<?php

namespace Pinkeen\CascadaBundle\Crud\ListView;
use Pinkeen\CascadaBundle\Crud\ConfigurableTrait;
use Pinkeen\CascadaBundle\Crud\Field\Container\FieldContainerTrait;

/**
 * An abstract list view.
 */
abstract class AbstractListView implements ListViewInterface
{
    use FieldContainerTrait;
    use ConfigurableTrait;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->resolveConfiguration($options);
    }
} 