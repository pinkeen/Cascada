<?php

namespace Cascada\CoreBundle\Admin\Paginator;

use Cascada\CoreBundle\Paginator\Results\PaginatedResultsInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Templating\EngineInterface;

interface PaginatorInterface
{
    /**
     * @param QueryBuilder $queryBuilder
     * @return PaginatedResultsInterface
     */
    public function paginate(QueryBuilder $queryBuilder);

    /**
     * @param string $field
     * @param string $label
     * @return string
     */
    public function renderSortControls($field, $label);

    /**
     * @param RequestStack $requestStack
     */
    public function setRequestStack(RequestStack $requestStack);

    /**
     * @param EngineInterface $templating
     */
    public function setTemplating(EngineInterface $templating);
}