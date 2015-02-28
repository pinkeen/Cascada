<?php

namespace Cascada\CoreBundle\Paginator;

use Cascada\CoreBundle\Admin\Paginator\AbstractPaginator;
use Cascada\CoreBundle\Paginator\Results\PaginatedResultsInterface;
use Cascada\CoreBundle\Paginator\Results\SlidingPaginationResults;
use Cascada\CoreBundle\Utilities\ArrayUtilities;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SimplePaginator extends AbstractPaginator
{
    /**
     * @param QueryBuilder $queryBuilder
     * @return PaginatedResultsInterface
     */
    public function handlePagination(QueryBuilder $queryBuilder)
    {
        $page = $this->getPage() - 1;
        $limit = $this->getOption('limit');
        $start = $limit * $page;

        $queryBuilder->setFirstResult($start);
        $queryBuilder->setMaxResults($limit);

        $paginator = new Paginator($queryBuilder, $this->getOption('fetch_join_collection'));

        $results = iterator_to_array($paginator);
        $count = $paginator->count();

        return new SlidingPaginationResults(
            $this->getPage(),
            $limit,
            $count,
            $results,
            $this->getTemplating(),
            ArrayUtilities::pick(['controls_template'], $this->getOptions())
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionsResolver)
    {
        parent::configureOptions($optionsResolver);

        $optionsResolver->setDefaults([
            'fetch_join_collection' => false,
        ]);

        $optionsResolver->setOptional([
            'controls_template',
        ]);

        $optionsResolver->setAllowedTypes([
            'controls_template' => 'string',
            'sort_controls_template' => 'string',
            'fetch_join_collection' => 'bool',
        ]);
    }
}