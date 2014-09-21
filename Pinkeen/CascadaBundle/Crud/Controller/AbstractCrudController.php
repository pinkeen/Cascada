<?php

namespace Pinkeen\CascadaBundle\Crud\Controller;

use Pinkeen\CascadaBundle\Crud\Templating\TemplatingAwareInterface;
use Pinkeen\CascadaBundle\Crud\View\ListViewInterface;
use Pinkeen\CascadaBundle\Crud\View\TableRowView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Storage layer agnostic controller that provides basic CRUD functionality.
 *
 * Among others provides the actions: create, edit, list, delete, show.
 */
abstract class AbstractCrudController extends AbstractConfigurableController
{
    /**
     * @var ListViewInterface
     */
    private $listView = null;

    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionsResolver)
    {
        $optionsResolver->setDefaults([

        ]);
    }

    /**
     * Creates a list view.
     *
     * @return ListViewInterface
     */
    protected function createListView()
    {
        return new TableRowView();
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
     * Lists items.
     *
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request)
    {
        $listView = $this->getListView();
    }
}