<?php

namespace Cascada\DemoBundle\Controller;

use Cascada\CoreBundle\Admin\Controller\AbstractAdminController;
use Cascada\CoreBundle\Admin\ListView\ListViewInterface;
use Cascada\CoreBundle\Admin\Field;
use Cascada\DemoBundle\Entity\Book;

class BookController extends AbstractAdminController
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