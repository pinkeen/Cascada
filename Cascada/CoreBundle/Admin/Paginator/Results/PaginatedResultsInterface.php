<?php

namespace Cascada\CoreBundle\Paginator\Results;

interface PaginatedResultsInterface extends \Iterator, \Countable
{
    /**
     * @return int
     */
    public function getPage();

    /**
     * @return int
     */
    public function getLimit();

    /**
     * @return string
     */
    public function renderPaginationControls();
}