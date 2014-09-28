<?php

namespace Pinkeen\CascadaBundle\Crud\ItemView;

use Pinkeen\CascadaBundle\Crud\ConfigurableTrait;
use Pinkeen\CascadaBundle\Crud\Field\Container\FieldContainerTrait;

/**
 * Abstract item view.
 */
abstract class AbstractItemView implements ItemViewInterface
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