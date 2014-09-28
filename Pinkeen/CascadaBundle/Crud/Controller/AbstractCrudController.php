<?php

namespace Pinkeen\CascadaBundle\Crud\Controller;

use Pinkeen\CascadaBundle\Crud\ListView\ListViewInterface;
use Pinkeen\CascadaBundle\Crud\ListView\TableListView;
use Pinkeen\CascadaBundle\Crud\Templating\TemplatingAwareInterface;
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
     * @return array
     */
    abstract protected function getItems();

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
        $items = $this->getItems();

        return $this->renderResponse('PinkeenCascadaBundle:Crud:list.html.twig', [
            'list' => $listView->render($items)
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