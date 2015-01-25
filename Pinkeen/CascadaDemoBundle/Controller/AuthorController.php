<?php

namespace Pinkeen\CascadaDemoBundle\Controller;

use Pinkeen\CascadaBundle\Crud\Field;
use Pinkeen\CascadaBundle\Crud\ListView\ListViewInterface;
use Pinkeen\CascadaBundle\Crud\Controller\AbstractCrudController;
use Pinkeen\CascadaDemoBundle\Entity\Author;

class AuthorController extends AbstractCrudController
{
    /**
     * {@inheritdoc}
     */
    protected function buildListView(ListViewInterface $listView)
    {
        $listView
            ->addField(new Field\ScalarField('firstName'))
            ->addField(new Field\ScalarField('middleName'))
            ->addField(new Field\ScalarField('lastName'))
            ->addField(new Field\ScalarField('bookCount', [
                'callback' => function (Author $author) {
                    return $author->getBooks()->count();
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
            ->getRepository('PinkeenCascadaDemoBundle:Author')
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