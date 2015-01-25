<?php

namespace Pinkeen\CascadaDemoBundle\Controller;

use Pinkeen\CascadaBundle\Crud\Controller\AbstractCrudController;
use Pinkeen\CascadaBundle\Crud\ListView\ListViewInterface;
use Pinkeen\CascadaBundle\Crud\Field;
use Pinkeen\CascadaDemoBundle\Entity\Book;

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