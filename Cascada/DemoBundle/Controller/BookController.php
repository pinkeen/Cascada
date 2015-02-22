<?php

namespace Cascada\DemoBundle\Controller;

use Cascada\AdminCoreBundle\Crud\Controller\AbstractCrudController;
use Cascada\AdminCoreBundle\Crud\ListView\ListViewInterface;
use Cascada\AdminCoreBundle\Crud\Field;
use Cascada\DemoBundle\Entity\Book;

class BookController extends AbstractCrudController
{
    /**
     * {@inheritdoc}
     */
    protected function buildListView(ListViewInterface $listView)
    {
        $listView
            ->addField(new Field\ScalarField('title'))
            ->addField(new Field\DateTimeField('publishedAt'))
            ->addField(new Field\ScalarField('isbn', [
                'label' => 'ISBN'
            ]))
            ->addField(new Field\ScalarField('author', [
                'callback' => function (Book $book) {
                    return $book->getAuthor()->getFirstName() . ' ' . $book->getAuthor()->getLastName();
                }
            ]))
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