<?php

namespace Cascada\CoreBundle\Admin\Filter;

use Cascada\CoreBundle\Admin\Exception\MethodNotImplemented;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\Query\Expr;

class StringFilter extends AbstractFilter
{
    /**
     * @param $queryBuilder
     */
    protected function handleApply($queryBuilder)
    {
        throw new MethodNotImplemented($this, 'handleApply', 'Extend this filter and implement this method or provide a callback.');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionsResolver)
    {
        parent::configureDefaults($optionsResolver);

        $optionsResolver->setDefaults([
            'template' => 'CascadaCoreBundle:Filter:string.html.twig',
        ]);
    }
}