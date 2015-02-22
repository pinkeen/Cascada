<?php

namespace Cascada\DemoBundle\Controller;

use Cascada\AdminCoreBundle\Crud\Field;
use Cascada\AdminCoreBundle\Crud\ListView\ListViewInterface;
use Cascada\AdminCoreBundle\Crud\Controller\AbstractCrudController;
use Cascada\DemoBundle\Entity\Author;

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