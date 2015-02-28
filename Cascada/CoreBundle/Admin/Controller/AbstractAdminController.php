<?php

namespace Cascada\CoreBundle\Admin\Controller;

use Cascada\CoreBundle\Admin\Filter\Manager\FilterManager;
use Cascada\CoreBundle\Admin\ListView\ListViewInterface;
use Cascada\CoreBundle\Admin\ListView\TableListView;
use Cascada\CoreBundle\Admin\Templating\TemplatingAwareInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Storage layer agnostic controller that provides basic CRUD functionality.
 *
 * Among others provides the actions: create, edit, list, delete, show.
 */
abstract class AbstractAdminController extends AbstractConfigurableController
{
    /**
     * @var ListViewInterface
     */
    private $listView = null;

    /**
     * @var FilterManager
     */
    private $filterManager = null;

    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionsResolver)
    {
        $optionsResolver->setDefaults([
            'list_view_options' => []
        ]);
    }

    /**
     * Creates a list view.
     *
     * @return ListViewInterface
     */
    protected function createListView()
    {
        return new TableListView($this->getOption('list_view_options'));
    }

    /**
     * Builds list view.
     *
     * Adds fields and optionally changes other config.
     *
     * @param ListViewInterface $listView
     */
    abstract protected function buildListView(ListViewInterface $listView);

    /**
     * Returns the list view and creates / initializes it
     *
     * @return ListViewInterface
     */
    protected function getListView()
    {
        if (null !== $this->listView) {
            return $this->listView;
        }

        $listView = $this->createListView();

        if ($listView instanceof TemplatingAwareInterface) {
            $listView->setTemplating($this->getTemplating());
        }

        $this->buildListView($listView);

        return $this->listView = $listView;
    }

    /**
     * Builds the filter chain.
     *
     * Adds filters to the chain.
     *
     * @param FilterManager $filterManager
     */
    protected function buildFilterChain(FilterManager $filterManager) {}

    /**
     * @return FilterManager
     */
    protected function getFilterManager()
    {
        if (null === $this->filterManager) {
            $this->filterManager = new FilterManager($this->getRequestStack(), $this->getTemplating());
            $this->buildFilterChain($this->filterManager);
        }

        return $this->filterManager;
    }

    /**
     * @return mixed
     */
    abstract protected function createListQueryBuilder();

    /**
     * @param $queryBuilder
     * @return array
     */
    abstract protected function executeQueryBuilderQuery($queryBuilder);

    /**
     * @return array
     */
    protected function getListItems()
    {
        $queryBuilder = $this->createListQueryBuilder();

        $this->getFilterManager()->applyFilters($queryBuilder);

        return $this->executeQueryBuilderQuery($queryBuilder);
    }


    /**
     * @param $id
     * @return object|array
     */
    abstract protected function getItemById($id);

    /**
     * Lists items.
     *
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request)
    {
        $listView = $this->getListView();
        $items = $this->getListItems();

        return $this->renderResponse('CascadaCoreBundle:Admin:list.html.twig', [
            'list' => $listView->render($items),
            'filter_manager' => $this->getFilterManager(),
        ]);
    }

    /**
     * @param Request $request
     * @param string $id
     */
    public function showAction(Request $request, $id)
    {
    }
}