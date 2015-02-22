<?php

namespace Cascada\CoreBundle\Admin\Filter;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Templating\EngineInterface;

/**
 * Manages filters.
 */
class FilterManager 
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var FilterInterface[]
     */
    protected $filterChain = [];

    /**
     * @var FilterInterface[]
     */
    protected $filters = [];

    /**
     * @param RequestStack $requestStack
     * @param EngineInterface $templating
     */
    public function __construct(RequestStack $requestStack, EngineInterface $templating)
    {
        $this->requestStack = $requestStack;
        $this->templating = $templating;
    }

    /**
     * Adds filter to the last position in the chain.
     *
     * @param FilterInterface $filter
     */
    public function registerFilter(FilterInterface $filter)
    {
        $filter->setTemplating($this->templating);
        $filter->setRequestStack($this->requestStack);

        $this->filterChain[] = $filter;
        $this->filters[$filter->getName()] = $filter;
    }

    /**
     * Applies the filter chain to the query.
     *
     * @param $queryBuilder
     */
    public function applyFilters($queryBuilder)
    {
        foreach ($this->filterChain as $filter) {
            $filter->apply($queryBuilder);
        }
    }

    /**
     * Returns filter by name.
     *
     * @param $name
     * @return FilterInterface
     */
    public function get($name)
    {
        if (!array_key_exists($name, $this->filters)) {
            throw new \RuntimeException("Request a non-existent filter '$name'.");
        }

        return $this->filters[$name];
    }
}