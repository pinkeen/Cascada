<?php

namespace Cascada\CoreBundle\Paginator\Results;

use Cascada\CoreBundle\Admin\Paginator\AbstractPaginator;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Templating\EngineInterface;

class SlidingPaginationResults extends AbstractPaginatedResults
{
    /**
     * @var int
     */
    private $total;

    /**
     * @param int $page
     * @param int $limit
     * @param int $total
     * @param array $results
     * @param EngineInterface $templating
     * @param array $options
     */
    public function __construct(
        $page,
        $limit,
        $total,
        array $results,
        EngineInterface $templating,
        array $options
    ) {
        parent::__construct($page, $limit, $results, $templating, $options);

        $this->total = $total;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        return $this->total;
    }

    /**
     * {@inheritdoc}
     */
    protected function getRenderingParameters()
    {
        $total = $this->total;
        $limit = $this->getLimit();
        $pageCount = floor($total / $limit);
        $proximity = $this->getOption('proximity_pages');

        if ($total % $limit ) {
            ++$pageCount;
        }

        $current = $this->getPage();

        $context = [
            'current' => $current,
            'page_count' => $pageCount,
            'total_count' => $total,
            'limit' => $limit,
            'page_parameter' => AbstractPaginator::PAGE_PARAMETER,
        ];

        if ($current < $pageCount) {
            $context['next'] = $current + 1;
        }

        if ($current > 1) {
            $context['previous'] = $current - 1;
        }

        $startPage = $current - $proximity;
        $endPage = $current + $proximity;

        if ($startPage <= 1) {
            $startPage = 1;
        }

        if ($endPage >= $pageCount) {
            $endPage = $pageCount;
        }

        $context['start_page'] = $startPage;
        $context['end_page'] = $endPage;

        return $context;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionsResolver)
    {
        parent::configureDefaults($optionsResolver);

        $optionsResolver->setDefaults([
            'controls_template' => 'CascadaCoreBundle:Paginator:slidingPaginationControls.html.twig',
            'proximity_pages' => 3,
        ]);
    }
}