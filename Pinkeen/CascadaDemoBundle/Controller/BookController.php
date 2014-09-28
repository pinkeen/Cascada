<?php

namespace Pinkeen\CascadaDemoBundle\Controller;

use Pinkeen\CascadaBundle\Crud\Controller\AbstractCrudController;
use Pinkeen\CascadaBundle\Crud\ListView\ListViewInterface;
use Pinkeen\CascadaBundle\Crud\Field;

class BookController extends AbstractCrudController
{
    /**
     * {@inheritdoc}
     */
    protected function buildListView(ListViewInterface $listView)
    {
        $listView
            ->addField(new Field\ScalarField('title'));
        $listView->addField(new Field\DateTimeField('publishedAt'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function getItems()
    {
        return $this
            ->getService('doctrine.orm.entity_manager')
            ->getRepository('PinkeenCascadaDemoBundle:Book')
            ->findAll()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function getItemById($id)
    {

    }

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        return [];
    }
}